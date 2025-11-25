#!/bin/bash

set -e

echo "🚀 Starting deployment..."

# Change to project directory
cd /home/forge/slamin.it

# Pull latest changes
echo "📥 Pulling latest changes..."
git pull origin main

# Install/Update Composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Install/Update NPM dependencies
echo "📦 Installing NPM dependencies..."
npm ci

# Build assets with Vite
echo "🏗️  Building assets..."
npm run build

# Clear all caches
echo "🧹 Clearing caches..."
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan event:clear

# Run migrations (if any)
echo "🗄️  Running migrations..."
php artisan migrate --force

# Optimize for production
echo "⚡ Optimizing..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Clear Livewire cache specifically
echo "🔄 Clearing Livewire cache..."
php artisan livewire:configure --optimize

# Restart queue workers
echo "👷 Restarting queue workers..."
php artisan queue:restart

# Restart PHP-FPM (adjust version if needed)
echo "🔄 Restarting PHP-FPM..."
sudo service php8.3-fpm reload || sudo service php8.2-fpm reload || echo "⚠️  Could not reload PHP-FPM"

echo "✅ Deployment complete!"

