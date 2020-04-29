@extends('layouts.app')

@section('title', 'Canal de Atendimento')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/ouvidoria/canal-atendimento/cad-canal-atendimento.js') }}"></script>
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
                Adicionar Canal de Atendimento
                <a href="{{ url('/canal-atendimento') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('canal-atendimento.store') }}" autocomplete="off">
                    @csrf

                    <div class="form-group {{ $errors->has('canal_atendimento_descricao') ? 'text-danger' : '' }}">
                        <label for="canal_atendimento_descricao">Descrição (*)</label>
                        <input type="text" class="form-control {{ $errors->has('canal_atendimento_descricao') ? 'is-invalid' : '' }}" 
                            name="canal_atendimento_descricao" value="{{ old('canal_atendimento_descricao') }}" />
                        <span class="text-danger">{{ $errors->first('canal_atendimento_descricao') }}</span>
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
