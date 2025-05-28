<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\EnergyUsageReportController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\EnergySimulationController; # Menambahkan controller simulasi hemat energi
use App\Http\Controllers\DeviceController;

// Rute untuk pengguna yang belum login (guest)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::view('/regist', 'auth.regist')->name('regist');
    Route::post('/regist', [AuthController::class, 'store'])->name('regist');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rute untuk pengguna yang sudah login (auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/leaderboard/{category?}', [LeaderboardController::class, 'showUserRank'])->name('leaderboard.index');
    Route::resource('maps', MapController::class);
    Route::get('maps/stations/{id}', [MapController::class, 'getStationDetails'])->name('maps.stations.details');
    Route::get('/forum', [ForumController::class, 'index'])->name('forum');
    // Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');

    // CRUD
    Route::get('/forum/{id}/edit', [ForumController::class, 'edit'])->name('forum.edit');
    Route::put('/forum/{id}', [ForumController::class, 'update'])->name('forum.update');
    Route::delete('/forum/{id}', [ForumController::class, 'destroy'])->name('forum.destroy');

    // store data to DB
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::get('/forum/{id}', [ForumController::class, 'show'])->name('forum.show');

    // Untuk reply & like
    Route::post('/forum/{id}/reply', [ForumController::class, 'reply'])->name('forum.reply');
    Route::post('/forum/{id}/like', [ForumController::class, 'like'])->name('forum.like');

    Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
    Route::get('/produk/{product}', [ProductController::class, 'show'])->name('products.show');

    // Review routes
    Route::post('/products/{product}/review', [ReviewController::class, 'store'])->name('review.store');
    Route::get('/review/{review}', [ReviewController::class, 'show'])->name('review.show');
    Route::put('/review/{review}', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');
    Route::resource('products.reviews', ReviewController::class)->shallow();

    Route::resource('reviews', ReviewController::class)->except(['index', 'show']);

    Route::post('/products/{product}/reviews', [ProductReviewController::class, 'store'])->name('products.reviews.store');

    Route::get('/energy-usage', [EnergyUsageReportController::class, 'index'])->name('energy.index');

    Route::get('/energy/create', [EnergyUsageReportController::class, 'create'])->name('energy.create');
    Route::post('/energy', [EnergyUsageReportController::class, 'store'])->name('energy.store');
    Route::get('/energy/{id}/edit', [EnergyUsageReportController::class, 'edit'])->name('energy.edit');
    Route::put('/energy/{id}', [EnergyUsageReportController::class, 'update'])->name('energy.update');
    Route::delete('/energy/{id}', [EnergyUsageReportController::class, 'destroy'])->name('energy.destroy');

    Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator.index');
    Route::post('/calculator', [CalculatorController::class, 'store'])->name('calculator.store');

    // Energy Saving Simulation Routes
    Route::prefix('simulasi-energi')->name('energy.simulation.')->group(function () {
        Route::get('/', [EnergySimulationController::class, 'index'])->name('index');
        Route::post('/hitung', [EnergySimulationController::class, 'calculate'])->name('calculate');
        Route::post('/simpan', [EnergySimulationController::class, 'save'])->name('save');
        Route::get('/riwayat', [EnergySimulationController::class, 'history'])->name('history');
        Route::get('/riwayat/{simulation}', [EnergySimulationController::class, 'showDetails'])->name('showDetails');
        Route::delete('/riwayat/{simulation}', [EnergySimulationController::class, 'delete'])->name('delete');
    });

    // Device routes
    Route::resource('devices', DeviceController::class);
    
    // Product routes
    Route::resource('products', ProductController::class);
});