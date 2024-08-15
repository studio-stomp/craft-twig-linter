FROM php:8.2-fpm-alpine
ENV XDEBUG_VERSION=3.3.2
# Update system
RUN apk update && apk upgrade \
    && apk add --update linux-headers \
    && apk add --no-cache mysql-client \
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
			   icu-data-full \
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

# Custom PHP config, overruling defaults
COPY custom.ini $PHP_INI_DIR/conf.d/zz-custom.ini

# Xdebug config
COPY xdebug.ini $PHP_INI_DIR/conf.d/zz-xdebug.ini

WORKDIR /app
