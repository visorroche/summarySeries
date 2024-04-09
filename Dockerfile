# Using the official PHP image with Apache, compatible with your PHP version
FROM php:8.1-apache

# Install necessary PHP extensions for Symfony
RUN docker-php-ext-install pdo pdo_mysql

# Enable mod_rewrite for Apache
RUN a2enmod rewrite && a2ensite 000-default.conf

# Copy the Apache configuration file to the container
COPY server-config/apache.conf /etc/apache2/sites-available/000-default.conf

# Set permissions for the application directory
RUN chown -R www-data:www-data /var/www

# Copy the application files to the container
COPY . /var/www/html

# Optional: Install Composer in the container for PHP dependency management
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js and npm
RUN apt-get update && apt-get install -y nodejs npm

# Run npm install to install dependencies
RUN npm install

# Run npm run build to build the application
RUN npm run build

# Expose port 80 for Apache access
EXPOSE 80




