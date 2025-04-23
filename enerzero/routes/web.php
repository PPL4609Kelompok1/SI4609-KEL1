<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanDanAnalisisController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/analisis', [LaporanDanAnalisisController::class, 'index'])->name('analisis.index');
Route::get('/analisis/{id}', [LaporanDanAnalisisController::class, 'show'])->name('analisis.show');
