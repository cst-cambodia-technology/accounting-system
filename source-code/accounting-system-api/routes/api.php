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

/*Authenticate*/
Route::post('/authenticate', 'UserController@authenticate');

Route::get('/users', 'UserController@index')->middleware('jwt.auth');
Route::get('/users/{id}', 'UserController@show')->middleware('jwt.auth');
Route::post('/users', 'UserController@create')->middleware('jwt.auth');
Route::put('/users/{id}', 'UserController@update')->middleware('jwt.auth');
Route::delete('/users/{id}', 'UserController@delete')->middleware('jwt.auth');
