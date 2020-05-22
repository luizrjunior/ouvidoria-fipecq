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
$tipo_ouvidoria_id = old('tipo_ouvidoria_id') ? old('tipo_ouvidoria_id') : $tipo_ouvidoria_id;
$tipo_solicitante_id = old('tipo_solicitante_id');
$solicitante_id = old('solicitante_id');
$institutora_id = old('institutora_id');
$uf = old('uf');
@endphp

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card uper">
            <div class="card-header">
                Informações da Ouvidoria
                <a href="{{ url('/fale-com-ouvidor') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <form id="formSolicitacaoOuvidoria" method="POST" 
                    action="{{ route('ouvidoria.store') }}" enctype="multipart/form-data" autocomplete="off">
                    @csrf

                    <input type="hidden" id="solicitante_id" name="solicitante_id" value="{{ $solicitante_id }}">

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="tipo_ouvidoria_id" class="control-label">Tipo de Solicitação</label>
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

                    <div class="row form-group {{ $errors->has('email') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="email" class="control-label">E-mail (*)</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                                id="email" name="email" value="{{ old('email') }}" />
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('telefone') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="telefone" class="control-label">Telefone</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('telefone') ? 'is-invalid' : '' }}" 
                                id="telefone" name="telefone" value="{{ old('telefone') }}" />
                            <span class="text-danger">{{ $errors->first('telefone') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('celular') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="celular" class="control-label">Celular (*)</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('celular') ? 'is-invalid' : '' }}" 
                                id="celular" name="celular" value="{{ old('celular') }}" />
                            <span class="text-danger">{{ $errors->first('celular') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('mensagem') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="mensagem" class="control-label">Digite aqui sua mensagem (*)</label>
                        </div>
                        <div class="col-md-9">
                            <textarea rows="5" id="mensagem" name="mensagem" 
                                class="form-control">{{ old('mensagem') }}</textarea>
                            <span class="text-danger">{{ $errors->first('mensagem') }}</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-9">
                            <small class="form-text text-muted">Sua mensagem tem <span class="caracteres">1200</span> caracteres restantes</small>
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

                    <div class="row form-group">
                        <div class="col-md-3">
                            &nbsp;
                        </div>

                        <div class="col-md-3">
                            <button type="button" class="btn btn-danger" 
                                onclick="location.href='{{ url('/fale-com-ouvidor') }}';">
                                Cancelar
                            </button>
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary" onclick="return validar();">
                                Cadastrar Solicitação
                            </button>
                        </div>

                        <div class="col-md-3">
                            <span class="float-right text-danger">
                                * Campos obrigatórios
                            </span>
                        </div>
                    </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection
