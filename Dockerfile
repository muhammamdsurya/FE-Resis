# Use the official Laravel Sail PHP 8.3 image
FROM laravelsail/php83-composer:latest

# Set working directory
WORKDIR /var/www/html

# Copy composer.json and composer.lock
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-scripts --no-autoloader

# Copy the existing application directory contents
COPY . .

# Generate optimized autoload files
RUN composer dump-autoload --optimize

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Create SQLite database file
RUN touch database/database.sqlite \
    && chown www-data:www-data database/database.sqlite

RUN echo "upload_max_filesize=50M" >> /usr/local/etc/php/php.ini \
    && echo "post_max_size=50M" >> /usr/local/etc/php/php.ini

# Expose port 8000
EXPOSE 8000

# Start Laravel server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
