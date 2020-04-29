@extends('layouts.app')

@section('title', 'Tipo de Solicitante')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/ouvidoria/tipo-solicitante/cad-tipo-solicitante.js') }}"></script>
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
                Adicionar Tipo de Solicitante
                <a href="{{ url('/tipo-solicitante') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('tipo-solicitante.store') }}" autocomplete="off">
                    @csrf
                    <div class="form-group {{ $errors->has('tipo_solicitante_descricao') ? 'text-danger' : '' }}">
                        <label for="tipo_solicitante_descricao">Descrição (*)</label>
                        <input type="text" class="form-control {{ $errors->has('tipo_solicitante_descricao') ? 'is-invalid' : '' }}" 
                            name="tipo_solicitante_descricao" value="{{ old('tipo_solicitante_descricao') }}" autofocus />
                        <span class="text-danger">{{ $errors->first('tipo_solicitante_descricao') }}</span>
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
