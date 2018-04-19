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

Route::get('paises/listing', 'PaisesController@listing');
Route::get('estados/listing', 'EstadosController@listing');
Route::get('cidades/listing/{cidade}', 'CidadesController@listing');

Route::get('marcas/listing', 'MarcasController@listing');
Route::get('proprietarios/listing', 'ProprietariosController@listing');

Route::get('autenticado', 'UsuariosController@authenticated')->middleware('auth:api');
Route::post('logout', 'UsuariosController@logout');
Route::post('oauth/token', 'Auth\CustomAccessTokenController@issueUserToken');

Route::group(['middleware' => ['auth:api', 'acl:api']], function () {
    Route::resource('marcas', 'MarcasController', ['except' => ['create', 'edit']]);
    Route::resource('proprietarios', 'ProprietariosController', ['except' => ['create', 'edit']]);
    Route::resource('veiculos', 'VeiculosController', ['except' => ['create', 'edit']]);
    Route::resource('perfis', 'PerfisController', ['except' => ['create', 'edit']]);
    Route::resource('usuarios', 'UsuariosController', ['except' => ['create', 'edit']]);

    Route::resource('paises', 'PaisesController', ['only' => ['index']]);
    Route::resource('estados', 'EstadosController', ['only' => ['index']]);
    Route::resource('cidades', 'CidadesController', ['only' => ['index']]);
});