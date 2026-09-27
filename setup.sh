#!/usr/bin/env bash

set -Eeuo pipefail


# ============================================================
# Generic Laravel + Docker Template
# Guided Master Setup
#
# This is the main entry point for setting up the template.
#
# First run can be:
#
#   bash setup.sh
#
# The script immediately makes all .sh files executable, so
# future runs may use:
#
#   ./setup.sh
#
# This script itself is NOT protected by environmentGuard.sh
# because one of its jobs is creating/configuring .env.
# ============================================================


# ============================================================
# Locate project
# ============================================================

PROJECT_ROOT="$(
    cd "$(dirname "${BASH_SOURCE[0]}")"
    pwd
)"

SCRIPTS_DIR="$PROJECT_ROOT/scripts"

cd "$PROJECT_ROOT"


# ============================================================
# Helpers
# ============================================================

die() {
    echo
    echo "============================================================"
    echo "❌ SETUP FAILED"
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


prompt_default() {
    local PROMPT="$1"
    local DEFAULT_VALUE="$2"
    local RESULT=""

    read -rp "$PROMPT [$DEFAULT_VALUE]: " RESULT

    printf '%s' "${RESULT:-$DEFAULT_VALUE}"
}


slugify() {
    local VALUE="$1"
    local RESULT=""

    RESULT="$(
        printf '%s' "$VALUE" \
            | tr '[:upper:]' '[:lower:]' \
            | sed -E \
                -e 's/[^a-z0-9]+/-/g' \
                -e 's/^-+//' \
                -e 's/-+$//'
    )"

    if [[ -z "$RESULT" ]]; then
        RESULT="laravel-app"
    fi

    printf '%s' "$RESULT"
}


quote_env_string() {
    local VALUE="$1"

    VALUE="${VALUE//\\/\\\\}"
    VALUE="${VALUE//\"/\\\"}"

    printf '"%s"' "$VALUE"
}


# ------------------------------------------------------------
# Safely add or replace KEY=value in an env-style file.
#
# Duplicate values for the same key are collapsed into one.
# VALUE should already be formatted exactly as it should
# appear after the equals sign.
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
echo "  Generic Laravel + Docker Guided Setup"
echo "============================================================"
echo


# ============================================================
# Step 1
# Make every shell script executable
# ============================================================

echo "🔧 Making shell scripts executable..."


find "$PROJECT_ROOT" \
    -type f \
    -name '*.sh' \
    -exec chmod +x {} \;


ok "Shell scripts are executable."


# ============================================================
# Step 2
# Verify template files
# ============================================================

echo
echo "🔎 Checking template files..."


REQUIRED_TEMPLATE_FILES=(

    "$PROJECT_ROOT/Dockerfile"

    "$PROJECT_ROOT/compose.yml"

    "$PROJECT_ROOT/.gitignore"

    "$PROJECT_ROOT/.dockerignore"

    "$SCRIPTS_DIR/environmentGuard.sh"

    "$SCRIPTS_DIR/setup-laravel.sh"

    "$SCRIPTS_DIR/setup-frontend.sh"

)


for REQUIRED_FILE in "${REQUIRED_TEMPLATE_FILES[@]}"; do

    if [[ ! -f "$REQUIRED_FILE" ]]; then

        die "Required template file is missing:

  $REQUIRED_FILE"

    fi

done


ok "Required template files are present."


# ============================================================
# Step 3
# Select environment
# ============================================================

echo
echo "============================================================"
echo "  Environment"
echo "============================================================"
echo

echo "1) Development / local"
echo "2) Production"
echo


read -rp "Select environment [1]: " ENV_CHOICE

ENV_CHOICE="${ENV_CHOICE:-1}"


case "$ENV_CHOICE" in

    1|development|dev|local)

        SETUP_ENV="development"

        APP_ENV_VALUE="local"

        APP_DEBUG_VALUE="true"

        ;;


    2|production|prod)

        SETUP_ENV="production"

        APP_ENV_VALUE="production"

        APP_DEBUG_VALUE="false"

        echo
        echo "⚠️  Production mode selected."
        echo
        echo "Production setup assumes this application has already"
        echo "been created and tested in development."
        echo

        read -rp "Type 'production' to continue: " PROD_CONFIRM

        if [[ "$PROD_CONFIRM" != "production" ]]; then

            die "Production setup cancelled."

        fi

        ;;


    *)

        die "Unknown environment selection:

  $ENV_CHOICE"

        ;;

esac


ok "Selected environment: $SETUP_ENV"


# ============================================================
# Step 4
# Collect application information
# ============================================================

echo
echo "============================================================"
echo "  Application Information"
echo "============================================================"
echo


DEFAULT_APP_NAME="$(basename "$PROJECT_ROOT")"


APP_NAME="$(
    prompt_default \
        "Application name" \
        "$DEFAULT_APP_NAME"
)"


DEFAULT_COMPOSE_NAME="$(
    slugify "$APP_NAME"
)"


COMPOSE_PROJECT_NAME="$(
    prompt_default \
        "Docker Compose project name" \
        "$DEFAULT_COMPOSE_NAME"
)"


# Normalize user-entered Compose name.
COMPOSE_PROJECT_NAME="$(
    slugify "$COMPOSE_PROJECT_NAME"
)"


# ============================================================
# Application domain
#
# APP_DOMAIN should contain ONLY the hostname.
#
# Examples:
#
#   localhost
#   example.com
#   app.example.com
#
# Do NOT include:
#
#   https://
#   http://
#   trailing paths
# ============================================================

echo
echo "============================================================"
echo "  Application Domain"
echo "============================================================"
echo


if [[ "$SETUP_ENV" == "development" ]]; then

    APP_DOMAIN="$(
        prompt_default \
            "APP_DOMAIN" \
            "localhost"
    )"

else

    while true; do

        read -rp "APP_DOMAIN (example.com): " APP_DOMAIN

        APP_DOMAIN="${APP_DOMAIN#http://}"
        APP_DOMAIN="${APP_DOMAIN#https://}"
        APP_DOMAIN="${APP_DOMAIN%%/*}"


        if [[ -n "$APP_DOMAIN" ]]; then
            break
        fi


        echo
        echo "❌ APP_DOMAIN cannot be empty."

    done

fi


echo
echo "✅ APP_DOMAIN:"
echo
echo "  $APP_DOMAIN"


# ============================================================
# Application URL
# ============================================================

if [[ "$SETUP_ENV" == "development" ]]; then

    APP_URL="$(
        prompt_default \
            "APP_URL" \
            "http://localhost:8000"
    )"

else

    APP_URL="$(
        prompt_default \
            "APP_URL" \
            "https://$APP_DOMAIN"
    )"

fi


echo
echo "✅ APP_URL:"
echo
echo "  $APP_URL"


# ============================================================
# Step 5
# Development: install Laravel first if needed
# ============================================================

if [[ "$SETUP_ENV" == "development" ]]; then

    echo
    echo "============================================================"
    echo "  Laravel Setup"
    echo "============================================================"
    echo


    "$SCRIPTS_DIR/setup-laravel.sh"


else

    # --------------------------------------------------------
    # Production should be deploying an existing application.
    # --------------------------------------------------------

    if [[ ! -f "$PROJECT_ROOT/artisan" ]]; then

        die "Laravel was not found.

Production setup expects an existing application that was
created and tested in development first."

    fi


    if [[ ! -f "$PROJECT_ROOT/.env.example" ]]; then

        die ".env.example was not found.

Production setup expects the Laravel application's committed
.env.example file."

    fi


    info "Existing Laravel application detected."

fi


# ============================================================
# Step 6
# Make sure .env exists
# ============================================================

echo
echo "============================================================"
echo "  Environment Configuration"
echo "============================================================"
echo


ENV_FILE="$PROJECT_ROOT/.env"

ENV_EXAMPLE="$PROJECT_ROOT/.env.example"


if [[ ! -f "$ENV_FILE" ]]; then

    if [[ ! -f "$ENV_EXAMPLE" ]]; then

        die ".env.example does not exist, so .env cannot be created."

    fi


    echo "⚙️ Creating .env from .env.example..."


    cp \
        "$ENV_EXAMPLE" \
        "$ENV_FILE"


    chmod \
        0600 \
        "$ENV_FILE"


    ok ".env created."

else

    info "Existing .env detected."

fi


# ============================================================
# Step 7
# Write common application configuration
# ============================================================

echo
echo "⚙️ Writing application configuration..."


set_env_value \
    "$ENV_FILE" \
    "APP_NAME" \
    "$(quote_env_string "$APP_NAME")"


set_env_value \
    "$ENV_FILE" \
    "APP_ENV" \
    "$APP_ENV_VALUE"


set_env_value \
    "$ENV_FILE" \
    "APP_DEBUG" \
    "$APP_DEBUG_VALUE"


set_env_value \
    "$ENV_FILE" \
    "APP_URL" \
    "$APP_URL"


set_env_value \
    "$ENV_FILE" \
    "APP_DOMAIN" \
    "$APP_DOMAIN"


set_env_value \
    "$ENV_FILE" \
    "COMPOSE_PROJECT_NAME" \
    "$COMPOSE_PROJECT_NAME"


chmod \
    0600 \
    "$ENV_FILE"


ok ".env application values updated."


# ============================================================
# Step 8
# Keep .env.example useful for future clones
#
# No passwords/secrets are copied into .env.example.
# ============================================================

echo
echo "⚙️ Updating .env.example with safe template values..."


set_env_value \
    "$ENV_EXAMPLE" \
    "APP_NAME" \
    "$(quote_env_string "$APP_NAME")"


set_env_value \
    "$ENV_EXAMPLE" \
    "APP_ENV" \
    "local"


set_env_value \
    "$ENV_EXAMPLE" \
    "APP_DEBUG" \
    "true"


set_env_value \
    "$ENV_EXAMPLE" \
    "APP_URL" \
    "http://localhost:8000"


set_env_value \
    "$ENV_EXAMPLE" \
    "APP_DOMAIN" \
    "localhost"


set_env_value \
    "$ENV_EXAMPLE" \
    "COMPOSE_PROJECT_NAME" \
    "$COMPOSE_PROJECT_NAME"


# Deployment metadata is safe to document as defaults.
set_env_value \
    "$ENV_EXAMPLE" \
    "DEPLOY_USER" \
    "deploy"


set_env_value \
    "$ENV_EXAMPLE" \
    "DEPLOY_APP_DIR" \
    "/opt/$COMPOSE_PROJECT_NAME"


# Keep database secrets explicitly blank.
set_env_value \
    "$ENV_EXAMPLE" \
    "DB_PASSWORD" \
    ""


set_env_value \
    "$ENV_EXAMPLE" \
    "DB_ROOT_PASSWORD" \
    ""


ok ".env.example updated."


# ============================================================
# Step 9
# Ensure generic Caddyfile exists
# ============================================================

CADDY_FILE="$PROJECT_ROOT/Caddyfile"


if [[ ! -f "$CADDY_FILE" ]]; then

    echo
    echo "🌐 Creating generic Caddyfile..."


    cat > "$CADDY_FILE" <<'EOF'
# Generic Laravel Caddy Configuration
#
# APP_DOMAIN is passed into the Caddy container from .env.

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
# Step 10
# Development frontend setup
# ============================================================

if [[ "$SETUP_ENV" == "development" ]]; then

    echo
    echo "============================================================"
    echo "  Frontend Setup"
    echo "============================================================"
    echo


    "$SCRIPTS_DIR/setup-frontend.sh"


    # --------------------------------------------------------
    # If routes/web.php still contains only Laravel's default
    # welcome route, point it at the generated home page.
    #
    # Existing/custom routes are preserved.
    # --------------------------------------------------------

    ROUTES_FILE="$PROJECT_ROOT/routes/web.php"


    if [[ -f "$ROUTES_FILE" ]]; then

        ROUTE_COUNT="$(
            grep \
                -c \
                'Route::' \
                "$ROUTES_FILE" \
                || true
        )"


        if grep -q \
            "view('welcome')" \
            "$ROUTES_FILE" \
            && [[ "$ROUTE_COUNT" -eq 1 ]]
        then

            echo
            echo "🏠 Replacing Laravel's untouched default welcome route..."


            cat > "$ROUTES_FILE" <<'EOF'
<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'home');
EOF


            ok "Home route now uses resources/views/home.blade.php."

        else

            info "Existing/custom routes detected."

            info "routes/web.php was not modified."

        fi

    fi


    # --------------------------------------------------------
    # Final development verification
    # --------------------------------------------------------

    echo
    echo "============================================================"
    echo "  Development Verification"
    echo "============================================================"
    echo


    echo "🧪 Running Laravel tests..."


    php artisan test


    echo
    echo "🔎 Running TypeScript check..."


    npm run typecheck


    echo
    echo "🏗️ Running production frontend build..."


    npm run build


    echo
    echo "🧹 Clearing Laravel caches..."


    php artisan optimize:clear


    ok "Development verification passed."

fi


# ============================================================
# Step 11
# Production-specific values / permissions
# ============================================================

if [[ "$SETUP_ENV" == "production" ]]; then

    echo
    echo "============================================================"
    echo "  Production Deployment Metadata"
    echo "============================================================"
    echo


    DEFAULT_DEPLOY_USER="deploy"

    DEPLOY_USER="$(
        prompt_default \
            "Deployment username" \
            "$DEFAULT_DEPLOY_USER"
    )"


    DEFAULT_DEPLOY_APP_DIR="/opt/$COMPOSE_PROJECT_NAME"

    DEPLOY_APP_DIR="$(
        prompt_default \
            "Production application directory" \
            "$DEFAULT_DEPLOY_APP_DIR"
    )"


    if [[ "$DEPLOY_APP_DIR" != /* ]]; then

        die "Production application directory must be an absolute path."

    fi


    set_env_value \
        "$ENV_FILE" \
        "DEPLOY_USER" \
        "$DEPLOY_USER"


    set_env_value \
        "$ENV_FILE" \
        "DEPLOY_APP_DIR" \
        "$DEPLOY_APP_DIR"


    chmod \
        0600 \
        "$ENV_FILE"


    ok "Production deployment metadata stored in .env."


    # --------------------------------------------------------
    # Validate production environment using the same guardian
    # used by deploy.sh.
    #
    # setup.sh itself cannot source the guardian because setup.sh
    # is intentionally not part of the environment policy.
    #
    # Instead verify the important production values directly.
    # --------------------------------------------------------

    if [[ "$APP_ENV_VALUE" != "production" ]]; then

        die "Internal error: production APP_ENV was not configured."

    fi


    if [[ "$APP_DEBUG_VALUE" != "false" ]]; then

        die "Internal error: APP_DEBUG must be false in production."

    fi


    # --------------------------------------------------------
    # Optional privileged permissions setup.
    #
    # This script remains interactive because it owns the
    # privileged user/group decisions.
    # --------------------------------------------------------

    if [[ -f "$PROJECT_ROOT/SetupUserAndPermissions.sh" ]]; then

        echo
        read -rp "Run SetupUserAndPermissions.sh now? [Y/n]: " RUN_USER_SETUP


        if [[ ! "$RUN_USER_SETUP" =~ ^[Nn]$ ]]; then

            echo
            echo "🔐 Starting privileged user/permissions setup..."
            echo
            echo "The permissions script will ask for its own username"
            echo "and application-directory confirmation."
            echo


            sudo "$PROJECT_ROOT/SetupUserAndPermissions.sh"

        else

            info "User/permissions setup skipped."

        fi

    else

        info "SetupUserAndPermissions.sh was not found."

    fi


    # --------------------------------------------------------
    # Compose validation
    # --------------------------------------------------------

    if command -v docker >/dev/null 2>&1 \
        && docker compose version >/dev/null 2>&1
    then

        echo
        echo "🐳 Validating Docker Compose configuration..."


        docker compose config --quiet


        ok "Docker Compose configuration is valid."

    else

        info "Docker/Compose not available in this session."

        info "Compose validation skipped."

    fi

fi


# ============================================================
# Step 12
# Final executable pass
#
# Some setup stages may have created additional .sh files.
# ============================================================

echo
echo "🔧 Performing final executable-permission pass..."


find "$PROJECT_ROOT" \
    -type f \
    -name '*.sh' \
    -exec chmod +x {} \;


ok "Shell-script permissions finalized."


# ============================================================
# Summary
# ============================================================

echo
echo "============================================================"
echo "✅ GUIDED SETUP COMPLETE"
echo "============================================================"
echo


echo "Environment:"
echo
echo "  $SETUP_ENV"
echo


echo "Application:"
echo
echo "  $APP_NAME"
echo


echo "Application URL:"
echo
echo "  $APP_URL"
echo


echo "Domain:"
echo
echo "  $APP_DOMAIN"
echo


echo "Compose project:"
echo
echo "  $COMPOSE_PROJECT_NAME"
echo


if [[ "$SETUP_ENV" == "development" ]]; then

    echo "Local development is ready."
    echo
    echo "The project has been:"
    echo
    echo "  - configured"
    echo "  - given an APP_KEY"
    echo "  - configured for React"
    echo "  - configured for TypeScript"
    echo "  - configured for SCSS"
    echo "  - configured for Vite"
    echo "  - given a Blade home template"
    echo "  - type checked"
    echo "  - production-asset built"
    echo "  - Laravel tested"
    echo
    echo "To work on the site, the normal development processes are:"
    echo
    echo "  php artisan serve"
    echo "  npm run dev"
    echo
    echo "After making a visible test change, verify it locally before"
    echo "committing and pushing to GitHub."

else

    echo "Production configuration has been prepared."
    echo
    echo "Deployment user:"
    echo
    echo "  $DEPLOY_USER"
    echo
    echo "Deployment directory:"
    echo
    echo "  $DEPLOY_APP_DIR"
    echo
    echo "If the deployment user was newly added to the docker group,"
    echo "start a new login session before running Docker as that user."
    echo
    echo "Production deployment is performed by:"
    echo
    echo "  ./deploy.sh"

fi


echo
echo "Configuration file:"
echo
echo "  $ENV_FILE"
echo


echo "Documentation:"
echo
echo "  $PROJECT_ROOT/SETUP.md"
echo
