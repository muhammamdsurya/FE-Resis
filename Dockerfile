# Use the official Laravel Sail PHP 8.3 image
FROM laravelsail/php83-composer:latest

# Set working directory
WORKDIR /var/www/html

# Copy the existing application directory contents
COPY . .

# Install PHP dependencies
RUN composer install

# Copy existing application directory permissions
COPY --chown=www-data:www-data . .

RUN touch database/database.sqlite

# Expose port 8000 and start Laravel Sail server
EXPOSE 8000
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000

