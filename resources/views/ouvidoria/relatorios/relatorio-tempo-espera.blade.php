@php
$data_inicio = $data['data_inicio'];
$data_termino = $data['data_termino'];

$y = 0;
$id_old = "";

$tiposSolicitacao = array();
@endphp

@if (count($ouvidorias) > 0)
    @foreach ($ouvidorias as $ouvidoria)
        @php
        $ouvidoriaController = new \App\Http\Controllers\OuvidoriaController();

        $parte_data1 = explode("-", date('Y-m-d', strtotime($ouvidoria->created_at)));
        $anoinicial = $parte_data1['0'];
        $mesinicial = $parte_data1['1'];
        $diainicial = $parte_data1['2'];
        //Concatena em um Novo Formato de DATA
        $datainicial = $anoinicial."-".$mesinicial."-".$diainicial;

        $parte_data2 = explode("-", date('Y-m-d', strtotime($ouvidoria->updated_at)));
        $anofinal = $parte_data2['0'];
        $mesfinal = $parte_data2['1'];
        $diafinal = $parte_data2['2'];
        //Concatena em um Novo Formato de DATA
        $datafinal = $anofinal."-".$mesfinal."-".$diafinal;

        $diasUteis = $ouvidoriaController->corre_anos($anoinicial, $anofinal, $mesinicial, $mesfinal, $datainicial, $datafinal);

        $id = $ouvidoria->tp_ouvidoria_id;
        if ($id != $id_old) {
            $y = 1;
            $dias = $diasUteis;
        } else {
            $dias += $diasUteis;
        }

        $tiposSolicitacao[$id]['dias'] = $dias;
        $tiposSolicitacao[$id]['qtde'] = $y;
        $tiposSolicitacao[$id]['nome'] = $ouvidoria->tipoOuvidoria->nome;
        $id_old = $id;
        $y++;
        @endphp
    @endforeach
@endif

@extends('layouts.app')

@section('javascript')
<script type="text/javascript">
    top.urlRelTipoOuvidoria = '{{ url("/relatorio/tipo-solicitacao") }}';
    top.urlRelFaixaEtaria = '{{ url("/relatorio/faixa-etaria") }}';
    top.urlRelTempoEspera = '{{ url("/relatorio/tempo-espera") }}';
    top.urlRelInstitutora = '{{ url("/relatorio/institutora") }}';
    top.urlRelatorios = '{{ url("/relatorio/relatorios") }}';
    top.urlRelPersonalizado = '{{ url("/relatorio/relatorio-personalizado") }}';
    top.urlRelComparativo = '{{ url("/relatorio/relatorio-comparativo") }}';
</script>
<script type="text/javascript" 
    src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" 
    src="{{ asset('/js/ouvidoria/relatorios/relatorios.js') }}"></script>
<!-- FLOT CHARTS -->
<script src="{{ asset('Flot/jquery.flot.js') }}"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="{{ asset('Flot/jquery.flot.resize.js') }}"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="{{ asset('Flot/jquery.flot.stack.js') }}"></script>
<!-- Page script -->
<script>
    $(function () {
		var d2 = [
            @php
            $i = 1;
            @endphp
            @if (count($tiposSolicitacao) > 0)
                @foreach ($tiposSolicitacao as $tipoSolicitacao)
                    @php
                    $qtde = $tipoSolicitacao['dias'] / $tipoSolicitacao['qtde'];
                    @endphp
                    [{{ $i }}, {{ (10 - $qtde) }}],
                    @php
                    $i++;
                    @endphp
                @endforeach
            @endif
        ];

		var d1 = [
            @php
            $i = 1;
            $total = 0;
            @endphp
            @if (count($tiposSolicitacao) > 0)
                @foreach ($tiposSolicitacao as $tipoSolicitacao)
                    @php
                    $qtde = $tipoSolicitacao['dias'] / $tipoSolicitacao['qtde'];
                    @endphp
                    [{{ $i }}, {{ $qtde }}],
                    @php
                    $i++;
                    $total += $qtde;
                    @endphp
                @endforeach
            @endif
        ];

		var d3 = [
            @php
            $i = 1;
            @endphp
            @if (count($tiposSolicitacao) > 0)
                @foreach ($tiposSolicitacao as $tipoSolicitacao)
                    @php
                    $nome = $tipoSolicitacao['nome'];
                    @endphp
                    [{{ $i }}, '{{ $nome }}'],
                    @php
                    $i++;
                    @endphp
                @endforeach
            @endif
        ];

        var data = [
            { label: 'Dias Consumidos', data: d1 },
            { label: 'Dias Restantes', data: d2 },
        ];

        var options = {
            series: {
                stack: 0,
                    lines: {
                        show: false, steps: false
                    },
                    bars: {
                        show: true, 
                        barWidth: 0.6, 
                        align: 'center',
                    },
                },
            xaxis: {
                ticks: d3
            },
        };

        $.plot("#stack-chart", data, options);
    });
</script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>

<ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link" href="#" onclick="abrirRelatorio('0')">Tipo de Solicitação</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" onclick="abrirRelatorio('1')">Faixa Etária</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="#">Tempo de Espera</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" onclick="abrirRelatorio('3')">Instituidora</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" onclick="abrirRelatorio('4')">Relatórios</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" onclick="abrirRelatorio('5')">Relatório Personalizado</a>
    </li>
</ul>

<div class="row justify-content-center">
    <div class="col-md-12">
        
        <form id="formRelatorios" class="form-horizontal" 
            role="form" method="POST" action="{{ route('relatorio.tempo-espera') }}">
            @csrf
            <input type="hidden" id="print" name="print" value="">

            <div class="card uper">
                <div class="card-header">
                    Filtros de Pesquisa
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="data_inicio" class="control-label">Período de (*)</label>
                            <div class='input-group date'>
                                <input type='text' id="data_inicio"
                                    name="data_inicio" class="form-control" value="{{ $data_inicio }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="data_termino" class="control-label">Até (*)</label>
                            <div class='input-group date'>
                                <input type="text" id="data_termino"
                                    name="data_termino" class="form-control" value="{{ $data_termino }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            &nbsp;
                        </div>
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary"
                                    onclick="return validar();" style="width: 100%;">
                                <i class="fa fa-btn fa-search"></i> Pesquisar
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card uper">
                <div class="card-body">
                    <h3>Total Tempo de Espera Por Tipo de Solicitação</h3>
                    <div class="row">
                        <div class="col-md-1">
                            &nbsp;
                        </div>
                        <div class="col-md-10">
                            <div id="stack-chart" style="height: 400px;"></div>
                        </div>
                        <div class="col-md-1">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>

            <div class="card uper">
                <div class="card-body">
                    <table class="table table-striped" cellspacing="0" width="100%">
                        <tr>
                            <td align="center"><b>Tipo de Solicitação</b></td>
                            <td align="center" width="25%"><b>Total de Dias</b></td>
                        </tr>

                        @if (count($tiposSolicitacao) > 0)
                            @foreach ($tiposSolicitacao as $tipoSolicitacao)
                                @php
                                $nome = $tipoSolicitacao['nome'];
                                $qtde = $tipoSolicitacao['dias'] / $tipoSolicitacao['qtde'];
                                @endphp
                        <tr>
                            <td align="center">{{ $nome }}</td>
                            <td align="center" width="25%">{{ $qtde }}</td>
                        </tr>
                            @endforeach
                        @endif

                        <tr>
                            <td align="center"><b>Total Geral</b></td>
                            <td align="center"><b>{{ $total }}</b></td>
                        </tr>
                    </table>

                    <div class="form-group row">
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary"
                                onclick="imprimir('ok');" style="width: 100%;">
                                <i class="fa fa-btn fa-print"></i> Exportar/Imprimir Relatório
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </form>

    </div>
</div>
@endsection
