#!/usr/bin/env bash

set -Eeuo pipefail

# ============================================================
# Michael's Tech Repair
# GitHub Actions -> DigitalOcean Deployment Trigger
#
# This script runs on the GitHub Actions runner.
#
# It DOES NOT build Docker containers or modify production.
# It only connects to the deployment user and invokes the
# existing production deploy.sh script.
#
# Credentials are supplied through GitHub environment secrets.
# Never commit SSH private keys or .env files.
# ============================================================


# ------------------------------------------------------------
# Required configuration
# ------------------------------------------------------------

: "${CD_HOST:?Missing CD_HOST}"
: "${CD_USER:?Missing CD_USER}"
: "${CD_SSH_KEY:?Missing CD_SSH_KEY}"
: "${CD_KNOWN_HOSTS:?Missing CD_KNOWN_HOSTS}"


# ------------------------------------------------------------
# Prepare temporary SSH credentials
# ------------------------------------------------------------

umask 077

SSH_DIR="$(mktemp -d)"

cleanup() {
    rm -rf "$SSH_DIR"
}

trap cleanup EXIT


printf '%s\n' "$CD_SSH_KEY" > "$SSH_DIR/deploy_key"

printf '%s\n' "$CD_KNOWN_HOSTS" > "$SSH_DIR/known_hosts"

chmod 600 "$SSH_DIR/deploy_key"
chmod 600 "$SSH_DIR/known_hosts"


# ------------------------------------------------------------
# Invoke the existing production deployment
# ------------------------------------------------------------

echo "Connecting to production deployment server..."

ssh \
    -i "$SSH_DIR/deploy_key" \
    -o IdentitiesOnly=yes \
    -o BatchMode=yes \
    -o StrictHostKeyChecking=yes \
    -o UserKnownHostsFile="$SSH_DIR/known_hosts" \
    -o ConnectTimeout=15 \
    "${CD_USER}@${CD_HOST}" \
    'cd /opt/laravel-app && ./deploy.sh'


echo "Production deployment command completed successfully."