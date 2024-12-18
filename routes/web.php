<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

// Any role
Route::get('/', [PostController::class, 'search'])->name('pages.dashboard');
Route::get('/post/{id}', [PostController::class, 'show'])->name(name: 'post.show');

//Login Register
Route::get('login', action: [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

// Authenticated Only
Route::middleware('auth')->group(function () {
    Route::get('admin', [PostController::class, 'admin'])->name('pages.dashboardAdmin');
    Route::post('admin', [PostController::class, 'store'])->name('post.store');
    Route::get('/admin/create', [PostController::class, 'create'])->name('post.create');
    Route::get('post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::post('/posts/{id}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{id}/comment', [PostController::class, 'comment'])->name('posts.comment');

    Route::post('logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});