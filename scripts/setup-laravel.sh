#!/usr/bin/env bash

set -Eeuo pipefail


# ============================================================
# Generic Laravel Application Setup
#
# Purpose:
#
#   - Verify PHP and Composer
#   - Create Laravel if it does not exist
#   - Merge Laravel into the reusable template
#   - Preserve existing template files
#   - Install PHP dependencies
#   - Create .env when needed
#   - Configure safe Laravel runtime defaults
#   - Generate APP_KEY
#   - Create a generic Caddyfile
#   - Prepare Laravel runtime directories
#   - Clear Laravel caches
#
# This script is intended for DEVELOPMENT setup.
# ============================================================


# ============================================================
# Locate project
# ============================================================

SCRIPT_DIR="$(
    cd "$(dirname "${BASH_SOURCE[0]}")"
    pwd
)"

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
    echo "❌ LARAVEL SETUP FAILED"
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


# ------------------------------------------------------------
# Add or replace KEY=value inside an env-style file.
#
# This is more reliable than sed alone because the variable
# will also be added if Laravel's default .env does not already
# contain it.
# ------------------------------------------------------------

set_env_value() {

    local FILE="$1"
    local KEY="$2"
    local VALUE="$3"
    local TEMP_FILE=""


    touch "$FILE"


    TEMP_FILE="$(mktemp)"


    awk \
        -v key="$KEY" \
        -v value="$VALUE" \
        '
        BEGIN {
            found = 0
        }

        $0 ~ "^[[:space:]]*" key "[[:space:]]*=" {

            if (!found) {

                print key "=" value

                found = 1

            }

            next
        }

        {
            print
        }

        END {

            if (!found) {

                print key "=" value

            }

        }
        ' \
        "$FILE" \
        > "$TEMP_FILE"


    cat "$TEMP_FILE" > "$FILE"


    rm -f "$TEMP_FILE"

}


# ============================================================
# Header
# ============================================================

echo
echo "============================================================"
echo "  Laravel Application Setup"
echo "============================================================"
echo


# ============================================================
# Do not run as root
# ============================================================

if [[ "${EUID}" -eq 0 ]]; then

    die "Do not run setup-laravel.sh as root.

Run it as your normal development user."

fi


# ============================================================
# If .env already exists, protect the script immediately.
#
# On a brand-new template .env may not exist yet, so the
# environment guard cannot be used until after Laravel creates
# or receives an environment file.
# ============================================================

if [[ -f "$PROJECT_ROOT/.env" ]]; then

    source "$SCRIPT_DIR/environmentGuard.sh"

fi


# ============================================================
# Development prerequisites
# ============================================================

echo "🔎 Checking development prerequisites..."


if ! command -v php >/dev/null 2>&1; then

    die "PHP was not found.

Install PHP before running Laravel setup."

fi


PHP_VERSION="$(
    php \
        -r 'echo PHP_VERSION;'
)"


ok "PHP found: $PHP_VERSION"


if ! command -v composer >/dev/null 2>&1; then

    die "Composer was not found.

Install Composer before running Laravel setup."

fi


COMPOSER_VERSION="$(
    composer \
        --version \
        --no-ansi
)"


ok "$COMPOSER_VERSION"


# ============================================================
# Detect existing Laravel application
# ============================================================

LARAVEL_EXISTS="false"


if [[ -f "$PROJECT_ROOT/artisan" ]] \
    && [[ -f "$PROJECT_ROOT/composer.json" ]]
then

    LARAVEL_EXISTS="true"

fi


# ============================================================
# Create Laravel skeleton if needed
# ============================================================

if [[ "$LARAVEL_EXISTS" == "false" ]]; then

    echo
    echo "============================================================"
    echo "  Creating Laravel Skeleton"
    echo "============================================================"
    echo


    TEMP_ROOT="$(mktemp -d)"

    TEMP_LARAVEL="$TEMP_ROOT/laravel"


    cleanup() {

        if [[ -n "${TEMP_ROOT:-}" ]] \
            && [[ -d "${TEMP_ROOT:-}" ]]
        then

            rm -rf "$TEMP_ROOT"

        fi

    }


    trap cleanup EXIT


    echo "📦 Downloading Laravel application skeleton..."


    # --------------------------------------------------------
    # --no-install
    #
    # We only want Laravel's skeleton here. Dependencies will
    # be installed after the skeleton is merged into the real
    # project.
    #
    # --no-scripts
    #
    # Recent Laravel versions try to run Artisan during the
    # create-project lifecycle. Artisan cannot run yet because
    # --no-install means vendor/autoload.php does not exist.
    # --------------------------------------------------------

    composer create-project \
        laravel/laravel \
        "$TEMP_LARAVEL" \
        --no-install \
        --no-scripts \
        --no-interaction


    ok "Laravel skeleton downloaded."


    # --------------------------------------------------------
    # Merge Laravel into the reusable template.
    #
    # --no-clobber preserves files already supplied by this
    # template, such as:
    #
    #   Dockerfile
    #   compose.yml
    #   .gitignore
    #   .dockerignore
    #   setup scripts
    # --------------------------------------------------------

    echo
    echo "📁 Merging Laravel into project..."


    cp \
        --archive \
        --no-clobber \
        "$TEMP_LARAVEL"/. \
        "$PROJECT_ROOT"/


    ok "Laravel skeleton merged."


    # --------------------------------------------------------
    # Cleanup temporary Laravel download
    # --------------------------------------------------------

    cleanup

    trap - EXIT


else

    info "Existing Laravel application detected."

    info "Laravel skeleton creation skipped."

fi


# ============================================================
# Verify required Laravel files
# ============================================================

echo
echo "🔎 Verifying Laravel files..."


if [[ ! -f "$PROJECT_ROOT/artisan" ]]; then

    die "Laravel artisan file is missing."

fi


if [[ ! -f "$PROJECT_ROOT/composer.json" ]]; then

    die "Laravel composer.json is missing."

fi


if [[ ! -f "$PROJECT_ROOT/.env.example" ]]; then

    die "Laravel .env.example is missing."

fi


ok "Required Laravel files are present."


# ============================================================
# Install PHP dependencies
# ============================================================

echo
echo "📦 Installing Composer dependencies..."


composer install \
    --no-interaction \
    --prefer-dist


ok "Composer dependencies installed."


# ============================================================
# Create .env if needed
# ============================================================

echo
echo "============================================================"
echo "  Environment File"
echo "============================================================"
echo


if [[ ! -f "$PROJECT_ROOT/.env" ]]; then

    echo "⚙️ Creating .env from .env.example..."


    cp \
        "$PROJECT_ROOT/.env.example" \
        "$PROJECT_ROOT/.env"


    chmod \
        0600 \
        "$PROJECT_ROOT/.env"


    ok ".env created."

else

    info "Existing .env preserved."

fi


# ============================================================
# Configure Laravel runtime defaults
#
# Recent Laravel versions commonly use database-backed cache,
# sessions, and queues.
#
# The reusable template should be able to initialize and run
# setup without needing a database connection first.
#
# These settings do NOT prevent the application itself from
# using MySQL later.
#
# Application data:
#   MySQL
#
# Sessions:
#   files
#
# Cache:
#   files
#
# Queue:
#   synchronous
# ============================================================

echo
echo "⚙️ Configuring Laravel runtime defaults..."


set_env_value \
    "$PROJECT_ROOT/.env" \
    "SESSION_DRIVER" \
    "file"


set_env_value \
    "$PROJECT_ROOT/.env" \
    "CACHE_STORE" \
    "file"


set_env_value \
    "$PROJECT_ROOT/.env" \
    "QUEUE_CONNECTION" \
    "sync"


ok "Laravel runtime defaults configured."


# ============================================================
# Environment guard
#
# .env now definitely exists, so environmentGuard.sh can
# safely verify APP_ENV.
# ============================================================

source "$SCRIPT_DIR/environmentGuard.sh"


# ============================================================
# Generate APP_KEY if needed
# ============================================================

echo
echo "🔑 Checking Laravel APP_KEY..."


CURRENT_APP_KEY="$(
    grep \
        '^APP_KEY=' \
        "$PROJECT_ROOT/.env" \
        2>/dev/null \
        | head -n 1 \
        | cut -d= -f2- \
        || true
)"


if [[ -z "$CURRENT_APP_KEY" ]]; then

    echo
    echo "🔑 Generating Laravel APP_KEY..."


    php artisan key:generate \
        --force


    ok "Laravel APP_KEY generated."

else

    info "APP_KEY already exists."

    info "Existing APP_KEY preserved."

fi


# ============================================================
# Caddy configuration
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
# Generic Laravel Caddy Configuration
#
# APP_DOMAIN is passed to Caddy by Docker Compose.

{$APP_DOMAIN} {

    encode zstd gzip

    reverse_proxy app:80

}
EOF


    ok "Caddyfile created."

else

    info "Existing Caddyfile preserved."

fi


# ============================================================
# Laravel runtime directories
# ============================================================

echo
echo "📁 Checking Laravel runtime directories..."


mkdir -p \
    "$PROJECT_ROOT/storage/framework/cache/data" \
    "$PROJECT_ROOT/storage/framework/sessions" \
    "$PROJECT_ROOT/storage/framework/views" \
    "$PROJECT_ROOT/storage/logs" \
    "$PROJECT_ROOT/bootstrap/cache"


ok "Laravel runtime directories exist."


# ============================================================
# Clear Laravel caches
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
echo "  Laravel Verification"
echo "============================================================"
echo


php artisan about \
    --only=environment


ok "Laravel application booted successfully."


# ============================================================
# Detect Laravel's default Vite config
#
# setup-frontend.sh will replace the default JavaScript config
# with vite.config.ts.
# ============================================================

if [[ -f "$PROJECT_ROOT/vite.config.js" ]] \
    || [[ -f "$PROJECT_ROOT/vite.config.mjs" ]]
then

    echo
    info "Laravel default Vite configuration detected."

    info "setup-frontend.sh will replace it with vite.config.ts."

fi


# ============================================================
# Complete
# ============================================================

echo
echo "============================================================"
echo "✅ Laravel setup complete"
echo "============================================================"
echo


echo "Laravel root:"
echo
echo "  $PROJECT_ROOT"
echo


echo "Environment:"
echo
echo "  development"
echo


echo "Next setup stage:"
echo
echo "  scripts/setup-frontend.sh"
echo