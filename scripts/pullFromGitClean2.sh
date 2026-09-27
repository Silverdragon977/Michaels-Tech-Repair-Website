#!/usr/bin/env bash

set -Eeuo pipefail

# Prevent script from running as root
if [ "$EUID" -eq 0 ]; then
    echo "❌ ERROR: Do not run this script as root."
    echo "Run it as the deployment user instead."
    exit 1
fi

APP_DIR="/opt/michaelstechrepair"

cd "$APP_DIR" || {
    echo "❌ Could not enter $APP_DIR"
    exit 1
}

echo "🔄 Fetching latest changes..."
git fetch origin main

echo "🔁 Resetting production to origin/main..."
git reset --hard origin/main

echo "🐳 Building production Docker image..."
docker compose build --pull app

echo "🚀 Starting updated containers..."
docker compose up -d --remove-orphans

echo "⏳ Waiting for Laravel to become healthy..."

for i in {1..30}; do
    STATUS=$(docker inspect \
        --format='{{.State.Health.Status}}' \
        michaelstechrepair-app 2>/dev/null || true)

    if [ "$STATUS" = "healthy" ]; then
        echo "✅ Laravel is healthy."
        break
    fi

    if [ "$i" -eq 30 ]; then
        echo "❌ Laravel failed its health check."
        docker compose logs --tail=100 app
        exit 1
    fi

    sleep 2
done

# Only run migrations if MySQL is actually running
if docker compose ps --status running --services | grep -qx "mysql"; then
    echo "🧱 Running database migrations..."
    docker compose exec -T app php artisan migrate --force
else
    echo "ℹ️ MySQL is not running — skipping migrations."
fi

echo "🧹 Clearing old Laravel caches..."
docker compose exec -T app php artisan optimize:clear

echo "⚡ Building Laravel production caches..."
docker compose exec -T app php artisan optimize

echo "🧹 Removing unused Docker images..."
docker image prune -f

echo
echo "📦 Current containers:"
docker compose ps

echo
echo "✅ Deployment complete!"
