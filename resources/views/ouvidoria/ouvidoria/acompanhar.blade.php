@extends('layouts.app')

@section('title', 'Solicitação de Ouvidoria - Acompanhar')

@section('javascript')
<script type="text/javascript" 
    src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" 
    src="{{ asset('/js/ouvidoria/solicitacao-ouvidoria/cad-solicitacao-ouvidoria.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>

@php
$solicitacao_ouvidoria_id = "";
$protocolo = "";
$created_at = "";
$tipo_solicitacao_id = "";
$cpf = "";
$nome = "";
$tipo_solicitante_id = "";
$institutora_id = "";
$uf = "";
$cidade = "";
$email = "";
$telefone = "";
$celular = "";
$mensagem = "";
$anexo = "";

if ($solicitacao_ouvidoria) {
    $solicitacao_ouvidoria_id = $errors->has('solicitacao_ouvidoria_id') ? old('solicitacao_ouvidoria_id') : $solicitacao_ouvidoria->solicitacao_ouvidoria_id;
    $protocolo = $errors->has('protocolo') ? old('protocolo') : str_pad($solicitacao_ouvidoria->protocolo, 14, 0, STR_PAD_LEFT);
    $created_at = $errors->has('created_at') ? old('created_at') : date('d/m/Y H:i:s', strtotime($solicitacao_ouvidoria->created_at));
    $tipo_solicitacao_id = $errors->has('tipo_solicitacao_id') ? old('tipo_solicitacao_id') : $solicitacao_ouvidoria->tipo_solicitacao_id;
    $cpf = $errors->has('cpf') ? old('cpf') : $solicitacao_ouvidoria->solicitante->cpf;
    $nome = $errors->has('nome') ? old('nome') : $solicitacao_ouvidoria->solicitante->nome;
    $tipo_solicitante_id = $errors->has('tipo_solicitante_id') ? old('tipo_solicitante_id') : $solicitacao_ouvidoria->solicitante->tipo_solicitante_id;
    $institutora_id = $errors->has('institutora_id') ? old('institutora_id') : $solicitacao_ouvidoria->solicitante->institutora_id;
    $uf = $errors->has('uf') ? old('uf') : $solicitacao_ouvidoria->solicitante->uf;
    $cidade = $errors->has('cidade') ? old('cidade') : $solicitacao_ouvidoria->solicitante->cidade;
    $email = $errors->has('email') ? old('email') : $solicitacao_ouvidoria->solicitante->email;
    $telefone = $errors->has('telefone') ? old('telefone') : $solicitacao_ouvidoria->solicitante->telefone;
    $celular = $errors->has('celular') ? old('celular') : $solicitacao_ouvidoria->solicitante->celular;
    $mensagem = $errors->has('mensagem') ? old('mensagem') : $solicitacao_ouvidoria->mensagem;
    $anexo = $errors->has('anexo') ? old('anexo') : $solicitacao_ouvidoria->anexo;
}
@endphp

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card uper">
            <div class="card-header">
                Informações da Solicitação de Ouvidoria
                <a href="{{ url('/home') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <form id="formSolicitacaoOuvidoria" method="POST" 
                    action="{{ route('solicitacao-ouvidoria.acompanhar') }}" autocomplete="off">
                    @csrf

                    <input type="hidden" id="solicitante_id" name="solicitante_id" value="">

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="protocolo_psq" class="control-label">Selecione outro Protocolo</label>
                        </div>
                        <div class="col-md-9">
                            <select id="protocolo_psq" name="protocolo_psq" class="form-control">
                                <option value="">- - Selecione - -</option>
                                @foreach ($solicitacao_ouvidorias as $solicitacao_ouvidoria)
                                    <option value="{{ $solicitacao_ouvidoria->protocolo }}">
                                        {{ str_pad($solicitacao_ouvidoria->protocolo, 14, 0, STR_PAD_LEFT) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br />

                    <div class="row form-group {{ $errors->has('nome') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="nome" class="control-label">Nome</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}" 
                            id="nome" name="nome" value="{{ $nome }}" disabled />
                            <span class="text-danger">{{ $errors->first('nome') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('cpf') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="cpf" class="control-label">CPF N°</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('cpf') ? 'is-invalid' : '' }}" 
                                id="cpf" name="cpf" value="{{ $cpf }}" disabled />
                            <span class="text-danger">{{ $errors->first('cpf') }}</span>
                        </div>
                    </div>
                    
                    <br />

                    <div class="row form-group {{ $errors->has('protocolo') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="protocolo" class="control-label">Protocolo</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('protocolo') ? 'is-invalid' : '' }}" 
                                id="protocolo" name="protocolo" 
                                value="{{ $protocolo }}" disabled />
                            <span class="text-danger">{{ $errors->first('protocolo') }}</span>
                        </div>
                    </div>
                    
                    <div class="row form-group {{ $errors->has('created_at') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="created_at" class="control-label">Data Hora da Solicitação</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('created_at') ? 'is-invalid' : '' }}" 
                                id="created_at" name="created_at" value="{{ $created_at }}" disabled />
                            <span class="text-danger">{{ $errors->first('created_at') }}</span>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="tipo_solicitacao_id" class="control-label">Tipo de Solicitação</label>
                        </div>
                        <div class="col-md-9">
                            <select id="tipo_solicitacao_id" name="tipo_solicitacao_id" class="form-control" disabled>
                                <option value="">- - Selecione - -</option>
                                @foreach ($tipo_solicitacaos as $tipo_solicitacao)
                                    @php $selected = ""; @endphp
                                    @if ($tipo_solicitacao->id == $tipo_solicitacao_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $tipo_solicitacao->id }}" {{$selected}}>{{ $tipo_solicitacao->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br />

                    <div class="row form-group {{ $errors->has('mensagem') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="mensagem" class="control-label">Mensagem</label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form-control" rows="5" id="mensagem" name="mensagem" 
                                class="form-control" disabled>{{ $mensagem }}</textarea>
                        </div>
                    </div>

                    @if ($anexo != "") 
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="anexo" class="control-label">Anexo</label>
                        </div>
                        <div class="col-md-9">
                            Abrir arquivo anexo. <a href="{{ url("storage/anexos/{$anexo}") }}" target="_blank">Clique aqui.</a>
                        </div>
                    </div>
                    @endif

                    <div class="row form-group">
                        <div class="col-md-12">
                            <span class="float-right text-danger">
                                <button type="button" class="btn btn-danger" onclick="location.href='{{ url('/home') }}';">Voltar</button>
                            </span>
                        </div>
                    </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection
