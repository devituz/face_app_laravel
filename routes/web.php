<?php

use App\Http\Controllers\Frontend\Login\LoginController;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/login', function () {
    return view('pages.auth.login.login'); // Login sahifasi
})->name('login')->middleware('guest');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {
    // Logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboards', function () {
        return view('pages.dashboards.dashboard.dashboard');
    })->name('dashboards');

    Route::get('/user', function () {
        return view('user');
    })->name('user');

    Route::get('/candidate', function () {
        return view('pages.candidates.candidate.candidate');
    })->name('candidate');


    Route::get('/face-id-admin', function () {
        return view('pages.face-id-admins.face-id-admin.face-id-admin');
    })->name('candidate');




});
