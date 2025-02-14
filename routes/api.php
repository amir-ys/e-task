<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::post("/login", [LoginController::class, 'store'])->name('login');

Route::prefix('v1')
    ->middleware('auth:sanctum')
    ->group(function () {
        #posts
        Route::apiResource('/posts', PostController::class);
    });
