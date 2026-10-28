#!/bin/sh
set -e

# Cachea config, rutas, vistas y eventos con las variables de entorno reales
php artisan optimize

# Solo el contenedor "app" corre migraciones (RUN_MIGRATIONS=true)
if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    php artisan migrate --force
fi

exec "$@"
