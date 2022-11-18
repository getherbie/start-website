FROM php:7.4-fpm

RUN apt-get update \
    && apt-get install -y \
        libicu-dev \
        zip \
        unzip \
        zlib1g-dev \
        libpng-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
    && docker-php-ext-configure \
        gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install \
        intl \
        opcache \
        gd \
        pdo \
        pdo_mysql \
        mysqli \
    && docker-php-ext-enable \
        intl \
        opcache \

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Permission fix
RUN usermod -u 1000 www-data
