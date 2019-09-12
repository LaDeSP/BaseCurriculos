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
Auth::routes(); 

Route::resource('/pfisicas', 'FisicaController');
Route::resource('/pjuridicas', 'JuridicaController');
Route::resource('/curriculos', 'CurriculoController', [
    'middleware' => 'jwt.auth'
]);
Route::resource('/vagas', 'VagaController', [
    'middleware' => 'jwt.auth'
]);
Route::post('/data/pjuridicas', 'JuridicaController@addData', [
 'middleware' => 'jwt.auth'
]);
Route::post('/areas', 'AreaController@store');
Route::post('/login', [
    'uses' => 'UserController@login'
]);
Route::post('/logout', [
    'uses' => 'UserController@logout',
    'middleware' => 'jwt.auth'
]);
/////////////////////////////////////////////////

