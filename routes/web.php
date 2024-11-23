<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Posts
    Route::get('/posts', [PostController::class, 'index'])->name('posts');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    
    //Mostrar todos los posts
    Route::get('/posts/show', [PostController::class, 'show'])->name('posts.show');
    // Ruta para redirigir al usuario a un enlace con el ID del post
    Route::get('/posts/{id}', [PostController::class, 'showPost'])->name('posts.showPost');

    //Ruta ShowDetail donde se suben los comentarios
    Route::post("/posts/comments", [PostController::class, 'storeComment'])->name('posts.comment');
    //Projects
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
});

require __DIR__.'/auth.php';
