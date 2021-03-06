@php
$qtdeResposta_1_1 = 0;
$qtdeResposta_1_2 = 0;
$qtdeResposta_1_3 = 0;

$qtdeResposta_2_1 = 0;
$qtdeResposta_2_2 = 0;
$qtdeResposta_2_3 = 0;
@endphp
@if (count($pesquisasSatisfacao) > 0)
    @foreach ($pesquisasSatisfacao as $pesquisaSatisfacao)
        @if ((int) $pesquisaSatisfacao->resposta_1 == 1)
            @php
            $qtdeResposta_1_1++;
            @endphp
        @endif
        @if ((int) $pesquisaSatisfacao->resposta_1 == 2)
            @php
            $qtdeResposta_1_2++;
            @endphp
        @endif
        @if ((int) $pesquisaSatisfacao->resposta_1 == 3)
            @php
            $qtdeResposta_1_3++;
            @endphp
        @endif
        
        @if ((int) $pesquisaSatisfacao->resposta_2 == 1)
            @php
            $qtdeResposta_2_1++;
            @endphp
        @endif
        @if ((int) $pesquisaSatisfacao->resposta_2 == 2)
            @php
            $qtdeResposta_2_2++;
            @endphp
        @endif
        @if ((int) $pesquisaSatisfacao->resposta_2 == 3)
            @php
            $qtdeResposta_2_3++;
            @endphp
        @endif
        
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
                    <h3>Pesquisa de Satisfação</h3>
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
                                    <div id="bar-chart" style="height: 400px;"></div>
                                </div>
                                <div class="col-md-1">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="row" style="text-align:center;">
                                <div class="col-md-2">
                                    &nbsp;
                                </div>
                                <div class="col-md-4 border-right">
                                    Sua demanda foi atendida?
                                </div>
                                <div class="col-md-4">
                                    Como você avalia o atendimento recebido pela Ouvidoria da FIPECq Vida?
                                </div>
                                <div class="col-md-2">
                                    &nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="card uper">
                        <div class="card-body">
                            <table class="table table-hover table-bordered" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center"><b>Pergunta</b></td>
                                    <td align="center" width="25%"><b>Resposta</b></td>
                                    <td align="center" width="25%"><b>Quantidade</b></td>
                                </tr>
                                <tr>
                                    <td rowspan="4"><br><br>Sua demanda foi atendida?</td>
                                </tr>
                                <tr>
                                    <td align="center">Sim</td>
                                    <td align="center">{{ str_pad($qtdeResposta_1_1, 2, 0, STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <td align="center">Não</td>
                                    <td align="center">{{ str_pad($qtdeResposta_1_2, 2, 0, STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <td align="center">Parcialmente Atendida</td>
                                    <td align="center">{{ str_pad($qtdeResposta_1_3, 2, 0, STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <td rowspan="4"><br><br>Como você avalia o atendimento recebido pela Ouvidoria da FIPECq Vida?</td>
                                </tr>
                                <tr>
                                    <td align="center">Satisfeito</td>
                                    <td align="center">{{ str_pad($qtdeResposta_2_1, 2, 0, STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <td align="center">Insatisfeito</td>
                                    <td align="center">{{ str_pad($qtdeResposta_2_2, 2, 0, STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <td align="center">Totalmente Insatisfeito</td>
                                    <td align="center">{{ str_pad($qtdeResposta_2_3, 2, 0, STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td></td>
                                    <td align="center">{{ str_pad($qtdeResposta_1_1 + $qtdeResposta_1_2 + $qtdeResposta_1_3 + $qtdeResposta_2_1 + $qtdeResposta_2_2 + $qtdeResposta_2_3, 2, 0, STR_PAD_LEFT) }}</td>
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
            * BAR CHART
            * ---------
            */
            var bar_data = {
                data : [
                    ['Sim', {{ $qtdeResposta_1_1 }}], 
                    ['Não', {{ $qtdeResposta_1_3 }}], 
                    ['Parcialmente Atendida', {{ $qtdeResposta_1_3 }}], 
                    ['Satisfeito', {{ $qtdeResposta_2_1 }}], 
                    ['Insatisfeito', {{ $qtdeResposta_2_2 }}], 
                    ['Totalmente Insatisfeito', {{ $qtdeResposta_2_3 }}]
                ],
                color: '#3c8dbc'
            }
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
                        align   : 'center'
                    }
                },
                xaxis : {
                    mode      : 'categories',
                    tickLength: 0
                }
            });
            /* END BAR CHART */

        });
    </script>

    </body>
</html>

