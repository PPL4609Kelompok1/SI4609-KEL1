<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CarbonAnalsiisController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('maps', MapController::class);
Route::get('/analisis', [CarbonAnalisisController::class, 'index'])->name('analisis.index');

