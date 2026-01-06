<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ProfileController, UserController};

// User Routes
Route::post('/register', [UserController::class, 'register'])->middleware('throttle:limit5');
Route::post('/login',[UserController::class, 'login'])->middleware('throttle:limit5');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
// Password Reset Routes
Route::post('/forgotpassword', [UserController::class, 'forgotPassword']);//->middleware('throttle:limit5');
Route::post('/resetpassword', [UserController::class, 'resetPassword']);//->middleware('throttle:limit5');

//Profile Routes
Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth:sanctum');
Route::post('/profile', [ProfileController::class, 'addProfile'])->middleware('auth:sanctum');
Route::put('/update-profile', [ProfileController::class, 'updateProfile'])->middleware('auth:sanctum');

Route::get('/welcome', [ProfileController::class, 'welcome'])->middleware('auth:sanctum');