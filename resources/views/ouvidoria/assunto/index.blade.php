@extends('layouts.app')

@section('title', 'Assunto')

@section('javascript')
<script>
    top.urlDestroyAssunto = "{{ url('/assunto/') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/ouvidoria/assunto/index-assunto.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card uper">
                <div class="card-header">
                    Lista de Assuntos
                    <a href="{{ url('/assunto/create') }}" class="float-right" onclick="return validar()">
                        <i class="fa fa-plus"></i> Adicionar Assunto
                    </a>
                </div>
                <div class="card-body">

                    @if(session()->get('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    </div>
                    @endif

                    @php
                    $arrSituacao = array(
                        '0' => "Desativado",
                        '1' => "Ativado"
                    );
                    $bgColor = array(
                        '0' => "danger",
                        '1' => "success"
                    );
                    @endphp

                    <form id="formSearchAssunto" 
                        class="form-horizontal" role="form" method="POST" action="#">
                    <input type="hidden" id="_method" name="_method" value="">
                    @csrf

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Criado em</td>
                                <td>Descrição</td>
                                <td>Status</td>
                                <td colspan="3">Ações</td>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($assuntos) > 0)

                            @foreach($assuntos as $assunto)
                            <tr>
                                <td>{{ date('d/m/Y H:i:s', strtotime($assunto->created_at)) }}</td>
                                <td>{{ $assunto->assunto_descricao }}</td>
                                <td>
                                    <span class="badge badge-{{ $bgColor[$assunto->assunto_status] }}"
                                          data-toggle="tooltip" title="{{ $arrSituacao[$assunto->assunto_status] }}">
                                        {{ $arrSituacao[$assunto->assunto_status] }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('assunto.edit', $assunto->assunto_cod) }}" title="Editar" 
                                        class="btn btn-primary btn-sm" onclick="return validar()">
                                        Editar
                                    </a>
                                </td>
                                <td>
                                    @if ($assunto->assunto_status)
                                    <button class="btn btn-primary btn-sm" type="button" title="Desativar" 
                                        onclick="ativarDesativarAssunto({{ $assunto->assunto_cod }})">Desativar
                                    </button>
                                    @else
                                    <button class="btn btn-primary btn-sm" type="button" title="Ativar" 
                                        onclick="ativarDesativarAssunto({{ $assunto->assunto_cod }})">Ativar
                                    </button>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm" type="button" title="Excluir" 
                                        onclick="confirmDestroy({{ $assunto->assunto_cod }})" disabled>Excluir
                                    </button>
                                </td>
                            </tr>
                            @endforeach

                        @else
                            <tr>
                                <td colspan="6">Nenhum registro encontrado!</td>
                            </tr>
                        @endif

                        </tbody>
                    </table>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div style="margin-top: 23px;">{{ $assuntos->links() }}</div>
                        </div>
                    </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
