@extends('layouts.app')

@section('title', 'Situação')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/ouvidoria/situacao/cad-situacao.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card uper">
                <div class="card-header">
                    Adicionar Situação
                    <a href="{{ url('/situacao') }}" class="float-right" onclick="return validar()">
                        <i class="fa fa-arrow-left"></i> Voltar
                    </a>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('situacao.store') }}" autocomplete="off">
                        @csrf
                        <div class="form-group {{ $errors->has('nome') ? 'text-danger' : '' }}">
                            <label for="nome">Nome (*)</label>
                            <input type="text" class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}" 
                                name="nome" value="{{ old('nome') }}" autofocus />
                            <span class="text-danger">{{ $errors->first('nome') }}</span>
                        </div>
                            <div class="form-group {{ $errors->has('descricao') ? 'text-danger' : '' }}">
                            <label for="descricao">Descrição (*)</label>
                            <input type="text" class="form-control {{ $errors->has('descricao') ? 'is-invalid' : '' }}" 
                                name="descricao" value="{{ old('descricao') }}" />
                            <span class="text-danger">{{ $errors->first('descricao') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('cor') ? 'text-danger' : '' }}">
                            <label for="cor">Cor (Bootstrap)(*)</label>
                            <input type="text" class="form-control {{ $errors->has('cor') ? 'is-invalid' : '' }}" 
                                name="cor" value="{{ old('cor') }}" />
                            <span class="text-danger">{{ $errors->first('cor') }}</span>
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
</div>
@endsection
