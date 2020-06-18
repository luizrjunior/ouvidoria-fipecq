@php
$data_inicio = $data['data_inicio'] ? $data['data_inicio'] : date('01/m/Y');
$data_termino = $data['data_termino'] ? $data['data_termino'] : date('d/m/Y');
$bgColor = [
    1 => '#6495ED',
    2 => '#4169E1',
    3 => '#1E90FF',
    4 => '#00BFFF',
    5 => '#87CEFA',
    6 => '#87CEEB',
    7 => '#ADD8E6',
    8 => '#FFFFFF',
    9 => '#B0C4DE',
    10 => '#0000FF',
];
@endphp

@extends('layouts.app')

@section('javascript')
<script type="text/javascript">
    top.urlRelTipoOuvidoria = '{{ url("/relatorio/tipo-solicitacao") }}';
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
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="{{ asset('Flot/jquery.flot.pie.js') }}"></script>
<!-- Page script -->
<script>
    $(function () {
        @php
        $i = 1;
        $total = 0;
        @endphp
        var data = [
        @if (count($faixasEtarias) > 0)
            @foreach ($faixasEtarias as $faixaEtaria)
                @php
                $nome = $faixaEtaria['nome'];
                $qtde = $faixaEtaria['qtde'];
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

        $.plot('#donut-chart', data, {
            series: {
                pie: {
                    show: true,
                    label      : {
                        show     : true,
                        formatter: labelFormatter,
                    }
                }
            },
            grid: {
                hoverable: true,
                clickable: true
            },
            legend: {
                show: false
            }
        });
    });

    function labelFormatter(label, series) {
        return '<div style="font-size:13px; font-weight: 600; color: #000000;">'
            + label
            + ': '
            + Math.round(series.percent) + '%</div>'
    }    
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
        <a class="nav-link active" href="#">Faixa Etária</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="abrirRelatorio('2')">Tempo de Espera</a>
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
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="abrirRelatorio('6')">Relatório Comparativo</a>
    </li>
</ul>

<div class="row justify-content-center">
    <div class="col-md-12">
        
        <form id="formRelatorios" class="form-horizontal" 
            role="form" method="POST" action="{{ route('relatorio.faixa-etaria') }}">
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
                    <h3>Total Por Faixa Etária</h3>
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
                    <table class="table table-striped" cellspacing="0" width="100%">
                        <tr>
                            <td align="center"><b>Faixa Etária</b></td>
                            <td align="center" width="25%"><b>Total</b></td>
                            <td align="center" width="25%"><b>%</b></td>
                        </tr>

                        @if (count($faixasEtarias) > 0)
                            @foreach ($faixasEtarias as $faixaEtaria)
                                @php
                                $nome = $faixaEtaria['nome'];
                                $qtde = $faixaEtaria['qtde'];
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
