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

@foreach($arr_TiposOuvidorias as $arr_TipoOuvidoria)
    @foreach($arr_Instituidoras as $arr_Instituidora)
        @php
        $idTipoOuvidoria = $arr_TipoOuvidoria['id'];
        $idInstituidora = $arr_Instituidora['id'];
        $relatoriosController = new \App\Http\Controllers\RelatorioController();
        $qtde = $relatoriosController->pegarTipoOuvidoriaPorInstituidora($idTipoOuvidoria, $idInstituidora, $data);
        $total += $qtde;
        @endphp
    @endforeach
@endforeach

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
    
    </body>
</html>

