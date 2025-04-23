<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\AuthController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/recommendations', [RecommendationController::class, 'index'])->name('recommendations');
Route::get('/forum', [ForumController::class, 'index'])->name('forum');
Route::get('/leaderboard/{category?}', [LeaderboardController::class, 'showUserRank'])->name('leaderboard.index');
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);