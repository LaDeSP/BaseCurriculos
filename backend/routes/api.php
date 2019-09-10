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
Route::resource('/pfisica', 'FisicaController');
Route::resource('/pjuridica', 'JuridicaController');

Route::resource('/curriculo', 'CurriculoController', [
    'middleware' => 'jwt.auth'
]);

Route::post('/data/pjuridica', 'JuridicaController@addData', [
 'middleware' => 'jwt.auth'
]);

Auth::routes(); 

Route::post('/login', [
    'uses' => 'UserController@login'
]);

Route::post('/logout', [
    'uses' => 'UserController@logout',
    'middleware' => 'jwt.auth'
]);
/////////////////////////////////////////////////

