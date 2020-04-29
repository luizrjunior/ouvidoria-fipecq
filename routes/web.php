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

Route::get('/home', function () {
    return view('home');
});

Route::get('/carta-servico', function () {
    return view('carta-servico');
});

Route::resource('institutora', 'InstitutoraController');
Route::post('/institutora/ativar-desativar-institutora', 'InstitutoraController@ativarDesativarInstitutora');

Route::resource('assunto', 'AssuntoController');
Route::post('/assunto/ativar-desativar-assunto', 'AssuntoController@ativarDesativarAssunto');

Route::resource('situacao', 'SituacaoController');
Route::post('/situacao/ativar-desativar-situacao', 'SituacaoController@ativarDesativarSituacao');

Route::resource('classificacao', 'ClassificacaoController');
Route::post('/classificacao/ativar-desativar-classificacao', 'ClassificacaoController@ativarDesativarClassificacao');

Route::resource('sub-classificacao', 'SubClassificacaoController');
Route::post('/sub-classificacao/ativar-desativar-sub-classificacao', 'SubClassificacaoController@ativarDesativarSubClassificacao');

Route::resource('canal-atendimento', 'CanalAtendimentoController');
Route::post('/canal-atendimento/ativar-desativar-canal-atendimento', 'CanalAtendimentoController@ativarDesativarCanalAtendimento');

Route::resource('tipo-solicitacao', 'TipoSolicitacaoController');
Route::post('/tipo-solicitacao/ativar-desativar-tipo-solicitacao', 'TipoSolicitacaoController@ativarDesativarTipoSolicitacao');

Route::resource('tipo-prestador', 'TipoPrestadorController');
Route::post('/tipo-prestador/ativar-desativar-tipo-prestador', 'TipoPrestadorController@ativarDesativarTipoPrestador');

Route::resource('tipo-solicitante', 'TipoSolicitanteController');
Route::post('/tipo-solicitante/ativar-desativar-tipo-solicitante', 'TipoSolicitanteController@ativarDesativarTipoSolicitante');

Route::get('/fale-com-ouvidor', 'FaleComOuvidorController@index');

/**
 * SOLICITACAO DE OUVIDORIA
 */
Route::resource('solicitacao-ouvidoria', 'SolicitacaoOuvidoriaController');

Route::post('/solicitacao-ouvidoria/index', 'SolicitacaoOuvidoriaController@index')->name('solicitacao-ouvidoria.index');
Route::post('/solicitacao-ouvidoria/create', 'SolicitacaoOuvidoriaController@create')->name('solicitacao-ouvidoria.create');

// Route::post('/solicitacao-ouvidoria/store', 'SolicitacaoOuvidoriaController@store')->name('solicitacao-ouvidoria.store');

Route::post('/solicitacao-ouvidoria/carregar-solicitante-cpf', 'SolicitacaoOuvidoriaController@carregarSolicitantePorCPF');
Route::post('/solicitacao-ouvidoria/acompanhar', 'SolicitacaoOuvidoriaController@acompanharSolicitacao')->name('solicitacao-ouvidoria.acompanhar');
