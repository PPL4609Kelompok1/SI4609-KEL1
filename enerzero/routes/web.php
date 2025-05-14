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
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EnergySimulationController;

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
    Route::post('/products/{product}/reviews', [ProductReviewController::class, 'store'])->name('products.reviews.store');
    Route::get('/reviews/{review}/edit', [ProductReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ProductReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ProductReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/energy-report', [EnergyUsageReportController::class, 'index'])->name('energy.index');
    Route::get('/energy/create', [EnergyUsageReportController::class, 'create'])->name('energy.create');
    Route::post('/energy', [EnergyUsageReportController::class, 'store'])->name('energy.store');
    Route::get('/energy/{id}/edit', [EnergyUsageReportController::class, 'edit'])->name('energy.edit');
    Route::put('/energy/{id}', [EnergyUsageReportController::class, 'update'])->name('energy.update');
    Route::delete('/energy/{id}', [EnergyUsageReportController::class, 'destroy'])->name('energy.destroy');

    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    // Checkout Process
    Route::get('/orders/{order}/payment', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/orders/{order}/payment', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/orders/{order}/confirmation', [OrderController::class, 'confirmation'])->name('order.confirmation');

    // Energy Saving Simulation Routes
    Route::get('/simulasi-energi', [EnergySimulationController::class, 'index'])->name('energy.simulation.index');
    Route::post('/simulasi-energi/hitung', [EnergySimulationController::class, 'calculate'])->name('energy.simulation.calculate');
    Route::post('/simulasi-energi/simpan', [EnergySimulationController::class, 'save'])->name('energy.simulation.save');
    Route::get('/simulasi-energi/riwayat', [EnergySimulationController::class, 'history'])->name('energy.simulation.history');
    Route::get('/simulasi-energi/riwayat/{simulation}', [EnergySimulationController::class, 'showDetails'])->name('energy.simulation.showDetails');
});

// Admin routes
// ... existing code ...