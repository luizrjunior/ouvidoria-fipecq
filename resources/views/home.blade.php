@extends('layouts.app')

@section('javascript')
<script type="text/javascript">
    top.urlFaleComOuvidor = "{{ url('/fale-com-ouvidor') }}";
    top.urlCartaServico = "{{ url('/carta-servico') }}";
</script>
<script type="text/javascript" 
    src="{{ asset('/js/plugins/jquery.maskedinput.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/home.js') }}"></script>
@endsection

@section('content')

<div class="panel-body">

    @if (Session('message'))
    <!-- Alert -->
    <div id="_sent_ok_" class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Alerta!</h4>
        <span id="_msg_txt_">{{ Session('message') }}</span>
    </div>
    <!-- /Alert -->
    @endif
    
	@if (Session('success'))
	<!-- Alert -->
	<div id="_sent_ok_" class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-check"></i> Alerta!</h4>
		<span id="_msg_txt_">{!! Session('success') !!}</span>
	</div>
	<!-- /Alert -->
	@endif

    <!-- Main row -->
    <div class="row">

        <!-- Left col -->
        <section class="col-lg-8 connectedSortable">

            <div class="row">
                <div class="col-md-12">
                    <h3>Bem Vindo a Ouvidoria da FIPECq Vida</h3>
                    <br/>
                    A Ouvidoria da FIPECq Vida foi inaugurada em junho de 2014, e desde então, tem sido uma importante ferramenta de comunicação entre nosso Associado e a gestão da Caixa de Assistência. Por meio da Ouvidoria o usuário poderia enviar elogios, sugestões, denúncias, pedidos de informação, solicitação e reclamações inerentes aos serviços prestados pela Caixa de Assistência Social da FIPECq Vida e seus parceiros, que por algum motivo, não puderam ser solucionadas pelos habituais canais de atendimento.
                    <br/><br/>
                    A Ouvidoria tem a responsabilidade de representar a voz dos usuários (Associados, parceiros, fornecedores, funcionários etc.) dentro da FIPECq Vida, propondo melhorias contínuas, sugerindo ações e soluções para tornar a gestão da FIPECq Vida mais transparente, ética e social.
                    <br/><br/>
                </div>
            </div>

            <form id="formSearchSolicitacaoOuvidoria" 
                class="form-horizontal" role="form" method="POST" action="{{ route('ouvidoria.acompanhar') }}">
                @csrf

                <div class="row">
                    
                    <div class="col-md-6">
                        <button id="btnFaleComOuvidor" type="button" class="btn btn-danger" style="width: 100%;">
                            <i class="fas fa-phone-volume"></i>&nbsp;
                            Fale com o ouvidor
                        </button>
                    </div>

                    <div class="col-md-6">
                        <div id="divInputProtocolo" style="display: none;">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">
                                      <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="protocolo_psq" name="protocolo_psq" placeholder="Protocolo Nº" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div id="divInputCPF" style="display: none;">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">
                                      <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="cpf_psq" name="cpf_psq" placeholder="CPF Nº" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="inlineRadio1" name="docC" value="prot" onclick="showProtocoloCPF();" checked />
                            <label class="form-check-label" for="inlineRadio1">Protocolo</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="inlineRadio2" name="docC" value="cpf" onclick="showProtocoloCPF();" />
                            <label class="form-check-label" for="inlineRadio2">CPF</label>
                        </div>

                    </div>
                </div>
            
                <div class="row">

                    <div class="col-md-6">
                        <button id="btnCartaServico" type="button" class="btn btn-warning" style="width: 100%;">
                            <i class="far fa-file-alt"></i>&nbsp;
                            Carta de Serviço
                        </button>
                    </div>

                    <div class="col-md-6">
                        <button type="submit" class="btn btn-dark" style="width: 100%;" onclick="return validar()">
                            Acompanhe sua demanda
                        </button>
                    </div>
                </div>

            </form>
        
        </section>
        <!-- /.Left col -->

        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-4 connectedSortable">

            <div class="card border-danger mb-3" style="max-width: 18rem;">
              <div class="card-body text-danger" style="text-align:center;">
                <h5 class="card-title"><span class="badge badge-pill badge-danger">Missão</span></h5>
                <p class="card-text">Acolher e apoiar os seus associados na busca pela saúde e bem-estar de forma humanizada.</p>
              </div>
            </div>

            <div class="card border-primary mb-3" style="max-width: 18rem;">
                <div class="card-body text-primary" style="text-align:center;">
                  <h5 class="card-title"><span class="badge badge-pill badge-primary">Visão</span></h5>
                  <p class="card-text">Ser referência como meio efetivo de participação dos associados, a fim de aperfeiçoar continuamente os serviços prestados pela FIPECq Vida.</p>
                </div>
            </div>

            <div class="card border-warning mb-3" style="max-width: 18rem;">
              <div class="card-body text-warning" style="text-align:center;">
                <h5 class="card-title"><span class="badge badge-pill badge-warning">Valores</span></h5>
                <p class="card-text">Ética, respeito, transparência, responsabilidade, imparcialidade e solidariedade.</p>
              </div>
            </div>

        </section>
        <!-- right col -->

    </div>   
    <!-- /.row (main row) -->
</div>

@endsection
