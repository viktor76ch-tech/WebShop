<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;


Route::get('', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('categories', CategoryController::class);
    });
