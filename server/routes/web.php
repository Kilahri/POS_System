// routes/web.php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Web routes for your POS system
Route::get('/products', [ProductController::class, 'index'])->name('products.index');


Route::get('/categories', [CategoryController::class, 'webIndex'])->name('categories.index');

// Auth web routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'webLogin']);
Route::post('/logout', [AuthController::class, 'webLogout'])->name('logout');