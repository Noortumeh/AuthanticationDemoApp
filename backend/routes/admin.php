<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'CheckUserRole'])->group(function () {
    Route::prefix('/admin')->group(function () {
        Route::get('/users', [AdminController::class, 'getUsers']);
        Route::get('/user', [AdminController::class, 'getUserData']);
    });
});
