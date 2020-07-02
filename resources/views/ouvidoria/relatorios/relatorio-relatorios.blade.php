@php
$data_inicio = $data['data_inicio'];
$data_termino = $data['data_termino'];

$tipo_ouvidoria_id_psq = $data['tipo_ouvidoria_id_psq'];
$checkTodosTipoOuvidoria = $data['checkTodosTipoOuvidoria'];

$institutora_id_psq = $data['institutora_id_psq'];
$checkTodosInstituidoras = $data['checkTodosInstituidoras'];

$bgColor = [
    1 => '#6495ED',
    2 => '#F98E76',
    3 => '#BEBEBE',
    4 => '#FFD700',
    5 => '#87CEFA',
    6 => '#87CEEB',
    7 => '#ADD8E6',
    8 => '#4682B4',
    9 => '#B0C4DE',
    10 => '#0000FF',
];
$bgColorRgb = [
    1 => 'rgba(100,149,237,.9)',
    2 => 'rgba(249,142,118,.9)',
    3 => 'rgba(190,190,190,.9)',
    4 => 'rgba(255,215,0,.9)',
    5 => '#87CEFA',
    6 => '#87CEEB',
    7 => '#ADD8E6',
    8 => '#4682B4',
    9 => '#B0C4DE',
    10 => '#0000FF',
];

$arr_TiposOuvidorias = array();
$arr_Instituidoras = array();
$total = 0;
@endphp

@if (count($arrTiposOuvidorias) > 0)
    @foreach($arrTiposOuvidorias as $arrTipoOuvidoria)
        @php
        $id = $arrTipoOuvidoria->idtipoouvidoria;
        $nome = $arrTipoOuvidoria->notipoouvidoria;
        $arr_TiposOuvidorias[$id]['id'] = $id;
        $arr_TiposOuvidorias[$id]['nome'] = $nome;
        @endphp
    @endforeach
@endif

@if (count($arrInstituidoras) > 0)
    @foreach($arrInstituidoras as $arrInstituidora)
        @php
        $id = $arrInstituidora->idempresa;
        $nome = $arrInstituidora->noempresa;
        $arr_Instituidoras[$id]['id'] = $id;
        $arr_Instituidoras[$id]['nome'] = $nome;
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
<script src="{{ asset('morris/chart.min.js') }}"></script>
<!-- Page script -->
<script>
    // Column chart
    // ------------------------------
    $(window).on("load", function() {

        var ctx = $("#column-chart");

        var chartOptions = {
            elements: {
                rectangle: {
                    borderWidth: 2,
                    borderColor: 'rgb(0, 255, 0)',
                    borderSkipped: 'bottom'
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            responsiveAnimationDuration:500,
            legend: {
                position: 'top',
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        color: "#f3f3f3",
                        drawTicks: false,
                    },
                    scaleLabel: {
                        display: true,
                    }
                }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        color: "#f3f3f3",
                        drawTicks: false,
                    },
                    scaleLabel: {
                        display: true,
                    }
                }]
            },
            title: {
                display: true,
                text: 'Total Comparativo de Instituidoras Por Tipo de Solicitação'
            }
        };

        // Chart Data
        var chartData = {
            labels: [
                @foreach($arr_Instituidoras as $arr_Instituidora)
                    @php
                    $partes = explode('-', $arr_Instituidora['nome']);
                    $primeiroNome = array_shift($partes);
                    @endphp
                    "{{ $primeiroNome }}",
                @endforeach
            ],
            datasets: [
                @foreach($arr_TiposOuvidorias as $arr_TipoOuvidoria)
                    @php
                    $id = $arr_TipoOuvidoria['id'];
                    $nome = $arr_TipoOuvidoria['nome'];
                    $color = $bgColor[$id];
                    $colorRgb = $bgColorRgb[$id];
                    @endphp
                    {
                        label: "{{ $nome }}", 
                        data: [
                        @foreach($arr_Instituidoras as $arr_Instituidora)
                            @php
                            $idTipoOuvidoria = $arr_TipoOuvidoria['id'];
                            $idInstituidora = $arr_Instituidora['id'];
                            $relatoriosController = new \App\Http\Controllers\RelatorioController();
                            $qtde = $relatoriosController->pegarTipoOuvidoriaPorInstituidora($idTipoOuvidoria, $idInstituidora, $data);
                            @endphp
                            {{ $qtde }},
                            @php
                            $total += $qtde;
                            @endphp
                        @endforeach
                        ], 
                        backgroundColor: "{{ $color }}", 
                        hoverBackgroundColor: "{{ $colorRgb }}", 
                        borderColor: "transparent"
                    },
                @endforeach
                {
                    label: "", 
                    data: [0, 0], 
                    backgroundColor: "#FFFFFF", 
                    hoverBackgroundColor: "", 
                    borderColor: "transparent"
                },
            ]
        };

        var config = {
            type: 'bar',
            options : chartOptions,
            data : chartData
        };

        // Create the chart
        var lineChart = new Chart(ctx, config);
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
        <a class="nav-link" href="#" onclick="abrirRelatorio('0')">Tipo Solicitação</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="abrirRelatorio('1')">Faixa Etária</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="abrirRelatorio('2')">Tempo Espera</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="abrirRelatorio('3')">Instituidora</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="#">Instituidora Comparativo</a>
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
        
        <form id="formRelatorios" class="form-horizontal" role="form" method="POST" 
            action="{{ route('relatorio.relatorios') }}">
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
                        <div class="col-md-12">
                            <label for="checkbox" class="control-label">Tipos de Solicitação</label><br>
                            @foreach ($tiposOuvidorias as $tipoOuvidoria)
                                @php
                                $checked = "";
                                @endphp
                                @if (in_array($tipoOuvidoria->id, $tipo_ouvidoria_id_psq))
                                    @php
                                    $checked = "checked";
                                    @endphp
                                @endif
                            <div class="form-check custom-control-inline">
                                <input class="form-check-input tipo-ouvidoria" type="checkbox" value="{{ $tipoOuvidoria->id }}" 
                                    name="tipo_ouvidoria_id_psq[]" {{ $checked }}>
                                <label class="form-check-label">{{ $tipoOuvidoria->nome }}</label>
                            </div>
                            @endforeach

                            @php
                            $checked = "";
                            @endphp
                            @if ($checkTodosTipoOuvidoria == "on")
                                @php
                                $checked = "checked";
                                @endphp
                            @endif
                            <div class="form-check custom-control-inline">
                                <input class="form-check-input" type="checkbox" id="checkTodosTipoOuvidoria" 
                                    name="checkTodosTipoOuvidoria" {{ $checked }}>
                                <label class="form-check-label">Marcar todos</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="checkbox" class="control-label">Instituidoras</label>
                        </div>
                        @php
                        $checked = "";
                        @endphp
                        @if ($checkTodosInstituidoras == "on")
                            @php
                            $checked = "checked";
                            @endphp
                        @endif
                        <div class="col-md-10">
                            <div class="form-check custom-control-inline">
                                <input class="form-check-input" type="checkbox" id="checkTodosInstituidoras" 
                                    name="checkTodosInstituidoras" {{ $checked }}>
                                <label class="form-check-label">Marcar todos</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-12">
                            @foreach ($institutoras as $institutora)
                                @php
                                $partes = explode('-', $institutora->nome);
                                $primeiroNome = array_shift($partes);
                                $checked = "";
                                @endphp
                                @if (in_array($institutora->empresa, $institutora_id_psq))
                                    @php
                                    $checked = "checked";
                                    @endphp
                                @endif
                            <div class="col-md-5 custom-control-inline">
                                <input class="form-check-input instituitora" type="checkbox" value="{{ $institutora->empresa }}" 
                                    name="institutora_id_psq[]" {{ $checked }}>
                                <label class="form-check-label">{{ $primeiroNome }}</label>
                            </div>
                            @endforeach
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
                        <div class="col-md-12">
                            <canvas id="column-chart" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card uper">
                <div class="card-body">
                    <table class="table table-striped" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" width="25%"><b>Instituidora</b></td>
                            @foreach($arr_TiposOuvidorias as $arr_TipoOuvidoria)
                                @php
                                $nome = $arr_TipoOuvidoria['nome'];
                                @endphp
                            <td align="center"><b>{{ $nome }}</b></td>
                            @endforeach
                            <td align="center" width="5%"><b>Total</b></td>
                            <td align="center" width="5%"><b>%</b></td>
                        </tr>

                        @if (count($arr_Instituidoras) > 0)
                            @foreach ($arr_Instituidoras as $arr_Instituidora)
                                @php
                                $idInstituidora = $arr_Instituidora['id'];
                                $partes = explode('-', $arr_Instituidora['nome']);
                                $primeiroNome = array_shift($partes);
                                $qtdeTotal = 0;
                                @endphp
                        <tr>
                            <td>{{ $primeiroNome }}</td>
                                @foreach($arr_TiposOuvidorias as $arr_TipoOuvidoria)
                                    @php
                                    $idTipoOuvidoria = $arr_TipoOuvidoria['id'];
                                    $relatoriosController = new \App\Http\Controllers\RelatorioController();
                                    $qtde = $relatoriosController->pegarTipoOuvidoriaPorInstituidora($idTipoOuvidoria, $idInstituidora, $data);
                                    @endphp
                            <td align="center">{{ $qtde }}</td>
                                    @php
                                    $qtdeTotal += $qtde;
                                    @endphp
                                @endforeach
                                @php
                                $ouvidoriaController = new \App\Http\Controllers\RelatorioController();
                                $perc = $ouvidoriaController->obterPercentual($qtdeTotal, $total);
                                @endphp
                            <td align="center">{{ $qtdeTotal }}</td>
                            <td align="center">{{ $perc }}</td>
                        </tr>
                            @endforeach
                        @endif

                        <tr>
                            <td align="center"><b>Total Geral</b></td>
                            @php
                            $qtdeTotal = 0;
                            @endphp
                            @foreach($arr_TiposOuvidorias as $arr_TipoOuvidoria)
                                @php
                                $total = 0;
                                @endphp
                                @foreach($arr_Instituidoras as $arr_Instituidora)
                                    @php
                                    $idTipoOuvidoria = $arr_TipoOuvidoria['id'];
                                    $idInstituidora = $arr_Instituidora['id'];
                                    $relatoriosController = new \App\Http\Controllers\RelatorioController();
                                    $qtde = $relatoriosController->pegarTipoOuvidoriaPorInstituidora($idTipoOuvidoria, $idInstituidora, $data);
                                    $total += $qtde;
                                    $qtdeTotal += $qtde;
                                    @endphp
                                @endforeach
                            <td align="center"><b>{{ $total }}</b></td>
                            @endforeach
                            <td align="center"><b>{{ $qtdeTotal }}</b></td>
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
