<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'CheckUserRole'])->group(function () {
    Route::prefix('/admin')->group(function () {
        Route::get('/users', [AdminController::class, 'getUsers']);
        Route::get('/user/{id}', [AdminController::class, 'getUserData']);
        Route::post('/user', [AdminController::class, 'createUser']);
        Route::delete('/user/{id}', [AdminController::class, 'deleteUser']);
        //
        Route::post('/users/{id}/profile', [AdminController::class, 'addUserProfile']);
        Route::put('/users/{id}/profile', [AdminController::class, 'updateUserProfile']);
        Route::delete('/profile/{id}', [AdminController::class, 'deleteUserProfile']);

    });
});
