@extends('layouts.app')

@section('javascript')
<script>
    top.urlDestroyCanalAtendimento = "{{ url('/canal-atendimento/') }}";
</script>
<script type="text/javascript" src="{{ asset('/js/ouvidoria/canal-atendimento/index-canal-atendimento.js') }}"></script>
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
                Lista de Canais de Atendimentos
                <a href="{{ url('/canal-atendimento/create') }}" class="float-right" onclick="return validar()">
                    <i class="fa fa-plus"></i> Adicionar Canal de Atendimento
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

                <form id="formSearchCanalAtendimento" 
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
                    @if (count($canal_atendimentos) > 0)

                        @foreach($canal_atendimentos as $canal_atendimento)

                        <tr>
                            <td>{{ date('d/m/Y H:i:s', strtotime($canal_atendimento->created_at)) }}</td>
                            <td>{{ $canal_atendimento->descricao }}</td>
                            <td>
                                <span class="badge badge-{{ $bgColor[$canal_atendimento->status] }}"
                                        data-toggle="tooltip" title="{{ $arrSituacao[$canal_atendimento->status] }}">
                                    {{ $arrSituacao[$canal_atendimento->status] }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('canal-atendimento.edit', $canal_atendimento->id) }}" title="Editar" 
                                    class="btn btn-primary btn-sm" onclick="return validar()">
                                    Editar
                                </a>
                            </td>
                            <td>
                                @if ($canal_atendimento->status)
                                <button class="btn btn-primary btn-sm" type="button" title="Desativar" 
                                    onclick="ativarDesativarCanalAtendimento({{ $canal_atendimento->id }})">Desativar
                                </button>
                                @else
                                <button class="btn btn-primary btn-sm" type="button" title="Ativar" 
                                    onclick="ativarDesativarCanalAtendimento({{ $canal_atendimento->id }})">Ativar
                                </button>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" type="button" title="Excluir" 
                                    onclick="confirmDestroy({{ $canal_atendimento->id }})" disabled>Excluir
                                </button>
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
                        <div style="margin-top: 23px;">{{ $canal_atendimentos->links() }}</div>
                    </div>
                </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
