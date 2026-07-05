FROM php:8.4-cli

# Install MySQL extension (needed for PlanetScale / Railway)
RUN docker-php-ext-install pdo_mysql

# Copy the whole project into the container
COPY . /var/www
WORKDIR /var/www

# Install Composer and project dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Start Laravel’s built-in server (Railway will set $PORT)
CMD php artisan serve --host=0.0.0.0 --port=$PORT