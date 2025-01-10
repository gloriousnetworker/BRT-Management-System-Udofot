<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TicketController;

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
Route::get('/home', [TicketController::class, 'index'])->name('home');

// Admin route
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard')
        ->middleware('admin'); // Custom middleware for checking if the user is an admin
});

// Auth routes
Auth::routes();

// Ticket routes (authenticated users only)
Route::middleware('auth')->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::put('/tickets/{id}', [TicketController::class, 'update'])->middleware('can:update,ticket')->name('tickets.update');
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->middleware('can:delete,ticket')->name('tickets.destroy');
});

