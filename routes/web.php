<?php

use App\Http\Controllers\AiToolController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AiToolController::class, 'index'])->name('home');
Route::get('/tool/{slug}', [AiToolController::class, 'show'])->name('tool.show');
Route::get('/api/search', [AiToolController::class, 'apiSearch'])->name('api.search');

Route::get('/test', function () {
    $dbStatus = 'OK';
    $toolCount = 0;
    $categoryCount = 0;
    try {
        $toolCount = \App\Models\AiTool::count();
        $categoryCount = \App\Models\Category::count();
    } catch (\Throwable $e) {
        $dbStatus = 'Error: ' . $e->getMessage();
    }

    return response()->json([
        'status' => 'Laravel is running successfully on Vercel!',
        'php_version' => PHP_VERSION,
        'storage_path' => storage_path(),
        'database_file' => config('database.connections.sqlite.database'),
        'database_status' => $dbStatus,
        'ai_tools_count' => $toolCount,
        'categories_count' => $categoryCount,
        'vite_manifest_exists' => file_exists(public_path('build/manifest.json')),
    ]);
});


