<?php

use Illuminate\Http\Request;

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

Route::group([ 'prefix' => 'auth' ], function() {
    Route::post('/login', 'AuthController@login');
    Route::post('/refresh', 'AuthController@refresh');

    Route::middleware([ 'jwt.verify' ])->group(function() {
        Route::post('/logout', 'AuthController@logout');
        Route::post('/me', 'AuthController@me');
    });
});

Route::group([ 'prefix' => 'products', 'middleware' => 'jwt.verify' ], function() {
    Route::get('/', 'ProductsController@showAll');
    Route::get('/{id}', 'ProductsController@show');
    Route::post('/', 'ProductsController@create');
    Route::put('/{id}', 'ProductsController@update');
    Route::delete('/{id}', 'ProductsController@delete');
});