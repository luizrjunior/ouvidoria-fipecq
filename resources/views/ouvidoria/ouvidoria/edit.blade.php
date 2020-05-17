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
$classificacao_cod = $errors->has('classificacao_cod') ? old('classificacao_cod') : $sub_classificacao->classificacao_cod;
$sub_classificacao_descricao = $errors->has('sub_classificacao_descricao') ? old('sub_classificacao_descricao') : $sub_classificacao->sub_classificacao_descricao;
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
                <form method="post" action="{{ route('sub-classificacao.update', $sub_classificacao->sub_classificacao_cod) }}" autocomplete="off">
                    @method('PATCH')
                    @csrf
                    <div class="form-group {{ $errors->has('classificacao_cod') ? 'has-error' : '' }}">
                        <label for="classificacao_cod" class="control-label">Classificação (*)</label>
                        <select id="classificacao_cod" name="classificacao_cod" class="form-control {{ $errors->has('classificacao_cod') ? 'is-invalid' : '' }}" autofocus>
                            <option value="">- - Selecione - -</option>
                            @foreach ($classificacaos as $classificacao)
                                @php $selected = ""; @endphp
                                @if ($classificacao->classificacao_cod == $classificacao_cod)
                                    @php $selected = "selected"; @endphp
                                @endif
                                <option value="{{$classificacao->classificacao_cod}}" {{$selected}}>{{$classificacao->classificacao_descricao}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{ $errors->first('classificacao_cod') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('sub_classificacao_descricao') ? 'text-danger' : '' }}">
                        <label for="sub_classificacao_descricao">Descrição (*)</label>
                        <input type="text" class="form-control {{ $errors->has('sub_classificacao_descricao') ? 'is-invalid' : '' }}" 
                            name="sub_classificacao_descricao" value="{{ $sub_classificacao_descricao }}" />
                        <span class="text-danger">{{ $errors->first('sub_classificacao_descricao') }}</span>
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
