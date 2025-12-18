FROM php:8.4.15-cli

# Install system dependencies
RUN apt-get update \
    && apt-get install -y \
        libpq-dev \
        libssl-dev \
        ca-certificates \
        curl \
        unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install

# Install MongoDB PHP extension
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Set working directory
WORKDIR /var/www/html

# Copy app
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Render / Heroku port
ENV PORT=10000
EXPOSE 10000

# Start PHP built-in server
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-10000}"]
