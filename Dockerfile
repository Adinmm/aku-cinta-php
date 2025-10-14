# Gunakan PHP + Apache
FROM php:8.2-apache

# Install ekstensi PHP
RUN apt-get update && apt-get install -y \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql mysqli gd

# Aktifkan mod_rewrite
RUN a2enmod rewrite

# Copy kode PHP
COPY . /var/www/html/

# Copy Apache config
COPY _other/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Set permission supaya tidak muncul 403
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80
