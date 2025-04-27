<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductReviewController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Product routes
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{id}', [ProductController::class, 'show'])->name('products.show');
Route::resource('products', ProductController::class);

// Review routes
Route::post('/products/{product}/review', [ReviewController::class, 'store'])->name('review.store');
Route::get('/review/{review}', [ReviewController::class, 'show'])->name('review.show');
Route::put('/review/{review}', [ReviewController::class, 'update'])->name('review.update');
Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');
Route::resource('products.reviews', ReviewController::class)->shallow();

Route::resource('reviews', ReviewController::class)->except(['index', 'show']);

Route::post('/products/{product}/reviews', [ProductReviewController::class, 'store'])->name('products.reviews.store');

