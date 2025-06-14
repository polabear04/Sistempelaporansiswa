# Gunakan image PHP + Apache
FROM php:8.2-apache

# Install ekstensi Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Salin semua file Laravel
COPY . .

# Set permission
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port
EXPOSE 80

# Jalankan migrasi dan cache config (opsional)
CMD php artisan config:cache && php artisan migrate --force && apache2-foreground
