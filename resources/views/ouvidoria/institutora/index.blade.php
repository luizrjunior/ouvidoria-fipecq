@extends('layouts.app')

@section('javascript')
<script>
    top.urlListaInstitutoras = "{{ url('/institutora/') }}";
    top.urlAtivarDesativarInstitutora = "{{ url('/assunto/ativar-desativar-institutora') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/ouvidoria/institutora/index-institutora.js') }}"></script>
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
                    Lista de Institutoras
                    <a href="{{ url('/institutora/create') }}" class="float-right" onclick="return validar()">
                        <i class="fa fa-plus"></i> Adicionar Institutora
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

                    <form id="formSearchInstitutora" 
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
                        @if (count($institutoras) > 0)

                            @foreach($institutoras as $institutora)
                            <tr>
                                <td>{{ date('d/m/Y H:i:s', strtotime($institutora->created_at)) }}</td>
                                <td>{{ $institutora->descricao }}</td>
                                <td>
                                    <span class="badge badge-{{ $bgColor[$institutora->status] }}"
                                          data-toggle="tooltip" title="{{ $arrSituacao[$institutora->status] }}">
                                        {{ $arrSituacao[$institutora->status] }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('institutora.edit', $institutora->id) }}" title="Editar" 
                                        class="btn btn-primary btn-sm" onclick="return validar()">
                                        Editar
                                    </a>
                                </td>
                                <td>
                                    @if ($institutora->status)
                                    <button class="btn btn-primary btn-sm" type="button" title="Desativar" 
                                        onclick="ativarDesativarInstitutora({{ $institutora->id }})"> Desativar
                                    </button>
                                    @else
                                    <button class="btn btn-primary btn-sm" type="button" title="Ativar" 
                                        onclick="ativarDesativarInstitutora({{ $institutora->id }})"> Ativar
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
                            <div style="margin-top: 23px;">{{ $institutoras->links() }}</div>
                        </div>
                    </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
