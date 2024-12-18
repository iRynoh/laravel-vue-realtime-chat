<?php

use App\Http\Controllers\DashboardShowController;
use App\Http\Controllers\MessageIndexController;
use App\Http\Controllers\MessageStoreController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomShowController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardShowController::class)
        ->name('dashboard');

    Route::prefix('rooms/{room:slug}')->group(function () {
        Route::get('/', RoomShowController::class)
            ->name('room.show');

        Route::get('/messages', MessageIndexController::class)
            ->name('room.show.messages');

        Route::post('/messages', MessageStoreController::class)->name('room.show.messages.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
