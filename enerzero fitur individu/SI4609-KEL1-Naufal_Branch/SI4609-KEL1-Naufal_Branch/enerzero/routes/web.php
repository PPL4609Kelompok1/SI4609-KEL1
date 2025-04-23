<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('maps', MapController::class);
Route::get('maps/stations/{id}', [MapController::class, 'getStationDetails'])->name('maps.stations.details');
