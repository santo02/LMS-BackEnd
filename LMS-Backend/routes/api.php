<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Student_Auth;
use App\Http\Controllers\Theacher_Auth;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [LoginController::class, 'Login']);


Route::group(['middleware' => ['auth:sanctum', 'CheckRole:admin']], function () {
    Route::post('/add-guru', [Theacher_Auth::class, 'Register']);
    Route::post('/add-siswa', [Student_Auth::class, 'Register']);
    //menampilkan akun
    Route::get('/account-siswa', [Student_Auth::class, 'index']);
    Route::get('/account-guru', [Theacher_Auth::class, 'index']);
    //delete
    Route::delete('/delete-siswa/{id}', [Student_Auth::class, 'delete']);
    Route::delete('/delete-guru/{id}', [Theacher_Auth::class, 'delete']);
});

Route::group(['middleware' => ['auth:sanctum', 'CheckRole:guru']], function () {
    // CRUD course
    Route::get('/course', [CourseController::class, 'index']);
    Route::post('/add-course', [CourseController::class, 'store']);
    Route::delete('/delete-course/{id}', [CourseController::class, 'delete']);
    Route::put('/update-course/{id}', [CourseController::class, 'Update']);

});
