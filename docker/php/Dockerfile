# Base image
FROM php:8.4-fpm

# Install PHP extensions
RUN apt-get update && apt-get install -y \
	zlib1g-dev \
	libzip-dev \
	libicu-dev \
	&& docker-php-ext-configure zip \
	&& docker-php-ext-install zip pdo pdo_mysql mysqli intl \
	&& docker-php-ext-enable mysqli intl

# Set working directory and copy the application files
WORKDIR /var/www/html
COPY ./app /var/www/html
COPY ./docker/php/conf.d/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# Install Composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

# Install NPM dependencies and build the project
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - && \
    apt-get install -y nodejs && \
    rm -rf node_modules || true && \
	npm install && \
	npm run build

RUN sed -i 's|^listen = 127\.0\.0\.1:9010|listen = 0.0.0.0:9010|' /usr/local/etc/php-fpm.d/www.conf
