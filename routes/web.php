<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Route::get('/', function () {
//    return view('tabbar.tab-index.index');
//});
//
//Route::get('/login', function () {
//    return view('auth.login.login');
//});
//
//Route::get('/dashboard', function () {
//    return view('dashboard.dashboard');
//});


Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/user', function () {
    return view('user');
})->name('user');

Route::get('/candidate', function () {
    return view('candidate');
})->name('candidate');
