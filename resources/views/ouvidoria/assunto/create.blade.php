@extends('layouts.app')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/ouvidoria/assunto/cad-assunto.js') }}"></script>
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
                    Adicionar Assunto
                    <a href="{{ url('/assunto') }}" class="float-right" onclick="return validar()">
                        <i class="fa fa-arrow-left"></i> Voltar
                    </a>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('assunto.store') }}" autocomplete="off">
                        @csrf
                        <div class="form-group {{ $errors->has('setor_id') ? 'text-danger' : '' }}">
                            <label for="setor_id" class="control-label">Setor / Área (*)</label>
                            <select id="setor_id" name="setor_id" 
                                class="form-control {{ $errors->has('setor_id') ? 'is-invalid' : '' }}" autofocus>
                                <option value="">- - Selecione - -</option>
                                @foreach ($setores as $setor)
                                    <option value="{{$setor->id}}">{{$setor->descricao}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('setor_id') }}</span>
                        </div>
                        <div class="form-group {{ $errors->has('descricao') ? 'text-danger' : '' }}">
                            <label for="descricao">Descrição (*)</label>
                            <input type="text" class="form-control {{ $errors->has('descricao') ? 'is-invalid' : '' }}" 
                                name="descricao" value="{{ old('descricao') }}" />
                            <span class="text-danger">{{ $errors->first('descricao') }}</span>
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="return validar()">
                            <i class="fa fa-btn fa-plus"></i> Adicionar
                        </button>
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
