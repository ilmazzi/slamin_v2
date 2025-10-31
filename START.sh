#!/bin/bash

# SLAMIN Quick Start Script

echo "🚀 Avvio SLAMIN..."

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Check if .env exists
if [ ! -f .env ]; then
    echo "⚠️  File .env non trovato. Creazione da .env.example..."
    cp .env.example .env
    php artisan key:generate
fi

# Check if node_modules exists
if [ ! -d node_modules ]; then
    echo "📦 Installazione dipendenze npm..."
    npm install
fi

# Check if vendor exists
if [ ! -d vendor ]; then
    echo "📦 Installazione dipendenze composer..."
    composer install
fi

# Check if database exists
if [ ! -f database/database.sqlite ]; then
    echo "💾 Creazione database..."
    touch database/database.sqlite
fi

# Run migrations
echo "🔄 Esecuzione migrations..."
php artisan migrate --force

# Clear caches
echo "🧹 Pulizia cache..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo ""
echo "${GREEN}✅ Setup completato!${NC}"
echo ""
echo "${BLUE}Per avviare il server:${NC}"
echo "  Terminal 1: ${GREEN}php artisan serve${NC}"
echo "  Terminal 2: ${GREEN}npm run dev${NC}"
echo ""
echo "${BLUE}Poi apri:${NC} ${GREEN}http://localhost:8000${NC}"
echo ""

