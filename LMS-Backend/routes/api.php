<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DetailCourseController;
use App\Http\Controllers\Enr0llmentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\MyCourseController;
use App\Http\Controllers\Student_Auth;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\Theacher_Auth;
use App\Http\Controllers\UserController;
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
    Route::post('/logout-admin', [LoginController::class, 'logout']);
});

Route::group(['middleware' => ['auth:sanctum', 'CheckRole:guru']], function () {
    // CRUD course
    Route::get('/course', [CourseController::class, 'index']);
    Route::post('/add-course', [CourseController::class, 'store']);
    Route::delete('/delete-course/{id}', [CourseController::class, 'delete']);
    Route::put('/update-course/{id}', [CourseController::class, 'Update']);
    // My course
    Route::get('/get-detail/{id}', [DetailCourseController::class, 'index']);
    //materi
    Route::post('/add-module/{id}', [ModuleController::class, 'store_materi']);
    Route::get('/update-module/{id}', [ModuleController::class, 'update']);
    Route::delete('/delete-module/{id}', [ModuleController::class, 'destroy']);
    //get Detail materi
    Route::get('/detail-materi/{id}', [ModuleController::class, 'detail_materi']);
    //enroll siswa
    Route::post('/enroll/{id}', [EnrollmentController::class, 'enroll_byteach']);
    Route::delete('/reset_enroll/{id}', [EnrollmentController::class, 'reset_enrollment']);
    //assignment
    Route::post('/add-assignment/{id}', [AssignmentController::class, 'store']);
    Route::get('/update-assignment/{id}', [AssignmentController::class, 'update']);
    Route::delete('/delete-assignment/{id}', [AssignmentController::class, 'delete']);
    //get Detail assignment
    Route::get('/detail-assignment/{id}', [AssignmentController::class, 'detail_assignment']);
    //profile guru
    Route::get('/profile-guru', [UserController::class, 'show']);
    Route::post('/logout-guru', [LoginController::class, 'logout']);
});

Route::group(['middleware' => ['auth:sanctum', 'CheckRole:siswa']], function () {
    //Selfenrollment
    Route::post('/enrollment/{id}', [EnrollmentController::class, 'enroll']);
    //mycourse
    Route::get('/mycourse', [MyCourseController::class, 'mycourse']);
    //submission
    Route::post('/submission/{id}', [SubmissionController::class, 'store']);
    //get Detail assignment
    Route::get('/detail-assignment/{id}', [AssignmentController::class, 'detail_assignment']);
    // Detail Materi
    Route::get('/detail-materi/{id}', [ModuleController::class, 'detail_materi']);
    //profile
    Route::get('/profile', [UserController::class, 'show']);
    Route::post('/logout', [LoginController::class, 'logout']);
});
