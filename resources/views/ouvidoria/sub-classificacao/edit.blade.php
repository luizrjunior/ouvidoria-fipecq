@extends('layouts.app')

@section('title', 'SubClassificação')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/ouvidoria/sub-classificacao/cad-sub-classificacao.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
@php
$classificacao_id = $errors->has('classificacao_id') ? old('classificacao_id') : $sub_classificacao->classificacao_id;
$descricao = $errors->has('descricao') ? old('descricao') : $sub_classificacao->descricao;
@endphp
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card uper">
            <div class="card-header">
                Editar SubClassificação
                <a href="{{ url('/sub-classificacao') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('sub-classificacao.update', $sub_classificacao->id) }}" autocomplete="off">
                    @method('PATCH')
                    @csrf
                    <div class="form-group {{ $errors->has('classificacao_id') ? 'has-error' : '' }}">
                        <label for="classificacao_id" class="control-label">Classificação (*)</label>
                        <select id="classificacao_id" name="classificacao_id" class="form-control {{ $errors->has('classificacao_id') ? 'is-invalid' : '' }}" autofocus>
                            <option value="">- - Selecione - -</option>
                            @foreach ($classificacaos as $classificacao)
                                @php $selected = ""; @endphp
                                @if ($classificacao->id == $classificacao_id)
                                    @php $selected = "selected"; @endphp
                                @endif
                                <option value="{{$classificacao->id}}" {{$selected}}>{{$classificacao->descricao}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{ $errors->first('classificacao_id') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('descricao') ? 'text-danger' : '' }}">
                        <label for="descricao">Descrição (*)</label>
                        <input type="text" class="form-control {{ $errors->has('descricao') ? 'is-invalid' : '' }}" 
                            name="descricao" value="{{ $descricao }}" />
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
@endsection
