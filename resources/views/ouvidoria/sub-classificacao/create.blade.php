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
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card uper">
            <div class="card-header">
                Adicionar SubClassificação
                <a href="{{ url('/sub-classificacao') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('sub-classificacao.store') }}" autocomplete="off">
                    @csrf

                    <div class="form-group {{ $errors->has('classificacao_cod') ? 'text-danger' : '' }}">
                        <label for="classificacao_cod" class="control-label">Classificação (*)</label>
                        <select id="classificacao_cod" name="classificacao_cod" class="form-control {{ $errors->has('classificacao_cod') ? 'is-invalid' : '' }}" autofocus>
                            <option value="">- - Selecione - -</option>
                            @foreach ($classificacaos as $classificacao)
                                <option value="{{$classificacao->classificacao_cod}}">{{$classificacao->classificacao_descricao}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{ $errors->first('classificacao_cod') }}</span>
                    </div>

                    <div class="form-group {{ $errors->has('sub_classificacao_descricao') ? 'text-danger' : '' }}">
                        <label for="sub_classificacao_descricao">Descrição (*)</label>
                        <input type="text" class="form-control {{ $errors->has('sub_classificacao_descricao') ? 'is-invalid' : '' }}" 
                            name="sub_classificacao_descricao" value="{{ old('sub_classificacao_descricao') }}" />
                        <span class="text-danger">{{ $errors->first('sub_classificacao_descricao') }}</span>
                    </div>
                    <button type="submit" class="btn btn-primary" onclick="return validar()">Adicionar</button>
                    <span class="float-right text-danger">
                        * Campos obrigatórios
                    </span>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
