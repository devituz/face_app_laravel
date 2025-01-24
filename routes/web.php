<?php

use App\Http\Controllers\Frontend\Login\LoginController;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/login', function () {
    return view('auth.login.login'); // Login sahifasi
})->name('login')->middleware('guest');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {
    // Logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/user', function () {
        return view('user');
    })->name('user');

    Route::get('/candidate', function () {
        return view('candidate');
    })->name('candidate');
});
