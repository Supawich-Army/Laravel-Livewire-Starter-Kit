<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Route::view('projects', 'projects')->name('projects');
    Route::get('projects', [ProjectController::class, 'index'])->name('projects');
});

require __DIR__ . '/settings.php';
