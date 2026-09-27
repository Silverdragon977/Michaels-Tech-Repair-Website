#!/usr/bin/env bash

# ============================================================
# Environment Guardian
#
# Reads APP_ENV from the project's .env file.
#
# Determines which script called this file and checks whether
# that script is allowed to execute in the current environment.
#
# Individual scripts DO NOT specify their environment.
# All environment permissions are controlled here.
# ============================================================

set -Eeuo pipefail

# ------------------------------------------------------------
# Locate project
# ------------------------------------------------------------

GUARD_DIR="$(
    cd "$(dirname "${BASH_SOURCE[0]}")"
    pwd
)"

PROJECT_ROOT="$(
    cd "$GUARD_DIR/.."
    pwd
)"

ENV_FILE="$PROJECT_ROOT/.env"

# The script that sourced this guardian.
CALLER_PATH="${BASH_SOURCE[1]:-unknown}"
CALLER_NAME="$(basename "$CALLER_PATH")"


# ------------------------------------------------------------
# Error helper
# ------------------------------------------------------------

deny() {
    echo
    echo "❌ ENVIRONMENT GUARD BLOCKED EXECUTION"
    echo
    echo "Script:"
    echo "  $CALLER_NAME"
    echo
    echo "$1"
    echo

    exit 1
}


# ------------------------------------------------------------
# Make sure .env exists
# ------------------------------------------------------------

if [[ ! -f "$ENV_FILE" ]]; then
    deny ".env was not found at:

  $ENV_FILE

This script requires a configured Laravel environment."
fi


# ------------------------------------------------------------
# Read APP_ENV
#
# Do NOT source .env.
#
# A Laravel .env file is configuration data, not necessarily
# valid or safe Bash syntax.
# ------------------------------------------------------------

APP_ENV="$(
    grep -E '^[[:space:]]*APP_ENV[[:space:]]*=' "$ENV_FILE" \
        | tail -n 1 \
        | cut -d= -f2- \
        | sed \
            -e 's/^[[:space:]]*//' \
            -e 's/[[:space:]]*$//' \
            -e 's/^"//' \
            -e 's/"$//' \
            -e "s/^'//" \
            -e "s/'$//"
)"


if [[ -z "$APP_ENV" ]]; then
    deny "APP_ENV is missing or empty in:

  $ENV_FILE"
fi


# ------------------------------------------------------------
# Normalize environment names
#
# Laravel normally uses:
#
#   APP_ENV=local
#   APP_ENV=production
#
# But development/dev and prod are accepted here as aliases.
# ------------------------------------------------------------

case "$APP_ENV" in

    local|development|dev)
        CURRENT_ENV="development"
        ;;

    production|prod)
        CURRENT_ENV="production"
        ;;

    testing|test)
        CURRENT_ENV="testing"
        ;;

    *)
        deny "Unknown APP_ENV value:

  APP_ENV=$APP_ENV

Recognized environments are:
  development
  production
  testing"
        ;;

esac


# ------------------------------------------------------------
# Environment policy
#
# THIS IS THE CENTRAL LOCATION THAT CONTROLS WHICH SCRIPTS
# ARE ALLOWED TO RUN IN EACH ENVIRONMENT.
# ------------------------------------------------------------

case "$CALLER_NAME" in

    setup-laravel.sh|setup-frontend.sh)

        ALLOWED_ENVIRONMENTS=(
            "development"
        )

        ;;


    deploy.sh|pullFromGitClean.sh)

        ALLOWED_ENVIRONMENTS=(
            "production"
        )

        ;;


    checkHealth.sh)

        ALLOWED_ENVIRONMENTS=(
            "development"
            "production"
        )

        ;;


    *)

        deny "No environment policy has been defined for:

  $CALLER_NAME

Add this script to:

  scripts/environmentGuard.sh

before allowing it to execute."

        ;;

esac


# ------------------------------------------------------------
# Determine whether current environment is permitted
# ------------------------------------------------------------

IS_ALLOWED=false

for ALLOWED_ENV in "${ALLOWED_ENVIRONMENTS[@]}"; do

    if [[ "$CURRENT_ENV" == "$ALLOWED_ENV" ]]; then
        IS_ALLOWED=true
        break
    fi

done


# ------------------------------------------------------------
# Deny incorrect environment
# ------------------------------------------------------------

if [[ "$IS_ALLOWED" != true ]]; then

    echo
    echo "❌ ENVIRONMENT GUARD BLOCKED EXECUTION"
    echo
    echo "Script:"
    echo "  $CALLER_NAME"
    echo
    echo "Current environment:"
    echo "  $CURRENT_ENV"
    echo
    echo "This script may only run in:"

    for ALLOWED_ENV in "${ALLOWED_ENVIRONMENTS[@]}"; do
        echo "  - $ALLOWED_ENV"
    done

    echo
    echo "APP_ENV was read from:"
    echo "  $ENV_FILE"
    echo

    exit 1

fi


# ------------------------------------------------------------
# Extra production safety validation
# ------------------------------------------------------------

if [[ "$CURRENT_ENV" == "production" ]]; then

    APP_DEBUG="$(
        grep -E '^[[:space:]]*APP_DEBUG[[:space:]]*=' "$ENV_FILE" \
            | tail -n 1 \
            | cut -d= -f2- \
            | sed \
                -e 's/^[[:space:]]*//' \
                -e 's/[[:space:]]*$//' \
                -e 's/^"//' \
                -e 's/"$//' \
                -e "s/^'//" \
                -e "s/'$//"
    )"

    if [[ "$APP_DEBUG" != "false" ]]; then

        deny "Production requires:

  APP_DEBUG=false

Current value:

  APP_DEBUG=$APP_DEBUG"

    fi

fi


# ------------------------------------------------------------
# Success
# ------------------------------------------------------------

echo "✅ Environment Guard"
echo "   Script:      $CALLER_NAME"
echo "   Environment: $CURRENT_ENV"
echo
