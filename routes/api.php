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
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

Route::get('saldo', 'SaldoController@saldo');
Route::get('saldoall', 'SaldoController@saldoAuth')->middleware('jwt.verify');
Route::get('user', 'UserController@getAuthenticatedUser')->middleware('jwt.verify');
Route::put('saldo/{id}', 'SaldoController@update')->middleware('jwt.verify');
Route::post('proses', 'SaldoController@proses')->middleware('jwt.verify');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
