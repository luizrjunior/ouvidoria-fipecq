@php
$data_inicio = $data['data_inicio'] ? $data['data_inicio'] : date('01/m/Y');
$data_termino = $data['data_termino'] ? $data['data_termino'] : date('d/m/Y');
$y = 0;
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
<script src="{{ asset('Flot/jquery.flot.categories.js') }}"></script>
<!-- Page script -->
<script>
    $(function () {
        @php
        $i = 0;
        $total = 0;
        @endphp
        var bar_data = {
            data : [
            @if (count($institutoras) > 0)
                @foreach ($institutoras as $institutora)
                    @php
                    $qtde = $institutora['qtde'];
                    @endphp
                    [{{ $qtde }}, {{ $i }}],
                    @php
                    $i++;
                    $total += $qtde;
                    @endphp
                @endforeach
            @endif
            ],
            color: '#FFD700'
        };

        // Setup labels for use on the Y-axis  
        @php
        $i = 0;
        @endphp
        var tickLabels = [
            @if (count($institutoras) > 0)
                @foreach ($institutoras as $institutora)
                    @php
                    $nome = $institutora['nome'];
                    @endphp
                    [{{ $i }}, '{{ $nome }}'],
                    @php
                    $i++;
                    @endphp
                @endforeach
            @endif
        ];

        $.plot('#bar-chart', [bar_data], {
            grid  : {
                borderWidth: 1,
                borderColor: '#f3f3f3',
                tickColor  : '#f3f3f3'
            },
            series: {
                bars: {
                    show    : true,
                    horizontal: true,
                    barWidth: 0.3,
                    align   : 'center'
                }
            },
            yaxis : {
                ticks: tickLabels
            }
        });
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
        <a class="nav-link" href="#" onclick="abrirRelatorio('2')">Tempo de Espera</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="#">Instituidora</a>
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
            role="form" method="POST" action="{{ route('relatorio.institutora') }}">
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
                    <h3>Total Por Instituidora</h3>
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

            <div class="card uper">
                <div class="card-body">
                    <table class="table table-striped" cellspacing="0" width="100%">
                        <tr>
                            <td align="center"><b>Instituidora</b></td>
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
