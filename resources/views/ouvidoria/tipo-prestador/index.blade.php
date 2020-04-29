@extends('layouts.app')

@section('title', 'Tipo de Prestador')

@section('javascript')
<script>
    top.urlDestroyTipoPrestador = "{{ url('/tipo-prestador/') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/ouvidoria/tipo-prestador/index-tipo-prestador.js') }}"></script>
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
                Lista de Tipos de Prestadores
                <a href="{{ url('/tipo-prestador/create') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-plus"></i> Adicionar Tipo de Prestador
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

                <form id="formSearchTipoPrestador" 
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
                    @if (count($tipo_prestadors) > 0)

                        @foreach($tipo_prestadors as $tipo_prestador)

                        <tr>
                            <td>{{ date('d/m/Y H:i:s', strtotime($tipo_prestador->created_at)) }}</td>
                            <td>{{ $tipo_prestador->tipo_prestador_descricao }}</td>
                            <td>
                                <span class="badge badge-{{ $bgColor[$tipo_prestador->tipo_prestador_status] }}"
                                        data-toggle="tooltip" title="{{ $arrSituacao[$tipo_prestador->tipo_prestador_status] }}">
                                    {{ $arrSituacao[$tipo_prestador->tipo_prestador_status] }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('tipo-prestador.edit', $tipo_prestador->tipo_prestador_cod) }}" title="Editar" 
                                    class="btn btn-primary btn-sm" onclick="return validar()">
                                    Editar
                                </a>
                            </td>
                            <td>
                                @if ($tipo_prestador->tipo_prestador_status)
                                <button class="btn btn-primary btn-sm" type="button" title="Desativar" 
                                    onclick="ativarDesativarTipoPrestador({{ $tipo_prestador->tipo_prestador_cod }})">Desativar
                                </button>
                                @else
                                <button class="btn btn-primary btn-sm" type="button" title="Ativar" 
                                    onclick="ativarDesativarTipoPrestador({{ $tipo_prestador->tipo_prestador_cod }})">Ativar
                                </button>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" type="button" title="Excluir" 
                                    onclick="confirmDestroy({{ $tipo_prestador->tipo_prestador_cod }})" disabled>Excluir
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
                        <div style="margin-top: 23px;">{{ $tipo_prestadors->links() }}</div>
                    </div>
                </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
