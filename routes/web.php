<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EntitiesController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ApplicationsController;
use App\Http\Controllers\DashboardController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard/groups/{group}', [DashboardController::class, 'showGroup'])->middleware(['auth'])->name('dashboard.group');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/my-projects', [ProjectsController::class, 'index'])->name('my-projects');
    Route::get('/projects/create/{groupId}', [ProjectsController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
    Route::get('/projects/{id}/edit', [ProjectsController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{id}', [ProjectsController::class, 'update'])->name('projects.update');
    Route::get('/projects/{id}', [ProjectsController::class, 'show'])->name('projects.show');
    Route::get('/groups/{id}', [GroupsController::class, 'show'])->name('groups.show');

    // Routes pour les commentaires
    Route::post('/comments', [CommentsController::class, 'store'])->name('comments.store');
    Route::post('/conversations', [CommentsController::class, 'createConversation'])->name('conversations.create');

    // Routes pour les candidatures
    Route::get('/applications', [ApplicationsController::class, 'index'])->name('applications.index');
    Route::get('/applications/create/{projectId}', [ApplicationsController::class, 'create'])->name('applications.create');
    Route::post('/applications', [ApplicationsController::class, 'store'])->name('applications.store');
    Route::post('/applications/{id}/approve', [ApplicationsController::class, 'approve'])->name('applications.approve');
    Route::post('/applications/{id}/reject', [ApplicationsController::class, 'reject'])->name('applications.reject');
});

require __DIR__ . '/auth.php';
