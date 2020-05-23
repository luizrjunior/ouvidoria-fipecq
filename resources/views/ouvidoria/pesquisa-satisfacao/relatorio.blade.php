@extends('layouts.app')

@section('javascript')
<script type="text/javascript" 
    src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" 
    src="{{ asset('/js/ouvidoria/pesquisa-satisfacao/relatorio-pesquisa-satisfacao.js') }}"></script>
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
@endsection

@section('content')
@php
$resposta_1_psq = "";
$resposta_2_psq = "";
$data_inicio = date('01/m/Y');
$data_termino = date('d/m/Y');
@endphp
@if (isset($data))
    @php
    $resposta_1_psq = $data['resposta_1_psq'];
    $resposta_2_psq = $data['resposta_2_psq'];
    $data_inicio = $data['data_inicio'];
    $data_termino = $data['data_termino'];
    @endphp
@endif

<style>
  .uper {
    margin-top: 40px;
  }
</style>

@if (Session('success'))
<!-- Alert -->
<div id="_sent_ok_" class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i> Alerta!</h4>
    <span id="_msg_txt_">{!! Session('success') !!}</span>
</div>
<!-- /Alert -->
@endif

<div class="row justify-content-center">
    <div class="col-md-12">
        
        <form id="formRelatorioPesquisaSatisfacao" 
            class="form-horizontal" role="form" method="POST" action="{{ route('pesquisa-satisfacao.relatorio') }}">
            @csrf
            <input type="hidden" id="print" name="print" value="">

            <div class="card uper">
                <div class="card-header">
                    Filtros de Pesquisa
                </div>
                <div class="card-body">

                    {{-- <div class="form-group row">
                        <div class="col-md-6" id="divFormNameEmail">
                            <label for="resposta_1_psq" class="control-label">Sua demanda foi atendida?:</label>
                            <br>&nbsp;
                            <select id="resposta_1_psq" name="resposta_1_psq" 
                                class="form-control">
                                @foreach ($respostas_1 as $resposta_1)
                                    @php $selected = ""; @endphp
                                    @if ($resposta_1['id'] == $resposta_1_psq)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                <option value="{{ $resposta_1['id'] }}" {{ $selected }}>{{ $resposta_1['nome'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="resposta_2_psq" class="control-label">Como você avalia o atendimento recebido pela Ouvidoria da FIPECq Vida?:</label>
                            <select id="resposta_2_psq" name="resposta_2_psq" 
                                class="form-control">
                                @foreach ($respostas_2 as $resposta_2)
                                    @php $selected = ""; @endphp
                                    @if ($resposta_2['id'] == $resposta_2_psq)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                <option value="{{ $resposta_2['id'] }}" {{ $selected }}>{{ $resposta_2['nome'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}

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
