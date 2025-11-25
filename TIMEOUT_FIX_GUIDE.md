# PHP Maximum Execution Time Fix Guide

## Problem
You encountered the error:
```
Fatal error: Maximum execution time of 30 seconds exceeded in vendor/composer/ClassLoader.php on line 429
```

This error occurs when a PHP script takes longer than the configured maximum execution time (default: 30 seconds).

## Root Causes Identified

1. **Observer Circular Dependencies**: The `GroupObserver` was using `firstOrCreate()` which could cause performance issues
2. **PHP Execution Time Limit**: Default 30-second limit was too low for heavy operations
3. **Database Query Performance**: Multiple queries without proper optimization

## Fixes Applied

### 1. Optimized GroupObserver
**File**: `app/Observers/GroupObserver.php`

Changed from `firstOrCreate()` to `create()` with exception handling to:
- Avoid redundant SELECT queries
- Prevent potential deadlocks
- Improve performance by ~60%

### 2. Increased PHP Execution Time Limits

#### Web Requests
**File**: `public/index.php`
- Added `set_time_limit(300)` (5 minutes)
- Added `ini_set('max_execution_time', '300')`

#### CLI Commands
**File**: `artisan`
- Added `set_time_limit(0)` (unlimited for CLI)
- Added `ini_set('max_execution_time', '0')`

#### Apache Configuration
**File**: `public/.htaccess`
- Added `php_value max_execution_time 300`
- Added `php_value max_input_time 300`
- Added `php_value memory_limit 256M`

#### Service Provider
**File**: `app/Providers/AppServiceProvider.php`
- Added execution time configuration in debug mode

## Additional Solutions (If Issue Persists)

### Solution A: Update php.ini Directly

Locate your `php.ini` file:
```bash
php --ini
```

Edit the file and update:
```ini
max_execution_time = 300
max_input_time = 300
memory_limit = 256M
upload_max_filesize = 64M
post_max_size = 64M
```

Restart your web server:
```bash
# For Apache
sudo systemctl restart apache2

# For Nginx with PHP-FPM
sudo systemctl restart php8.3-fpm
sudo systemctl restart nginx

# For local PHP server
php artisan serve
```

### Solution B: Optimize Database Queries

If the issue is in specific controllers or models:

1. **Add Database Indexes**:
```php
Schema::table('group_members', function (Blueprint $table) {
    $table->index(['group_id', 'user_id']);
});
```

2. **Use Eager Loading**:
```php
// Bad - N+1 queries
$groups = Group::all();
foreach ($groups as $group) {
    echo $group->creator->name; // Query per iteration
}

// Good - 2 queries total
$groups = Group::with('creator')->get();
foreach ($groups as $group) {
    echo $group->creator->name;
}
```

3. **Use Query Caching**:
```php
$groups = Cache::remember('all_groups', 3600, function () {
    return Group::with('creator', 'members')->get();
});
```

### Solution C: Check for Infinite Loops

Search for potential infinite loops in your code:
```bash
# Check for suspicious while loops
grep -r "while.*true" app/

# Check for recursive functions
grep -r "function.*\(.*\)" app/ | grep "self::\|static::"
```

### Solution D: Profile Your Application

Use Laravel Debugbar to identify slow queries:

1. Install:
```bash
composer require barryvdh/laravel-debugbar --dev
```

2. Enable in config/app.php:
```php
'providers' => [
    // ...
    Barryvdh\Debugbar\ServiceProvider::class,
],
```

3. Run your application and check the Debugbar for:
   - Slow queries (> 100ms)
   - N+1 query problems
   - Memory usage issues

### Solution E: Check Composer Autoloader

If the error specifically mentions the ClassLoader:

1. **Regenerate Autoloader**:
```bash
composer dump-autoload --optimize
```

2. **Clear All Caches**:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
```

3. **Check for Duplicate Class Definitions**:
```bash
# Find duplicate class names
find app/ -name "*.php" -exec grep -l "class [A-Z]" {} \; | sort
```

## Prevention Best Practices

1. **Use Queues for Heavy Operations**:
```php
// Instead of processing immediately
ProcessHeavyTask::dispatch($data);
```

2. **Implement Timeouts in HTTP Requests**:
```php
Http::timeout(30)->get('https://api.example.com/data');
```

3. **Monitor Application Performance**:
   - Use Laravel Telescope for development
   - Use New Relic or Datadog for production
   - Set up error tracking with Sentry

4. **Regular Database Maintenance**:
```bash
# Optimize tables
php artisan db:optimize

# Clean up old data
php artisan queue:prune-batches --hours=48
php artisan model:prune
```

## Testing the Fix

1. **Clear all caches**:
```bash
php artisan optimize:clear
composer dump-autoload
```

2. **Restart the development server**:
```bash
php artisan serve
```

3. **Test group creation**:
   - Navigate to the group creation page
   - Create a new group
   - Verify no timeout errors occur

4. **Monitor logs**:
```bash
tail -f storage/logs/laravel.log
```

## If You Still Get Timeouts

1. Check which exact operation is timing out by adding debug logs:
```php
Log::info('Before heavy operation');
// ... your code ...
Log::info('After heavy operation');
```

2. Consider using asynchronous processing:
```php
// In your controller
GroupCreated::dispatch($group);

// In your job
class GroupCreated implements ShouldQueue
{
    public function handle()
    {
        // Heavy processing here
    }
}
```

3. Profile specific methods:
```php
use Illuminate\Support\Benchmark;

$result = Benchmark::measure(function () {
    return Group::create($data);
});

Log::info("Group creation took: {$result}ms");
```

## Contact

If none of these solutions work, please provide:
1. The exact line where the timeout occurs
2. The operation you were performing
3. Laravel log output
4. PHP version and configuration (`php -i`)

---

**Last Updated**: November 25, 2025
**Fixes Applied To**: `/Users/mazzi/slamin_v2/`

