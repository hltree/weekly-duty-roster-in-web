FROM php:7.2-apache
COPY ./php.ini /usr/local/etc/php/
COPY ./*.conf /etc/apache2/sites-enabled/

RUN apt-get update \
    && apt-get install -y zlib1g-dev libpq-dev mariadb-client unzip \
    && docker-php-ext-install zip pdo_mysql mysqli mbstring \
    && docker-php-ext-enable pdo_mysql mysqli mbstring \
    && a2enmod rewrite

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

WORKDIR /var/www/html
RUN composer global require "laravel/installer"
