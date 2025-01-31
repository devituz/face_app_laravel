<?php


use App\Http\Controllers\Frontend\Candidate\CandidateController;
use App\Http\Controllers\Frontend\Faceid\FaceidContoller;
use App\Http\Controllers\Frontend\Login\LoginController;
use App\Models\ApiAdmins;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;



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





    Route::resource('face-id-admin', FaceidContoller::class);
    Route::post('face-id-admin/bulk-delete', [FaceidContoller::class, 'bulkDestroy'])->name('face-id-admin.bulkDelete');

    Route::resource('candidate', CandidateController::class);
    Route::post('candidate/bulk-delete', [CandidateController::class, 'bulkDestroy'])->name('candidate.bulkDelete');










});
