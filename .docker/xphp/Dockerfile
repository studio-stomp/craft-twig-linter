FROM php:8.0-fpm-alpine
ENV XDEBUG_VERSION 3.1.6
# Update system
RUN apk update && apk upgrade \
    && apk add --no-cache ${PHPIZE_DEPS} procps \
    && apk add --no-cache libxml2-dev \
                          freetype \
                           gmp-dev \
                           libpng \
                           libjpeg-turbo \
                           freetype-dev \
                           libpng-dev \
                           libjpeg-turbo-dev \
                           libzip-dev \
                           oniguruma-dev \
                           icu-dev \
    && docker-php-ext-configure gd \
                           --with-freetype=/usr/include/ \
                           --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install xdebug-${XDEBUG_VERSION} \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install mbstring opcache pdo_mysql soap zip gmp intl bcmath

# Cleanup
RUN apk del ${PHPIZE_DEPS} \
    && rm -rf /var/cache/apk/*

# Configuration
# Use the default develop configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Increase maximum execution time
RUN sed -e 's/max_execution_time = 30/max_execution_time = 300/' -i ${PHP_INI_DIR}/php.ini

# Xdebug config
COPY custom.ini $PHP_INI_DIR/conf.d/zz-custom.ini
COPY xdebug.ini $PHP_INI_DIR/conf.d/zz-xdebug.ini

WORKDIR /app
