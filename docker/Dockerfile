FROM php:8.2-fpm

# Install necessary PHP extensions
RUN apt-get update && apt-get install -y \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Set ownership of the working directory
RUN chown -R www-data:www-data /var/www/html

USER www-data

# Expose port 9000 to connect to Nginx
EXPOSE 9000

CMD ["php-fpm"]

