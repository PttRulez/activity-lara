# Start from the PHP 8.4 FPM base image
FROM php:8.4-fpm

# Install system dependencies (e.g., for Composer, npm, PostgreSQL extensions)
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    npm \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions: pdo_pgsql and pgsql
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# Set the working directory inside the container
WORKDIR /var/www/html

# Expose the necessary port
EXPOSE 9000

# Start PHP-FPM service
CMD ["php-fpm"]
