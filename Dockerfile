# ./Dockerfile
# [BASE STAGE]
FROM php:8.1-fpm-alpine as base
ARG app_env
# Install the php extension installer from its image
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# Install dependencies
RUN apk add --no-cache \
    openssl \
    ca-certificates \
    libxml2-dev \
    oniguruma-dev\
    libpq-dev
RUN apk add --no-cache zip libzip-dev
RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip

# Install php extensions
RUN install-php-extensions \
    bcmath \
    pcntl \
    iconv  \
    gettext

RUN apk add --no-cache \
      freetype \
      libjpeg-turbo \
      libpng \
      freetype-dev \
      libjpeg-turbo-dev \
      libpng-dev \
    && docker-php-ext-configure gd \
      --with-freetype=/usr/include/ \
      # --with-png=/usr/include/ \ # No longer necessary as of 7.4; https://github.com/docker-library/php/pull/910#issuecomment-559383597
      --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable gd \
    && apk del --no-cache \
      freetype-dev \
      libjpeg-turbo-dev \
      libpng-dev \
    && rm -rf /tmp/*

# Install Postgre PDO
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql pgsql

# Install the composer packages using www-data user
WORKDIR /app
RUN chown www-data:www-data /app
COPY --chown=www-data:www-data . .
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer
USER www-data
# [END BASE STAGE]

# [APP STAGE]
FROM base as app
# Prepare the frontend files & caching
COPY . /app

RUN chown www-data:www-data /app
# Setup nginx & supervisor as root user
USER root
RUN apk add --no-progress --quiet --no-cache nginx supervisor
COPY docker/nginx-default.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf
# Apply the required changes to run nginx as www-data user
RUN chown -R www-data:www-data /run/nginx /var/lib/nginx /var/log/nginx && \
    sed -i '/user nginx;/d' /etc/nginx/nginx.conf

RUN composer install --no-dev --prefer-dist

RUN chown -R www-data:www-data /app

RUN php artisan view:cache

# Switch to www-user
USER www-data
EXPOSE 80
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
# [END APP STAGE]
# DEFAULT STAGE
FROM base
