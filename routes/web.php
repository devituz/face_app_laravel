<?php


use App\Http\Controllers\Frontend\Candidate\CandidateController;
use App\Http\Controllers\Frontend\CandidateList\CandidateListController;
use App\Http\Controllers\Frontend\Faceid\FaceidContoller;
use App\Http\Controllers\Frontend\Login\LoginController;
use App\Models\ApiAdmins;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;



Route::get('/', function () {
    return redirect()->route('login');
});





Route::get('/login', function () {
    return view('pages.auth.login.login');
})->name('login')->middleware('guest');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboards', function () {
        return view('pages.dashboards.dashboard.dashboard');
    })->name('dashboards');
    Route::get('/user', function () {
        return view('user');
    })->name('user');

// Tanlangan ID'larni o'chirish
    Route::post('candidatelist/bulk-delete', [CandidateListController::class, 'bulkDelete'])->name('candidatelist.bulkDelete');
    Route::post('/candidates/bulk-delete', [CandidateController::class, 'bulkDelete'])->name('candidates.bulkDelete');



    Route::resource('candidate-list', CandidateListController::class);
    Route::get('candidatelist/export', [CandidateListController::class, 'export'])->name('candidatelist.export');

    Route::get('candidates', [CandidateController::class, 'index'])->name('candidates.index');
    Route::get('/candidate-list', [CandidateListController::class, 'index'])->name('candidatelist.index');


    Route::resource('face-id-admin', FaceidContoller::class);
    Route::post('face-id-admin/bulk-delete', [FaceidContoller::class, 'bulkDestroy'])->name('face-id-admin.bulkDelete');

    Route::resource('candidate', CandidateController::class);
    Route::post('candidate/bulk-delete', [CandidateController::class, 'bulkDestroy'])->name('candidate.bulkDelete');
    Route::get('students/export', [CandidateController::class, 'export'])->name('students.export');









});
