ARG PHP_VERSION=8.4
ARG NODE_VERSION=22

############################################
# Base Image
############################################
FROM ghcr.io/yieldstudio/php:${PHP_VERSION}-frankenphp AS base

ENV HEALTHCHECK_PATH="/up"

############################################
# Development Image
############################################
FROM base AS development

ARG WWWUSER
ARG WWWGROUP
ARG NODE_VERSION=22
ARG MYSQL_CLIENT="mysql-client"
ARG POSTGRES_VERSION=17

ENV XDEBUG_MODE="off"
ENV XDEBUG_CONFIG="client_host=host.docker.internal"
ENV PHP_MEMORY_LIMIT=1024M

USER root

RUN apt-get update && apt-get upgrade -y \
    && mkdir -p /etc/apt/keyrings \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python3 dnsutils librsvg2-bin fswatch ffmpeg nano  \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && npm install -g pnpm \
    && npm install -g bun \
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor | tee /etc/apt/keyrings/yarn.gpg >/dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/yarn.gpg] https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
    && curl -sS https://www.postgresql.org/media/keys/ACCC4CF8.asc | gpg --dearmor | tee /etc/apt/keyrings/pgdg.gpg >/dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/pgdg.gpg] http://apt.postgresql.org/pub/repos/apt bookworm-pgdg main" > /etc/apt/sources.list.d/pgdg.list \
    && apt-get update \
    && apt-get install -y yarn \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-set-id www-data $WWWUSER:$WWWGROUP \
    && docker-php-set-file-permissions --owner $WWWUSER:$WWWGROUP --service frankenphp \
    && useradd -mNo -g www-data -u $(id -u www-data) sail

RUN install-php-extensions xdebug

USER www-data

############################################
# CI image
############################################
FROM base AS ci

ENV AUTORUN_ENABLED=false
ENV PHP_OPCACHE_ENABLE=0

ENV XDEBUG_MODE="coverage,debug"
ENV XDEBUG_CONFIG="client_host=host.docker.internal client_port=9003"

# Sometimes CI images need to run as root
# so we set the ROOT user and configure
# the PHP-FPM pool to run as www-data
USER root

RUN install-php-extensions xdebug

############################################
# Composer Build
############################################
FROM base AS composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --chown=www-data:www-data composer.* ./
COPY --chown=www-data:www-data . .

RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist \
    && composer dump-autoload --classmap-authoritative --no-dev --optimize

############################################
# Assets Build
############################################
FROM node:${NODE_VERSION}-slim AS frontend

WORKDIR /app

COPY package*.json *.config.js ./
COPY public/ ./public
COPY resources/ ./resources
COPY app-modules/ ./app-modules
COPY --from=composer /var/www/html/vendor ./vendor

RUN if [ -f yarn.lock ]; then \
        yarn install --frozen-lockfile && yarn run build; \
    elif [ -f package-lock.json ]; then \
        npm ci && npm run build; \
    elif [ -f pnpm-lock.yaml ]; then \
        pnpm install --frozen-lockfile && pnpm run build; \
    elif [ -f bun.lockb ]; then \
        bun install && bun run build; \
    else \
        echo "No lock file found, skipping asset build."; \
    fi

############################################
# Production Image
############################################
FROM base

ENV AUTORUN_ENABLED=true
ENV PHP_OPCACHE_ENABLE=1
ENV PHP_MEMORY_LIMIT=512M
ENV SSL_MODE=mixed

USER root

RUN apt-get update && apt-get install -y openssh-client && rm -rf /var/lib/apt/lists/*

USER www-data

# Copy Filament assets from Composer
COPY --from=composer --chown=www-data:www-data /var/www/html/public/css ./public/css
COPY --from=composer --chown=www-data:www-data /var/www/html/public/js ./public/js

# Composer dependencies
COPY --from=composer --chown=www-data:www-data /var/www/html/vendor ./vendor

# Application assets
COPY --from=frontend --chown=www-data:www-data /app/public/build ./public/build

# Application source
COPY --chown=www-data:www-data . /var/www/html

# Start Octane with FrankenPHP
RUN php artisan octane:install --server=frankenphp -n
