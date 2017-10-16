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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('paises/listing', 'PaisesController@listing');
Route::get('estados/listing', 'EstadosController@listing');
Route::get('cidades/listing/{cidade}', 'CidadesController@listing');

Route::resource('paises', 'PaisesController', ['only' => ['index']]);
Route::resource('estados', 'EstadosController', ['only' => ['index']]);
Route::resource('cidades', 'CidadesController', ['only' => ['index']]);
