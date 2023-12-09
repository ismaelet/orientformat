FROM php:apache

WORKDIR /var/www/html

RUN docker-php-ext-install mysqli

# RUN apt-get update
# RUN apt-get install -y nodejs
# RUN apt-get install -y npm

RUN a2enmod rewrite