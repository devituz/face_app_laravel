<?php

use App\Http\Controllers\Api\ApiAdminsController;
use App\Http\Controllers\Api\ApiStudentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/face/login', [ApiAdminsController::class, 'login']);
Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/dashboards', [ApiAdminsController::class, 'dashboard']);
    Route::get('/getme', [ApiAdminsController::class, 'getAdmins']);
    Route::post('/student', [ApiAdminsController::class, 'search']);
    Route::get('/students/my-register', [ApiStudentsController::class, 'myregister']);

});
