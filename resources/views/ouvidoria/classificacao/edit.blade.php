@extends('layouts.app')

@section('title', 'Classificação')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/ouvidoria/classificacao/cad-classificacao.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
@php
$classificacao_descricao = $errors->has('classificacao_descricao') ? old('classificacao_descricao') : $classificacao->classificacao_descricao;
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card uper">
                <div class="card-header">
                    Editar Classificação
                    <a href="{{ url('/classificacao') }}" class="float-right" onclick="return validar()">
                        <i class="fa fa-arrow-left"></i> Voltar
                    </a>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('classificacao.update', $classificacao->classificacao_cod) }}" autocomplete="off">
                        @method('PATCH')
                        @csrf
                        <div class="form-group {{ $errors->has('classificacao_descricao') ? 'text-danger' : '' }}">
                            <label for="classificacao_descricao">Descrição (*)</label>
                            <input type="text" class="form-control {{ $errors->has('classificacao_descricao') ? 'is-invalid' : '' }}" 
                                name="classificacao_descricao" value="{{ $classificacao_descricao }}" autofocus />
                            <span class="text-danger">{{ $errors->first('classificacao_descricao') }}</span>
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
