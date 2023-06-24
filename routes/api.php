<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/login", [\App\Http\Controllers\ApiController::class, "Login"]);
Route::post("/logout", [\App\Http\Controllers\ApiController::class, "Logout"]);
Route::post("/shows", [\App\Http\Controllers\ApiController::class, "CreateMovieShows"]);


Route::get("/latest-movies", [\App\Http\Controllers\ApiController::class, "GetMovies"]);
Route::get("/movies", [\App\Http\Controllers\ApiController::class, "GetMovieByTitle"]);
Route::get("/cinema/{cinema_id}/date/{date}/shows", [\App\Http\Controllers\ApiController::class, "GetCinema"]);
Route::get("/cinemas", [\App\Http\Controllers\ApiController::class, "GetAllCinemas"]);
