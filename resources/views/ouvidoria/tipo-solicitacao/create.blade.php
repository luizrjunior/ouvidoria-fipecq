@extends('layouts.app')

@section('title', 'Tipo de Solicitação')

@section('javascript')
<script type="text/javascript" src="{{ asset('/js/ouvidoria/tipo-solicitacao/cad-tipo-solicitacao.js') }}"></script>
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
                Adicionar Tipo de Solicitação
                <a href="{{ url('/tipo-solicitacao') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('tipo-solicitacao.store') }}" autocomplete="off">
                    @csrf
                    <div class="form-group {{ $errors->has('tipo_ouvidoria_nome') ? 'text-danger' : '' }}">
                        <label for="tipo_ouvidoria_nome">Nome (*)</label>
                        <input type="text" class="form-control {{ $errors->has('tipo_ouvidoria_nome') ? 'is-invalid' : '' }}" 
                            name="tipo_ouvidoria_nome" value="{{ old('tipo_ouvidoria_nome') }}" autofocus />
                        <span class="text-danger">{{ $errors->first('tipo_ouvidoria_nome') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('tipo_ouvidoria_descricao') ? 'text-danger' : '' }}">
                        <label for="tipo_ouvidoria_descricao">Descrição (*)</label>
                        <input type="text" class="form-control {{ $errors->has('tipo_ouvidoria_descricao') ? 'is-invalid' : '' }}" 
                            name="tipo_ouvidoria_descricao" value="{{ old('tipo_ouvidoria_descricao') }}" />
                        <span class="text-danger">{{ $errors->first('tipo_ouvidoria_descricao') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('tipo_ouvidoria_icone') ? 'text-danger' : '' }}">
                        <label for="tipo_ouvidoria_icone">Ícone (Font Awesome)(*)</label>
                        <input type="text" class="form-control {{ $errors->has('tipo_ouvidoria_icone') ? 'is-invalid' : '' }}" 
                            name="tipo_ouvidoria_icone" value="{{ old('tipo_ouvidoria_icone') }}" />
                        <span class="text-danger">{{ $errors->first('tipo_ouvidoria_icone') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('tipo_ouvidoria_cor') ? 'text-danger' : '' }}">
                        <label for="tipo_ouvidoria_cor">Cor (Bootstrap)(*)</label>
                        <input type="text" class="form-control {{ $errors->has('tipo_ouvidoria_cor') ? 'is-invalid' : '' }}" 
                            name="tipo_ouvidoria_cor" value="{{ old('tipo_ouvidoria_cor') }}" />
                        <span class="text-danger">{{ $errors->first('tipo_ouvidoria_cor') }}</span>
                    </div>
                    <div class="form-group {{ $errors->has('tipo_ouvidoria_sla') ? 'text-danger' : '' }}">
                        <label for="tipo_ouvidoria_sla">SLA (*)</label>
                        <input type="text" class="form-control {{ $errors->has('tipo_ouvidoria_sla') ? 'is-invalid' : '' }}" 
                            name="tipo_ouvidoria_sla" value="{{ old('tipo_ouvidoria_sla') }}" />
                        <span class="text-danger">{{ $errors->first('tipo_ouvidoria_sla') }}</span>
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
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
<br />&nbsp;
@endsection
