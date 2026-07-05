FROM php:8.4-cli

# Install required system packages and PHP extensions
RUN apt-get update && apt-get install -y \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        zip \
        bcmath \
        gd \
        exif \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy the whole project
COPY . /var/www
WORKDIR /var/www

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies (without dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Start Laravel’s built-in server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=$PORT"]
