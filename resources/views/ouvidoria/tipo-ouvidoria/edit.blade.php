@extends('layouts.app')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/ouvidoria/tipo-ouvidoria/cad-tipo-ouvidoria.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
@php
$nome = $errors->has('nome') ? old('nome') : $tipoOuvidoria->nome;
$descricao = $errors->has('descricao') ? old('descricao') : $tipoOuvidoria->descricao;
$icone = $errors->has('icone') ? old('icone') : $tipoOuvidoria->icone;
$cor = $errors->has('cor') ? old('cor') : $tipoOuvidoria->cor;
$sla = $errors->has('sla') ? old('sla') : $tipoOuvidoria->sla;
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card uper">
            <div class="card-header">
                Editar Tipo de Ouvidoria
                <a href="{{ url('/tipo-ouvidoria') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('tipo-ouvidoria.update', $tipoOuvidoria->id) }}" autocomplete="off">
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
