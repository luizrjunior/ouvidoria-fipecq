@extends('layouts.app')

@section('javascript')
<script>
    top.urlDestroySubClassificacao = "{{ url('/sub-classificacao/') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/ouvidoria/sub-classificacao/index-sub-classificacao.js') }}"></script>
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
                Lista de SubClassificações
                <a href="{{ url('/sub-classificacao/create') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-plus"></i> Adicionar SubClassificação
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

                <form id="formSearchSubClassificacao" 
                    class="form-horizontal" role="form" method="POST" action="#">
                <input type="hidden" id="_method" name="_method" value="">
                @csrf

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Criado em</td>
                            <td>Classificação</td>
                            <td>Descrição</td>
                            <td>Status</td>
                            <td colspan="3">Ações</td>
                        </tr>
                    </thead>
                    <tbody>
                    @if (count($sub_classificacaos) > 0)

                        @foreach($sub_classificacaos as $sub_classificacao)

                        <tr>
                            <td>{{ date('d/m/Y H:i:s', strtotime($sub_classificacao->created_at)) }}</td>
                            <td>{{ $sub_classificacao->classificacao->descricao }}</td>
                            <td>{{ $sub_classificacao->descricao }}</td>
                            <td>
                                <span class="badge badge-{{ $bgColor[$sub_classificacao->status] }}"
                                        data-toggle="tooltip" title="{{ $arrSituacao[$sub_classificacao->status] }}">
                                    {{ $arrSituacao[$sub_classificacao->status] }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('sub-classificacao.edit', $sub_classificacao->id) }}" title="Editar" 
                                    class="btn btn-primary btn-sm" onclick="return validar()">
                                    Editar
                                </a>
                            </td>
                            <td>
                                @if ($sub_classificacao->status)
                                <button class="btn btn-primary btn-sm" type="button" title="Desativar" 
                                    onclick="ativarDesativarSubClassificacao({{ $sub_classificacao->id }})">Desativar
                                </button>
                                @else
                                <button class="btn btn-primary btn-sm" type="button" title="Ativar" 
                                    onclick="ativarDesativarSubClassificacao({{ $sub_classificacao->id }})">Ativar
                                </button>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" type="button" title="Excluir" 
                                    onclick="confirmDestroy({{ $sub_classificacao->id }})" disabled>Excluir
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
                        <div style="margin-top: 23px;">{{ $sub_classificacaos->links() }}</div>
                    </div>
                </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
