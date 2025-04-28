FROM php:8.2-fpm

# Install necessary PHP extensions
RUN apt-get update && apt-get install -y \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev \
    libfreetype6-dev \
    libzip-dev \
    msmtp msmtp-mta \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Install Composer securely
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copier le fichier php.ini personnalisé
# COPY php.ini /usr/local/etc/php/

# Copier les fichiers de l'application

COPY ../src /var/www/src

RUN chown -R www-data:www-data /var/www/src \
    && chmod -R 755 /var/www/src

COPY docker/msmtprc /etc/msmtprc

# Expose port 9000 to connect to Nginx
EXPOSE 9000
EXPOSE 25
