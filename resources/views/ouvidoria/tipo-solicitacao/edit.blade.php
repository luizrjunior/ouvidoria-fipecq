@extends('layouts.app')

@section('title', 'Tipo de Solicitação')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/ouvidoria/tipo-solicitacao/cad-tipo-solicitacao.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
@php
$tipo_solicitacao_nome = $errors->has('tipo_solicitacao_nome') ? old('tipo_solicitacao_nome') : $tipo_solicitacao->tipo_solicitacao_nome;
$tipo_solicitacao_descricao = $errors->has('tipo_solicitacao_descricao') ? old('tipo_solicitacao_descricao') : $tipo_solicitacao->tipo_solicitacao_descricao;
$tipo_solicitacao_icone = $errors->has('tipo_solicitacao_icone') ? old('tipo_solicitacao_icone') : $tipo_solicitacao->tipo_solicitacao_icone;
$tipo_solicitacao_cor = $errors->has('tipo_solicitacao_cor') ? old('tipo_solicitacao_cor') : $tipo_solicitacao->tipo_solicitacao_cor;
$tipo_solicitacao_sla = $errors->has('tipo_solicitacao_sla') ? old('tipo_solicitacao_sla') : $tipo_solicitacao->tipo_solicitacao_sla;
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card uper">
            <div class="card-header">
                Editar Tipo de Solicitação
                <a href="{{ url('/tipo-solicitacao') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('tipo-solicitacao.update', $tipo_solicitacao->tipo_solicitacao_cod) }}" autocomplete="off">
                    @method('PATCH')
                    @csrf
                    <div class="form-group {{ $errors->has('tipo_solicitacao_nome') ? 'text-danger' : '' }}">
                        <label for="tipo_solicitacao_nome">Nome (*)</label>
                        <input type="text" class="form-control {{ $errors->has('tipo_solicitacao_nome') ? 'is-invalid' : '' }}" 
                            name="tipo_solicitacao_nome" value="{{ $tipo_solicitacao_nome }}" />
                        <span class="text-danger">{{ $errors->first('tipo_solicitacao_nome') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('tipo_solicitacao_descricao') ? 'text-danger' : '' }}">
                        <label for="tipo_solicitacao_descricao">Descrição (*)</label>
                        <input type="text" class="form-control {{ $errors->has('tipo_solicitacao_descricao') ? 'is-invalid' : '' }}" 
                            name="tipo_solicitacao_descricao" value="{{ $tipo_solicitacao_descricao }}" />
                        <span class="text-danger">{{ $errors->first('tipo_solicitacao_descricao') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('tipo_solicitacao_icone') ? 'text-danger' : '' }}">
                        <label for="tipo_solicitacao_icone">Ícone (Font Awesome)(*)</label>
                        <input type="text" class="form-control {{ $errors->has('tipo_solicitacao_icone') ? 'is-invalid' : '' }}" 
                            name="tipo_solicitacao_icone" value="{{ $tipo_solicitacao_icone }}" />
                        <span class="text-danger">{{ $errors->first('tipo_solicitacao_icone') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('tipo_solicitacao_cor') ? 'text-danger' : '' }}">
                        <label for="tipo_solicitacao_cor">Cor (Bootstrap)(*)</label>
                        <input type="text" class="form-control {{ $errors->has('tipo_solicitacao_cor') ? 'is-invalid' : '' }}" 
                            name="tipo_solicitacao_cor" value="{{ $tipo_solicitacao_cor }}" />
                        <span class="text-danger">{{ $errors->first('tipo_solicitacao_cor') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('tipo_solicitacao_sla') ? 'text-danger' : '' }}">
                        <label for="tipo_solicitacao_sla">SLA (*)</label>
                        <input type="text" class="form-control {{ $errors->has('tipo_solicitacao_sla') ? 'is-invalid' : '' }}" 
                            name="tipo_solicitacao_sla" value="{{ $tipo_solicitacao_sla }}" />
                        <span class="text-danger">{{ $errors->first('tipo_solicitacao_sla') }}</span>
                    </div>
                    <button type="submit" class="btn btn-primary" onclick="return validar()">Atualizar</button>
                    <span class="float-right text-danger">
                        * Campos obrigatórios
                    </span>
                </form>
            </div>
        </div>
    </div>
</div>
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
@endsection
