#!/usr/bin/env bash

set -Eeuo pipefail
umask 027


# ============================================================
# Generic Laravel / Docker Template
# SetupUserAndPermissions.sh
#
# Purpose:
#
#   - Create or reuse a dedicated deployment user
#   - Optionally set/change its password
#   - Give the deployment user Docker access
#   - Create the production application directory
#   - Correct host-side ownership and permissions
#   - Store DEPLOY_USER and DEPLOY_APP_DIR in .env if it exists
#   - Secure .env if it exists
#   - Make known project scripts executable when present
#
# SSH keys are intentionally NOT configured here.
#
# This is intended for production server bootstrap.
#
# It may run before Laravel or .env exists, so it does not use
# environmentGuard.sh.
#
# Run with:
#
#   sudo ./SetupUserAndPermissions.sh
# ============================================================


# ------------------------------------------------------------
# Generic defaults
#
# The future master setup.sh can provide project-specific
# values instead.
# ------------------------------------------------------------

DEFAULT_USER="deploy"

DEFAULT_APP_DIR="/opt/laravel-app"


# ------------------------------------------------------------
# Helper functions
# ------------------------------------------------------------

die() {

    echo
    echo "❌ ERROR: $*" >&2
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
# Must run as root
#
# User/group changes and /opt directory ownership require
# administrative privileges.
# ============================================================

if [[ "${EUID}" -ne 0 ]]; then

    die "Run this script with sudo:

  sudo ./SetupUserAndPermissions.sh"

fi


# ============================================================
# Header
# ============================================================

echo
echo "============================================================"
echo "  Deployment User & Permissions Setup"
echo "============================================================"
echo


# ============================================================
# Deployment username
# ============================================================

read -rp "Deployment username [${DEFAULT_USER}]: " DEPLOY_USER


DEPLOY_USER="${DEPLOY_USER:-$DEFAULT_USER}"


# ------------------------------------------------------------
# Validate Linux username
# ------------------------------------------------------------

if [[ ! "$DEPLOY_USER" =~ ^[a-z_][a-z0-9_-]*$ ]]; then

    die "Invalid Linux username:

  $DEPLOY_USER"

fi


# ============================================================
# Application directory
# ============================================================

read -rp "Application directory [${DEFAULT_APP_DIR}]: " APP_DIR


APP_DIR="${APP_DIR:-$DEFAULT_APP_DIR}"


# ------------------------------------------------------------
# Require an absolute path
# ------------------------------------------------------------

if [[ "$APP_DIR" != /* ]]; then

    die "Application directory must be an absolute path.

Example:

  /opt/myapplication"

fi


# ============================================================
# Create or reuse deployment user
# ============================================================

if id "$DEPLOY_USER" >/dev/null 2>&1; then

    info "User '$DEPLOY_USER' already exists."

    info "Existing account will be reused."

else

    echo
    echo "👤 Creating deployment user '$DEPLOY_USER'..."


    useradd \
        --create-home \
        --shell /bin/bash \
        "$DEPLOY_USER"


    ok "Created deployment user '$DEPLOY_USER'."

fi


# ============================================================
# Determine deployment user's home directory
# ============================================================

DEPLOY_HOME="$(
    getent passwd "$DEPLOY_USER" \
        | cut -d: -f6
)"


if [[ -z "$DEPLOY_HOME" ]]; then

    die "Could not determine home directory for:

  $DEPLOY_USER"

fi


# ============================================================
# Optional local password
#
# passwd is used directly so the password is not stored:
#
#   - in this script
#   - in a variable
#   - in shell history
# ============================================================

echo

read -rp "Set/change a local password for '$DEPLOY_USER'? [y/N]: " SET_PASSWORD


if [[ "$SET_PASSWORD" =~ ^[Yy]$ ]]; then

    echo

    passwd "$DEPLOY_USER"


    ok "Password updated."

else

    info "Password setup skipped."

fi


# ============================================================
# Docker access
# ============================================================

echo
echo "🐳 Configuring Docker access..."


# ------------------------------------------------------------
# Docker group should normally already exist on a Docker host.
#
# Create it if necessary.
# ------------------------------------------------------------

if ! getent group docker >/dev/null 2>&1; then

    info "Docker group does not exist."

    info "Creating Docker group..."


    groupadd docker


    ok "Docker group created."

fi


# ------------------------------------------------------------
# Add deployment user to Docker group
# ------------------------------------------------------------

if id -nG "$DEPLOY_USER" \
    | tr ' ' '\n' \
    | grep -qx docker
then

    info "'$DEPLOY_USER' is already in the docker group."

else

    usermod \
        -aG docker \
        "$DEPLOY_USER"


    ok "Added '$DEPLOY_USER' to the docker group."

fi


# ============================================================
# Application directory
# ============================================================

echo
echo "📁 Preparing application directory..."


# ------------------------------------------------------------
# Create application directory.
#
# Permissions:
#
#   750
#
# Owner:
#   read/write/execute
#
# Group:
#   read/execute
#
# Others:
#   no access
# ------------------------------------------------------------

install \
    -d \
    -m 0750 \
    -o "$DEPLOY_USER" \
    -g "$DEPLOY_USER" \
    "$APP_DIR"


ok "Application directory exists."


# ============================================================
# Existing application files
#
# If files already exist, optionally correct ownership.
# ============================================================

if find "$APP_DIR" \
    -mindepth 1 \
    -print \
    -quit \
    2>/dev/null \
    | grep -q .
then

    echo
    echo "The application directory already contains files."
    echo


    read -rp "Make '$DEPLOY_USER' the owner of everything in it? [Y/n]: " FIX_OWNER


    if [[ ! "$FIX_OWNER" =~ ^[Nn]$ ]]; then

        echo
        echo "🔧 Correcting application ownership..."


        chown \
            -R \
            "$DEPLOY_USER:$DEPLOY_USER" \
            "$APP_DIR"


        ok "Application ownership corrected."

    else

        info "Existing file ownership was left unchanged."

    fi

fi


# ------------------------------------------------------------
# Keep root application directory at 750.
# ------------------------------------------------------------

chmod \
    0750 \
    "$APP_DIR"


# ============================================================
# Deployment metadata
#
# Store reusable deployment information in .env if it already
# exists.
#
# These values allow other scripts to avoid hard-coding:
#
#   usernames
#   application directories
# ============================================================

ENV_FILE="$APP_DIR/.env"


if [[ -f "$ENV_FILE" ]]; then

    echo
    echo "⚙️ Existing .env detected."
    echo "⚙️ Saving deployment configuration..."


    # ========================================================
    # DEPLOY_USER
    #
    # Replace an existing value or append it if missing.
    # ========================================================

    if grep -qE \
        '^[[:space:]]*DEPLOY_USER=' \
        "$ENV_FILE"
    then

        sed \
            -i \
            "s|^[[:space:]]*DEPLOY_USER=.*|DEPLOY_USER=$DEPLOY_USER|" \
            "$ENV_FILE"


        ok "Updated DEPLOY_USER in .env."

    else

        echo >> "$ENV_FILE"


        echo "DEPLOY_USER=$DEPLOY_USER" \
            >> "$ENV_FILE"


        ok "Added DEPLOY_USER to .env."

    fi


    # ========================================================
    # DEPLOY_APP_DIR
    #
    # Replace an existing value or append it if missing.
    # ========================================================

    if grep -qE \
        '^[[:space:]]*DEPLOY_APP_DIR=' \
        "$ENV_FILE"
    then

        sed \
            -i \
            "s|^[[:space:]]*DEPLOY_APP_DIR=.*|DEPLOY_APP_DIR=$APP_DIR|" \
            "$ENV_FILE"


        ok "Updated DEPLOY_APP_DIR in .env."

    else

        echo "DEPLOY_APP_DIR=$APP_DIR" \
            >> "$ENV_FILE"


        ok "Added DEPLOY_APP_DIR to .env."

    fi


    # ========================================================
    # Secure .env
    # ========================================================

    chown \
        "$DEPLOY_USER:$DEPLOY_USER" \
        "$ENV_FILE"


    chmod \
        0600 \
        "$ENV_FILE"


    ok ".env secured with permissions 0600."

else

    echo

    info "No .env exists yet."


    echo
    echo "Expected deployment values once .env exists:"
    echo
    echo "  DEPLOY_USER=$DEPLOY_USER"
    echo "  DEPLOY_APP_DIR=$APP_DIR"
    echo

fi


# ============================================================
# Known project scripts
#
# If these files already exist, make sure the deployment user
# owns them and they are executable.
#
# Files that do not exist yet are simply skipped.
# ============================================================

echo
echo "🔧 Checking project scripts..."


KNOWN_SCRIPTS=(

    "$APP_DIR/setup.sh"

    "$APP_DIR/deploy.sh"

    "$APP_DIR/pullFromGitClean2.sh"

    "$APP_DIR/SetupUserAndPermissions.sh"

    "$APP_DIR/scripts/environmentGuard.sh"

    "$APP_DIR/scripts/setup-laravel.sh"

    "$APP_DIR/scripts/setup-frontend.sh"

)


for SCRIPT in "${KNOWN_SCRIPTS[@]}"; do

    if [[ -f "$SCRIPT" ]]; then

        chown \
            "$DEPLOY_USER:$DEPLOY_USER" \
            "$SCRIPT"


        chmod \
            0750 \
            "$SCRIPT"


        ok "Configured ${SCRIPT#$APP_DIR/}"

    fi

done


# ============================================================
# Verification
# ============================================================

echo
echo "🔎 Verifying configuration..."


# ------------------------------------------------------------
# Read actual directory ownership
# ------------------------------------------------------------

ACTUAL_OWNER="$(
    stat \
        -c '%U' \
        "$APP_DIR"
)"


ACTUAL_GROUP="$(
    stat \
        -c '%G' \
        "$APP_DIR"
)"


ACTUAL_MODE="$(
    stat \
        -c '%a' \
        "$APP_DIR"
)"


# ------------------------------------------------------------
# Verify owner
# ------------------------------------------------------------

if [[ "$ACTUAL_OWNER" != "$DEPLOY_USER" ]]; then

    die "Application directory owner is incorrect.

Expected:

  $DEPLOY_USER

Found:

  $ACTUAL_OWNER"

fi


# ------------------------------------------------------------
# Verify group
# ------------------------------------------------------------

if [[ "$ACTUAL_GROUP" != "$DEPLOY_USER" ]]; then

    die "Application directory group is incorrect.

Expected:

  $DEPLOY_USER

Found:

  $ACTUAL_GROUP"

fi


# ------------------------------------------------------------
# Verify directory permissions
# ------------------------------------------------------------

if [[ "$ACTUAL_MODE" != "750" ]]; then

    die "Application directory permissions are incorrect.

Expected:

  750

Found:

  $ACTUAL_MODE"

fi


# ------------------------------------------------------------
# Verify Docker group membership
# ------------------------------------------------------------

if ! id -nG "$DEPLOY_USER" \
    | tr ' ' '\n' \
    | grep -qx docker
then

    die "'$DEPLOY_USER' was not successfully added to the docker group."

fi


ok "Deployment user configuration looks correct."

ok "Docker group membership looks correct."

ok "Application directory ownership looks correct."

ok "Application directory permissions look correct."


# ============================================================
# Display stored deployment metadata
# ============================================================

if [[ -f "$ENV_FILE" ]]; then

    echo
    echo "🔎 Deployment information stored in .env:"
    echo
    echo "  DEPLOY_USER=$DEPLOY_USER"
    echo "  DEPLOY_APP_DIR=$APP_DIR"

fi


# ============================================================
# Final summary
# ============================================================

echo
echo "============================================================"
echo "✅ Setup complete"
echo "============================================================"
echo


echo "Deployment user:"
echo
echo "  $DEPLOY_USER"
echo


echo "Home directory:"
echo
echo "  $DEPLOY_HOME"
echo


echo "Application directory:"
echo
echo "  $APP_DIR"
echo


echo "Application ownership:"
echo
echo "  $DEPLOY_USER:$DEPLOY_USER"
echo


echo "Application directory permissions:"
echo
echo "  750"
echo


# ============================================================
# Docker group notice
# ============================================================

echo "------------------------------------------------------------"
echo "Docker access"
echo "------------------------------------------------------------"
echo

echo "The deployment user was added to the docker group."

echo
echo "Start a NEW login session before testing Docker as:"
echo
echo "  $DEPLOY_USER"

echo
echo "Then test with:"
echo
echo "  docker ps"
echo


# ============================================================
# Repository ownership reminder
# ============================================================

echo "------------------------------------------------------------"
echo "Repository ownership"
echo "------------------------------------------------------------"
echo

echo "Clone and pull the Git repository as:"
echo
echo "  $DEPLOY_USER"

echo
echo "Do NOT clone the application as root."

echo
echo "Do NOT run production deployment scripts with sudo."
echo


# ============================================================
# Container permissions reminder
# ============================================================

echo "------------------------------------------------------------"
echo "Laravel web-server permissions"
echo "------------------------------------------------------------"
echo

echo "Host-side application files stay owned by:"
echo
echo "  $DEPLOY_USER"

echo
echo "Do NOT change the host repository to www-data."

echo
echo "Laravel runs inside Docker."

echo
echo "The Dockerfile handles www-data ownership inside the"
echo "container for Laravel's writable directories:"
echo
echo "  storage/"
echo "  bootstrap/cache/"
echo


# ============================================================
# Security notice
# ============================================================

echo "------------------------------------------------------------"
echo "Security notice"
echo "------------------------------------------------------------"
echo

echo "A user in the docker group effectively has root-level"
echo "control of the server through the Docker daemon."

echo
echo "Only trusted deployment accounts should be members."
echo


echo "✅ SetupUserAndPermissions.sh finished successfully."
echo
