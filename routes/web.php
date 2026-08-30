<?php

use App\Http\Controllers\AiToolController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AiToolController::class, 'index'])->name('home');
Route::get('/tool/{slug}', [AiToolController::class, 'show'])->name('tool.show');
Route::get('/api/search', [AiToolController::class, 'apiSearch'])->name('api.search');

