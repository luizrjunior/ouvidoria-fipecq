@extends('layouts.app')

@section('javascript')
<script>
    top.urlListaCategorias = "{{ url('/categoria/') }}";
    top.urlAtivarDesativarCategoria = "{{ url('/categoria/ativar-desativar-categoria') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/ouvidoria/categoria/index-categoria.js') }}"></script>
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
                    Lista de Categorias
                    <a href="{{ url('/categoria/create') }}" class="float-right" onclick="return validar()">
                        <i class="fa fa-plus"></i> Adicionar Categoria
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

                    <form id="formSearchCategoria" class="form-horizontal" role="form" method="POST" action="#">
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
                            @if (count($categorias) > 0)
                                @foreach($categorias as $categoria)
                                <tr>
                                    <td>{{ date('d/m/Y H:i:s', strtotime($categoria->created_at)) }}</td>
                                    <td>{{ $categoria->descricao }}</td>
                                    <td>
                                        <span class="badge badge-{{ $bgColor[$categoria->status] }}"
                                            data-toggle="tooltip" title="{{ $arrSituacao[$categoria->status] }}">
                                            {{ $arrSituacao[$categoria->status] }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('categoria.edit', $categoria->id) }}" title="Editar" 
                                            class="btn btn-primary btn-sm" onclick="return validar()">
                                            <i class="fa fa-btn fa-edit"></i> Editar
                                        </a>
                                    </td>
                                    <td>
                                        @if ($categoria->status)
                                        <button class="btn btn-primary btn-sm" type="button" title="Desativar" 
                                            onclick="ativarDesativarCategoria({{ $categoria->id }})"> Desativar
                                        </button>
                                        @else
                                        <button class="btn btn-primary btn-sm" type="button" title="Ativar" 
                                            onclick="ativarDesativarCategoria({{ $categoria->id }})"> Ativar
                                        </button>
                                        @endif
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
                                <div style="margin-top: 23px;">{{ $categorias->links() }}</div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
