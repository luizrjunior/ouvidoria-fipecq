<?php

use Illuminate\Support\Facades\Route;

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

/**
 * HOME PAGE
 */
Route::get('/home', function () {
    return view('home');
});

/**
 * CARTA DE SERVICOS
 */
Route::get('/carta-servico', function () {
    return view('carta-servico');
});

/**
 * FALE COM O OUVIDOR
 */
Route::get('/fale-com-ouvidor', 'FaleComOuvidorController@index');

/**
 * TIPO DE OUVIDORIA
 */
Route::resource('tipo-ouvidoria', 'TipoOuvidoriaController');
Route::post('/tipo-ouvidoria/ativar-desativar-tipo-ouvidoria', 'TipoOuvidoriaController@ativarDesativarTipoOuvidoria');

/**
 * TIPO DE SOLICITANTE
 */
Route::resource('tipo-solicitante', 'TipoSolicitanteController');
Route::post('/tipo-solicitante/ativar-desativar-tipo-solicitante', 'TipoSolicitanteController@ativarDesativarTipoSolicitante');

/**
 * SITUACAO
 */
Route::resource('situacao', 'SituacaoController');
Route::post('/situacao/ativar-desativar-situacao', 'SituacaoController@ativarDesativarSituacao');

/**
 * ASSUNTO
 */
Route::resource('assunto', 'AssuntoController');
Route::post('/assunto/ativar-desativar-assunto', 'AssuntoController@ativarDesativarAssunto');

/**
 * CLASSIFICACAO
 */
Route::resource('classificacao', 'ClassificacaoController');
Route::post('/classificacao/ativar-desativar-classificacao', 'ClassificacaoController@ativarDesativarClassificacao');

/**
 * SUB-CLASSIFICACAO
 */
Route::resource('sub-classificacao', 'SubClassificacaoController');
Route::post('/sub-classificacao/ativar-desativar-sub-classificacao', 'SubClassificacaoController@ativarDesativarSubClassificacao');

/**
 * CANAL DE ATENDIMENTO
 */
Route::resource('canal-atendimento', 'CanalAtendimentoController');
Route::post('/canal-atendimento/ativar-desativar-canal-atendimento', 'CanalAtendimentoController@ativarDesativarCanalAtendimento');

/**
 * TIPO DE PRESTADOR
 */
Route::resource('tipo-prestador', 'TipoPrestadorController');
Route::post('/tipo-prestador/ativar-desativar-tipo-prestador', 'TipoPrestadorController@ativarDesativarTipoPrestador');

/**
 * OUVIDORIA
 */
// Route::resource('ouvidoria', 'OuvidoriaController');
Route::get('/ouvidoria', 'OuvidoriaController@index');
Route::any('/ouvidoria/search', 'OuvidoriaController@search')->name('ouvidoria.search');
Route::any('/ouvidoria/create', 'OuvidoriaController@create')->name('ouvidoria.create');
Route::post('/ouvidoria/store', 'OuvidoriaController@store')->name('ouvidoria.store');
Route::get('/ouvidoria/{ouvidoria_id}/edit', 'OuvidoriaController@edit')->name('ouvidoria.edit');
Route::post('/ouvidoria/update', 'OuvidoriaController@update')->name('ouvidoria.update');
Route::post('/ouvidoria/carregar-solicitante-cpf', 'OuvidoriaController@carregarSolicitantePorCPF');
Route::post('/ouvidoria/acompanhar', 'OuvidoriaController@acompanhar')->name('ouvidoria.acompanhar');

/**
 * BENEFICIARIO
 */
Route::get('/benef', 'BeneficiarioController@index');

