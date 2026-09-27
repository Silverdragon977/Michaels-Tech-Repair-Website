#!/usr/bin/env bash

set -Eeuo pipefail


# ============================================================
# Michael's Tech Repair
# Production Deployment Script
#
# Purpose:
#
#   - Verify this is the production environment
#   - Fetch the latest code from GitHub
#   - Reset production to origin/main
#   - Build the Laravel production Docker image
#   - Start/update Docker containers
#   - Wait for Laravel to become healthy
#   - Run migrations if MySQL is running
#   - Rebuild Laravel production caches
#   - Remove unused Docker images
#
# This script is PRODUCTION ONLY.
#
# Run as the deployment user:
#
#   ./deploy.sh
#
# Do NOT run with sudo.
# ============================================================


# ------------------------------------------------------------
# Application directory
# ------------------------------------------------------------

APP_DIR=
	"$(
	cd "$(dirname "${BASH_SOURCE[0]}")"
	pwd
	)"


# ------------------------------------------------------------
# Prevent running as root
#
# The Git repository and application files should remain owned
# by the deployment user.
# ------------------------------------------------------------

if [[ "$EUID" -eq 0 ]]; then

    echo
    echo "❌ ERROR: Do not run deploy.sh as root."
    echo
    echo "Run it as the deployment user instead."
    echo

    exit 1

fi


# ------------------------------------------------------------
# Make sure application directory exists
# ------------------------------------------------------------

if [[ ! -d "$APP_DIR" ]]; then

    echo
    echo "❌ ERROR: Application directory does not exist:"
    echo
    echo "  $APP_DIR"
    echo

    exit 1

fi


# ------------------------------------------------------------
# Enter application directory
# ------------------------------------------------------------

cd "$APP_DIR"


# ============================================================
# Environment Guard
#
# Reads:
#
#   $APP_DIR/.env
#
# environmentGuard.sh knows deploy.sh is production-only.
#
# If APP_ENV is not production, execution stops here BEFORE
# Git or Docker changes anything.
# ============================================================

source "$APP_DIR/scripts/environmentGuard.sh"


# ------------------------------------------------------------
# Make sure this is actually a Git repository
# ------------------------------------------------------------

if [[ ! -d "$APP_DIR/.git" ]]; then

    echo
    echo "❌ ERROR: This directory is not a Git repository:"
    echo
    echo "  $APP_DIR"
    echo

    exit 1

fi


# ------------------------------------------------------------
# Make sure Docker exists
# ------------------------------------------------------------

if ! command -v docker >/dev/null 2>&1; then

    echo
    echo "❌ ERROR: Docker is not installed or is not in PATH."
    echo

    exit 1

fi


# ------------------------------------------------------------
# Make sure Docker Compose is available
# ------------------------------------------------------------

if ! docker compose version >/dev/null 2>&1; then

    echo
    echo "❌ ERROR: Docker Compose is not available."
    echo

    exit 1

fi


# ------------------------------------------------------------
# Verify deployment user can access Docker
# ------------------------------------------------------------

if ! docker info >/dev/null 2>&1; then

    echo
    echo "❌ ERROR: Current user cannot access Docker."
    echo
    echo "Make sure this user belongs to the docker group."
    echo
    echo "You may need to log out and back in after being added."
    echo

    exit 1

fi


# ------------------------------------------------------------
# Validate Docker Compose configuration BEFORE deployment
# ------------------------------------------------------------

echo
echo "🔎 Validating Docker Compose configuration..."


if ! docker compose config --quiet; then

    echo
    echo "❌ Docker Compose configuration is invalid."
    echo

    exit 1

fi


echo "✅ Docker Compose configuration is valid."


# ============================================================
# Git update
# ============================================================

echo
echo "============================================================"
echo "  Updating Source Code"
echo "============================================================"
echo


# ------------------------------------------------------------
# Fetch latest main branch
# ------------------------------------------------------------

echo "🔄 Fetching latest changes from origin/main..."


git fetch origin main


# ------------------------------------------------------------
# Reset production checkout
#
# Production is intentionally made identical to origin/main.
#
# Do not manually edit production source files.
# ------------------------------------------------------------

echo
echo "🔁 Resetting production to origin/main..."


git reset --hard origin/main


# ------------------------------------------------------------
# Run environment guard AGAIN
#
# The Git reset may have replaced environmentGuard.sh with a
# newer version from the repository.
#
# The .env file is not stored in Git, so its production value
# remains local to this server.
# ------------------------------------------------------------

echo
echo "🔎 Rechecking production environment..."


source "$APP_DIR/scripts/environmentGuard.sh"


# ------------------------------------------------------------
# Validate the newly pulled Compose configuration
# ------------------------------------------------------------

echo
echo "🔎 Revalidating Docker Compose configuration..."


docker compose config --quiet


echo "✅ Configuration passed."


# ============================================================
# Docker build
# ============================================================

echo
echo "============================================================"
echo "  Building Application"
echo "============================================================"
echo


echo "🐳 Building Laravel production image..."


# --pull checks for newer versions of base images used by the
# Dockerfile.
#
# The Dockerfile's multi-stage build handles:
#
#   Composer
#   npm
#   React
#   TypeScript
#   SCSS
#   Vite
#
# Node/build tooling is discarded from the final runtime image.

docker compose build \
    --pull \
    app


# ============================================================
# Start/update containers
# ============================================================

echo
echo "============================================================"
echo "  Starting Application"
echo "============================================================"
echo


echo "🚀 Starting updated Docker services..."


docker compose up \
    -d \
    --remove-orphans


# ============================================================
# Wait for Laravel health check
# ============================================================

echo
echo "⏳ Waiting for Laravel to become healthy..."


APP_CONTAINER_ID="$(
    docker compose ps \
        -q \
        app
)"


if [[ -z "$APP_CONTAINER_ID" ]]; then

    echo
    echo "❌ ERROR: Laravel app container was not found."
    echo

    docker compose ps

    exit 1

fi


APP_HEALTHY=false


for ATTEMPT in {1..30}; do

    HEALTH_STATUS="$(
        docker inspect \
            --format='{{if .State.Health}}{{.State.Health.Status}}{{else}}no-healthcheck{{end}}' \
            "$APP_CONTAINER_ID" \
            2>/dev/null \
            || true
    )"


    if [[ "$HEALTH_STATUS" == "healthy" ]]; then

        APP_HEALTHY=true

        echo "✅ Laravel container is healthy."

        break

    fi


    if [[ "$HEALTH_STATUS" == "unhealthy" ]]; then

        echo "⚠️ Laravel currently reports unhealthy."

    fi


    if [[ "$HEALTH_STATUS" == "no-healthcheck" ]]; then

        echo
        echo "❌ ERROR: Laravel container has no health check."
        echo

        exit 1

    fi


    echo "   Waiting... ($ATTEMPT/30)"


    sleep 2

done


# ------------------------------------------------------------
# Fail deployment if Laravel never became healthy
# ------------------------------------------------------------

if [[ "$APP_HEALTHY" != true ]]; then

    echo
    echo "❌ ERROR: Laravel failed to become healthy."
    echo
    echo "Recent application logs:"
    echo


    docker compose logs \
        --tail=100 \
        app


    exit 1

fi


# ============================================================
# Optional MySQL migrations
# ============================================================

echo
echo "============================================================"
echo "  Database Check"
echo "============================================================"
echo


# ------------------------------------------------------------
# Determine whether the optional MySQL service is running
# ------------------------------------------------------------

if docker compose ps \
    --status running \
    --services \
    | grep -qx mysql
then

    echo "🗄️ MySQL is running."


    # --------------------------------------------------------
    # Wait for MySQL health check
    # --------------------------------------------------------

    MYSQL_CONTAINER_ID="$(
        docker compose ps \
            -q \
            mysql
    )"


    MYSQL_HEALTHY=false


    for ATTEMPT in {1..30}; do

        MYSQL_STATUS="$(
            docker inspect \
                --format='{{if .State.Health}}{{.State.Health.Status}}{{else}}no-healthcheck{{end}}' \
                "$MYSQL_CONTAINER_ID" \
                2>/dev/null \
                || true
        )"


        if [[ "$MYSQL_STATUS" == "healthy" ]]; then

            MYSQL_HEALTHY=true

            echo "✅ MySQL is healthy."

            break

        fi


        echo "   Waiting for MySQL... ($ATTEMPT/30)"


        sleep 2

    done


    if [[ "$MYSQL_HEALTHY" != true ]]; then

        echo
        echo "❌ ERROR: MySQL failed to become healthy."
        echo

        docker compose logs \
            --tail=100 \
            mysql

        exit 1

    fi


    # --------------------------------------------------------
    # Run Laravel database migrations
    # --------------------------------------------------------

    echo
    echo "🧱 Running Laravel database migrations..."


    docker compose exec \
        -T \
        app \
        php artisan migrate --force


    echo "✅ Database migrations complete."

else

    echo "ℹ️ Optional MySQL service is not running."

    echo "ℹ️ Database migrations will be skipped."

fi


# ============================================================
# Laravel production optimization
# ============================================================

echo
echo "============================================================"
echo "  Optimizing Laravel"
echo "============================================================"
echo


# ------------------------------------------------------------
# Clear old caches
# ------------------------------------------------------------

echo "🧹 Clearing existing Laravel caches..."


docker compose exec \
    -T \
    app \
    php artisan optimize:clear


# ------------------------------------------------------------
# Rebuild production caches
#
# Laravel optimize handles the appropriate production caches.
# ------------------------------------------------------------

echo
echo "⚡ Building Laravel production caches..."


docker compose exec \
    -T \
    app \
    php artisan optimize


# ============================================================
# Final health verification
# ============================================================

echo
echo "🔎 Performing final health check..."


sleep 2


FINAL_HEALTH="$(
    docker inspect \
        --format='{{.State.Health.Status}}' \
        "$APP_CONTAINER_ID" \
        2>/dev/null \
        || true
)"


if [[ "$FINAL_HEALTH" != "healthy" ]]; then

    echo
    echo "❌ ERROR: Application is no longer healthy."
    echo


    docker compose logs \
        --tail=100 \
        app


    exit 1

fi


echo "✅ Final application health check passed."


# ============================================================
# Docker cleanup
# ============================================================

echo
echo "============================================================"
echo "  Cleanup"
echo "============================================================"
echo


echo "🧹 Removing unused Docker image layers..."


docker image prune -f


# ============================================================
# Display running services
# ============================================================

echo
echo "============================================================"
echo "  Running Containers"
echo "============================================================"
echo


docker compose ps


# ============================================================
# Complete
# ============================================================

echo
echo "============================================================"
echo "✅ Deployment complete!"
echo "============================================================"
echo
