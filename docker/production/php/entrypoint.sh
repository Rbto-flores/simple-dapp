#!/bin/sh
set -e

# Run migrations and seeders 
echo "Running migrations..."
php artisan migrate --force

# Add other commands needed, like cache:clear or config:cache
echo "Caching configuration..."
php artisan config:cache

# Adjust permissions in runtime (if needed)
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Run the CMD (php-fpm)
exec "$@"
