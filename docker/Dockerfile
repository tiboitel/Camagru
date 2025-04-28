FROM php:8.2-fpm

# Install necessary PHP extensions
RUN apt-get update && apt-get install -y \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev \
    libfreetype6-dev \
    libzip-dev \
    msmtp \
    msmtp-mta \
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

# Copy msmtp config
COPY docker/msmtprc /etc/msmtprc

RUN chmod 644 /etc/msmtprc \
    && chown root:root /etc/msmtprc

# Make sure only root can read it, and create the log file
RUN touch /var/log/msmtp.log \
    && chown www-data:www-data /var/log/msmtp.log

RUN echo 'sendmail_path = "/usr/bin/msmtp -t"' \
    >> /usr/local/etc/php/php.ini

# Expose port 9000 to connect to Nginx
EXPOSE 9000
