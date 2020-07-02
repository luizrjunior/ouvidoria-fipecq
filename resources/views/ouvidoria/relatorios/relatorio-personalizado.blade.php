@php
$routeCarregarSetores = route('ouvidoria.carrregar-setores');
$routeCarregarAssuntos = route('ouvidoria.carrregar-assuntos');
$routeCarregarClassificacoes = route('ouvidoria.carrregar-classificacoes');
$routeCarregarSubClassificacoes = route('ouvidoria.carrregar-sub-classificacoes');

$data_inicio = $data['data_inicio'];
$data_termino = $data['data_termino'];

$tipo_ouvidoria_id_psq = $data['tipo_ouvidoria_id_psq'];
$tipo_solicitante_id_psq = $data['tipo_solicitante_id_psq'];

$categoria_id_psq = $data['categoria_id_psq'];

$setor_id_psq = $data['setor_id_psq'];
$assunto_id_psq = $data['assunto_id_psq'];

$classificacao_id_psq = $data['classificacao_id_psq'];
$sub_classificacao_id_psq = $data['sub_classificacao_id_psq'];

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

    top.routeCarregarSetores = '{{ $routeCarregarSetores }}';
    top.routeCarregarAssuntos = '{{ $routeCarregarAssuntos }}';
    top.routeCarregarClassificacoes = '{{ $routeCarregarClassificacoes }}';
    top.routeCarregarSubClassificacoes = '{{ $routeCarregarSubClassificacoes }}';

    top.valorCategoria = '{{ $categoria_id_psq }}';
    top.valorSetor = '{{ $setor_id_psq }}';
    top.valorAssunto = '{{ $assunto_id_psq }}';
    top.valorClassificacao = '{{ $classificacao_id_psq }}';
    top.valorSubClassificacao = '{{ $sub_classificacao_id_psq }}';
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
        <a class="nav-link" href="#" onclick="abrirRelatorio('4')">Instituidora Comparativo</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="#">Relatório Personalizado</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="abrirRelatorio('6')">Relatório Comparativo</a>
    </li>
</ul>

<div class="row justify-content-center">
    <div class="col-md-12">
        
        <form id="formRelatorios" class="form-horizontal" 
            role="form" method="POST" action="{{ route('relatorio.relatorio-personalizado') }}">
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
                            <label for="tipo_ouvidoria_id_psq" class="control-label">Tipo de Solicitação</label>
                            <select id="tipo_ouvidoria_id_psq" name="tipo_ouvidoria_id_psq" 
                                class="form-control {{ $errors->has('tipo_ouvidoria_id_psq') ? 'is-invalid' : '' }}">
                                <option value=""> -- SELECIONE -- </option>
                                @foreach ($tiposOuvidorias as $tipoOuvidoria)
                                    @php $selected = ""; @endphp
                                    @if ($tipoOuvidoria->id == $tipo_ouvidoria_id_psq)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $tipoOuvidoria->id }}" {{$selected}}>{{ $tipoOuvidoria->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tipo_solicitante_id_psq" class="control-label">Tipo de Solicitante</label>
                            <select id="tipo_solicitante_id_psq" name="tipo_solicitante_id_psq" 
                                class="form-control {{ $errors->has('tipo_solicitante_id_psq') ? 'is-invalid' : '' }}">
                                <option value=""> -- SELECIONE -- </option>
                                @foreach ($tiposSolicitantes as $tipoSolicitante)
                                    @php $selected = ""; @endphp
                                    @if ($tipoSolicitante->id == $tipo_solicitante_id_psq)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                <option value="{{$tipoSolicitante->id}}" {{$selected}}>{{$tipoSolicitante->descricao}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
        
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="categoria_id_psq" class="control-label">Categoria</label>
                            <select id="categoria_id_psq" name="categoria_id_psq" class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                                @foreach ($categorias as $categoria)
                                    @php $selected = ""; @endphp
                                    @if ($categoria->id == $categoria_id_psq)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $categoria->id }}" {{ $selected }}>
                                        {{ strtoupper($categoria->descricao) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="setor_id_psq" class="control-label">Setor / Área</label>
                            <select id="setor_id_psq" name="setor_id_psq" 
                                class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="assunto_id_psq" class="control-label">Assunto</label>
                            <select id="assunto_id_psq" name="assunto_id_psq" class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                            </select>
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="classificacao_id_psq" class="control-label">Classificação</label>
                            <select id="classificacao_id_psq" name="classificacao_id_psq" 
                                class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="sub_classificacao_id_psq" class="control-label">Subclassificação</label>
                            <select id="sub_classificacao_id_psq" name="sub_classificacao_id_psq" class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                            </select>
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
