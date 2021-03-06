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
Route::get('/home', 'HomeController@index');

Route::get('/home/admin', 'HomeController@admin');

/**
 * Envio de E-mails
 */
Route::get('/enviar-emails', 'EnvioEmailController@index');

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
 * CATEGORIA
 */
Route::resource('categoria', 'CategoriaController');
Route::post('/categoria/ativar-desativar-categoria', 'CategoriaController@ativarDesativarCategoria');

/**
 * SETOR / AREA
 */
Route::resource('setor', 'SetorController');
Route::post('/setor/ativar-desativar-setor', 'SetorController@ativarDesativarSetor');

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
Route::any('/ouvidoria', 'OuvidoriaController@index')->name('ouvidoria.index');

Route::any('/ouvidoria/create', 'OuvidoriaController@create')->name('ouvidoria.create');
Route::post('/ouvidoria/store', 'OuvidoriaController@store')->name('ouvidoria.store');

Route::get('/ouvidoria/{ouvidoria_id}/edit', 'OuvidoriaController@edit')->name('ouvidoria.edit');
Route::post('/ouvidoria/update', 'OuvidoriaController@update')->name('ouvidoria.update');

Route::get('/ouvidoria/create-admin', 'OuvidoriaController@createAdmin');
Route::post('/ouvidoria/store-admin', 'OuvidoriaController@storeAdmin')->name('ouvidoria.store-admin');

Route::post('/ouvidoria/acompanhar', 'OuvidoriaController@acompanhar')->name('ouvidoria.acompanhar');

Route::post('/ouvidoria/carregar-solicitante-cpf', 'OuvidoriaController@carregarSolicitantePorCPF')->name('ouvidoria.carrregar-solicitante-cpf');
Route::post('/ouvidoria/carregar-setores', 'OuvidoriaController@carregarSelectSetor')->name('ouvidoria.carrregar-setores');
Route::post('/ouvidoria/carregar-assuntos', 'OuvidoriaController@carregarSelectAssunto')->name('ouvidoria.carrregar-assuntos');
Route::post('/ouvidoria/carregar-classificacoes', 'OuvidoriaController@carregarSelectClassificacao')->name('ouvidoria.carrregar-classificacoes');
Route::post('/ouvidoria/carregar-sub-classificacoes', 'OuvidoriaController@carregarSelectSubClassificacao')->name('ouvidoria.carrregar-sub-classificacoes');

/**
 * PESQUISA DE SATISFACAO
 */
Route::any('/pesquisa-satisfacao/relatorio', 'PesquisaSatisfacaoController@relatorio')->name('pesquisa-satisfacao.relatorio');

Route::get('/pesquisa-satisfacao/{ouvidoria_id}/create', 'PesquisaSatisfacaoController@create');
Route::post('/pesquisa-satisfacao/store', 'PesquisaSatisfacaoController@store')->name('pesquisa-satisfacao.store');

/**
 * RELATORIOS
 */
Route::any('/relatorio/tipo-solicitacao', 'RelatorioController@relatorioTipoOuvidoria')
    ->name('relatorio.tipo-solicitacao');

Route::any('/relatorio/faixa-etaria', 'RelatorioController@relatorioFaixaEtaria')
    ->name('relatorio.faixa-etaria');

Route::post('/relatorio/tempo-espera', 'RelatorioController@relatorioTempoEspera')
    ->name('relatorio.tempo-espera');

Route::post('/relatorio/institutora', 'RelatorioController@relatorioInstitutora')
    ->name('relatorio.institutora');

Route::post('/relatorio/relatorios', 'RelatorioController@relatorios')
    ->name('relatorio.relatorios');

Route::post('/relatorio/relatorio-personalizado', 'RelatorioController@relatorioPersonalizado')
    ->name('relatorio.relatorio-personalizado');

Route::post('/relatorio/relatorio-comparativo', 'RelatorioController@relatorioComparativo')
    ->name('relatorio.relatorio-comparativo');

/**
 * BENEFICIARIO
 */
Route::get('/benef', 'BeneficiarioController@index');
