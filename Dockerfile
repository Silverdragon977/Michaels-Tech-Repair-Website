# ============================================================
# Michael's Tech Repair
# Laravel Production Dockerfile
#
# Build stages:
#
#   1. frontend
#        Node
#        npm
#        React
#        TypeScript
#        SCSS
#        Vite
#
#   2. composer
#        PHP dependencies
#
#   3. production
#        PHP
#        Apache
#        Laravel
#
# Node/npm/Vite/TypeScript/Sass are NOT included in the
# final production image.
# ============================================================


# ============================================================
# Stage 1
# Frontend Build
# ============================================================

FROM node:22-alpine AS frontend


# ------------------------------------------------------------
# Work inside /app
# ------------------------------------------------------------

WORKDIR /app


# ------------------------------------------------------------
# Copy dependency files first.
#
# Docker can cache npm dependencies unless package.json or
# package-lock.json changes.
#
# package-lock.json should be committed to Git.
# ------------------------------------------------------------

COPY package.json package-lock.json ./


# ------------------------------------------------------------
# Install the exact dependency versions from package-lock.json
# ------------------------------------------------------------

RUN npm ci


# ------------------------------------------------------------
# Copy frontend source and Vite configuration
# ------------------------------------------------------------

COPY vite.config.ts ./

COPY tsconfig.json ./

COPY resources ./resources

COPY public ./public


# ------------------------------------------------------------
# TypeScript validation
#
# This fails the Docker build if TypeScript contains errors.
# ------------------------------------------------------------

RUN npm run typecheck


# ------------------------------------------------------------
# Production frontend build
#
# Creates:
#
#   public/build/
#
# containing the compiled JavaScript and CSS.
# ------------------------------------------------------------

RUN npm run build



# ============================================================
# Stage 2
# Composer / PHP Dependencies
# ============================================================

FROM composer:2 AS composer


# ------------------------------------------------------------
# Work inside /app
# ------------------------------------------------------------

WORKDIR /app


# ------------------------------------------------------------
# Copy Composer dependency definitions first for Docker cache.
# ------------------------------------------------------------

COPY composer.json composer.lock ./


# ------------------------------------------------------------
# Install production PHP dependencies.
#
# --no-dev
#     Development-only PHP packages are excluded.
#
# --prefer-dist
#     Prefer packaged releases instead of source repositories.
#
# --no-interaction
#     Appropriate for automated Docker builds.
#
# --no-progress
#     Keeps build output cleaner.
#
# --no-scripts
#     Avoid running Laravel scripts before the full project
#     source exists in this build stage.
# ------------------------------------------------------------

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --no-scripts


# ------------------------------------------------------------
# Copy the Laravel application.
#
# .dockerignore will prevent things such as:
#
#   .env
#   node_modules
#   vendor
#   .git
#
# from being copied.
# ------------------------------------------------------------

COPY . .


# ------------------------------------------------------------
# Build optimized Composer autoload files.
#
# Scripts remain disabled here because Laravel production
# initialization will happen in the final image/runtime.
# ------------------------------------------------------------

RUN composer dump-autoload \
    --optimize \
    --no-dev \
    --no-scripts



# ============================================================
# Stage 3
# Production Laravel Runtime
# ============================================================

FROM php:8.3-apache AS production


# ------------------------------------------------------------
# Production environment defaults
#
# Actual Laravel values such as APP_ENV and APP_DEBUG are
# supplied by compose.yml from the runtime .env.
# ------------------------------------------------------------

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public


# ------------------------------------------------------------
# Install Linux packages required by Laravel/PHP.
#
# curl
#     Used by the Docker health check.
#
# unzip
#     Useful for PHP package operations/debugging.
#
# libzip-dev
#     Required for PHP zip support.
#
# libonig-dev
#     Required for mbstring.
# ------------------------------------------------------------

RUN apt-get update \
    && apt-get install -y \
        --no-install-recommends \
        curl \
        unzip \
        libzip-dev \
        libonig-dev \
    && docker-php-ext-install \
        mbstring \
        pdo_mysql \
        zip \
        opcache \
    && rm -rf /var/lib/apt/lists/*


# ------------------------------------------------------------
# Enable Apache modules Laravel/Caddy may need.
#
# rewrite
#     Allows Laravel's public/.htaccess routing.
#
# headers
#     Useful for HTTP header configuration.
# ------------------------------------------------------------

RUN a2enmod \
    rewrite \
    headers


# ------------------------------------------------------------
# Change Apache's web root from:
#
#   /var/www/html
#
# to Laravel's:
#
#   /var/www/html/public
#
# This prevents application source files from being exposed
# directly by Apache.
# ------------------------------------------------------------

RUN sed -ri \
    -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf


# ------------------------------------------------------------
# Application directory
# ------------------------------------------------------------

WORKDIR /var/www/html


# ------------------------------------------------------------
# Copy the Laravel application from the Composer build stage.
# ------------------------------------------------------------

COPY --from=composer /app /var/www/html


# ------------------------------------------------------------
# Copy only the compiled frontend assets from Node stage.
#
# The Node environment itself is discarded.
# ------------------------------------------------------------

COPY --from=frontend \
    /app/public/build \
    /var/www/html/public/build


# ------------------------------------------------------------
# Laravel writable directories
#
# Apache/PHP runs Laravel requests as www-data.
#
# Only directories Laravel actually needs to write to are
# assigned to www-data.
#
# The entire Laravel application is NOT made writable.
# ------------------------------------------------------------

RUN mkdir -p \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R \
        www-data:www-data \
        storage \
        bootstrap/cache \
    && chmod -R \
        775 \
        storage \
        bootstrap/cache


# ------------------------------------------------------------
# Apache listens internally on port 80.
#
# This does NOT expose the port publicly.
#
# compose.yml uses:
#
#   expose:
#     - "80"
#
# so only Caddy can reach it through the Docker network.
# ------------------------------------------------------------

EXPOSE 80


# ============================================================
# Health Check
#
# Laravel provides:
#
#   /up
#
# The container is considered healthy only if Laravel
# successfully answers the request.
# ============================================================

HEALTHCHECK \
    --interval=30s \
    --timeout=5s \
    --start-period=20s \
    --retries=3 \
    CMD curl -fsS http://localhost/up || exit 1


# ------------------------------------------------------------
# The official PHP Apache image already contains the correct
# startup command.
#
# We therefore do NOT need to specify CMD or ENTRYPOINT here.
# ------------------------------------------------------------
