<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShowsController;
use App\Http\Controllers\FavListController;
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


Route::group(['prefix' => 'v1'], function () {
    Route::post('users/login', [UserController::class, 'login']);
    Route::apiResource('users', UserController::class)->only('store');

    Route::get('/shows', [ShowsController::class, 'index']);

    Route::get('/movies', [ShowsController::class, 'getMovies']);
    Route::get('/tv-shows', [ShowsController::class, 'getTvShows']);
    Route::get('/movies/count', [ShowsController::class, 'getMoviesCount']);
    Route::get('/tv-shows/count', [ShowsController::class, 'getTVShowsCount']);


    Route::get('/search/', [ShowsController::class, 'searchShowsbyTitle']);
    Route::get('/show-details/{id}', [ShowsController::class, 'getShowDetails']);
    Route::get('/show-trailer/{id}', [ShowsController::class, 'getShowTrailer']);


    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('users/logout', [UserController::class, 'logout']);

        Route::post('/create-fav-list/{name}', [FavListController::class, 'createFavList']);
        Route::post('/add-to-favorites/{id}', [FavListController::class, 'pushShow']);
        Route::delete('/remove-from-favorites/{id}', [FavListController::class, 'popShow']);
        Route::get('/my-favorites', [FavListController::class, 'getFavListBody']);






    });
});


//
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
