@extends('layouts.app')

@section('title', 'Institutora')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/ouvidoria/institutora/cad-institutora.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
@php
$descricao = $errors->has('descricao') ? old('descricao') : $institutora->descricao;
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card uper">
                <div class="card-header">
                    Editar Institutora
                    <a href="{{ url('/institutora') }}" class="float-right" onclick="return validar()">
                        <i class="fa fa-arrow-left"></i> Voltar
                    </a>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('institutora.update', $institutora->id) }}" autocomplete="off">
                        @method('PATCH')
                        @csrf
                        <div class="form-group {{ $errors->has('descricao') ? 'text-danger' : '' }}">
                            <label for="descricao">Descrição (*)</label>
                            <input type="text" class="form-control {{ $errors->has('descricao') ? 'is-invalid' : '' }}" 
                                name="descricao" value="{{ $descricao }}" autofocus />
                            <span class="text-danger">{{ $errors->first('descricao') }}</span>
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
