@extends('layouts.app')

@section('javascript')
<script>
    top.urlDestroyTipoOuvidoria = "{{ url('/tipo-ouvidoria/') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/ouvidoria/tipo-ouvidoria/index-tipo-ouvidoria.js') }}"></script>
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
                Lista de Tipos de Ouvidoria
                <a href="{{ url('/tipo-ouvidoria/create') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-plus"></i> Adicionar Tipo de Ouvidoria
                </a>
            </div>
            <div class="card-body">

                @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                </div>
                @endif

                @php
                $arrSituacao = array(
                    '0' => "Desativado",
                    '1' => "Ativado"
                );
                $bgColor = array(
                    '0' => "danger",
                    '1' => "success"
                );
                @endphp

                <form id="formSearchTipoOuvidoria" 
                    class="form-horizontal" role="form" method="POST" action="#">
                <input type="hidden" id="_method" name="_method" value="">
                @csrf

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Criado em</td>
                            <td>Nome</td>
                            <td>Ícone</td>
                            <td>Cor</td>
                            <td>SLA</td>
                            <td>Status</td>
                            <td colspan="3">Ações</td>
                        </tr>
                    </thead>
                    <tbody>
                    @if (count($tiposOuvidorias) > 0)

                        @foreach($tiposOuvidorias as $tipoOuvidoria)

                        <tr>
                            <td>{{ date('d/m/Y H:i:s', strtotime($tipoOuvidoria->created_at)) }}</td>
                            <td>{{ $tipoOuvidoria->nome }}</td>
                            <td><i class="{{ $tipoOuvidoria->icone }}"></td>
                            <td class="bg-{{ $tipoOuvidoria->cor }}">&nbsp;</td>
                            <td align="right">{{ $tipoOuvidoria->sla }}</td>
                            <td>
                                <span class="badge badge-{{ $bgColor[$tipoOuvidoria->status] }}"
                                        data-toggle="tooltip" title="{{ $arrSituacao[$tipoOuvidoria->status] }}">
                                    {{ $arrSituacao[$tipoOuvidoria->status] }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('tipo-ouvidoria.edit', $tipoOuvidoria->id) }}" title="Editar" 
                                    class="btn btn-primary btn-sm" onclick="return validar()">
                                    Editar
                                </a>
                            </td>
                            <td>
                                @if ($tipoOuvidoria->status)
                                <button class="btn btn-primary btn-sm" type="button" title="Desativar" 
                                    onclick="ativarDesativarTipoOuvidoria({{ $tipoOuvidoria->id }})">Desativar
                                </button>
                                @else
                                <button class="btn btn-primary btn-sm" type="button" title="Ativar" 
                                    onclick="ativarDesativarTipoOuvidoria({{ $tipoOuvidoria->id }})">Ativar
                                </button>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" type="button" title="Excluir" 
                                    onclick="confirmDestroy({{ $tipoOuvidoria->id }})" disabled>Excluir
                                </button>
                            </td>
                        </tr>
                        @endforeach

                    @else
                        <tr>
                            <td colspan="7">Nenhum registro encontrado!</td>
                        </tr>
                    @endif

                    </tbody>
                </table>

                <div class="form-group row">
                    <div class="col-md-12">
                        <div style="margin-top: 23px;">{{ $tiposOuvidorias->links() }}</div>
                    </div>
                </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
