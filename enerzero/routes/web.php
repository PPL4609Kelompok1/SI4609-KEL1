<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForumController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/forum.forum', [ForumController::class, 'index'])->name('forum');
