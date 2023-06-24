<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\IndexController::class, "Index"]);

Route::get('/movie-details/{movieId}', [\App\Http\Controllers\MovieController::class, "Details"]);
Route::get('/movie-show/{movieId}/{showId}', [\App\Http\Controllers\MovieController::class, "ShowInfo"])->name("show");

Route::get('/booking/{showId}', [\App\Http\Controllers\MovieController::class, "Booking"]);
Route::get('/myBooking', [\App\Http\Controllers\UserController::class, "MyBooking"]);

Route::get('/sign-in/index/{movieId?}/{showId?}', [\App\Http\Controllers\UserController::class, "SignInIndex"]);
Route::get('/sign-in', [\App\Http\Controllers\UserController::class, "SignIn"]);
Route::get('/sign-up/index', [\App\Http\Controllers\UserController::class, "SignUpIndex"]);
Route::get('/sign-up', [\App\Http\Controllers\UserController::class, "SingUp"]);

Route::get('/logout', [\App\Http\Controllers\UserController::class, "Logout"]);

