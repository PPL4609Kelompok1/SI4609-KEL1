<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaderboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/leaderboard/{category?}', [LeaderboardController::class, 'showUserRank'])->name('leaderboard.index');
