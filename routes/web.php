<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Routes untuk Program
    Route::prefix('program')->name('program.')->group(function () {
        Route::get('/', function () {
            return view('program.index');
        })->name('index');
        
        Route::get('/create', function () {
            return view('program.create');
        })->name('create');
        
        Route::get('/{id}', function ($id) {
            return view('program.show', compact('id'));
        })->name('show');
        
        Route::get('/{id}/edit', function ($id) {
            return view('program.edit', compact('id'));
        })->name('edit');
    });
    
    // Routes untuk Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', function () {
            return view('notifications.index');
        })->name('index');
        
        Route::get('/create', function () {
            return view('notifications.create');
        })->name('create');
        
        Route::get('/{id}', function ($id) {
            return view('notifications.show', compact('id'));
        })->name('show');
        
        Route::get('/{id}/edit', function ($id) {
            return view('notifications.edit', compact('id'));
        })->name('edit');
    });
});

require __DIR__.'/auth.php';