<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Default welcome page
Route::get('/', function () {
    return view('welcome');
});

// Allow unauthenticated users to access login and register
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);
});

// Home route for authenticated users
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin route - Requires both 'auth' and 'admin' middleware
Route::middleware(['auth', 'admin'])->get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// Auth routes (using built-in routes for login, register, etc.)
Auth::routes();
