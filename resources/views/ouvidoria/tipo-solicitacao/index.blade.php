@extends('layouts.app')

@section('title', 'Tipo de Solicitação')

@section('javascript')
<script>
    top.urlDestroyTipoSolicitacao = "{{ url('/tipo-solicitacao/') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/ouvidoria/tipo-solicitacao/index-tipo-solicitacao.js') }}"></script>
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
                Lista de Tipos de Solicitação
                <a href="{{ url('/tipo-solicitacao/create') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-plus"></i> Adicionar Tipo de Solicitação
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

                <form id="formSearchTipoSolicitacao" 
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
                    @if (count($tipo_solicitacaos) > 0)

                        @foreach($tipo_solicitacaos as $tipo_solicitacao)

                        <tr>
                            <td>{{ date('d/m/Y H:i:s', strtotime($tipo_solicitacao->created_at)) }}</td>
                            <td>{{ $tipo_solicitacao->tipo_solicitacao_nome }}</td>
                            <td><i class="{{ $tipo_solicitacao->tipo_solicitacao_icone }}"></td>
                            <td class="bg-{{ $tipo_solicitacao->tipo_solicitacao_cor }}">&nbsp;</td>
                            <td align="right">{{ $tipo_solicitacao->tipo_solicitacao_sla }}</td>
                            <td>
                                <span class="badge badge-{{ $bgColor[$tipo_solicitacao->tipo_solicitacao_status] }}"
                                        data-toggle="tooltip" title="{{ $arrSituacao[$tipo_solicitacao->tipo_solicitacao_status] }}">
                                    {{ $arrSituacao[$tipo_solicitacao->tipo_solicitacao_status] }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('tipo-solicitacao.edit', $tipo_solicitacao->tipo_solicitacao_cod) }}" title="Editar" 
                                    class="btn btn-primary btn-sm" onclick="return validar()">
                                    Editar
                                </a>
                            </td>
                            <td>
                                @if ($tipo_solicitacao->tipo_solicitacao_status)
                                <button class="btn btn-primary btn-sm" type="button" title="Desativar" 
                                    onclick="ativarDesativarTipoSolicitacao({{ $tipo_solicitacao->tipo_solicitacao_cod }})">Desativar
                                </button>
                                @else
                                <button class="btn btn-primary btn-sm" type="button" title="Ativar" 
                                    onclick="ativarDesativarTipoSolicitacao({{ $tipo_solicitacao->tipo_solicitacao_cod }})">Ativar
                                </button>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" type="button" title="Excluir" 
                                    onclick="confirmDestroy({{ $tipo_solicitacao->tipo_solicitacao_cod }})" disabled>Excluir
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
                        <div style="margin-top: 23px;">{{ $tipo_solicitacaos->links() }}</div>
                    </div>
                </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
