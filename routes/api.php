<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

// Авторизация (публичные)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Защищённые маршруты (нужен токен)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Публикации
    Route::get('/posts', [PostController::class, 'index']);        // Общая лента
    Route::post('/posts', [PostController::class, 'store']);       // Создать пост
    Route::get('/posts/my', [PostController::class, 'myPosts']);   // Мои посты
});