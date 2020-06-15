@php
$y = 0;
$total = 0;
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

@if (count($tiposSolicitacao) > 0)
    @foreach ($tiposSolicitacao as $tipoSolicitacao)
        @php
        $qtde = $tipoSolicitacao['dias'] / $tipoSolicitacao['qtde'];
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
                            <h3>Tempo de Espera Por Tipo de Solicitação</h3>
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

                    <br>
            
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
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="{{ asset('Flot/jquery.flot.pie.js') }}"></script>
    <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
    <script src="{{ asset('Flot/jquery.flot.categories.js') }}"></script>
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
    
    </body>
</html>

