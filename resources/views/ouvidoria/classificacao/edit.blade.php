@extends('layouts.app')

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
$assunto_id = $errors->has('assunto_id') ? old('assunto_id') : $classificacao->assunto_id;
$descricao = $errors->has('descricao') ? old('descricao') : $classificacao->descricao;
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
                    <form method="post" action="{{ route('classificacao.update', $classificacao->id) }}" autocomplete="off">
                        @method('PATCH')
                        @csrf
                        <div class="form-group {{ $errors->has('assunto_id') ? 'has-error' : '' }}">
                            <label for="assunto_id" class="control-label">Setor / Área (*)</label>
                            <select id="assunto_id" name="assunto_id" 
                                class="form-control {{ $errors->has('assunto_id') ? 'is-invalid' : '' }}" autofocus>
                                <option value="">- - Selecione - -</option>
                                @foreach ($assuntos as $assunto)
                                    @php $selected = ""; @endphp
                                    @if ($assunto->id == $assunto_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{$assunto->id}}" {{$selected}}>{{$assunto->descricao}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('assunto_id') }}</span>
                        </div>
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
