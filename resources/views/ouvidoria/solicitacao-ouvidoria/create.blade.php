@extends('layouts.app')

@section('title', 'Solicitação de Ouvidoria')

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
$tipo_solicitacao_cod = old('tipo_solicitacao_cod') ? old('tipo_solicitacao_cod') : $tipo_solicitacao_cod;
$tipo_solicitante_cod = old('tipo_solicitante_cod');
$institutora_cod = old('institutora_cod');
$solicitante_uf = old('solicitante_uf');
@endphp

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card uper">
            <div class="card-header">
                Informações da Solicitação de Ouvidoria
                <a href="{{ url('/fale-com-ouvidor') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <form id="formSolicitacaoOuvidoria" method="POST" 
                    action="{{ route('solicitacao-ouvidoria.store') }}" enctype="multipart/form-data" autocomplete="off">
                    @csrf

                    <input type="hidden" id="solicitante_cod" name="solicitante_cod" value="">

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

                    <div class="row form-group {{ $errors->has('solicitante_cpf') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="solicitante_cpf" class="control-label">CPF N° (*)</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('solicitante_cpf') ? 'is-invalid' : '' }}" 
                                id="solicitante_cpf" name="solicitante_cpf" value="{{ old('solicitante_cpf') }}" autofocus />
                            <span class="text-danger">{{ $errors->first('solicitante_cpf') }}</span>
                        </div>
                    </div>
                    
                    <div class="row form-group {{ $errors->has('solicitante_nome') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="solicitante_nome" class="control-label">Nome (*)</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('solicitante_nome') ? 'is-invalid' : '' }}" 
                            id="solicitante_nome" name="solicitante_nome" value="{{ old('solicitante_nome') }}" />
                            <span class="text-danger">{{ $errors->first('solicitante_nome') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('tipo_solicitante_cod') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="tipo_solicitante_cod" class="control-label">Tipo de Solicitante - Você é (*)</label>
                        </div>
                        <div class="col-md-9">
                            <select id="tipo_solicitante_cod" name="tipo_solicitante_cod" class="form-control {{ $errors->has('tipo_solicitante_cod') ? 'is-invalid' : '' }}">
                                <option value="">- - Selecione - -</option>
                                @foreach ($tipo_solicitantes as $tipo_solicitante)
                                    @php $selected = ""; @endphp
                                    @if ($tipo_solicitante->tipo_solicitante_cod == $tipo_solicitante_cod)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                <option value="{{$tipo_solicitante->tipo_solicitante_cod}}" {{$selected}}>{{$tipo_solicitante->tipo_solicitante_descricao}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('tipo_solicitante_cod') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('institutora_cod') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="institutora_cod" class="control-label">Institutora/Empresa (*)</label>
                        </div>
                        <div class="col-md-9">
                            <select id="institutora_cod" name="institutora_cod" class="form-control {{ $errors->has('institutora_cod') ? 'is-invalid' : '' }}">
                                <option value="">- - Selecione - -</option>
                                @foreach ($institutoras as $institutora)
                                    @php $selected = ""; @endphp
                                    @if ($institutora->institutora_cod == $institutora_cod)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                <option value="{{$institutora->institutora_cod}}" {{$selected}}>{{$institutora->institutora_descricao}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('institutora_cod') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('solicitante_uf') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="solicitante_uf" class="control-label">Estado (*)</label>
                        </div>
                        <div class="col-md-9">
                            <select id="solicitante_uf" name="solicitante_uf" class="form-control {{ $errors->has('solicitante_uf') ? 'is-invalid' : '' }}">
                                <option value="">- - Selecione - -</option>
                                @foreach ($ufs as $uf)
                                    @php $selected = ""; @endphp
                                    @if ($uf->uf_sigla == $solicitante_uf)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                <option value="{{$uf->uf_sigla}}" {{$selected}}>{{$uf->uf_descricao}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('solicitante_uf') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('solicitante_cidade') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="solicitante_cidade" class="control-label">Cidade (*)</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control {{ $errors->has('solicitante_cidade') ? 'is-invalid' : '' }}" 
                                id="solicitante_cidade" name="solicitante_cidade" value="{{ old('solicitante_cidade') }}" />
                            <span class="text-danger">{{ $errors->first('solicitante_cidade') }}</span>
                        </div>
                    </div>

                    <div class="row form-group {{ $errors->has('solicitante_email') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="solicitante_email" class="control-label">E-mail (*)</label>
                        </div>
                        <div class="col-md-9">
                        <input type="text" class="form-control {{ $errors->has('solicitante_email') ? 'is-invalid' : '' }}" 
                            id="solicitante_email" name="solicitante_email" value="{{ old('solicitante_email') }}" />
                        <span class="text-danger">{{ $errors->first('solicitante_email') }}</span>
                    </div>
                    </div>

                    <div class="row form-group {{ $errors->has('solicitante_telefone') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="solicitante_telefone" class="control-label">Telefone</label>
                        </div>
                        <div class="col-md-9">
                        <input type="text" class="form-control {{ $errors->has('solicitante_telefone') ? 'is-invalid' : '' }}" 
                            id="solicitante_telefone" name="solicitante_telefone" value="{{ old('solicitante_telefone') }}" />
                        <span class="text-danger">{{ $errors->first('solicitante_telefone') }}</span>
                    </div>
                    </div>

                    <div class="row form-group {{ $errors->has('solicitante_celular') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="solicitante_celular" class="control-label">Celular (*)</label>
                        </div>
                        <div class="col-md-9">
                        <input type="text" class="form-control {{ $errors->has('solicitante_celular') ? 'is-invalid' : '' }}" 
                            id="solicitante_celular" name="solicitante_celular" value="{{ old('solicitante_celular') }}" />
                        <span class="text-danger">{{ $errors->first('solicitante_celular') }}</span>
                    </div>
                    </div>

                    <div class="row form-group {{ $errors->has('solicitacao_ouvidoria_mensagem') ? 'text-danger' : '' }}">
                        <div class="col-md-3">
                            <label for="solicitacao_ouvidoria_mensagem" class="control-label">Digite aqui sua mensagem (*)</label>
                        </div>
                        <div class="col-md-9">
                            <textarea rows="5" id="solicitacao_ouvidoria_mensagem" name="solicitacao_ouvidoria_mensagem" 
                                class="form-control">{{ old('solicitacao_ouvidoria_mensagem') }}</textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-9">
                            <small class="form-text text-muted">Sua mensagem tem <span class="caracteres">255</span> caracteres restantes</small>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="solicitacao_ouvidoria_anexo" class="control-label">Anexar Arquivo</label>
                        </div>
                        <div class="col-md-9">
                            <input type="file" id="solicitacao_ouvidoria_anexo" name="solicitacao_ouvidoria_anexo" />
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            &nbsp;
                        </div>

                        <div class="col-md-3">
                            <button type="button" class="btn btn-danger" onclick="location.href='{{ url('/fale-com-ouvidor') }}';">Cancelar</button>
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary" onclick="return validar()">Cadastrar Solicitação</button>
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
