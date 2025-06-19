#!/bin/sh
set -e

# Esperar que MySQL esté listo en host "db" puerto 3306, máximo 30s
echo "Waiting for MySQL to be ready..."
wait-for db:3306 --timeout=30  -- echo "MySQL is up"

# Run migrations and seeders
echo "Running migrations..."
php artisan migrate --force

# Cache config
echo "Caching configuration..."
php artisan config:cache

# Permisos runtime
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Ejecutar CMD (php-fpm)
exec "$@"
