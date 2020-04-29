@extends('layouts.app')

@section('title', 'Tipo de Prestador')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/ouvidoria/tipo-prestador/cad-tipo-prestador.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
@php
$tipo_prestador_descricao = $errors->has('tipo_prestador_descricao') ? old('tipo_prestador_descricao') : $tipo_prestador->tipo_prestador_descricao;
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card uper">
            <div class="card-header">
                Editar Tipo de Prestador
                <a href="{{ url('/tipo-prestador') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('tipo-prestador.update', $tipo_prestador->tipo_prestador_cod) }}" autocomplete="off">
                    @method('PATCH')
                    @csrf
                    <div class="form-group {{ $errors->has('tipo_prestador_descricao') ? 'text-danger' : '' }}">
                        <label for="tipo_prestador_descricao">Descrição (*)</label>
                        <input type="text" class="form-control {{ $errors->has('tipo_prestador_descricao') ? 'is-invalid' : '' }}" 
                            name="tipo_prestador_descricao" value="{{ $tipo_prestador_descricao }}" />
                        <span class="text-danger">{{ $errors->first('tipo_prestador_descricao') }}</span>
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
@endsection
