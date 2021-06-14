ARG PHP_VERSION=8.0.3

FROM php:${PHP_VERSION}-apache AS api_platform_php_bug
ARG TIMEZONE='Europe/London'
ARG APP_ENV='prod'

#RUN ln -s $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
COPY docker/conf.d/api-platform.${APP_ENV}.ini $PHP_INI_DIR/conf.d/api-platform.ini

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring

ARG APCU_VERSION=5.1.19
RUN pecl install apcu-${APCU_VERSION} \
    && pecl clear-cache \
    && docker-php-ext-enable \
        apcu \
        opcache

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

COPY --from=composer:2.0 /usr/bin/composer /usr/local/bin
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"

ENV APACHE_DOCUMENT_ROOT /var/www/api/public

WORKDIR /var/www/api

RUN a2enmod rewrite
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN service apache2 restart
RUN usermod -u 1000 www-data
