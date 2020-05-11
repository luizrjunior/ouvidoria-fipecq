@extends('layouts.app')

@section('title', 'Solicitação de Ouvidoria')

@section('javascript')
<script>
    top.urlDestroySolicitacaoOuvidoria = "{{ url('/solicitacao-ouvidoria/') }}";
</script>
<script type="text/javascript" 
    src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/ouvidoria/solicitacao-ouvidoria/index-solicitacao-ouvidoria.js') }}"></script>
@endsection

@section('content')
@php
$cpf_psq = "";
$nome_psq = "";
$tipo_solicitacao_id_psq = "";
$tipo_solicitante_id_psq = "";
$data_inicio = date('01/m/Y');
$data_termino = date('d/m/Y');
$totalPage = 2;
@endphp
@if (isset($data))
    @php
    $cpf_psq = $data['cpf_psq'];
    $nome_psq = $data['nome_psq'];
    $tipo_solicitacao_id_psq = $data['tipo_solicitacao_id_psq'];
    $tipo_solicitante_id_psq = $data['tipo_solicitante_id_psq'];

    $data_inicio = $data['data_inicio'];
    $data_termino = $data['data_termino'];

    $totalPage = $data['totalPage'];
    @endphp
@endif

<style>
  .uper {
    margin-top: 40px;
  }
</style>

<div class="row justify-content-center">
    <div class="col-md-12">
        
        <form id="formSearchSolicitacaoOuvidoria" 
            class="form-horizontal" role="form" method="POST" action="{{ route('solicitacao-ouvidoria.index') }}">
            <input type="hidden" id="_method" name="_method" value="">
            @csrf

        <div class="card uper">
            <div class="card-header">
                Filtros de Pesquisa
            </div>
            <div class="card-body">

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="cpf_psq" class="control-label">CPF N°</label>
                        <input type="text" id="cpf_psq" name="cpf_psq" 
                               class="form-control" value="{{ $cpf_psq }}" 
                               placeholder="Informe CPF do Solicitante" autofocus>
                    </div>
                    <div class="col-md-6">
                        <label for="nome_psq" class="control-label">Nome</label>
                        <input type="text" id="nome_psq" name="nome_psq" 
                               class="form-control" value="{{ $nome_psq }}" 
                               placeholder="Informe Nome do Solicitante">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="tipo_solicitacao_id_psq" class="control-label">Tipo de Solicitação</label>
                        <select id="tipo_solicitacao_id_psq" name="tipo_solicitacao_id_psq" 
                            class="form-control {{ $errors->has('tipo_solicitante_id_psq') ? 'is-invalid' : '' }}">
                            <option value="">- - Selecione - -</option>
                            @foreach ($tipo_solicitacaos as $tipo_solicitacao)
                                @php $selected = ""; @endphp
                                @if ($tipo_solicitacao->id == $tipo_solicitacao_id_psq)
                                    @php $selected = "selected"; @endphp
                                @endif
                                <option value="{{ $tipo_solicitacao->id }}" {{$selected}}>{{ $tipo_solicitacao->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="tipo_solicitante_id_psq" class="control-label">Tipo de Solicitante</label>
                        <select id="tipo_solicitante_id_psq" name="tipo_solicitante_id_psq" 
                            class="form-control {{ $errors->has('tipo_solicitante_id_psq') ? 'is-invalid' : '' }}">
                            <option value="">- - Selecione - -</option>
                            @foreach ($tipo_solicitantes as $tipo_solicitante)
                                @php $selected = ""; @endphp
                                @if ($tipo_solicitante->id == $tipo_solicitante_id_psq)
                                    @php $selected = "selected"; @endphp
                                @endif
                            <option value="{{$tipo_solicitante->id}}" {{$selected}}>{{$tipo_solicitante->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="data_inicio" class="control-label">Período de (*)</label>
                        <div class='input-group date'>
                            <input type='text' id="data_inicio"
                                   name="data_inicio" class="form-control" value="{{ $data_inicio }}">
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="data_termino" class="control-label">Até (*)</label>
                        <div class='input-group date'>
                            <input type="text" id="data_termino"
                                   name="data_termino" class="form-control" value="{{ $data_termino }}">
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6" id="divFormNameEmail">
                        <label for="situacao_id_psq" class="control-label">Situação</label>
                        <select id="situacao_id_psq" name="situacao_id_psq" 
                            class="form-control">
                            <option value="">- - Selecione - -</option>
                            <option value="1">Novo</option>
                            <option value="2">Em analise</option>
                            <option value="3">Finalizado</option>
                        </select>
                    </div>
                    <div class="col-md-4">&nbsp;</div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary"
                                onclick="return validar();" style="margin-top: 30px; width: 100%;">
                            <i class="fa fa-btn fa-search"></i> Pesquisar
                        </button>
                    </div>
                </div>

            </div>
        </div>


        <div class="card uper">
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

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Protocolo N°</td>
                            <td>Solicitação</td>
                            <td>Solicitante</td>
                            <td>Nome</td>
                            <td>Criado em</td>
                            <td>Dias Úteis</td>
                            <td>Situação</td>
                            <td>Ações</td>
                        </tr>
                    </thead>
                    <tbody>
                    @if (count($solicitacao_ouvidorias) > 0)

                        @foreach($solicitacao_ouvidorias as $solicitacao_ouvidoria)

                        <tr>
                            <td>{{ str_pad($solicitacao_ouvidoria->protocolo, 14, 0, STR_PAD_LEFT) }}</td>
                            <td>{{ $solicitacao_ouvidoria->noTipoSolicitacao }}</td>

                            <td>{{ $solicitacao_ouvidoria->dsTipoSolicitante }}</td>
                            <td>{{ $solicitacao_ouvidoria->noSolicitante }}</td>

                            <td>{{ date('d/m/Y H:i:s', strtotime($solicitacao_ouvidoria->dtCriacao)) }}</td>

                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <a href="{{ route('solicitacao-ouvidoria.edit', $solicitacao_ouvidoria->id) }}" title="Editar" 
                                    class="btn btn-primary btn-sm" onclick="return validar()">
                                    Detalhar
                                </a>
                            </td>
                        </tr>

                        @endforeach

                        @if (isset($data))
                    <tr>
                        <td colspan="2">
                                <input id="totalPage" name="totalPage" type="text"
                                        value="{{ $totalPage }}" class="form-control" size="10"
                                        style="text-align: right;">
                                        Registros por página
                        </td>
                        <td colspan="6">
                                {{  $solicitacao_ouvidorias->appends($data)->links() }}
                        </td>
                    </tr>
                        @else
                    <tr>
                        <td colspan="2">
                            <input id="totalPage" name="totalPage" type="text"
                                    value="{{ $totalPage }}" class="form-control" size="10"
                                    style="text-align: right;">
                                    Registros por página
                        </td>
                        <td colspan="6">
                            {{ $solicitacao_ouvidorias->links() }}
                        </td>
                    </tr>
                        @endif

                    @else
                        <tr>
                            <td colspan="8">
                                <input id="totalPage" name="totalPage" type="hidden" value="{{ $totalPage }}">
                                Nenhum registro encontrado!
                            </td>
                        </tr>
                    @endif

                    </tbody>
                </table>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
