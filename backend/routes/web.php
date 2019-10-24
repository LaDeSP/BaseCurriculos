<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/teste','CandidaturaController@teste')->name('teste');
Route::post('/store/foto/{categoria}/{id}', 'UploadController@storeFoto')->name('fotos.store');
Route::post('/store/arquivo/{categoria}/{id}', 'UploadController@storeArquivo')->name('arquivos.store');

Route::get('/teste', function () {
    return view('teste');
  });

  Route::get('/testetwo', 'UserController@teste');
  Route::get('/testethree', 'VagaController@index');



