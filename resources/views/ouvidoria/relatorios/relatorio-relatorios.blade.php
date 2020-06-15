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
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="{{ asset('Flot/jquery.flot.pie.js') }}"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="{{ asset('Flot/jquery.flot.categories.js') }}"></script>
@endsection

@section('content')
@php
$data_inicio = date('01/m/Y');
$data_termino = date('d/m/Y');
@endphp
@if (isset($data))
    @php
    $data_inicio = $data['data_inicio'];
    $data_termino = $data['data_termino'];
    @endphp
@endif

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
        <a class="nav-link" href="#" onclick="abrirRelatorio('3')">Institutora</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="#">Relatórios</a>
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
            role="form" method="POST" action="{{ route('relatorio.relatorios') }}">
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
                            <div class="form-check custom-control-inline">
                                <input class="form-check-input" type="checkbox" value="{{ $tipoOuvidoria->id }}" 
                                    id="tipo_ouvidoria_id_psq" name="tipo_ouvidoria_id_psq[]" {{ $checked }}>
                                <label class="form-check-label" for="anonima">{{ $tipoOuvidoria->nome }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="checkbox" class="control-label">Institutoras</label>
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
                            <div class="col-md-5 custom-control-inline">
                                <input class="form-check-input" type="checkbox" value="{{ $institutora->empresa }}" 
                                    id="institutora_id_psq" name="institutora_id_psq[]" {{ $checked }}>
                                <label class="form-check-label" for="anonima">{{ $primeiroNome }}</label>
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

                </div>
            </div>

        </form>

    </div>
</div>
@endsection
