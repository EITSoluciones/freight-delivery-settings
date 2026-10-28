
set -e
git pull
docker compose -f compose.prod.yaml up -d --build --remove-orphans
docker image prune -f
docker compose -f compose.prod.yaml ps
