<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EntitiesController;
use App\Http\Controllers\GroupsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [EntitiesController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/groups/{id}', [GroupsController::class, 'show'])->name('groups.show');
});

require __DIR__ . '/auth.php';
