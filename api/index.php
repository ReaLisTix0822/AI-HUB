<?php

use Illuminate\Http\Request;

// 1. Prepare writable storage directories in /tmp for Vercel Serverless environment
$dirs = [
    '/tmp/storage',
    '/tmp/storage/app',
    '/tmp/storage/app/public',
    '/tmp/storage/framework',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/storage/bootstrap',
    '/tmp/storage/bootstrap/cache',
    '/tmp/database',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    @chmod($dir, 0777);
}

// 2. Prepare SQLite database in /tmp
$sourceDb = __DIR__ . '/../database/database.sqlite';
$targetDb = '/tmp/database/database.sqlite';

if (!file_exists($targetDb) || filesize($targetDb) === 0) {
    if (file_exists($sourceDb) && filesize($sourceDb) > 0) {
        @copy($sourceDb, $targetDb);
    } else {
        @touch($targetDb);
    }
}
@chmod($targetDb, 0777);

// 3. Set environment variables for serverless runtime
if (!getenv('APP_KEY') && !isset($_ENV['APP_KEY'])) {
    putenv('APP_KEY=base64:cq8LiyvFB1sD9PuGU7KdFKmGEBVlmIpCDbwXUmyjRto=');
}
putenv('APP_ENV=production');
putenv('APP_DEBUG=true');
putenv('APP_STORAGE=/tmp/storage');
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
putenv('APP_CONFIG_CACHE=/tmp/storage/bootstrap/cache/config.php');
putenv('APP_EVENTS_CACHE=/tmp/storage/bootstrap/cache/events.php');
putenv('APP_PACKAGES_CACHE=/tmp/storage/bootstrap/cache/packages.php');
putenv('APP_ROUTES_CACHE=/tmp/storage/bootstrap/cache/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/storage/bootstrap/cache/services.php');
putenv('SESSION_DRIVER=cookie');
putenv('CACHE_STORE=array');
putenv('LOG_CHANNEL=stderr');
putenv("DB_DATABASE={$targetDb}");
putenv('DB_CONNECTION=sqlite');

if (!defined('LARAVEL_START')) {
    define('LARAVEL_START', microtime(true));
}

// 4. Autoload and Bootstrap
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 5. Self-Healing: Verify tables exist in SQLite
try {
    $pdo = new PDO('sqlite:' . $targetDb);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $tableExists = $pdo->query("SELECT count(*) FROM sqlite_master WHERE type='table' AND name='categories'")->fetchColumn();
    
    if (!$tableExists) {
        if (file_exists($sourceDb) && filesize($sourceDb) > 0) {
            @copy($sourceDb, $targetDb);
        } else {
            $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
            $kernel->call('migrate', ['--force' => true]);
            $kernel->call('db:seed', ['--force' => true]);
        }
    }
} catch (\Throwable $e) {
    // Continue if PDO check errors
}

// 6. Handle HTTP Request
$app->handleRequest(Request::capture());
