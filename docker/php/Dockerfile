FROM php:8.1-apache

WORKDIR /var/www/html

RUN a2enmod rewrite

RUN docker-php-ext-install pdo_mysql

RUN cat /etc/os-release

RUN apt-get update \
    && apt-get install -y \
        git \
        default-mysql-client \
        zip \
        unzip \
        vim \
        libpng-dev \
        libpq-dev \
        libzip-dev \
        openssl \
        libssl-dev \
        libcurl4-openssl-dev \
        wget \
        zlib1g-dev \
        libxml2-dev \
        libssh-dev \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
        intl \
    && docker-php-ext-enable intl

RUN docker-php-ext-install zip curl bcmath pdo iconv xml gd sockets soap

ENV TZ=Asia/Tehran
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php && composer config --global repos.packagist composer https://packagist.org

RUN composer install
