<?php

//use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth','2fa')->group(function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
});

Route::middleware(['auth', 'redirect.2fa.confirmed'])->group(function () {
    Route::inertia('/two-factor-setup', 'Auth/TwoFactorAuthenticationSetup')->name('two-factor.setup');
});


Route::middleware('guest')->group(function () {
    Route::inertia('/register', 'Auth/Register')->name('register');
    Route::inertia('/login', 'Auth/Login')->name('login');
});
