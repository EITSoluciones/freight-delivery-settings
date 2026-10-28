
# Dependencias PHP (sin dev)

FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist \
    --no-interaction --ignore-platform-reqs
COPY . .
RUN composer dump-autoload --optimize --no-dev


#  Assets de Vite

FROM node:22-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .

COPY --from=vendor /app/vendor ./vendor
RUN npm run build


# Imagen final: FrankenPHP (Caddy + PHP, HTTPS automático)

FROM dunglas/frankenphp:1-php8.4

# Ajusta las extensiones a lo que use tu proyecto
RUN install-php-extensions pdo_mysql pcntl bcmath intl zip opcache gd exif

COPY docker/php.ini $PHP_INI_DIR/conf.d/zz-app.ini
COPY docker/Caddyfile /etc/frankenphp/Caddyfile

WORKDIR /app
COPY --from=vendor /app /app
COPY --from=assets /app/public/build /app/public/build

RUN mkdir -p storage/app/public storage/logs \
        storage/framework/cache/data storage/framework/sessions storage/framework/views \
        bootstrap/cache \
    && ln -sfn /app/storage/app/public /app/public/storage \
    && chown -R www-data:www-data storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

ENTRYPOINT ["entrypoint"]
CMD ["frankenphp", "run", "--config", "/etc/frankenphp/Caddyfile"]
