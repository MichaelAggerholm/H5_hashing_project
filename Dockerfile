FROM php:8.3.3-apache

RUN apt-get update && apt-get install -y \
    wget \
    && wget -O phpunit https://phar.phpunit.de/phpunit-9.5.phar \
    && chmod +x phpunit \
    && mv phpunit /usr/local/bin/

RUN docker-php-ext-install mysqli

COPY src/ /var/www/html/