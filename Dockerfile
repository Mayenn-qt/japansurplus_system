FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libsqlite3-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_sqlite pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project
COPY . .

# Make sure SQLite database file exists
RUN mkdir -p database \
    && touch database/database.sqlite

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

# Clear Laravel configuration
RUN php artisan config:clear

# Run migrations
RUN php artisan migrate --force

# Render provides the PORT environment variable
EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}