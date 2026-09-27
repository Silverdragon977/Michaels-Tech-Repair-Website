#!/usr/bin/env bash

set -Eeuo pipefail


# ============================================================
# Generic Laravel Application Template
# Laravel Setup Script
#
# Purpose:
#
#   - Install a fresh Laravel application into this template
#   - Preserve files already provided by the template
#   - Install Composer dependencies
#   - Ensure .env exists
#   - Generate APP_KEY when necessary
#   - Create a generic Caddyfile
#   - Verify Laravel can start
#
# This script is DEVELOPMENT ONLY.
#
# The environment policy is controlled by:
#
#   scripts/environmentGuard.sh
#
# This script intentionally does NOT:
#
#   - install React
#   - install TypeScript
#   - install Sass
#   - run Vite
#   - configure production
#   - configure deployment users
#   - configure GitHub
#   - run database migrations
#
# Those responsibilities belong to other setup scripts.
# ============================================================


# ------------------------------------------------------------
# Find script directory
# ------------------------------------------------------------

SCRIPT_DIR="$(
    cd "$(dirname "${BASH_SOURCE[0]}")"
    pwd
)"


# ------------------------------------------------------------
# Find project root
#
# Expected location:
#
#   PROJECT_ROOT/scripts/setup-laravel.sh
# ------------------------------------------------------------

PROJECT_ROOT="$(
    cd "$SCRIPT_DIR/.."
    pwd
)"


cd "$PROJECT_ROOT"


# ============================================================
# Helpers
# ============================================================

die() {

    echo
    echo "============================================================"
    echo "❌ Laravel setup failed"
    echo "============================================================"
    echo
    echo "$*"
    echo

    exit 1
}


info() {

    echo "ℹ️  $*"

}


ok() {

    echo "✅ $*"

}


# ============================================================
# Do not run as root
# ============================================================

if [[ "$EUID" -eq 0 ]]; then

    die "Do not run setup-laravel.sh with sudo.

Run it as your normal development user."

fi


# ============================================================
# Existing environment protection
#
# If .env already exists, check the environment BEFORE doing
# anything.
#
# If .env does not exist yet, Laravel has not necessarily been
# installed, so the guardian cannot run yet.
#
# We run it again later after .env has been created.
# ============================================================

if [[ -f "$PROJECT_ROOT/.env" ]]; then

    source "$SCRIPT_DIR/environmentGuard.sh"

fi


# ============================================================
# Header
# ============================================================

echo
echo "============================================================"
echo "  Laravel Application Setup"
echo "============================================================"
echo


# ============================================================
# Prerequisite checks
# ============================================================

echo "🔎 Checking development prerequisites..."


# ------------------------------------------------------------
# PHP
# ------------------------------------------------------------

if ! command -v php >/dev/null 2>&1; then

    die "PHP was not found.

Install PHP before running the application setup."

fi


PHP_VERSION="$(
    php \
        -r 'echo PHP_VERSION;'
)"


ok "PHP found: $PHP_VERSION"


# ------------------------------------------------------------
# Composer
# ------------------------------------------------------------

if ! command -v composer >/dev/null 2>&1; then

    die "Composer was not found.

Install Composer before running the application setup."

fi


COMPOSER_VERSION="$(
    composer \
        --version \
        --no-ansi
)"


ok "$COMPOSER_VERSION"


# ============================================================
# Determine whether Laravel already exists
# ============================================================

if [[ -f "$PROJECT_ROOT/artisan" ]] \
    && [[ -f "$PROJECT_ROOT/composer.json" ]]
then

    echo
    info "Existing Laravel application detected."

    LARAVEL_ALREADY_EXISTS=true

else

    LARAVEL_ALREADY_EXISTS=false

fi


# ============================================================
# Create Laravel skeleton when necessary
# ============================================================

if [[ "$LARAVEL_ALREADY_EXISTS" == false ]]; then

    echo
    echo "============================================================"
    echo "  Creating Laravel Skeleton"
    echo "============================================================"
    echo


    # --------------------------------------------------------
    # Temporary working directory
    #
    # We cannot use:
    #
    #   composer create-project laravel/laravel .
    #
    # because the template repository is already non-empty.
    #
    # Instead:
    #
    #   1. Laravel is downloaded into a temporary directory.
    #   2. Missing Laravel files are merged into this repo.
    #   3. Existing template files are NOT overwritten.
    # --------------------------------------------------------

    TEMP_ROOT="$(
        mktemp -d
    )"


    TEMP_LARAVEL="$TEMP_ROOT/laravel"


    # --------------------------------------------------------
    # Always clean temporary files when the script exits.
    # --------------------------------------------------------

    cleanup() {

        if [[ -n "${TEMP_ROOT:-}" ]] \
            && [[ -d "${TEMP_ROOT:-}" ]]
        then

            rm \
                -rf \
                "$TEMP_ROOT"

        fi

    }


    trap cleanup EXIT


    echo "📦 Downloading Laravel application skeleton..."


    # --------------------------------------------------------
    # --no-install
    #
    # Only obtain the Laravel application skeleton here.
    #
    # Dependencies will be installed AFTER the application has
    # been safely merged into our template repository.
    #
    # --no-interaction
    #
    # Keeps setup automatic.
    # --------------------------------------------------------

    composer create-project \
        laravel/laravel \
        "$TEMP_LARAVEL" \
        --no-install \
        --no-interaction


    ok "Laravel skeleton downloaded."


    # --------------------------------------------------------
    # Merge Laravel into existing template
    #
    # --archive
    #     Recursively preserve normal file attributes.
    #
    # --no-clobber
    #     NEVER overwrite an existing template file.
    #
    # This protects files we already created such as:
    #
    #   .gitignore
    #   .dockerignore
    #   Dockerfile
    #   compose.yml
    #   cloud-init-prod-only.yml
    #   deploy.sh
    #   scripts/
    #
    # Hidden Laravel files are included because source is:
    #
    #   "$TEMP_LARAVEL"/.
    # --------------------------------------------------------

    echo
    echo "📂 Merging Laravel into template..."


    cp \
        --archive \
        --no-clobber \
        "$TEMP_LARAVEL"/. \
        "$PROJECT_ROOT"/


    ok "Laravel files merged without overwriting template files."


else

    echo
    echo "ℹ️ Laravel installation step skipped."

fi


# ============================================================
# Verify required Laravel files now exist
# ============================================================

if [[ ! -f "$PROJECT_ROOT/artisan" ]]; then

    die "Laravel artisan was not created."

fi


if [[ ! -f "$PROJECT_ROOT/composer.json" ]]; then

    die "Laravel composer.json was not created."

fi


if [[ ! -f "$PROJECT_ROOT/.env.example" ]]; then

    die "Laravel .env.example was not created."

fi


# ============================================================
# Install PHP dependencies
# ============================================================

echo
echo "============================================================"
echo "  Installing Laravel Dependencies"
echo "============================================================"
echo


echo "📦 Running Composer install..."


composer install \
    --no-interaction \
    --prefer-dist


ok "Composer dependencies installed."


# ============================================================
# Create .env
# ============================================================

echo
echo "============================================================"
echo "  Laravel Environment"
echo "============================================================"
echo


if [[ ! -f "$PROJECT_ROOT/.env" ]]; then

    echo "⚙️ Creating .env from Laravel's .env.example..."


    cp \
        "$PROJECT_ROOT/.env.example" \
        "$PROJECT_ROOT/.env"


    chmod \
        0600 \
        "$PROJECT_ROOT/.env"


    ok ".env created."

else

    info ".env already exists."

fi


# ============================================================
# NOW enforce development environment
#
# At this point .env is guaranteed to exist.
#
# Fresh Laravel uses APP_ENV=local, so a new development
# installation will pass.
# ============================================================

source "$SCRIPT_DIR/environmentGuard.sh"


# ============================================================
# Laravel application key
# ============================================================

echo
echo "🔑 Checking Laravel APP_KEY..."


APP_KEY="$(
    grep \
        -E '^APP_KEY=' \
        "$PROJECT_ROOT/.env" \
        | tail -n 1 \
        | cut -d= -f2- \
        || true
)"


if [[ -z "$APP_KEY" ]]; then

    echo "🔑 Generating Laravel application key..."


    php artisan key:generate \
        --force


    ok "Laravel APP_KEY generated."

else

    info "Laravel APP_KEY already exists."

    info "Existing key will NOT be replaced."

fi


# ============================================================
# Generic Caddyfile
#
# No application-specific domain is stored here.
#
# Caddy receives APP_DOMAIN from Docker Compose / .env.
#
# Example production .env:
#
#   APP_DOMAIN=example.com
#
# Caddy syntax:
#
#   {$APP_DOMAIN}
#
# means:
#
#   read APP_DOMAIN from the container environment.
# ============================================================

echo
echo "============================================================"
echo "  Caddy Configuration"
echo "============================================================"
echo


CADDY_FILE="$PROJECT_ROOT/Caddyfile"


if [[ ! -f "$CADDY_FILE" ]]; then

    echo "🌐 Creating generic Caddyfile..."


    cat > "$CADDY_FILE" <<'EOF'
# ============================================================
# Generic Laravel Caddy Configuration
#
# APP_DOMAIN is supplied by Docker Compose from .env.
#
# Example:
#
#   APP_DOMAIN=example.com
#
# Caddy automatically handles HTTPS certificates when the
# domain resolves to this server and ports 80/443 are open.
# ============================================================


{$APP_DOMAIN} {

    # --------------------------------------------------------
    # Compress compatible responses
    # --------------------------------------------------------

    encode zstd gzip


    # --------------------------------------------------------
    # Laravel/PHP/Apache container
    # --------------------------------------------------------

    reverse_proxy app:80

}
EOF


    ok "Caddyfile created."

else

    info "Existing Caddyfile detected."

    info "It will NOT be overwritten."

fi


# ============================================================
# Laravel writable directories
# ============================================================

echo
echo "📁 Checking Laravel runtime directories..."


mkdir \
    -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache


ok "Laravel runtime directories exist."


# ============================================================
# Clear stale Laravel caches
# ============================================================

echo
echo "🧹 Clearing existing Laravel caches..."


php artisan optimize:clear


ok "Laravel caches cleared."


# ============================================================
# Verify Laravel
# ============================================================

echo
echo "============================================================"
echo "  Verifying Laravel"
echo "============================================================"
echo


# ------------------------------------------------------------
# Artisan must successfully boot the Laravel application.
# ------------------------------------------------------------

php artisan about \
    --only=environment


ok "Laravel successfully booted."


# ============================================================
# Detect Laravel's original JavaScript Vite configuration
#
# Our setup-frontend.sh will create:
#
#   vite.config.ts
#
# We leave Laravel's original file alone here so Laravel setup
# remains independent of frontend setup.
#
# setup-frontend.sh should remove the old vite.config.js when
# it creates vite.config.ts.
# ============================================================

if [[ -f "$PROJECT_ROOT/vite.config.js" ]]; then

    echo
    info "Laravel default vite.config.js detected."

    info "setup-frontend.sh will replace it with vite.config.ts."

fi


# ============================================================
# Finish
# ============================================================

echo
echo "============================================================"
echo "✅ Laravel setup complete!"
echo "============================================================"
echo


echo "Laravel:"
echo
php artisan \
    --version


echo
echo "Environment:"
echo
echo "  Development"


echo
echo "Created/verified:"
echo
echo "  artisan"
echo "  composer.json"
echo "  vendor/"
echo "  .env.example"
echo "  .env"
echo "  APP_KEY"
echo "  Caddyfile"
echo "  Laravel runtime directories"


echo
echo "The next setup stage is:"
echo
echo "  scripts/setup-frontend.sh"
echo


echo "That script will configure:"
echo
echo "  React"
echo "  TypeScript"
echo "  SCSS"
echo "  Vite"
echo "  Blade template"
echo "  React example component"
echo
