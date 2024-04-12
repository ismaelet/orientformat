# Use the official PHP image with Apache
FROM php:apache

# Install the database
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Image handling
# RUN apt-get install -y libwebp-dev libjpeg62-turbo-dev libpng-dev libexif-dev \
#     && docker-php-ext-install exif
# RUN docker-php-ext-configure gd --with-webp --with-jpeg \
# 	&& docker-php-ext-install gd

# XLSX files handling
# RUN apt-get install -y libonig-dev
# RUN docker-php-ext-install mbstring

# Enable .htaccess rewrite
RUN a2enmod rewrite
