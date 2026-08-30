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

// 3. Set and sanitize environment variables for serverless runtime
$defaults = [
    'APP_NAME' => 'AI Hub',
    'APP_ENV' => 'production',
    'APP_DEBUG' => 'true',
    'APP_KEY' => 'base64:cq8LiyvFB1sD9PuGU7KdFKmGEBVlmIpCDbwXUmyjRto=',
    'APP_URL' => 'http://localhost',
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => $targetDb,
    'SESSION_DRIVER' => 'cookie',
    'SESSION_LIFETIME' => '120',
    'CACHE_STORE' => 'array',
    'CACHE_DRIVER' => 'array',
    'LOG_CHANNEL' => 'stderr',
    'QUEUE_CONNECTION' => 'sync',
    'BROADCAST_CONNECTION' => 'log',
    'FILESYSTEM_DISK' => 'local',
    'MAIL_MAILER' => 'log',
    'APP_STORAGE' => '/tmp/storage',
    'VIEW_COMPILED_PATH' => '/tmp/storage/framework/views',
    'APP_CONFIG_CACHE' => '/tmp/storage/bootstrap/cache/config.php',
    'APP_EVENTS_CACHE' => '/tmp/storage/bootstrap/cache/events.php',
    'APP_PACKAGES_CACHE' => '/tmp/storage/bootstrap/cache/packages.php',
    'APP_ROUTES_CACHE' => '/tmp/storage/bootstrap/cache/routes.php',
    'APP_SERVICES_CACHE' => '/tmp/storage/bootstrap/cache/services.php',
];

foreach ($defaults as $key => $defaultVal) {
    $current = getenv($key);
    if ($current === false || trim((string)$current) === '') {
        putenv("{$key}={$defaultVal}");
        $_ENV[$key] = $defaultVal;
        $_SERVER[$key] = $defaultVal;
    } else {
        putenv("{$key}={$current}");
        $_ENV[$key] = $current;
        $_SERVER[$key] = $current;
    }
}

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
    error_log("SQLite Pre-check warning: " . $e->getMessage());
}

// 6. Handle HTTP Request with Error Catching
try {
    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<div style='font-family: sans-serif; padding: 20px; background: #fff; color: #111;'>";
    echo "<h2 style='color: #e11d48;'>Laravel Serverless Exception</h2>";
    echo "<p><b>Message:</b> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><b>File:</b> " . htmlspecialchars($e->getFile()) . " on line <b>" . $e->getLine() . "</b></p>";
    echo "<pre style='background: #f4f4f5; padding: 15px; border-radius: 8px; overflow: auto;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
    error_log("Exception: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
}
