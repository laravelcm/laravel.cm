# syntax=docker/dockerfile:1.4
ARG PHP_VERSION=8.4
ARG NODE_VERSION=22

#---------------------------------
# Base Image
#---------------------------------
FROM ghcr.io/yieldstudio/php:${PHP_VERSION}-frankenphp AS base

ENV HEALTHCHECK_PATH="/up"

#---------------------------------
# Development Image
#---------------------------------
FROM base AS development

ARG WWWUSER
ARG WWWGROUP
ARG NODE_VERSION=22
ARG MYSQL_CLIENT="mysql-client"
ARG POSTGRES_VERSION=17

ENV XDEBUG_MODE="coverage,debug"
ENV XDEBUG_CONFIG="client_host=host.docker.internal"
ENV PHP_MEMORY_LIMIT=1024M

USER root

# Use BuildKit cache mount for apt packages
RUN --mount=type=cache,target=/var/cache/apt,sharing=locked \
    --mount=type=cache,target=/var/lib/apt,sharing=locked \
    apt-get update && apt-get upgrade -y \
    && mkdir -p /etc/apt/keyrings \
    && apt-get install -y --no-install-recommends \
        gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 \
        libcap2-bin libpng-dev python3 dnsutils librsvg2-bin fswatch ffmpeg nano \
        libevent-2.1-7 libevent-core-2.1-7 libevent-extra-2.1-7 \
        libevent-openssl-2.1-7 libevent-pthreads-2.1-7 \
        libflite1 flite1-dev libenchant-2-2 libsecret-1-0 \
        libmanette-0.2-0 libgles2-mesa libx264-dev \
        openssh-client netcat-openbsd \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && curl -sS https://www.postgresql.org/media/keys/ACCC4CF8.asc | gpg --dearmor | tee /etc/apt/keyrings/pgdg.gpg >/dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/pgdg.gpg] http://apt.postgresql.org/pub/repos/apt bookworm-pgdg main" > /etc/apt/sources.list.d/pgdg.list \
    && apt-get update \
    && apt-get install -y --no-install-recommends nodejs \
    && npm install -g npm \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-set-id www-data $WWWUSER:$WWWGROUP \
    && docker-php-set-file-permissions --owner $WWWUSER:$WWWGROUP --service frankenphp \
    && useradd -mNo -g www-data -u $(id -u www-data) sail

RUN install-php-extensions xdebug sockets

USER www-data

#---------------------------------
# CI image
#---------------------------------
FROM base AS ci

ENV AUTORUN_ENABLED=false
ENV PHP_OPCACHE_ENABLE=0

ENV XDEBUG_MODE="coverage,debug"
ENV XDEBUG_CONFIG="client_host=host.docker.internal client_port=9003"

# Sometimes CI images need to run as root
# so we set the ROOT user and configure
# the PHP-FPM pool to run as www-data
USER root

RUN install-php-extensions xdebug sockets

#---------------------------------
# Composer Build
#---------------------------------
FROM base AS composer

ARG FLUX_USERNAME
ARG FLUX_LICENSE_KEY
ARG PURELINE_USERNAME
ARG PURELINE_LICENSE_KEY

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy only composer files first for better caching
COPY --chown=www-data:www-data composer.json composer.lock* ./

# Copy app-modules directory (required for path dependencies in composer.json)
COPY --chown=www-data:www-data app-modules/ ./app-modules/

# Configure composer cache directory
RUN --mount=type=cache,target=/tmp/.composer-cache \
    composer config cache-dir /tmp/.composer-cache

# Validate and configure Flux credentials (required for Flux Pro packages)
RUN --mount=type=cache,target=/tmp/.composer-cache \
    if [ -z "$FLUX_USERNAME" ] || [ -z "$FLUX_LICENSE_KEY" ]; then \
        echo "ERROR: FLUX_USERNAME and FLUX_LICENSE_KEY are required build arguments" >&2; \
        exit 1; \
    fi && \
    composer config http-basic.composer.fluxui.dev "$FLUX_USERNAME" "$FLUX_LICENSE_KEY"

# Validate and configure Pureline credentials (required for anystack packages)
RUN --mount=type=cache,target=/tmp/.composer-cache \
    if [ -z "$PURELINE_USERNAME" ] || [ -z "$PURELINE_LICENSE_KEY" ]; then \
        echo "ERROR: PURELINE_USERNAME and PURELINE_LICENSE_KEY are required build arguments" >&2; \
        exit 1; \
    fi && \
    composer config http-basic.pureline.composer.sh "$PURELINE_USERNAME" "$PURELINE_LICENSE_KEY"

# Install dependencies with cache mount
RUN --mount=type=cache,target=/tmp/.composer-cache \
    composer install --no-dev --no-interaction --no-scripts --prefer-dist --no-autoloader

# Copy application code (needed for autoloader generation)
COPY --chown=www-data:www-data . .

# Generate optimized autoloader
RUN --mount=type=cache,target=/tmp/.composer-cache \
    composer dump-autoload --classmap-authoritative --no-dev --optimize

#---------------------------------
# Assets Build
#---------------------------------
FROM node:${NODE_VERSION}-slim AS frontend

WORKDIR /app

# Copy package files first for better caching
COPY package*.json *.config.js ./

# Install dependencies with npm cache mount
RUN --mount=type=cache,target=/root/.npm \
    npm ci --prefer-offline --no-audit

# Copy application files needed for build
COPY public/ ./public
COPY resources/ ./resources
COPY app-modules/ ./app-modules
COPY --from=composer /var/www/html/vendor ./vendor

# Build assets
RUN npm run build

#---------------------------------
# Production Image
#---------------------------------
FROM base

ENV \
    AUTORUN_ENABLED=true \
    SSL_MODE=off \
    PHP_OPCACHE_ENABLE=1 \
    PHP_MEMORY_LIMIT=512M \
    OCTANE_SERVER=frankenphp \
    HEALTHCHECK_PATH="/up"

USER root

# Install only runtime dependencies
RUN --mount=type=cache,target=/var/cache/apt,sharing=locked \
    --mount=type=cache,target=/var/lib/apt,sharing=locked \
    apt-get update \
    && apt-get install -y --no-install-recommends openssh-client \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

USER www-data

# Copy only necessary files from composer stage
COPY --from=composer --chown=www-data:www-data /var/www/html/public/css ./public/css
COPY --from=composer --chown=www-data:www-data /var/www/html/public/js ./public/js
COPY --from=composer --chown=www-data:www-data /var/www/html/public/fonts ./public/fonts
COPY --from=composer --chown=www-data:www-data /var/www/html/vendor ./vendor

# Copy built assets from frontend stage
COPY --from=frontend --chown=www-data:www-data /app/public/build ./public/build

# Copy application code (excludes dev files via .dockerignore)
COPY --chown=www-data:www-data . /var/www/html

# Start Octane with FrankenPHP
RUN php artisan octane:install --server=frankenphp -n
