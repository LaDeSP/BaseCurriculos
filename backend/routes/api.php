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
Route::post('/login', [
    'uses' => 'UserController@login'
]);
Route::post('/logout', [
    'uses' => 'UserController@logout'
]);

Route::resource('/pfisicas', 'FisicaController');
Route::resource('/pjuridicas', 'JuridicaController');
Route::resource('/curriculos', 'CurriculoController', [
    'middleware' => 'jwt.auth'
]);
Route::resource('/vagas', 'VagaController', [
    'middleware' => 'jwt.auth'
]);

Route::resource('/candidaturas', 'CandidaturaController', [
    'middleware' => 'jwt.auth'
]);

Route::group([
    'middleware' => 'jwt.auth',
], function ($router) {

    Route::post('/pjuridicas/data', 'JuridicaController@addData');
    Route::post('/areas', 'AreaController@store');
    Route::get('/areas', 'AreaController@index');
    Route::post('/store/foto/{categoria}/{id}', 'UploadController@storeFoto')->name('fotos.store');
    Route::get('/getActualPhoto', 'UploadController@getActualPhoto');
    Route::post('/deletePhoto/{id?}', 'UploadController@deletePhoto');//delete
    Route::post('/vagas/changeStatus', 'VagaController@changeStatus');
});

Route::resource('/agenda', 'AgendaController', [
    'middleware' => 'jwt.auth'
]);

Route::get('/teste', 'CandidaturaController@teste');
