@php
$route = route('ouvidoria.store-admin');
$routeCarregarSolicitanteCPF = route('ouvidoria.carrregar-solicitante-cpf');
$routeCarregarSetores = route('ouvidoria.carrregar-setores');
$routeCarregarAssuntos = route('ouvidoria.carrregar-assuntos');
$routeCarregarClassificacoes = route('ouvidoria.carrregar-classificacoes');
$routeCarregarSubClassificacoes = route('ouvidoria.carrregar-sub-classificacoes');
// DADOS DO SOLICITANTE
$checked = old('anonima') == "A" ? "checked" : "";
$solicitante_id = old('solicitante_id') ? old('solicitante_id') : "";
$tipo_solicitante_id = old('tipo_solicitante_id') ? old('tipo_solicitante_id') : "";
$cpf = old('cpf') ? old('cpf') : "";
$nome = old('nome') ? old('nome') : "";
$institutora_id = old('institutora_id') ? old('institutora_id') : "";
$uf = old('uf') ? old('uf') : "";
$cidade = old('cidade') ? old('cidade') : "";
$email = old('email') ? old('email') : "";
$telefone = old('telefone') ? old('telefone') : "";
$celular = old('celular') ? old('celular') : "";
// DADOS DA OUVIDORIA
$canal_atendimento_id = old('canal_atendimento_id') ? old('canal_atendimento_id') : "";
$tipo_ouvidoria_id = old('tipo_ouvidoria_id') ? old('tipo_ouvidoria_id') : "";
$observacao = old('observacao') ? old('observacao') : "";
$mensagem = old('mensagem') ? old('mensagem') : "";
$anexo = old('anexo') ? old('anexo') : "";
$categoria_id = old('categoria_id') ? old('categoria_id') : "";
$setor_id = old('setor_id') ? old('setor_id') : "";
$assunto_id = old('assunto_id') ? old('assunto_id') : "";
$classificacao_id = old('classificacao_id') ? old('classificacao_id') : "";
$sub_classificacao_id = old('sub_classificacao_id') ? old('sub_classificacao_id') : "";
// DADOS DA SITUACAO DA OUVIDORIA
$situacao_id = old('situacao_id') ? old('situacao_id') : "";
$comentario = old('comentario') ? old('comentario') : "";
@endphp

@extends('layouts.app')

@section('javascript')
<script type="text/javascript">
    top.routeCarregarSolicitanteCPF = "{{ $routeCarregarSolicitanteCPF }}";

    top.routeCarregarSetores = '{{ $routeCarregarSetores }}';
    top.routeCarregarAssuntos = '{{ $routeCarregarAssuntos }}';
    top.routeCarregarClassificacoes = '{{ $routeCarregarClassificacoes }}';
    top.routeCarregarSubClassificacoes = '{{ $routeCarregarSubClassificacoes }}';

    top.valorCategoria = '{{ $categoria_id }}';
    top.valorSetor = '{{ $setor_id }}';
    top.valorAssunto = '{{ $assunto_id }}';
    top.valorClassificacao = '{{ $classificacao_id }}';
    top.valorSubClassificacao = '{{ $sub_classificacao_id }}';
</script>
<script type="text/javascript" 
    src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" 
    src="{{ asset('/js/ouvidoria/ouvidoria/cad-ouvidoria.js') }}"></script>
<script type="text/javascript">
    @if (old('anonima') == "A")
    apresentarCamposSolicitante();
    @endif
</script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>

@if ($errors->any())
<!-- Alert -->
<div id="_sent_ok_" class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-exclamation-triangle"></i> Atenção!</h4>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<!-- /Alert -->
@endif

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card uper">
            <div class="card-header">
                Administração - Nova Solicitação
                <a href="{{ url('/ouvidoria') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <form id="formSolicitacaoOuvidoria" method="POST" action="{{ $route }}" autocomplete="off">
                    @csrf

                    <input type="hidden" id="ouvidoria_id" name="ouvidoria_id" value="">
                    <input type="hidden" id="solicitante_id" name="solicitante_id" value="{{ $solicitante_id }}">

                    <h5>Dados Pessoais</h5>
                    <hr>

                    <div class="row form-group {{ $errors->has('tipo_solicitante_id') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="tipo_solicitante_id" class="control-label">Você é (*)</label>
                        </div>
                        <div class="col-md-6">
                            <select id="tipo_solicitante_id" name="tipo_solicitante_id" 
                                class="form-control {{ $errors->has('tipo_solicitante_id') ? 'is-invalid' : '' }}" autofocus>
                                <option value="">- - Selecione - -</option>
                                @foreach ($tiposSolicitantes as $tipoSolicitante)
                                    @php $selected = ""; @endphp
                                    @if ($tipoSolicitante->id == $tipo_solicitante_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                <option value="{{ $tipoSolicitante->id }}" {{ $selected }}>
                                    {{ $tipoSolicitante->descricao }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('tipo_solicitante_id') }}</span>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="A" id="anonima" name="anonima" {{ $checked }}>
                                <label class="form-check-label" for="anonima">
                                  Ouvidoria anônima
                                </label>
                              </div>
                        </div>
                    </div>

                    <div id="divNaoAnonimo">
                    <div class="row form-group {{ $errors->has('cpf') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="cpf" class="control-label">CPF N° (*)</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('cpf') ? 'is-invalid' : '' }}" 
                                id="cpf" name="cpf" value="{{ $cpf }}" />
                            <span class="text-danger">{{ $errors->first('cpf') }}</span>
                        </div>
                    </div>
                    
                    <div class="row form-group {{ $errors->has('nome') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="nome" class="control-label">Nome (*)</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }} maiuscula" 
                                id="nome" name="nome" value="{{ $nome }}" />
                            <span class="text-danger">{{ $errors->first('nome') }}</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="institutora_id" class="control-label">Instituidora</label>
                        </div>
                        <div class="col-md-9">
                            <select id="institutora_id" name="institutora_id" 
                                class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                                @foreach ($institutoras as $institutora)
                                    @php $selected = ""; @endphp
                                    @if ($institutora->empresa == $institutora_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $institutora->empresa }}" {{ $selected }}>
                                        {{ $institutora->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('uf') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="uf" class="control-label">Estado (*)</label>
                        </div>
                        <div class="col-md-9">
                            <select id="uf" name="uf" class="form-control {{ $errors->has('uf') ? 'is-invalid' : '' }}">
                                <option value=""> -- SELECIONE -- </option>
                                @foreach ($ufs as $arrUf)
                                    @php $selected = ""; @endphp
                                    @if ($arrUf["sigla"] == $uf)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                <option value="{{ $arrUf["sigla"] }}" {{ $selected }}>
                                    {{ $arrUf["descricao"] }}
                                </option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('uf') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('cidade') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="cidade" class="control-label">Cidade (*)</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('cidade') ? 'is-invalid' : '' }}" 
                                id="cidade" name="cidade" value="{{ $cidade }}" />
                            <span class="text-danger">{{ $errors->first('cidade') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('email') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="email" class="control-label">E-mail (*)</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                                id="email" name="email" value="{{ $email }}" />
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="telefone" class="control-label">Telefone</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" 
                                id="telefone" name="telefone" value="{{ $telefone }}" />
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('celular') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="celular" class="control-label">Celular (*)</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('celular') ? 'is-invalid' : '' }}" 
                                id="celular" name="celular" value="{{ $celular }}" />
                            <span class="text-danger">{{ $errors->first('celular') }}</span>
                        </div>
                    </div>
                    <br>
                    </div>
                    
                    <h5>Canal de Atendimento</h5>
                    <hr>
                    
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="canal_atendimento_id" class="control-label">Manifestação encaminhada por:</label>
                            <select id="canal_atendimento_id" name="canal_atendimento_id" class="form-control">
                                @foreach ($canaisAtendimentos as $canalAtendimento)
                                    @php $selected = ""; @endphp
                                    @if ($canalAtendimento->id == $canal_atendimento_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $canalAtendimento->id }}" {{ $selected }}>
                                        {{ $canalAtendimento->descricao }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="tipo_ouvidoria_id" class="control-label">Tipo da Solicitação</label>
                            <select id="tipo_ouvidoria_id" name="tipo_ouvidoria_id" class="form-control">
                                @foreach ($tiposOuvidorias as $tipoOuvidoria)
                                    @php $selected = ""; @endphp
                                    @if ($tipoOuvidoria->id == $tipo_ouvidoria_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $tipoOuvidoria->id }}" {{ $selected }}>
                                        {{ $tipoOuvidoria->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="observacao" class="control-label">Observação:</label>
                            <textarea class="form-control" rows="5" id="observacao" name="observacao" 
                                class="form-control">{{ $observacao }}</textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <small class="form-text text-muted">
                                Sua observação tem <span class="caracteresObservacao">600</span> caracteres restantes
                            </small>
                        </div>
                    </div>

                    <br>
                    <h5>Mensagem e Anexo</h5>
                    <hr>

                    <div class="row form-group {{ $errors->has('mensagem') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="mensagem" class="control-label">Digite aqui sua mensagem (*)</label>
                        </div>
                        <div class="col-md-9">
                            <textarea rows="5" id="mensagem" name="mensagem" 
                                class="form-control">{{ $mensagem }}</textarea>
                            <span class="text-danger">{{ $errors->first('mensagem') }}</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-9">
                            <small class="form-text text-muted">
                                Sua mensagem tem <span class="caracteres">1200</span> caracteres restantes
                            </small>
                        </div>
                    </div>

                        <div class="row form-group">
                        <div class="col-md-3">
                            <label for="anexo" class="control-label">Anexar Arquivo</label>
                        </div>
                        <div class="col-md-9">
                            <input type="file" id="anexo" name="anexo" value="{{ $anexo }}" />
                        </div>
                    </div>

                    <br>
                    <h5>Classificação: Atendimento Parceiro FIPECq Vida</h5>
                    <hr>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="categoria_id" class="control-label">Categoria</label>
                            <select id="categoria_id" name="categoria_id" class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                                @foreach ($categorias as $categoria)
                                    @php $selected = ""; @endphp
                                    @if ($categoria->id == $categoria_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $categoria->id }}" {{ $selected }}>
                                        {{ $categoria->descricao }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="setor_id" class="control-label">Setor / Área</label>
                            <select id="setor_id" name="setor_id" 
                                class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="assunto_id" class="control-label">Assunto</label>
                            <select id="assunto_id" name="assunto_id" class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="classificacao_id" class="control-label">Classificação</label>
                            <select id="classificacao_id" name="classificacao_id" 
                                class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="sub_classificacao_id" class="control-label">Subclassificação</label>
                            <select id="sub_classificacao_id" name="sub_classificacao_id" class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                            </select>
                        </div>
                    </div>

                    <br>
                    <h5>Situação - Definir situação da mensagem:</h5>
                    <hr>

                    <div class="row form-group {{ $errors->has('situacao_id') ? 'text-danger' : '' }}">
                        <div class="col-md-6">
                            <label for="situacao_id" class="control-label">Definir Situação (*)</label>
                            <select id="situacao_id" name="situacao_id" 
                                class="form-control {{ $errors->has('situacao_id') ? 'is-invalid' : '' }}">
                                <option value=""> -- SELECIONE -- </option>
                                @foreach ($situacoes as $situacao)
                                    @php $selected = ""; @endphp
                                    @if ($situacao->id == $situacao_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $situacao->id }}" {{ $selected }}>{{ strtoupper($situacao->nome) }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('situacao_id') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('comentario') ? 'text-danger' : '' }}">
                        <div class="col-md-12">
                            <label for="comentario" class="control-label">Digite aqui sua mensagem (*)</label>
                            <textarea class="form-control" rows="5" id="comentario" name="comentario" 
                                class="form-control"></textarea>
                            <span class="text-danger">{{ $errors->first('comentario') }}</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <small class="form-text text-muted">
                                Sua mensagem tem <span class="caracteresComentario">1200</span> caracteres restantes
                            </small>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <span class="float-right text-danger">
                                <button type="submit" class="btn btn-primary" onclick="return validar();">
                                    <i class="fa fa-save"></i> Cadastrar Solicitação
                                </button>
                            </span>
                            <span class="float-right text-danger">
                                <button type="button" class="btn btn-danger" 
                                    onclick="location.href='{{ url('/ouvidoria') }}';">
                                    <i class="fa fa-arrow-left"></i> Voltar
                                </button>&nbsp;
                            </span>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
