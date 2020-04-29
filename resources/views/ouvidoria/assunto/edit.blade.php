@extends('layouts.app')

@section('title', 'Assunto')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/ouvidoria/assunto/cad-assunto.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
@php
$assunto_descricao = $errors->has('assunto_descricao') ? old('assunto_descricao') : $assunto->assunto_descricao;
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card uper">
                <div class="card-header">
                    Editar Assunto
                    <a href="{{ url('/assunto') }}" class="float-right" onclick="return validar()">
                        <i class="fa fa-arrow-left"></i> Voltar
                    </a>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('assunto.update', $assunto->assunto_cod) }}" autocomplete="off">
                        @method('PATCH')
                        @csrf
                        <div class="form-group {{ $errors->has('assunto_descricao') ? 'text-danger' : '' }}">
                            <label for="assunto_descricao">Descrição (*)</label>
                            <input type="text" class="form-control {{ $errors->has('assunto_descricao') ? 'is-invalid' : '' }}" 
                                name="assunto_descricao" value="{{ $assunto_descricao }}" autofocus />
                            <span class="text-danger">{{ $errors->first('assunto_descricao') }}</span>
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
</div>
@endsection
