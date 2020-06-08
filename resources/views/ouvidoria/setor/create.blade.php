@extends('layouts.app')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/ouvidoria/setor/cad-setor.js') }}"></script>
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
                Adicionar Setor / Área
                <a href="{{ url('/setor') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('setor.store') }}" autocomplete="off">
                    @csrf
                    <div class="form-group {{ $errors->has('categoria_id') ? 'text-danger' : '' }}">
                        <label for="categoria_id" class="control-label">Categoria (*)</label>
                        <select id="categoria_id" name="categoria_id" 
                            class="form-control {{ $errors->has('categoria_id') ? 'is-invalid' : '' }}" autofocus>
                            <option value="">- - Selecione - -</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{$categoria->id}}">{{$categoria->descricao}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{ $errors->first('categoria_id') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('descricao') ? 'text-danger' : '' }}">
                        <label for="descricao">Descrição (*)</label>
                        <input type="text" class="form-control {{ $errors->has('descricao') ? 'is-invalid' : '' }}" 
                            name="descricao" value="{{ old('descricao') }}" />
                        <span class="text-danger">{{ $errors->first('descricao') }}</span>
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
