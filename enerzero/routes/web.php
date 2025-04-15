<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecommendationController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/recommendations', [RecommendationController::class, 'index'])->name('recommendations');
