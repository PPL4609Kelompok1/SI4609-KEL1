<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForumController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

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