FROM php:8.2-fpm AS base

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get update  \
    && apt-get install -y  libpq-dev libpng-dev libzip-dev zip nodejs libicu-dev \
    && docker-php-ext-install zip mysqli pdo_mysql sysvsem gd bcmath intl \
    && apt-get clean \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

#USER 1000:1000

WORKDIR /var/www/delivery
