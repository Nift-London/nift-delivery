# syntax=docker/dockerfile:latest
#################### PHP BACKEND VENDOR INSTALL ####################
FROM composer:2.4 as vendor

COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install                \
            --ignore-platform-reqs  \
            --no-interaction        \
            --no-plugins            \
            --no-scripts            \
            --prefer-dist


#################### PHP IMAGE ####################
FROM php:8-fpm as backend

WORKDIR /var/www/html/

RUN apt-get update && apt-get install -y git                    \
                                         curl                   \
                                         cron                   \
                                         libpng-dev             \
                                         libonig-dev            \
                                         libxml2-dev            \
                                         zip                    \
                                         unzip                  \
                                         libjpeg-dev            \
                                         libwebp-dev            \
                                         libfreetype6-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp

RUN docker-php-ext-install  gd            \
                            pcntl         \
                            bcmath        \
                            mysqli        \
                            pdo_mysql     \
                            exif

RUN pecl install redis && docker-php-ext-enable redis
RUN echo 'memory_limit = 3048M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;

#DataDog
RUN curl -LO https://github.com/DataDog/dd-trace-php/releases/latest/download/datadog-setup.php
RUN php datadog-setup.php --php-bin=all

COPY --chown=www-data:www-data . /var/www/html
COPY --chown=www-data:www-data --from=vendor /vendor/ /var/www/html/vendor/
COPY --chown=www-data:www-data  public/ /var/www/html/

COPY .infrastructure/configurations/php/entrypoint.sh entrypoint.sh

CMD ["bash","entrypoint.sh"]

#################### NGINX IMAGE ####################
FROM nginx:latest as nginx

COPY .infrastructure/configurations/nginx/nginx.conf /etc/nginx/nginx.conf
COPY .infrastructure/configurations/nginx/production.conf /etc/nginx/conf.d/production.conf

COPY --chown=nginx:nginx public/ /var/www/html/

WORKDIR /var/www/html/

