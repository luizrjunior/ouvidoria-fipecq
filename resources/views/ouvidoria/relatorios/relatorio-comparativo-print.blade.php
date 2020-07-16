@php
$data_inicio_1 = $data['data_inicio_1'];
$data_termino_1 = $data['data_termino_1'];

$data_inicio_2 = $data['data_inicio_2'];
$data_termino_2 = $data['data_termino_2'];

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

$y = 0;
$id_old = "";
$qtdeAnoInicio = 0;
$qtdeAnoTermino = 0;

$arrCanaisAtendimentos = array();
$arrTiposOuvidorias = array();
@endphp

{{-- CANAIS DE ATENDIMENTO --}}
@if (count($ouvidoriasAnoInicioCA) > 0)
    @foreach ($ouvidoriasAnoInicioCA as $ouvidoriaAnoInicioCA)
        @php
        $id = $ouvidoriaAnoInicioCA->canal_atendimento_id;
        if ($id != $id_old) {
            $y = 1;
        }
        $arrCanaisAtendimentos['1'][$id]['qtde'] = $y;
        $arrCanaisAtendimentos['1'][$id]['nome'] = $ouvidoriaAnoInicioCA->canalAtendimento->descricao;
        $id_old = $id;
        $y++;
        @endphp
    @endforeach
@else

    @if (count($canaisAtendimentos) > 0)
        @foreach($canaisAtendimentos as $canalAtendimento)
            @php
            $id = $canalAtendimento->id;
            $descricao = $canalAtendimento->descricao;
            $arrCanaisAtendimentos['1'][$id]['qtde'] = 0;
            $arrCanaisAtendimentos['1'][$id]['nome'] = $descricao;
            @endphp
        @endforeach
    @endif

@endif

@if (count($ouvidoriasAnoTerminoCA) > 0)
    @foreach ($ouvidoriasAnoTerminoCA as $ouvidoriaAnoTerminoCA)
        @php
        $id = $ouvidoriaAnoTerminoCA->canal_atendimento_id;
        if ($id != $id_old) {
            $y = 1;
        }
        $arrCanaisAtendimentos['2'][$id]['qtde'] = $y;
        $arrCanaisAtendimentos['2'][$id]['nome'] = $ouvidoriaAnoTerminoCA->canalAtendimento->descricao;
        $id_old = $id;
        $y++;
        @endphp
    @endforeach
@else

    @if (count($canaisAtendimentos) > 0)
        @foreach($canaisAtendimentos as $canalAtendimento)
            @php
            $id = $canalAtendimento->id;
            $descricao = $canalAtendimento->descricao;
            $arrCanaisAtendimentos['2'][$id]['qtde'] = 0;
            $arrCanaisAtendimentos['2'][$id]['nome'] = $descricao;
            @endphp
        @endforeach
    @endif

@endif

{{-- TIPO DE SOLICITAÇÃO --}}
@if (count($ouvidoriasAnoInicioTS) > 0)
    @foreach ($ouvidoriasAnoInicioTS as $ouvidoriaAnoInicioTS)
        @php
        $id = $ouvidoriaAnoInicioTS->tp_ouvidoria_id;
        if ($id != $id_old) {
            $y = 1;
        }
        $arrTiposOuvidorias['1'][$id]['qtde'] = $y;
        $arrTiposOuvidorias['1'][$id]['nome'] = $ouvidoriaAnoInicioTS->tipoOuvidoria->nome;
        $id_old = $id;
        $y++;
        $qtdeAnoInicio++;
        @endphp
    @endforeach
@else

    @if (count($tiposOuvidorias) > 0)
        @foreach($tiposOuvidorias as $tipoOuvidoria)
            @php
            $id = $tipoOuvidoria->id;
            $nome = $tipoOuvidoria->nome;
            $arrTiposOuvidorias['1'][$id]['qtde'] = 0;
            $arrTiposOuvidorias['1'][$id]['nome'] = $nome;
            @endphp
        @endforeach
    @endif

@endif

@if (count($ouvidoriasAnoTerminoTS) > 0)
    @foreach ($ouvidoriasAnoTerminoTS as $ouvidoriaAnoTerminoTS)
        @php
        $id = $ouvidoriaAnoTerminoTS->tp_ouvidoria_id;
        if ($id != $id_old) {
            $y = 1;
        }
        $arrTiposOuvidorias['2'][$id]['qtde'] = $y;
        $arrTiposOuvidorias['2'][$id]['nome'] = $ouvidoriaAnoTerminoTS->tipoOuvidoria->nome;
        $id_old = $id;
        $y++;
        $qtdeAnoTermino++;
        @endphp
    @endforeach
@else

    @if (count($tiposOuvidorias) > 0)
        @foreach($tiposOuvidorias as $tipoOuvidoria)
            @php
            $id = $tipoOuvidoria->id;
            $nome = $tipoOuvidoria->nome;
            $arrTiposOuvidorias['2'][$id]['qtde'] = 0;
            $arrTiposOuvidorias['2'][$id]['nome'] = $nome;
            @endphp
        @endforeach
    @endif

@endif

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Sistema de Ouvidoria - FIPECqVida">
        <meta name="author" content="Luiz Roberto Teixeira Reis Junior">
        <link rel="icon" href="{{ asset('favicon.ico') }}">

        <title>Caixa de Assistência Social da FIPECq - FIPECq Vida - Ouvidoria</title>

        <!-- Bootstrap core CSS -->
        {{-- <link href="{{ asset('bootstrap/4.4.1/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <!-- Custom styles for this template -->
        <link href="{{ asset('css/pricing.css') }}" rel="stylesheet">

        <!-- Styles Extras -->
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('bootstrap/4.4.1/css/bootstrap-datepicker.css') }}" rel="stylesheet"/>
        
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/ce01a1c161.js" crossorigin="anonymous"></script>
        <style>
            .uper {
                margin-top: 40px;
            }
        </style>
    </head>

    <body>
        <div style="display: none;">
            <div class="col-md-6">
                <label for="data_inicio_1" class="control-label">1º Período de (*)</label>
                <div class='input-group date'>
                    <input type='text' id="data_inicio_1" name="data_inicio_1" class="form-control" 
                        value="{{ $data_inicio_1 }}">
                </div>
            </div>
            <div class="col-md-6">
                <label for="data_termino_1" class="control-label">Até (*)</label>
                <div class='input-group date'>
                    <input type="text" id="data_termino_1" name="data_termino_1" class="form-control" 
                        value="{{ $data_termino_1 }}">
                </div>
            </div>
            <div class="col-md-6">
                <label for="data_inicio_2" class="control-label">2º Período de (*)</label>
                <div class='input-group date'>
                    <input type='text' id="data_inicio_2" name="data_inicio_2" class="form-control" 
                        value="{{ $data_inicio_2 }}">
                </div>
            </div>
            <div class="col-md-6">
                <label for="data_termino_2" class="control-label">Até (*)</label>
                <div class='input-group date'>
                    <input type="text" id="data_termino_2" name="data_termino_2" class="form-control" 
                        value="{{ $data_termino_2 }}">
                </div>
            </div>
        </div>

        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-12" style="text-align:center;">
                    <img src="{{ url('images/logo_ouvidoria.png') }}" class="p-4">
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    
                    <div class="card uper">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <canvas id="column-chart-canal-atendimento" height="400"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card uper">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <canvas id="bar-chart-tipo-solicitacao" height="400"></canvas>
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

                    <br>&nbsp;

                </div>
            </div>

        </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script src="{{ asset('morris/chart.min.js') }}"></script>
    <!-- Page script -->
    <script>
        // Column chart
        // ------------------------------
        $(window).on("load", function(){

            //Get the context of the Chart canvas element we want to select
            var ctx = $("#column-chart-canal-atendimento");

            // Chart Options
            var chartOptions = {
                // Elements options apply to all of the options unless overridden in a dataset
                // In this case, we are setting the border of each bar to be 2px wide and green
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: 'rgb(0, 255, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                responsiveAnimationDuration:0,
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
                    text: 'Total Comparativo Por Canal de Atendimento'
                }
            };

            // Chart Data
            var chartData = {
                labels: ["1º Periodo de " + $("#data_inicio_1").val() + " até " + $("#data_termino_1").val(), "2º Periodo de " + $("#data_inicio_2").val() + " até " + $("#data_termino_2").val()],
                datasets: [
                    @if (count($canaisAtendimentos) > 0)
                        @foreach($canaisAtendimentos as $canalAtendimento)
                            @php
                            $id = $canalAtendimento->id;
                            $descricao = $canalAtendimento->descricao;
                            $qtdeInicio = $arrCanaisAtendimentos['1'][$id]['qtde'];
                            $qtdeTermino = $arrCanaisAtendimentos['2'][$id]['qtde'];
                            $color = $bgColor[$id];
                            $colorRgb = $bgColorRgb[$id];
                            @endphp
                            {
                                label: "{{ $descricao }}", 
                                data: [{{ $qtdeInicio }}, {{ $qtdeTermino }}], 
                                backgroundColor: "{{ $color }}", 
                                hoverBackgroundColor: "{{ $colorRgb }}", 
                                borderColor: "transparent"
                            },
                        @endforeach
                    @endif
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

                // Chart Options
                options : chartOptions,

                data : chartData
            };

            // Create the chart
            var lineChart = new Chart(ctx, config);
        });

        $(window).on("load", function(){
            
            var a=$("#bar-chart-tipo-solicitacao");

            new Chart(a,{
                type:"horizontalBar",
                options:{
                    elements:{
                        rectangle:{
                            borderWidth:2,
                            borderColor:"rgb(0, 255, 0)",
                            borderSkipped:"left"
                        }
                    },
                    responsive:!0,
                    maintainAspectRatio:!1,
                    responsiveAnimationDuration:0,
                    legend:{
                        position:"top"
                    },
                    scales:{
                        xAxes:[{
                            display:!0,
                            gridLines:{
                                color:"#f3f3f3",
                                drawTicks:!1
                            },
                            scaleLabel:{
                                display:!0
                            }
                        }],
                        yAxes:[{
                            display:!0,
                            gridLines:{
                                color:"#f3f3f3",
                                drawTicks:!1
                            },
                            scaleLabel:{
                                display:!0
                            }
                        }]
                    },
                    title:{
                        display:true,
                        text:"Total Comparativo Por Tipo de Solicitação"
                    }
                },
                data:{
                    labels:[
                        @if (count($tiposOuvidorias) > 0)
                            @foreach($tiposOuvidorias as $tipoOuvidoria)
                            @php
                            $descricao = $tipoOuvidoria->nome;
                            @endphp
                        "{{ $descricao }}",
                            @endforeach
                        @endif
                        ],
                    datasets:[{
                        label:"1º Periodo de " + $("#data_inicio_1").val() + " até " + $("#data_termino_1").val(),
                        data:[
                            @if (count($tiposOuvidorias) > 0)
                                @foreach ($tiposOuvidorias as $tipoOuvidoria)
                                    @php
                                    $id = $tipoOuvidoria->id;
                                    $qtdeInicio = $arrTiposOuvidorias['1'][$id]['qtde'];
                                    @endphp
                                {{ $qtdeInicio }},
                                @endforeach
                            @endif
                            ],
                        backgroundColor:"#28D094",
                        hoverBackgroundColor:"rgba(22,211,154,.9)",
                        borderColor:"transparent"
                    },
                    {
                        label:"2º Periodo de " + $("#data_inicio_2").val() + " até " + $("#data_termino_2").val(),
                        data:[
                            @if (count($tiposOuvidorias) > 0)
                                @foreach ($tiposOuvidorias as $tiposOuvidorias)
                                    @php
                                    $id = $tiposOuvidorias->id;
                                    $qtdeTermino = $arrTiposOuvidorias['2'][$id]['qtde'];
                                    @endphp
                                {{ $qtdeTermino }},
                                @endforeach
                            @endif
                            ],
                        backgroundColor:"#F98E76",
                        hoverBackgroundColor:"rgba(249,142,118,.9)",
                        borderColor:"transparent"
                    }]
                }
            });
        });

        // Column chart
        // ------------------------------
        $(window).on("load", function(){

            //Get the context of the Chart canvas element we want to select
            var ctxT = $("#column-chart");

            // Chart Options
            var chartOptionsT = {
                // Elements options apply to all of the options unless overridden in a dataset
                // In this case, we are setting the border of each bar to be 2px wide and green
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: 'rgb(0, 255, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
                responsiveAnimationDuration:0,
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
                    text: 'Total Comparativo Por Ano'
                }
            };

            // Chart Data
            var chartDataT = {
                labels: [""],
                datasets: [
                    {
                        label: "1º Periodo de " + $("#data_inicio_1").val() + " até " + $("#data_termino_1").val(), 
                        data: [{{ $qtdeAnoInicio }}], 
                        backgroundColor: "#28D094", 
                        hoverBackgroundColor: "rgba(22,211,154,.9)", 
                        borderColor: "transparent"
                    },
                    {
                        label: "2º Periodo de " + $("#data_inicio_2").val() + " até " + $("#data_termino_2").val(), 
                        data: [{{ $qtdeAnoTermino }}], 
                        backgroundColor: "#F98E76", 
                        hoverBackgroundColor: "rgba(249,142,118,.9)", 
                        borderColor: "transparent"
                    },
                    {
                        label: "", 
                        data: [0, 0], 
                        backgroundColor: "#FFFFFF", 
                        hoverBackgroundColor: "", 
                        borderColor: "transparent"
                    },
                ]
            };

            var configT = {
                type: 'bar',

                // Chart Options
                options : chartOptionsT,

                data : chartDataT
            };

            // Create the chart
            var lineChartT = new Chart(ctxT, configT);
        });
    </script>
    
    </body>
</html>

