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
Route::middleware(['auth', 'admin'])->get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard'); // Admin route

// Auth routes
Auth::routes();
