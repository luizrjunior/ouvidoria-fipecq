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
@php
$i = 1;
$total = 0;
@endphp
@if (count($tiposSolicitacao) > 0)
    @foreach ($tiposSolicitacao as $tipoSolicitacao)
        @php
        $nome = $tipoSolicitacao['nome'];
        $qtde = $tipoSolicitacao['qtde'];
        $color = $bgColor[$i];
        $i++;
        $total += $qtde;
        @endphp
    @endforeach
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
    </head>

    <body onload="window.print();">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-12" style="text-align:center;">
                    <img src="{{ url('images/logo_ouvidoria.png') }}" class="p-4">
                    <br>
                    <br>
                    <h3>Tipo de Solicitação</h3>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    
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
                        </div>
                    </div>
            
                </div>
            </div>

        </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- JavaScripts Extras -->
    <script type="text/javascript" src="{{ asset('js/jsgeneralfunctions.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/componentes.js') }}"></script>
		
    <script src="{{ asset('bootstrap/4.4.1/js/bootstrap-datepicker.min.js') }}"></script> 
    <script src="{{ asset('bootstrap/4.4.1/js/bootstrap-datepicker.pt-BR.min.js') }}" charset="UTF-8"></script>
    <!-- FLOT CHARTS -->
    <script src="{{ asset('Flot/jquery.flot.js') }}"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="{{ asset('Flot/jquery.flot.resize.js') }}"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="{{ asset('Flot/jquery.flot.pie.js') }}"></script>
    <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
    <script src="{{ asset('Flot/jquery.flot.categories.js') }}"></script>
    <!-- Page script -->
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
    
    </body>
</html>

