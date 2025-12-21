<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// User Routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login',[UserController::class, 'login']);
Route::post('/logout',[UserController::class, 'logout'])->middleware('auth:sanctum');
// Password Reset Routes
Route::post('/forgotpassword', [UserController::class, 'forgotPassword']);

//Profile Routes
Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth:sanctum');
Route::post('/profile', [ProfileController::class, 'addProfile'])->middleware('auth:sanctum');
