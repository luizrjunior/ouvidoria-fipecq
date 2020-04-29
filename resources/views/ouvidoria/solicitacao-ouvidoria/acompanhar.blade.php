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
$solicitacao_ouvidoria_cod = "";
$solicitacao_ouvidoria_protocolo = "";
$created_at = "";
$tipo_solicitacao_cod = "";
$solicitante_cpf = "";
$solicitante_nome = "";
$tipo_solicitante_cod = "";
$institutora_cod = "";
$solicitante_uf = "";
$solicitante_cidade = "";
$solicitante_email = "";
$solicitante_telefone = "";
$solicitante_celular = "";
$solicitacao_ouvidoria_mensagem = "";
$solicitacao_ouvidoria_anexo = "";

if ($solicitacao_ouvidoria) {
    $solicitacao_ouvidoria_cod = $errors->has('solicitacao_ouvidoria_cod') ? old('solicitacao_ouvidoria_cod') : $solicitacao_ouvidoria->solicitacao_ouvidoria_cod;
    $solicitacao_ouvidoria_protocolo = $errors->has('solicitacao_ouvidoria_protocolo') ? old('solicitacao_ouvidoria_protocolo') : str_pad($solicitacao_ouvidoria->solicitacao_ouvidoria_protocolo, 14, 0, STR_PAD_LEFT);
    $created_at = $errors->has('created_at') ? old('created_at') : date('d/m/Y H:i:s', strtotime($solicitacao_ouvidoria->created_at));
    $tipo_solicitacao_cod = $errors->has('tipo_solicitacao_cod') ? old('tipo_solicitacao_cod') : $solicitacao_ouvidoria->tipo_solicitacao_cod;
    $solicitante_cpf = $errors->has('solicitante_cpf') ? old('solicitante_cpf') : $solicitacao_ouvidoria->solicitante->solicitante_cpf;
    $solicitante_nome = $errors->has('solicitante_nome') ? old('solicitante_nome') : $solicitacao_ouvidoria->solicitante->solicitante_nome;
    $tipo_solicitante_cod = $errors->has('tipo_solicitante_cod') ? old('tipo_solicitante_cod') : $solicitacao_ouvidoria->solicitante->tipo_solicitante_cod;
    $institutora_cod = $errors->has('institutora_cod') ? old('institutora_cod') : $solicitacao_ouvidoria->solicitante->institutora_cod;
    $solicitante_uf = $errors->has('solicitante_uf') ? old('solicitante_uf') : $solicitacao_ouvidoria->solicitante->solicitante_uf;
    $solicitante_cidade = $errors->has('solicitante_cidade') ? old('solicitante_cidade') : $solicitacao_ouvidoria->solicitante->solicitante_cidade;
    $solicitante_email = $errors->has('solicitante_email') ? old('solicitante_email') : $solicitacao_ouvidoria->solicitante->solicitante_email;
    $solicitante_telefone = $errors->has('solicitante_telefone') ? old('solicitante_telefone') : $solicitacao_ouvidoria->solicitante->solicitante_telefone;
    $solicitante_celular = $errors->has('solicitante_celular') ? old('solicitante_celular') : $solicitacao_ouvidoria->solicitante->solicitante_celular;
    $solicitacao_ouvidoria_mensagem = $errors->has('solicitacao_ouvidoria_mensagem') ? old('solicitacao_ouvidoria_mensagem') : $solicitacao_ouvidoria->solicitacao_ouvidoria_mensagem;
    $solicitacao_ouvidoria_anexo = $errors->has('solicitacao_ouvidoria_anexo') ? old('solicitacao_ouvidoria_anexo') : $solicitacao_ouvidoria->solicitacao_ouvidoria_anexo;
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

                    <input type="hidden" id="solicitante_cod" name="solicitante_cod" value="">

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="solicitacao_ouvidoria_protocolo_psq" class="control-label">Selecione o Protocolo</label>
                        </div>
                        <div class="col-md-9">
                            <select id="solicitacao_ouvidoria_protocolo_psq" name="solicitacao_ouvidoria_protocolo_psq" class="form-control">
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

                    <div class="row form-group {{ $errors->has('solicitante_nome') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="solicitante_nome" class="control-label">Nome</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('solicitante_nome') ? 'is-invalid' : '' }}" 
                            id="solicitante_nome" name="solicitante_nome" value="{{ $solicitante_nome }}" disabled />
                            <span class="text-danger">{{ $errors->first('solicitante_nome') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('solicitante_cpf') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="solicitante_cpf" class="control-label">CPF N°</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('solicitante_cpf') ? 'is-invalid' : '' }}" 
                                id="solicitante_cpf" name="solicitante_cpf" value="{{ $solicitante_cpf }}" disabled />
                            <span class="text-danger">{{ $errors->first('solicitante_cpf') }}</span>
                        </div>
                    </div>
                    
                    <br />

                    <div class="row form-group {{ $errors->has('solicitacao_ouvidoria_protocolo') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="solicitacao_ouvidoria_protocolo" class="control-label">Protocolo</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('solicitacao_ouvidoria_protocolo') ? 'is-invalid' : '' }}" 
                                id="solicitacao_ouvidoria_protocolo" name="solicitacao_ouvidoria_protocolo" 
                                value="{{ $solicitacao_ouvidoria_protocolo }}" disabled />
                            <span class="text-danger">{{ $errors->first('solicitacao_ouvidoria_protocolo') }}</span>
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
                            <label for="tipo_solicitacao_cod" class="control-label">Tipo de Solicitação</label>
                        </div>
                        <div class="col-md-9">
                            <select id="tipo_solicitacao_cod" name="tipo_solicitacao_cod" class="form-control" disabled>
                                <option value="">- - Selecione - -</option>
                                @foreach ($tipo_solicitacaos as $tipo_solicitacao)
                                    @php $selected = ""; @endphp
                                    @if ($tipo_solicitacao->tipo_solicitacao_cod == $tipo_solicitacao_cod)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $tipo_solicitacao->tipo_solicitacao_cod }}" {{$selected}}>{{ $tipo_solicitacao->tipo_solicitacao_nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br />

                    <div class="row form-group {{ $errors->has('solicitacao_ouvidoria_mensagem') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="solicitacao_ouvidoria_mensagem" class="control-label">Mensagem</label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form-control" rows="5" id="solicitacao_ouvidoria_mensagem" name="solicitacao_ouvidoria_mensagem" 
                                class="form-control" disabled>{{ $solicitacao_ouvidoria_mensagem }}</textarea>
                        </div>
                    </div>

                    @if ($solicitacao_ouvidoria_anexo != "") 
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="solicitacao_ouvidoria_anexo" class="control-label">Anexo</label>
                        </div>
                        <div class="col-md-9">
                            Abrir arquivo anexo. <a href="{{ url("storage/anexos/{$solicitacao_ouvidoria_anexo}") }}" target="_blank">Clique aqui.</a>
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
