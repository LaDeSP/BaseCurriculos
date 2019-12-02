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

Route::post('/areas', 'AreaController@store');
Route::get('/areas', 'AreaController@index');

Route::resource('/pfisicas', 'FisicaController');
Route::resource('/pjuridicas', 'JuridicaController');
Route::resource('/curriculos', 'CurriculoController', [
    'middleware' => 'jwt.auth'
]);

Route::resource('/agenda', 'AgendaController', [
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
    Route::post('/store/foto/{categoria}/{id}', 'UploadController@storeFoto')->name('fotos.store');
    Route::get('/getActualPhoto', 'UploadController@getActualPhoto');
    Route::post('/deletePhoto/{id?}', 'UploadController@deletePhoto');//delete
    Route::post('/vagas/changeStatus', 'VagaController@changeStatus');
    Route::get('/buscaVagas/{keywords}', 'BuscaController@buscaVagas');
    Route::get('/buscaVagasAvancadas/{keywords?}/{cargo?}/{beneficio?}/{jornada?}/{requisitos?}/{area?}', 'BuscaController@buscaVagasAvancadas');
    Route::get('/buscaCurriculos/{keywords}', 'BuscaController@buscaCurriculos');
    Route::get('/buscaCurriculosAvancadas/{keywords?}/{escolaridade?}/{objetivos?}/{historicoProfissional?}/{cidade?}/{nome?}/{area?}', 'BuscaController@buscaCurriculosAvancadas');
    Route::get('/buscaVagasRecomendadas/{userId}', 'BuscaController@buscaVagaIndicada');
    Route::post('/confirmAgenda', 'AgendaController@confirmAgenda');
    Route::post('/cancelAgenda', 'AgendaController@cancelAgenda');
    Route::get('/vagasPorcentagem', 'BuscaController@buscaVagasProgress');
    Route::delete('/deactivate/{id}', 'UserController@destroy');
});
Route::post('/activate/{id}', 'UserController@activateAccount');
Route::get('/teste', 'UserController@teste');
