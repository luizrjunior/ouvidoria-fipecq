@extends('layouts.app')

@section('javascript')
<script>
    top.urlDestroySolicitacaoOuvidoria = "{{ url('/ouvidoria/') }}";
</script>
<script type="text/javascript" 
    src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/ouvidoria/ouvidoria/index-ouvidoria.js') }}"></script>
@endsection

@section('content')
@php
$cpf_psq = "";
$nome_psq = "";
$tipo_ouvidoria_id_psq = "";
$tipo_solicitante_id_psq = "";
$data_inicio = date('01/m/Y');
$data_termino = date('d/m/Y');
$situacao_id_psq = "";
$totalPage = 25;
@endphp
@if (isset($data))
    @php
    $cpf_psq = $data['cpf_psq'];
    $nome_psq = $data['nome_psq'];
    $tipo_ouvidoria_id_psq = $data['tipo_ouvidoria_id_psq'];
    $tipo_solicitante_id_psq = $data['tipo_solicitante_id_psq'];
    $data_inicio = $data['data_inicio'];
    $data_termino = $data['data_termino'];
    $situacao_id_psq = $data['situacao_id_psq'];
    $totalPage = $data['totalPage'];
    @endphp
@endif

<style>
  .uper {
    margin-top: 40px;
  }
</style>

@if (Session('success'))
<!-- Alert -->
<div id="_sent_ok_" class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i> Alerta!</h4>
    <span id="_msg_txt_">{!! Session('success') !!}</span>
</div>
<!-- /Alert -->
@endif

<div class="row justify-content-center">
    <div class="col-md-12">
        
        <form id="formSearchSolicitacaoOuvidoria" 
            class="form-horizontal" role="form" method="POST" action="{{ route('ouvidoria.search') }}">
            <input type="hidden" id="_method" name="_method" value="">
            @csrf

        <div class="card uper">
            <div class="card-header">
                Filtros de Pesquisa
                <a href="{{ url('/ouvidoria/create-admin') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-plus"></i> Nova Solicitação
                </a>
                <a href="{{ url('/enviar-emails') }}" target="_blank" class="float-right">
                    <i class="fa fa-paper-plane"></i> Enviar E-mails&nbsp;|&nbsp;
                </a>
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
                        <label for="tipo_ouvidoria_id_psq" class="control-label">Tipo de Solicitação</label>
                        <select id="tipo_ouvidoria_id_psq" name="tipo_ouvidoria_id_psq" 
                            class="form-control {{ $errors->has('tipo_ouvidoria_id_psq') ? 'is-invalid' : '' }}">
                            <option value="">- - Selecione - -</option>
                            @foreach ($tiposOuvidorias as $tipoOuvidoria)
                                @php $selected = ""; @endphp
                                @if ($tipoOuvidoria->id == $tipo_ouvidoria_id_psq)
                                    @php $selected = "selected"; @endphp
                                @endif
                                <option value="{{ $tipoOuvidoria->id }}" {{$selected}}>{{ $tipoOuvidoria->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="tipo_solicitante_id_psq" class="control-label">Tipo de Solicitante</label>
                        <select id="tipo_solicitante_id_psq" name="tipo_solicitante_id_psq" 
                            class="form-control {{ $errors->has('tipo_solicitante_id_psq') ? 'is-invalid' : '' }}">
                            <option value="">- - Selecione - -</option>
                            @foreach ($tiposSolicitantes as $tipoSolicitante)
                                @php $selected = ""; @endphp
                                @if ($tipoSolicitante->id == $tipo_solicitante_id_psq)
                                    @php $selected = "selected"; @endphp
                                @endif
                            <option value="{{$tipoSolicitante->id}}" {{$selected}}>{{$tipoSolicitante->descricao}}</option>
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
                            @foreach ($situacoes as $situacao)
                                @php $selected = ""; @endphp
                                @if ($situacao->id == $situacao_id_psq)
                                    @php $selected = "selected"; @endphp
                                @endif
                            <option value="{{ $situacao->id }}" {{ $selected }}>{{ $situacao->nome }}</option>
                            @endforeach
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
                            <td><b>Protocolo N°</b></td>
                            <td><b>Solicitação</b></td>
                            <td><b>Solicitante</b></td>
                            <td><b>Nome</b></td>
                            <td><b>Criado em</b></td>
                            <td><b>Dias Úteis</b></td>
                            <td><b>Situação</b></td>
                            <td><b>Ações</b></td>
                        </tr>
                    </thead>
                    <tbody>
                    @if (count($ouvidorias) > 0)

                        @foreach($ouvidorias as $ouvidoria)

                            @php
                            $ouvidoriaController = new \App\Http\Controllers\OuvidoriaController();

                            $parte_data1 = explode("-", date('Y-m-d', strtotime($ouvidoria->dtCriacao)));
                            $anoinicial = $parte_data1['0'];
                            $mesinicial = $parte_data1['1'];
                            $diainicial = $parte_data1['2'];
                            //Concatena em um Novo Formato de DATA
                            $datainicial = $anoinicial."-".$mesinicial."-".$diainicial;

                            $parte_data2 = explode("-", date('Y-m-d'));
                            $anofinal = $parte_data2['0'];
                            $mesfinal = $parte_data2['1'];
                            $diafinal = $parte_data2['2'];
                            //Concatena em um Novo Formato de DATA
                            $datafinal = $anofinal."-".$mesfinal."-".$diafinal;

                            $diasUteis = $ouvidoriaController->corre_anos($anoinicial, $anofinal, $mesinicial, $mesfinal, $datainicial, $datafinal);
                            @endphp

                        <tr>
                            <td>
                                <a href="/pesquisa-satisfacao/{{ $ouvidoria->id }}/create" target="_blank">
                                    {{ str_pad($ouvidoria->protocolo, 13, 0, STR_PAD_LEFT) }}
                                </a>
                            </td>
                            <td>{{ $ouvidoria->noTipoOuvidoria }}</td>
                            <td>{{ $ouvidoria->dsTipoSolicitante }}</td>
                            <td>{{ $ouvidoria->noSolicitante }}</td>
                            <td>{{ date('d/m/Y', strtotime($ouvidoria->dtCriacao)) }}</td>
                            <td align="right">{{ str_pad($diasUteis, 2, 0, STR_PAD_LEFT) }}</td>
                            <td>
                                <h5>
                                    <span class="badge badge-pill badge-{{ $ouvidoria->noSituacaoCor }}" style="width: 100%;">
                                        {{ $ouvidoria->noSituacao }}
                                    </span>
                                </h5>
                            </td>
                            <td>
                                <a href="{{ route('ouvidoria.edit', $ouvidoria->id) }}" title="Detalhar Solicitação" 
                                    class="btn btn-primary btn-sm" onclick="return validar()">
                                    <i class="fa fa-btn fa-file-text-o"></i> Detalhar
                                </a>
                            </td>
                        </tr>

                        @endforeach

                        @if (isset($data))
                        <tr>
                            <td colspan="2">
                                <input id="totalPage" name="totalPage" type="text" value="{{ $totalPage }}" 
                                    class="form-control" size="10" style="text-align: right;">
                                    Registros por página
                            </td>
                            <td colspan="6">
                                {{  $ouvidorias->appends($data)->links() }}
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="2">
                                <input id="totalPage" name="totalPage" type="text" value="{{ $totalPage }}" 
                                    class="form-control" size="10" style="text-align: right;">
                                    Registros por página
                            </td>
                            <td colspan="6">
                                {{ $ouvidorias->links() }}
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
