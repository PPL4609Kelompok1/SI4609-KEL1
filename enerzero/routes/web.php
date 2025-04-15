<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/map', [MapController::class, 'index'])->name('map');
