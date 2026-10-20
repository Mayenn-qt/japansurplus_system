FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libsqlite3-dev \
    libpq-dev \
    default-libmysqlclient-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Laravel storage permissions
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Clear Laravel configuration during build
RUN php artisan config:clear

# Render provides the PORT environment variable
EXPOSE 10000

# Clear config, run database migrations, and start the server pointing to the public folder
CMD php artisan config:clear && php artisan migrate --force && php -S 0.0.0.0:${PORT:-10000} -t public