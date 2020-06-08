@extends('layouts.app')

@php
$route = route('ouvidoria.update');
$routeEditCombo = route('ouvidoria.edit-combo');
@endphp

@section('javascript')
<script type="text/javascript">
    top.routeUpdate = '{{ $route }}';
    top.routeEditCombo = '{{ $routeEditCombo }}';
</script>
<script type="text/javascript" 
    src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" 
    src="{{ asset('/js/ouvidoria/ouvidoria/cad-ouvidoria.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>

@php
$ouvidoria_id = $errors->has('ouvidoria_id') ? old('ouvidoria_id') : $ouvidoria->id;
$tipo_ouvidoria_id = $errors->has('tipo_ouvidoria_id') ? old('tipo_ouvidoria_id') : $ouvidoria->tp_ouvidoria_id;
$canal_atendimento_id = $errors->has('canal_atendimento_id') ? old('canal_atendimento_id') : $ouvidoria->canal_atendimento_id;

$categoria_id = $errors->has('categoria_id') ? old('categoria_id') : $ouvidoria->categoria_id;
$setor_id = $errors->has('setor_id') ? old('setor_id') : $ouvidoria->setor_id;
$assunto_id = $errors->has('assunto_id') ? old('assunto_id') : $ouvidoria->assunto_id;
$classificacao_id = $errors->has('classificacao_id') ? old('classificacao_id') : $ouvidoria->classificacao_id;
$sub_classificacao_id = $errors->has('sub_classificacao_id') ? old('sub_classificacao_id') : $ouvidoria->sub_classificacao_id;

$observacao = $errors->has('observacao') ? old('observacao') : $ouvidoria->observacao;
$mensagem = $errors->has('mensagem') ? old('mensagem') : $ouvidoria->mensagem;
$anexo = $errors->has('anexo') ? old('anexo') : $ouvidoria->anexo;

$solicitante_id = $errors->has('solicitante_id') ? old('solicitante_id') : $ouvidoria->solicitante_id;
if ($solicitante_id != "") {
    $email = $errors->has('email') ? old('email') : $ouvidoria->solicitante->email;
    $telefone = $errors->has('telefone') ? old('telefone') : $ouvidoria->solicitante->telefone;
    $celular = $errors->has('celular') ? old('celular') : $ouvidoria->solicitante->celular;
}
@endphp

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card uper">
            <div class="card-header">
                Administração - Detalhes
                <a href="{{ url('/ouvidoria') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <form id="formSolicitacaoOuvidoria" method="POST" action="{{ $route }}" autocomplete="off">
                    @csrf

                    <input type="hidden" id="ouvidoria_id" name="ouvidoria_id" value="{{ $ouvidoria_id }}">

                    @php
                    $ouvidoriaController = new \App\Http\Controllers\OuvidoriaController();

                    $parte_data1 = explode("-", date('Y-m-d', strtotime($ouvidoria->created_at)));
                    $anoinicial = $parte_data1['0'];
                    $mesinicial = $parte_data1['1'];
                    $diainicial = $parte_data1['2'];
                    //Concatena em um Novo Formato de DATA
                    $datainicial = $anoinicial."-".$mesinicial."-".$diainicial;

                    $parte_data2 = explode("-", date('Y-m-d'));
                    $anofinal = $parte_data2['0'];
                    $mesfinal = $parte_data2['1'];
                    $diafinal = $parte_data2['2'];
                    //Concatena em um Novo Formato de DATA
                    $datafinal = $anofinal."-".$mesfinal."-".$diafinal;

                    $diasUteis = $ouvidoriaController->corre_anos($anoinicial, $anofinal, $mesinicial, $mesfinal, $datainicial, $datafinal);
                    @endphp

                    <div class="row form-group">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td><b>Protocolo N°</b></td>
                                        <td><b>Solicitação</b></td>
                                        <td><b>Solicitante</b></td>
                                        <td><b>Nome</b></td>
                                        <td><b>Criado em</b></td>
                                        <td><b>Dias Úteis</b></td>
                                        <td><b>Situação</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ str_pad($ouvidoria->protocolo, 13, 0, STR_PAD_LEFT) }}</td>
                                        <td>{{ $ouvidoria->tipoOuvidoria->nome }}</td>
                                        <td>{{ $ouvidoria->tipoSolicitante->descricao }}</td>
                                        <td>{{ $solicitante_id != "" ? $ouvidoria->solicitante->nome : "ANÔNIMO" }}</td>
                                        <td>{{ date('d/m/Y', strtotime($ouvidoria->created_at)) }}</td>
                                        <td align="right">{{ str_pad($diasUteis, 2, 0, STR_PAD_LEFT) }}</td>
                                        <td>
                                            <h5>
                                                <span class="badge badge-pill badge-{{ $ouvidoria->situacao->cor }}" style="width: 100%;">
                                                    {{ $ouvidoria->situacao->nome }}
                                                </span>
                                            </h5>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($solicitante_id != "")
                    <h5>Dados Pessoais</h5>
                    <hr>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="email" class="control-label">E-mail</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="email" name="email" 
                                value="{{ $email }}" disabled />
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="telefone" class="control-label">Telefone</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="telefone" name="telefone" 
                                value="{{ $telefone }}" disabled />
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="celular" class="control-label">Celular</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="celular" name="celular" 
                                value="{{ $celular }}" disabled />
                        </div>
                    </div>
                    <br>
                    @endif
                    
                    <h5>Canal de Atendimento</h5>
                    <hr>
                    
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="canal_atendimento_id" class="control-label">Manifestação encaminhada por:</label>
                            <select id="canal_atendimento_id" name="canal_atendimento_id" class="form-control">
                                @foreach ($canaisAtendimentos as $canalAtendimento)
                                    @php $selected = ""; @endphp
                                    @if ($canalAtendimento->id == $canal_atendimento_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $canalAtendimento->id }}" {{ $selected }}>
                                        {{ strtoupper($canalAtendimento->descricao) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="tipo_ouvidoria_id" class="control-label">Tipo da Solicitação</label>
                            <select id="tipo_ouvidoria_id" name="tipo_ouvidoria_id" class="form-control">
                                @foreach ($tiposOuvidorias as $tipoOuvidoria)
                                    @php $selected = ""; @endphp
                                    @if ($tipoOuvidoria->id == $tipo_ouvidoria_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $tipoOuvidoria->id }}" {{ $selected }}>
                                        {{ strtoupper($tipoOuvidoria->nome) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="observacao" class="control-label">Observação:</label>
                            <textarea class="form-control" rows="5" id="observacao" name="observacao" 
                                class="form-control">{{ $observacao }}</textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <small class="form-text text-muted">
                                Sua observação tem <span class="caracteresObservacao">600</span> caracteres restantes
                            </small>
                        </div>
                    </div>

                    <br>
                    <h5>Mensagem @if ($anexo != "")e Anexo @endif</h5>
                    <hr>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <textarea class="form-control" rows="5" id="mensagem" name="mensagem" 
                                class="form-control" disabled>{{ $mensagem }}</textarea>
                        </div>
                    </div>

                    @if ($anexo != "") 
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="anexo" class="control-label">Anexo</label>
                        </div>
                        <div class="col-md-9">
                            Abrir arquivo anexo <a href="{{ url("storage/anexos/{$anexo}") }}" target="_blank">clique aqui.</a>
                        </div>
                    </div>
                    @endif

                    <br>
                    <h5>Classificação: Atendimento Parceiro FIPECq Vida</h5>
                    <hr>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="categoria_id" class="control-label">Categoria</label>
                            <select id="categoria_id" name="categoria_id" class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                                @foreach ($categorias as $categoria)
                                    @php $selected = ""; @endphp
                                    @if ($categoria->id == $categoria_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $categoria->id }}" {{ $selected }}>
                                        {{ strtoupper($categoria->descricao) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="setor_id" class="control-label">Setor / Área</label>
                            <select id="setor_id" name="setor_id" 
                                class="form-control">
                                <option value="">- - SELECIONE - -</option>
                                @foreach ($setores as $setor)
                                    @php $selected = ""; @endphp
                                    @if ($setor->id == $setor_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                <option value="{{ $setor->id }}" {{ $selected }}>{{ $setor->descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="assunto_id" class="control-label">Assunto</label>
                            <select id="assunto_id" name="assunto_id" class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                                @foreach ($assuntos as $assunto)
                                    @php $selected = ""; @endphp
                                    @if ($assunto->id == $assunto_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $assunto->id }}" {{ $selected }}>
                                        {{ strtoupper($assunto->descricao) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="classificacao_id" class="control-label">Classificação</label>
                            <select id="classificacao_id" name="classificacao_id" 
                                class="form-control">
                                <option value="">- - SELECIONE - -</option>
                                @foreach ($classificacoes as $classificacao)
                                    @php $selected = ""; @endphp
                                    @if ($classificacao->id == $classificacao_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                <option value="{{ $classificacao->id }}" {{ $selected }}>{{ $classificacao->descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="sub_classificacao_id" class="control-label">Subclassificação</label>
                            <select id="sub_classificacao_id" name="sub_classificacao_id" class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                                @foreach ($subClassificacoes as $subclassificacao)
                                    @php $selected = ""; @endphp
                                    @if ($subclassificacao->id == $sub_classificacao_id)
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $subclassificacao->id }}" {{ $selected }}>
                                        {{ strtoupper($subclassificacao->descricao) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br>
                    <h5>Situação Atual e Comentário</h5>
                    <hr>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class="control-label">Situação Atual</label>
                        </div>
                        <div class="col-md-9">
                            @if ($ouvidoria)
                            <h3>
                                <span class="badge badge-pill badge-{{ $ouvidoria->situacao->cor }}" style="width: 50%;">
                                    {{ $ouvidoria->situacao->nome }}
                                </span>
                            </h3>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label for="created_at" class="control-label">Data Hora</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="created_at" name="created_at" 
                                value="{{ date('d/m/Y H:i:s', strtotime($situacaoOuvidoria->created_at)) }}" disabled />
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="comentarioDisable" class="control-label">Comentário:</label>
                            <textarea class="form-control" rows="5" id="comentarioDisable" name="comentarioDisable" 
                                class="form-control" disabled>{{ $situacaoOuvidoria->comentario }}</textarea>
                        </div>
                    </div>

                    <br>
                    <h5>Situação - Definir situação da mensagem:</h5>
                    <hr>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="situacao_id" class="control-label">Definir Situação:</label>
                            <select id="situacao_id" name="situacao_id" class="form-control">
                                <option value=""> -- SELECIONE -- </option>
                                @foreach ($situacoes as $situacao)
                                    <option value="{{ $situacao->id }}">{{ strtoupper($situacao->nome) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="comentario" class="control-label">Digite aqui sua mensagem:</label>
                            <textarea class="form-control" rows="5" id="comentario" name="comentario" 
                                class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <small class="form-text text-muted">
                                Sua mensagem tem <span class="caracteresComentario">1200</span> caracteres restantes
                            </small>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <span class="float-right text-danger">
                                <button type="submit" class="btn btn-primary" onclick="return validar();">
                                    <i class="fa fa-refresh"></i> Atualizar
                                </button>
                            </span>
                            <span class="float-right text-danger">
                                <button type="button" class="btn btn-danger" onclick="location.href='{{ url('/ouvidoria') }}';">
                                    <i class="fa fa-arrow-left"></i> Voltar
                                </button>&nbsp;
                            </span>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
