<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnergyUsageReportController;




Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// CRUD untuk data penggunaan energi
Route::get('/energy-report', [EnergyUsageReportController::class, 'index'])->name('energy.index');
Route::get('/energy/create', [EnergyUsageReportController::class, 'create'])->name('energy.create');
Route::post('/energy', [EnergyUsageReportController::class, 'store'])->name('energy.store');
Route::get('/energy/{id}/edit', [EnergyUsageReportController::class, 'edit'])->name('energy.edit');
Route::put('/energy/{id}', [EnergyUsageReportController::class, 'update'])->name('energy.update');
Route::delete('/energy/{id}', [EnergyUsageReportController::class, 'destroy'])->name('energy.destroy');



