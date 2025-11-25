#!/bin/bash

echo "================================================"
echo "  PHP Timeout Fix - Cache Clear & Restart"
echo "================================================"

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Step 1: Clearing Laravel caches...${NC}"
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

echo -e "${YELLOW}Step 2: Optimizing Composer autoloader...${NC}"
composer dump-autoload --optimize

echo -e "${YELLOW}Step 3: Checking PHP configuration...${NC}"
echo "Current max_execution_time: $(php -r 'echo ini_get("max_execution_time");')"
echo "Current memory_limit: $(php -r 'echo ini_get("memory_limit");')"

echo -e "${GREEN}✓ All caches cleared!${NC}"
echo ""
echo "To test the fix, run:"
echo "  php artisan serve"
echo ""
echo "Then navigate to your application and test group creation."
echo ""
echo "For more details, see: TIMEOUT_FIX_GUIDE.md"
echo "================================================"

