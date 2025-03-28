<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EntitiesController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pricing', function () {
    return view('pages.pricing');
})->name('pricing');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/dashboard', [EntitiesController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/my-projects', [ProjectsController::class, 'index'])->name('my-projects');
    Route::get('/projects/{id}', [ProjectsController::class, 'show'])->name('projects.show');
    Route::get('/groups/{id}', [GroupsController::class, 'show'])->name('groups.show');

    // Routes pour les commentaires
    Route::post('/comments', [CommentsController::class, 'store'])->name('comments.store');
    Route::post('/conversations', [CommentsController::class, 'createConversation'])->name('conversations.create');
});

require __DIR__ . '/auth.php';
