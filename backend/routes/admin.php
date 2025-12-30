<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function (Request $request) {
    return "welcome";
})->middleware('auth:sanctum')->middleware('CheckUserRole');