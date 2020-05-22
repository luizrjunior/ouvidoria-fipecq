@extends('layouts.app')

@section('javascript')
<script>
    top.urlDestroySituacao = "{{ url('/situacao/') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/ouvidoria/situacao/index-situacao.js') }}"></script>
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
                    Lista de Situações
                    <a href="{{ url('/situacao/create') }}" class="float-right" onclick="return validar()">
                        <i class="fa fa-plus"></i> Adicionar Situação
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

                    <form id="formSearchSituacao" 
                        class="form-horizontal" role="form" method="POST" action="#">
                    <input type="hidden" id="_method" name="_method" value="">
                    @csrf

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Criado em</td>
                                <td>Nome</td>
                                <td>Cor</td>
                                <td>Status</td>
                                <td colspan="3">Ações</td>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($situacaos) > 0)

                            @foreach($situacaos as $situacao)
                            <tr>
                                <td>{{ date('d/m/Y H:i:s', strtotime($situacao->created_at)) }}</td>
                                <td>{{ $situacao->nome }}</td>
                                <td class="bg-{{ $situacao->cor }}">&nbsp;</td>
                                <td>
                                    <span class="badge badge-{{ $bgColor[$situacao->status] }}"
                                          data-toggle="tooltip" title="{{ $arrSituacao[$situacao->status] }}">
                                        {{ $arrSituacao[$situacao->status] }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('situacao.edit', $situacao->id) }}" title="Editar" 
                                        class="btn btn-primary btn-sm" onclick="return validar()">
                                        Editar
                                    </a>
                                </td>
                                <td>
                                    @if ($situacao->status)
                                    <button class="btn btn-primary btn-sm" type="button" title="Desativar" 
                                        onclick="ativarDesativarSituacao({{ $situacao->id }})">Desativar
                                    </button>
                                    @else
                                    <button class="btn btn-primary btn-sm" type="button" title="Ativar" 
                                        onclick="ativarDesativarSituacao({{ $situacao->id }})">Ativar
                                    </button>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm" type="button" title="Excluir" 
                                        onclick="confirmDestroy({{ $situacao->id }})" disabled>Excluir
                                    </button>
                                </td>
                            </tr>
                            @endforeach

                        @else
                            <tr>
                                <td colspan="6">Nenhum registro encontrado!</td>
                            </tr>
                        @endif

                        </tbody>
                    </table>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div style="margin-top: 23px;">{{ $situacaos->links() }}</div>
                        </div>
                    </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
