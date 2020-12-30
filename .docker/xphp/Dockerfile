FROM php:7.4-fpm-alpine
ENV XDEBUG_VERSION 3.0.1
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
    && docker-php-ext-configure gd \
                           --with-freetype=/usr/include/ \
                           --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install xdebug-${XDEBUG_VERSION} \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install mbstring opcache pdo_mysql soap zip gmp

# Cleanup
RUN apk del ${PHPIZE_DEPS} \
    && rm -rf /var/cache/apk/*

# Configuration
# Use the default develop configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Increase maximum execution time
RUN sed -e 's/max_execution_time = 30/max_execution_time = 300/' -i ${PHP_INI_DIR}/php.ini

# Xdebug config
COPY xdebug.ini $PHP_INI_DIR/conf.d/zz-xdebug.ini

# Fix iconv errors
# @see https://github.com/docker-library/php/issues/240#issuecomment-353678474
RUN apk add gnu-libiconv --update-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ --allow-untrusted
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

WORKDIR /app
