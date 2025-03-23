# Use the official PHP image with Apache
FROM php:8.4-apache

# Set working directory
WORKDIR /app
COPY ./app/ .

# Install the zip extension
RUN apt-get update && \
	apt-get install -y zlib1g-dev libzip-dev && \
	docker-php-ext-configure zip && \
	docker-php-ext-install zip

# Install the database
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - 
RUN apt-get install -y nodejs

# Install dependencies
RUN composer update
# RUN npm install && npm run build && rm -r node_modules

# Enable .htaccess rewrite
RUN a2enmod rewrite
