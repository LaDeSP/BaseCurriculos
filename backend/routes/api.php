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

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Allow-Headers:  *');

Auth::routes(); 
Route::post('/login', [
    'uses' => 'UserController@login'
]);

Route::post('/laaaagout', [
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
    Route::post('/updateDadosCadastroFisica', 'FisicaController@updateDadosCadastroFisica');//put
    Route::post('/updateDadosCadastroJuridica', 'JuridicaController@updateDadosCadastroJuridica');//put
    Route::post('/createConvite', 'ConviteController@store');
    Route::get('/getConvites', 'ConviteController@getConvites');
    Route::post('/respostaConvite', 'ConviteController@respostaConvite');
    Route::post('/cancelarConvite', 'ConviteController@cancelarConvite');
    Route::post('/logout', 'UserController@logout');
    Route::get('/users', 'UserController@index');
    Route::post('/userStatus', 'UserController@handleUserStatus');
});
Route::post('/activate/{id}', 'UserController@activateAccount');