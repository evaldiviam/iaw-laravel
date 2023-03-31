<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\ServiceController;
use app\Http\Controllers\ClientController;

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

Route::get('/clients', 'App\Http\Controllers\ClientController@index');
Route::post('/clients', 'App\Http\Controllers\ClientController@store');
Route::get('/clients/{client}', 'App\Http\Controllers\ClientController@show');
Route::put('/clients/{client}', 'App\Http\Controllers\ClientController@update');
Route::delete('/clients/{client}', 'App\Http\Controllers\ClientController@destroy');

Route::get('/services', 'ServiceController@index');
Route::post('/services', 'ServiceController@store');
Route::get('/services/{service}', 'ServiceController@show');
Route::put('/services/{service}', 'ServiceController@update');
Route::delete('/services/{service}', 'ServiceController@destroy');

Route::post('/clients/services', 'App\Http\Controllers\ClientController@attach');
Route::post('/clients/services/detach', 'App\Http\Controllers\ClientController@detach');


Route::post('/services/clients', 'App\Http\Controllers\ServiceController@clients');
/*
 Versionado

 Route::prefix('v2')->group(
    function(){
        Route::get('/clients', 'ClientController@index');
        Route::post('/clients', 'ClientController@store');
        Route::get('/clients/{client}', 'ClientController@show');
        Route::put('/clients/{client}', 'ClientController@update');
        Route::delete('/clients/{client}', 'ClientController@destroy');
  })
 
 */