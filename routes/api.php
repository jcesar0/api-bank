<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'v1'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('register', [\App\Http\Controllers\v1\Auth\RegisterController::class, 'store'])->name('register');
        Route::post('login', [\App\Http\Controllers\v1\Auth\LoginController::class, 'store'])->name('login');
    });

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    });
});
