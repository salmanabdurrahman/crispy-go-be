<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api.token')->group(function () {
    Route::get('/menus', [MenuController::class, 'index']);
    Route::get('/blogs', [BlogController::class, 'index']);

    Route::post('/newsletter', [NewsletterController::class, 'store']);
    Route::post('/contact', [ContactController::class, 'store']);
    Route::post('/order', [OrderController::class, 'store']);
});