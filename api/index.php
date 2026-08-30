<?php

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
        @mkdir($dir, 0755, true);
    }
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

// 3. Set environment variables for serverless runtime
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

// 4. Forward to standard public/index.php
require __DIR__ . '/../public/index.php';
