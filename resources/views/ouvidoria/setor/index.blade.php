@extends('layouts.app')

@section('javascript')
<script>
    top.urlListaSetores = "{{ url('/setor') }}";
    top.urlAtivarDesativarSetor = "{{ url('/setor/ativar-desativar-setor') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/ouvidoria/setor/index-setor.js') }}"></script>
@endsection

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="row justify-content-center">
    <div class="col-md-12">

        <div class="card uper">
            <div class="card-header">
                Lista de Setores / Áreas
                <a href="{{ url('/setor/create') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-plus"></i> Adicionar Setor / Área
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

                <form id="formSearchSetor" 
                    class="form-horizontal" role="form" method="POST" action="#">
                <input type="hidden" id="_method" name="_method" value="">
                @csrf

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Criado em</td>
                            <td>Categoria</td>
                            <td>Descrição</td>
                            <td>Status</td>
                            <td colspan="3">Ações</td>
                        </tr>
                    </thead>
                    <tbody>
                    @if (count($setores) > 0)

                        @foreach($setores as $setor)

                        <tr>
                            <td>{{ date('d/m/Y H:i:s', strtotime($setor->created_at)) }}</td>
                            <td>{{ $setor->categoria->descricao }}</td>
                            <td>{{ $setor->descricao }}</td>
                            <td>
                                <span class="badge badge-{{ $bgColor[$setor->status] }}"
                                        data-toggle="tooltip" title="{{ $arrSituacao[$setor->status] }}">
                                    {{ $arrSituacao[$setor->status] }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('setor.edit', $setor->id) }}" title="Editar" 
                                    class="btn btn-primary btn-sm" onclick="return validar()">
                                    Editar
                                </a>
                            </td>
                            <td>
                                @if ($setor->status)
                                <button class="btn btn-primary btn-sm" type="button" title="Desativar" 
                                    onclick="ativarDesativarSetor({{ $setor->id }})"> Desativar
                                </button>
                                @else
                                <button class="btn btn-primary btn-sm" type="button" title="Ativar" 
                                    onclick="ativarDesativarSetor({{ $setor->id }})"> Ativar
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                    @else
                        <tr>
                            <td colspan="7">Nenhum registro encontrado!</td>
                        </tr>
                    @endif

                    </tbody>
                </table>

                <div class="form-group row">
                    <div class="col-md-12">
                        <div style="margin-top: 23px;">{{ $setores->links() }}</div>
                    </div>
                </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
