@php
$y = 0;
$total = 0;
$id_old = "";
$institutoras = array();
@endphp

@if (count($ouvidorias) > 0)
    @foreach ($ouvidorias as $ouvidoria)
        @php
        $id = $ouvidoria->idinstitutora;
        if ($id != $id_old) {
            $y = 1;
        }
        $institutoras[$id]['qtde'] = $y;
        $institutoras[$id]['nome'] = $ouvidoria->noempresa;
        $id_old = $id;
        $y++;
        @endphp
    @endforeach
@endif

@if (count($institutoras) > 0)
    @foreach ($institutoras as $institutora)
        @php
        $qtde = $institutora['qtde'];
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
                </div>
            </div>

            <br>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    
                    <div class="card uper">
                        <div class="card-body">
                            <h3>Relatório Personalizado</h3>
                            <div class="row">
                                <div class="col-md-1">
                                    &nbsp;
                                </div>
                                <div class="col-md-10">
                                    <div id="bar-chart" style="height: 400px;"></div>
                                </div>
                                <div class="col-md-1">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
            
                    <div class="card uper">
                        <div class="card-body">
                            <table class="table table-striped" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center"><b>Institutora</b></td>
                                    <td align="center" width="25%"><b>Total</b></td>
                                    <td align="center" width="25%"><b>%</b></td>
                                </tr>
        
                                @if (count($institutoras) > 0)
                                    @foreach ($institutoras as $institutora)
                                        @php
                                        $nome = $institutora['nome'];
                                        $qtde = $institutora['qtde'];
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

                    <br>
            
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
    <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
    <script src="{{ asset('Flot/jquery.flot.categories.js') }}"></script>
    <!-- Page script -->
    <script>
        $(function () {
            @php
            $total = 0;
            @endphp
            var bar_data = {
                data : [
                    @if (count($institutoras) > 0)
                        @foreach ($institutoras as $institutora)
                            @php
                            $qtde = $institutora['qtde'];
                            $nome = $institutora['nome'];
                            @endphp
                            ['{{ $nome }}', {{ $qtde }}],
                            @php
                            $total += $qtde;
                            @endphp
                        @endforeach
                    @endif
                ],
                color: '#3c8dbc'
            };
    
            $.plot('#bar-chart', [bar_data], {
                grid  : {
                    borderWidth: 1,
                    borderColor: '#f3f3f3',
                    tickColor  : '#f3f3f3'
                },
                series: {
                    bars: {
                        show    : true,
                        barWidth: 0.3,
                    }
                },
                xaxis : {
                    mode      : 'categories',
                    tickLength: 0
                }
            });
        });
    </script>
        
    </body>
</html>

