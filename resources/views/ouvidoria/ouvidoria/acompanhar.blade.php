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
$ouvidoria_id = "";
$protocolo = "";
$created_at = "";
$tipo_ouvidoria_id = "";
$solicitante_id = "";
$cpf = "";
$nome = "";
$mensagem = "";
$anexo = "";

if ($ouvidoria) {
    $ouvidoria_id = $ouvidoria->id;
    $protocolo = $errors->has('protocolo') ? old('protocolo') : str_pad($ouvidoria->protocolo, 14, 0, STR_PAD_LEFT);
    $created_at = $errors->has('created_at') ? old('created_at') : date('d/m/Y H:i:s', strtotime($ouvidoria->created_at));
    $tipo_ouvidoria_id = $errors->has('tipo_ouvidoria_id') ? old('tipo_ouvidoria_id') : $ouvidoria->tp_ouvidoria_id;

    $solicitante_id = $ouvidoria->solicitante_id;
    if ($solicitante_id != "") {
        $cpf = $errors->has('cpf') ? old('cpf') : $ouvidoria->solicitante->cpf;
        $nome = $errors->has('nome') ? old('nome') : $ouvidoria->solicitante->nome;
    }

    $mensagem = $errors->has('mensagem') ? old('mensagem') : $ouvidoria->mensagem;
    $anexo = $errors->has('anexo') ? old('anexo') : $ouvidoria->anexo;
}
@endphp

@if (count($ouvidorias) > 0)
    @if ($ouvidoria == null)
<!-- Alert -->
<div id="_sent_ok_" class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i> Alerta!</h4>
    <span id="_msg_txt_">Foram encontradas algumas solicitações. Por favor selecione pelo Nº do Protoloco!</span>
</div>
<!-- /Alert -->
    @endif
@endif

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card uper">
            <div class="card-header">
                Acompanhar Solicitação
                <a href="{{ url('/home') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <form id="formSolicitacaoOuvidoria" method="POST" 
                    action="{{ route('ouvidoria.acompanhar') }}" autocomplete="off">
                    @csrf

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="protocolo_psq" class="control-label">Selecione o Protocolo</label>
                        </div>
                        <div class="col-md-9">
                            <select id="protocolo_psq" name="protocolo_psq" class="form-control">
                                <option value="">- - Selecione - -</option>
                                @foreach ($ouvidorias as $arrOuvidoria)
                                    <option value="{{ $arrOuvidoria->protocolo }}">
                                        {{ str_pad($arrOuvidoria->protocolo, 14, 0, STR_PAD_LEFT) }} - {{ $arrOuvidoria->notipoouvidoria }} - {{ date('d/m/Y', strtotime($arrOuvidoria->dtcriacao)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if ($solicitante_id != "")
                    <h5>Dados Pessoais</h5>
                    <hr>

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
                    @endif
                    
                    @if ($ouvidoria_id != "")
                    <h5>Informações da Solicitação</h5>
                    <hr>

                    <div class="row form-group {{ $errors->has('protocolo') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="protocolo" class="control-label">Protocolo Nº</label>
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
                            <label for="tipo_ouvidoria_id" class="control-label">Tipo da Solicitação</label>
                        </div>
                        <div class="col-md-9">
                            <select id="tipo_ouvidoria_id" name="tipo_ouvidoria_id" class="form-control" disabled>
                                <option value="">- - Selecione - -</option>
                                @foreach ($tiposOuvidorias as $tipoOuvidoria)
                                    @php $selected = ""; @endphp
                                    @if ($tipoOuvidoria->id == $tipo_ouvidoria_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $tipoOuvidoria->id }}" {{$selected}}>{{ $tipoOuvidoria->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="control-label">Situação da Solicitação</label>
                        </div>
                        <div class="col-md-9">
                            @if ($ouvidoria)
                            <h3>
                                <span class="badge badge-pill badge-{{ $ouvidoria->situacao->cor }}" style="width: 50%;">
                                    {{ $ouvidoria->situacao->nome }}
                                </span>
                            </h3>
                            @endif
                        </div>
                    </div>

                    @if ($anexo != "") 
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="anexo" class="control-label">Anexo</label>
                        </div>
                        <div class="col-md-9">
                            Abrir arquivo anexo <a href="{{ url("storage/anexos/{$anexo}") }}" target="_blank">clique aqui.</a>
                        </div>
                    </div>
                    @endif

                    <h5>Mensagem</h5>
                    <hr>

                    <div class="row form-group {{ $errors->has('mensagem') ? 'text-danger' : '' }}">
                        <div class="col-md-12">
                            <textarea class="form-control" rows="5" id="mensagem" name="mensagem" 
                                class="form-control" disabled>{{ $mensagem }}</textarea>
                        </div>
                    </div>

                    <br>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="card-deck">

                            @if (count($situacoes) > 0)
                                @foreach ($situacoes as $situacao)
                                
                                <div class="card text-white bg-{{ $situacao->cor }} mb-3">
                                    <div class="card-body" style="text-align:center;">
                                        <h5 class="card-title">{{ $situacao->nome }}</h5>
                                        <p class="card-text">{{ $situacao->descricao }}</p>
                                    </div>
                                </div>

                                @endforeach
                            @endif

                            </div>
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
