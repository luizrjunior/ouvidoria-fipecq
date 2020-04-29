@extends('layouts.app')

@section('title', 'Tipo de Solicitante')

@section('javascript')
<script>
    top.urlDestroyTipoSolicitante = "{{ url('/tipo-solicitante/') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/ouvidoria/tipo-solicitante/index-tipo-solicitante.js') }}"></script>
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
                Lista de Tipos de Solicitantes
                <a href="{{ url('/tipo-solicitante/create') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-plus"></i> Adicionar Tipo de Solicitante
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

                <form id="formSearchTipoSolicitante" 
                    class="form-horizontal" role="form" method="POST" action="#">
                <input type="hidden" id="_method" name="_method" value="">
                @csrf

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Criado em</td>
                            <td>Descrição</td>
                            <td>Status</td>
                            <td colspan="3">Ações</td>
                        </tr>
                    </thead>
                    <tbody>
                    @if (count($tipo_solicitantes) > 0)

                        @foreach($tipo_solicitantes as $tipo_solicitante)

                        <tr>
                            <td>{{ date('d/m/Y H:i:s', strtotime($tipo_solicitante->created_at)) }}</td>
                            <td>{{ $tipo_solicitante->tipo_solicitante_descricao }}</td>
                            <td>{{ $tipo_solicitante->tipo_solicitante_sla }}</td>
                            <td>
                                <span class="badge badge-{{ $bgColor[$tipo_solicitante->tipo_solicitante_status] }}"
                                        data-toggle="tooltip" title="{{ $arrSituacao[$tipo_solicitante->tipo_solicitante_status] }}">
                                    {{ $arrSituacao[$tipo_solicitante->tipo_solicitante_status] }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('tipo-solicitante.edit', $tipo_solicitante->tipo_solicitante_cod) }}" title="Editar" 
                                    class="btn btn-primary btn-sm" onclick="return validar()">
                                    Editar
                                </a>
                            </td>
                            <td>
                                @if ($tipo_solicitante->tipo_solicitante_status)
                                <button class="btn btn-primary btn-sm" type="button" title="Desativar" 
                                    onclick="ativarDesativarTipoSolicitante({{ $tipo_solicitante->tipo_solicitante_cod }})">Desativar
                                </button>
                                @else
                                <button class="btn btn-primary btn-sm" type="button" title="Ativar" 
                                    onclick="ativarDesativarTipoSolicitante({{ $tipo_solicitante->tipo_solicitante_cod }})">Ativar
                                </button>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" type="button" title="Excluir" 
                                    onclick="confirmDestroy({{ $tipo_solicitante->tipo_solicitante_cod }})" disabled>Excluir
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
                        <div style="margin-top: 23px;">{{ $tipo_solicitantes->links() }}</div>
                    </div>
                </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
