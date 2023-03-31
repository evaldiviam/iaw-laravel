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

Route::get('/articles', 'App\Http\Controllers\ArticleController@index');
Route::post('/articles', 'App\Http\Controllers\ArticleController@store');
Route::get('/articles/{article}', 'App\Http\Controllers\ArticleController@show');
Route::put('/articles/{article}', 'App\Http\Controllers\ArticleController@update');
Route::delete('/articles/{article}', 'App\Http\Controllers\ArticleController@destroy');

Route::get('/articles/search/{name}', 'App\Http\Controllers\ArticleController@searchByName');