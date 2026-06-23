#!/bin/sh
set -e

echo "Installing composer dependencies..."
composer install --no-interaction --optimize-autoloader

if [ ! -f ".env" ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
fi

if [ -f ".env" ] && [ -z "$(grep APP_KEY .env | cut -d '=' -f2)" ]; then
    echo "Generating application key..."
    php artisan key:generate
fi

php artisan config:clear
php artisan storage:link
php artisan migrate

echo "Starting PHP-FPM..."

# Команда, переданная в CMD
exec "$@"
