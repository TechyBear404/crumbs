<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/products', ProductController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/ingredients', IngredientController::class);
    Route::resource('users', UserController::class);
    Route::resource('orders', OrderController::class);
    Route::put('/orders/bulk-update', [OrderController::class, 'bulkUpdate'])->name('orders.bulk-update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/cart/items', [CartController::class, 'getCartItems']);
    Route::post('/cart/items/{id}/quantity', [CartController::class, 'updateQuantity']);
    Route::delete('/cart/items/{id}', [CartController::class, 'removeItem']);
});

require __DIR__ . '/auth.php';
