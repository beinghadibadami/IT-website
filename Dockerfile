# Simple Dockerfile for deploying this PHP site on Render using Docker
# - Uses official PHP CLI image with built-in web server
# - Serves the application from /var/www/html
# - Listens on the PORT environment variable (Render sets this, default 10000)

FROM php:8.2-cli

# Install PostgreSQL PDO extension
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Set working directory inside the container
WORKDIR /var/www/html

# Copy the entire application into the container
COPY . .

# Default port for local runs; Render will override PORT env var
ENV PORT=10000

# Documented container port (Render will route traffic here)
EXPOSE 10000

# Start PHP's built-in web server
# Render sets PORT, so we bind to 0.0.0.0:$PORT and serve the app from the current directory
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-10000}"]
