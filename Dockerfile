FROM php:8.4-cli

# Install system packages and PHP extensions
RUN apt-get update && apt-get install -y \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        curl \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        zip \
        bcmath \
        gd \
        exif \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Node.js (for building frontend assets)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean

# Copy the whole project
COPY . /var/www
WORKDIR /var/www

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install & build frontend assets
RUN npm install && npm run build

# Start Laravel’s built-in server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=$PORT"]
