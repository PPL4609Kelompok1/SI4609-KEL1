<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\EducationController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Map routes
Route::get('/map', [MapController::class, 'index'])->name('map.index');
Route::get('/map/favorites', [MapController::class, 'favorites'])->name('map.favorites');

// API routes
Route::get('/api/charging-stations', [MapController::class, 'getChargingStations']);
Route::get('/api/charging-station/{id}', [MapController::class, 'getChargingStation']);

// Education routes
Route::resource('education', EducationController::class);

