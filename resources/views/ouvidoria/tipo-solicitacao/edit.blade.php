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
$nome = $errors->has('nome') ? old('nome') : $tipo_solicitacao->nome;
$descricao = $errors->has('descricao') ? old('descricao') : $tipo_solicitacao->descricao;
$icone = $errors->has('icone') ? old('icone') : $tipo_solicitacao->icone;
$cor = $errors->has('cor') ? old('cor') : $tipo_solicitacao->cor;
$sla = $errors->has('sla') ? old('sla') : $tipo_solicitacao->sla;
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
                <form method="post" action="{{ route('tipo-solicitacao.update', $tipo_solicitacao->id) }}" autocomplete="off">
                    @method('PATCH')
                    @csrf
                    <div class="form-group {{ $errors->has('nome') ? 'text-danger' : '' }}">
                        <label for="nome">Nome (*)</label>
                        <input type="text" class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}" 
                            name="nome" value="{{ $nome }}" />
                        <span class="text-danger">{{ $errors->first('nome') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('descricao') ? 'text-danger' : '' }}">
                        <label for="descricao">Descrição (*)</label>
                        <input type="text" class="form-control {{ $errors->has('descricao') ? 'is-invalid' : '' }}" 
                            name="descricao" value="{{ $descricao }}" />
                        <span class="text-danger">{{ $errors->first('descricao') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('icone') ? 'text-danger' : '' }}">
                        <label for="icone">Ícone (Font Awesome)(*)</label>
                        <input type="text" class="form-control {{ $errors->has('icone') ? 'is-invalid' : '' }}" 
                            name="icone" value="{{ $icone }}" />
                        <span class="text-danger">{{ $errors->first('icone') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('cor') ? 'text-danger' : '' }}">
                        <label for="cor">Cor (Bootstrap)(*)</label>
                        <input type="text" class="form-control {{ $errors->has('cor') ? 'is-invalid' : '' }}" 
                            name="cor" value="{{ $cor }}" />
                        <span class="text-danger">{{ $errors->first('cor') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('sla') ? 'text-danger' : '' }}">
                        <label for="sla">SLA (*)</label>
                        <input type="text" class="form-control {{ $errors->has('sla') ? 'is-invalid' : '' }}" 
                            name="sla" value="{{ $sla }}" />
                        <span class="text-danger">{{ $errors->first('sla') }}</span>
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
