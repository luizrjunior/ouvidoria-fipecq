@extends('layouts.app')

@section('javascript')
<script type="text/javascript" 
    src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" 
    src="{{ asset('/js/ouvidoria/relatorios/relatorios.js') }}"></script>
<!-- FLOT CHARTS -->
<script src="{{ asset('Flot/jquery.flot.js') }}"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="{{ asset('Flot/jquery.flot.resize.js') }}"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="{{ asset('Flot/jquery.flot.pie.js') }}"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="{{ asset('Flot/jquery.flot.categories.js') }}"></script>
<!-- Page script -->
@php
$tiposSolicitacao = array();
$dataChart = "";
$bgColor = [
    1 => '#6495ED',
    2 => '#4169E1',
    3 => '#1E90FF',
    4 => '#00BFFF',
    5 => '#87CEFA',
    6 => '#87CEEB',
    7 => '#ADD8E6',
    8 => '#4682B4',
    9 => '#B0C4DE',
    10 => '#0000FF',
];
$y = 0;
$id_old = "";
@endphp
@if (count($ouvidorias) > 0)
    @foreach ($ouvidorias as $ouvidoria)
        @php
        $id = $ouvidoria->tp_ouvidoria_id;
        if ($id != $id_old) {
            $y = 1;
        }
        $tiposSolicitacao[$id]['qtde'] = $y;
        $tiposSolicitacao[$id]['nome'] = $ouvidoria->tipoOuvidoria->nome;
        $id_old = $id;
        $y++;
        @endphp
    @endforeach
@endif

<script>
    $(function () {
    /*
    * DONUT CHART
    * -----------
    */
    @php
    $i = 1;
    @endphp
    var donutData = [
        @php
        $total = 0;
        @endphp
        @if (count($tiposSolicitacao) > 0)
            @foreach ($tiposSolicitacao as $tipoSolicitacao)
                @php
                $nome = $tipoSolicitacao['nome'];
                $qtde = $tipoSolicitacao['qtde'];
                $color = $bgColor[$i];
                @endphp
                { label: '{{ $nome }}', data: {{ $qtde }}, color: '{{ $color}}' },
                @php
                $i++;
                $total += $qtde;
                @endphp
            @endforeach
        @endif
        ];
    $.plot('#donut-chart', donutData, {
            series: {
                pie: {
                    show       : true,
                    radius     : 1,
                    innerRadius: 0.5,
                    label      : {
                        show     : true,
                        radius   : 2 / 3,
                        formatter: labelFormatter,
                        threshold: 0.1
                    }
                }
            },
            grid: {
                hoverable: true,
                clickable: true
            },
            legend: {
                show: true
            }
        });
        /*
        * END DONUT CHART
        */
    });

    /*
    * Custom Label formatter
    * ----------------------
    */
    function labelFormatter(label, series) {
        return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
            + label
            + '<br>'
            + Math.round(series.percent) + '%</div>'
    }
</script>
@endsection

@section('content')
@php
$data_inicio = date('01/m/Y');
$data_termino = date('d/m/Y');
@endphp
@if (isset($data))
    @php
    $data_inicio = $data['data_inicio'];
    $data_termino = $data['data_termino'];
    @endphp
@endif

<style>
  .uper {
    margin-top: 40px;
  }
</style>

<ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" href="#">Tipo de Solicitação</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" onclick="abrirRelatorio(1)">Faixa Etária</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" onclick="abrirRelatorio(2)">Tempo de Espera por Tipo</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" onclick="abrirRelatorio(3)">Institutora</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" onclick="abrirRelatorio(4)">Relatórios</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" onclick="abrirRelatorio(5)">Relatório Personalizado</a>
    </li>
</ul>

<div class="row justify-content-center">
    <div class="col-md-12">
        
        <form id="formRelatoriosOuvidoria" class="form-horizontal" 
            role="form" method="POST" action="{{ route('relatorio.tipo-solicitacao') }}">
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
                    <div class="row">
                        <div class="col-md-1">
                            &nbsp;
                        </div>
                        <div class="col-md-10">
                            <div id="donut-chart" style="height: 400px;"></div>
                        </div>
                        <div class="col-md-1">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>

            <div class="card uper">
                <div class="card-body">
                    <table class="table table-hover table-bordered" cellspacing="0" width="100%">
                        <tr>
                            <td align="center"><b>Tipo de Solicitação</b></td>
                            <td align="center" width="25%"><b>Total</b></td>
                            <td align="center" width="25%"><b>%</b></td>
                        </tr>

                        @if (count($tiposSolicitacao) > 0)
                            @foreach ($tiposSolicitacao as $tipoSolicitacao)
                                @php
                                $nome = $tipoSolicitacao['nome'];
                                $qtde = $tipoSolicitacao['qtde'];
                                $ouvidoriaController = new \App\Http\Controllers\RelatorioController();
                                $perc = $ouvidoriaController->obterPercentual($qtde, $total);
                                @endphp
                        <tr>
                            <td align="center">{{ $nome }}</td>
                            <td align="center" width="25%">{{ $qtde }}</td>
                            <td align="center" width="25%">{{ $perc }}</td>
                        </tr>
                            @endforeach
                        @endif

                        <tr>
                            <td align="center"><b>Total Geral</b></td>
                            <td align="center"><b>{{ $total }}</b></td>
                            <td align="center"><b>100%</b></td>
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
