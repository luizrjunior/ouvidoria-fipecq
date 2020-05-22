@extends('layouts.app')

@section('javascript')
<script type="text/javascript" 
    src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" 
    src="{{ asset('/js/ouvidoria/ouvidoria/cad-ouvidoria.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>

@php
$ouvidoria_id = $errors->has('ouvidoria_id') ? old('ouvidoria_id') : "";
$tipo_ouvidoria_id = $errors->has('tipo_ouvidoria_id') ? old('tipo_ouvidoria_id') : "";
$canal_atendimento_id = $errors->has('canal_atendimento_id') ? old('canal_atendimento_id') : "";
$sub_classificacao_id = $errors->has('sub_classificacao_id') ? old('sub_classificacao_id') : "";
$observacao_novo = $errors->has('observacao_novo') ? old('observacao_novo') : "";
$mensagem = $errors->has('mensagem') ? old('mensagem') : "";
$anexo = $errors->has('anexo') ? old('anexo') : "";

$solicitante_id = $errors->has('solicitante_id') ? old('solicitante_id') : "";
$tipo_solicitante_id = $errors->has('tipo_solicitante_id') ? old('tipo_solicitante_id') : "";
$institutora_id = $errors->has('institutora_id') ? old('institutora_id') : "";
$uf = $errors->has('uf') ? old('uf') : "";
$email = $errors->has('email') ? old('email') : "";
$telefone = $errors->has('telefone') ? old('telefone') : "";
$celular = $errors->has('celular') ? old('celular') : "";
@endphp

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
                <form id="formSolicitacaoOuvidoria" method="POST" 
                    action="{{ route('ouvidoria.store-admin') }}" autocomplete="off">
                    @csrf

                    <input type="hidden" id="ouvidoria_id" name="ouvidoria_id" value="">
                    <input type="hidden" id="solicitante_id" name="solicitante_id" value="">

                    <h5>Dados Pessoais</h5>
                    <hr>

                    <div class="row form-group {{ $errors->has('cpf') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="cpf" class="control-label">CPF N° (*)</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('cpf') ? 'is-invalid' : '' }}" 
                                id="cpf" name="cpf" value="{{ old('cpf') }}" autofocus />
                            <span class="text-danger">{{ $errors->first('cpf') }}</span>
                        </div>
                    </div>
                    
                    <div class="row form-group {{ $errors->has('nome') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="nome" class="control-label">Nome (*)</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}" 
                            id="nome" name="nome" value="{{ old('nome') }}" />
                            <span class="text-danger">{{ $errors->first('nome') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('tipo_solicitante_id') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="tipo_solicitante_id" class="control-label">Você é (*)</label>
                        </div>
                        <div class="col-md-9">
                            <select id="tipo_solicitante_id" name="tipo_solicitante_id" class="form-control {{ $errors->has('tipo_solicitante_id') ? 'is-invalid' : '' }}">
                                <option value="">- - Selecione - -</option>
                                @foreach ($tiposSolicitantes as $tipoSolicitante)
                                    @php $selected = ""; @endphp
                                    @if ($tipoSolicitante->id == $tipo_solicitante_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                <option value="{{$tipoSolicitante->id}}" {{$selected}}>{{$tipoSolicitante->descricao}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('tipo_solicitante_id') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('institutora_id') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="institutora_id" class="control-label">Institutora</label>
                        </div>
                        <div class="col-md-9">
                            <select id="institutora_id" name="institutora_id" class="form-control {{ $errors->has('institutora_id') ? 'is-invalid' : '' }}">
                                <option value="">- - Selecione - -</option>
                                @foreach ($institutoras as $institutora)
                                    @php $selected = ""; @endphp
                                    @if ($institutora->empresa == $institutora_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                <option value="{{$institutora->empresa}}" {{$selected}}>{{$institutora->nome}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('institutora_id') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('uf') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="uf" class="control-label">Estado (*)</label>
                        </div>
                        <div class="col-md-9">
                            <select id="uf" name="uf" class="form-control {{ $errors->has('uf') ? 'is-invalid' : '' }}">
                                <option value="">- - Selecione - -</option>
                                @foreach ($ufs as $arrUf)
                                    @php $selected = ""; @endphp
                                    @if ($arrUf["sigla"] == $uf)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                <option value="{{ $arrUf["sigla"] }}" {{$selected}}>{{ $arrUf["descricao"] }}</option>
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
                                id="cidade" name="cidade" value="{{ old('cidade') }}" />
                            <span class="text-danger">{{ $errors->first('cidade') }}</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="email" class="control-label">E-mail (*)</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="email" name="email" 
                                value="{{ $email }}" />
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="telefone" class="control-label">Telefone</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="telefone" name="telefone" 
                                value="{{ $telefone }}" />
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="celular" class="control-label">Celular (*)</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="celular" name="celular" 
                                value="{{ $celular }}" />
                        </div>
                    </div>
                    
                    <br>
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
                                        {{ strtoupper($canalAtendimento->descricao) }}
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
                                        {{ strtoupper($tipoOuvidoria->nome) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="observacao_novo" class="control-label">Observação:</label>
                            <textarea class="form-control" rows="5" id="observacao_novo" name="observacao_novo" 
                                class="form-control">{{ $observacao_novo }}</textarea>
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

                    <div class="row form-group">
                        <div class="col-md-12">
                            <textarea class="form-control" rows="5" id="mensagem" name="mensagem" 
                                class="form-control">{{ $mensagem }}</textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="anexo" class="control-label">Anexar Arquivo</label>
                        </div>
                        <div class="col-md-9">
                            <input type="file" id="anexo" name="anexo" />
                        </div>
                    </div>

                    <br>
                    <h5>Classificação: Atendimento Parceiro FIPECq Vida</h5>
                    <hr>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <select id="sub_classificacao_id" name="sub_classificacao_id" class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                                @foreach ($subclassificacoes as $subclassificacao)
                                    @php $selected = ""; @endphp
                                    @if ($subclassificacao->id == $sub_classificacao_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $subclassificacao->id }}" {{ $selected }}>
                                        {{ strtoupper($subclassificacao->classificacao->descricao) }} - {{ strtoupper($subclassificacao->descricao) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br>
                    <h5>Situação - Definir situação da mensagem:</h5>
                    <hr>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="situacao_id" class="control-label">Definir Situação:</label>
                            <select id="situacao_id" name="situacao_id" class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                                @foreach ($situacoes as $situacao)
                                    <option value="{{ $situacao->id }}">{{ strtoupper($situacao->nome) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="comentario" class="control-label">Digite aqui sua mensagem:</label>
                            <textarea class="form-control" rows="5" id="comentario" name="comentario" 
                                class="form-control"></textarea>
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
