<?php

use Illuminate\Support\Facades\Route;

// Default welcome page
Route::get('/', function () {
    return view('welcome');
});

// Allow unauthenticated users to access login and register
Route::middleware('guest')->group(function () {
    Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
});

// Home route for authenticated users
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin route
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard')
        ->middleware('admin'); // Custom middleware for checking if the user is an admin
});

// Auth routes
Auth::routes();
