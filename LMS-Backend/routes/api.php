<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Student_Auth;
use App\Http\Controllers\Theacher_Auth;
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
Route::post('/add-guru', [Theacher_Auth::class, 'Register']);
Route::post('/add-siswa', [Student_Auth::class, 'Register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
