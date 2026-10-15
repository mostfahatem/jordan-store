# Multi-stage production Dockerfile for Laravel 12 + PHP 8.4
FROM node:20-alpine AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

FROM php:8.4-cli-alpine AS production
WORKDIR /var/www/html

# Install required system packages & PHP extensions
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite-dev \
    mariadb-connector-c-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .
COPY --from=node_builder /app/public/build ./public/build

# Install production dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8000

ENV PORT=8000

CMD ["sh", "-c", "php artisan migrate --force --seed && php artisan optimize && php artisan serve --host=0.0.0.0 --port=${PORT}"]
