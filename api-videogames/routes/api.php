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

Route::get('/categories', 'App\Http\Controllers\CategoryController@index');
Route::post('/categories', 'App\Http\Controllers\CategoryController@store');
Route::get('/categories/{category}', 'App\Http\Controllers\CategoryController@show');
Route::put('/categories/{category}', 'App\Http\Controllers\CategoryController@update');
Route::delete('/categories/{category}', 'App\Http\Controllers\CategoryController@destroy');

Route::get('/videogames', 'App\Http\Controllers\VideogameController@index');
Route::get('/videogames/search/{videogame}', 'App\Http\Controllers\VideogameController@searchVideogamesByTitle');
Route::get('/videogames/search/category/{category_id}', 'App\Http\Controllers\VideogameController@searchVideogamesByCategory');
Route::post('/videogames', 'App\Http\Controllers\VideogameController@store');
Route::get('/videogames/{videogame}', 'App\Http\Controllers\VideogameController@show');
Route::put('/videogames/{videogame}', 'App\Http\Controllers\VideogameController@update');
Route::delete('/videogames/{videogame}', 'App\Http\Controllers\VideogameController@destroy');

