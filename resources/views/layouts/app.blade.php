<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Ouvidoria - FIPECqVida">
    <meta name="author" content="Luiz Roberto Teixeira Reis Junior">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <title>Caixa de Assistência Social da FIPECq - FIPECq Vida - Ouvidoria</title>

    <!-- Bootstrap core CSS -->
    {{-- <link href="{{ asset('bootstrap/4.4.1/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/pricing.css') }}" rel="stylesheet">

    <!-- Styles Extras -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('bootstrap/4.4.1/css/bootstrap-datepicker.css') }}" rel="stylesheet"/>
    
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/ce01a1c161.js" crossorigin="anonymous"></script>
  </head>

  <body>

    @include('layouts.partials.header')

    <div class="container">
        @yield('content')
    </div>

    <p>&nbsp;</p>
    {{-- <p>&nbsp;</p> --}}
    
    @include('layouts.partials.footer')

    <!-- Modal Alerta -->
    <div id="modalAlerta" style="display: none;" class="modal fade" 
            tabindex="-1" role="dialog" aria-labelledby="modalAlertaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAlertaLabel">
                        <i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;Alerta
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Fechar</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="conteudoModalAlerta" style="color: #000000;"></div>
                        <div class="col-lg-6 col-md-6 center">
                            <button type="button" id="btnOk" class="btn btn-primary">
                                <i class="glyphicon glyphicon-ok"></i> Ok
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- Fim Modal -->

    <!-- Modal -->
    <div class="modal fade" id="confirmModalLong" tabindex="-1"
            role="dialog" aria-labelledby="confirmModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="confirmModalLongTitle">
                        <i class="fa fa-question-circle"></i>&nbsp;&nbsp;Confirmação
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="conteudoConfirmModalLong">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Não</button>
                    <button type="button" id="btnSim" class="btn btn-primary">Sim</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Progess bar -->
    <div id="carregando" style="display: none;">
        <div id="conteudoCarregando">
            <div>
                <i class="fa fa-spin fa-spinner"></i> Processando...
            </div>
            <div class="progress progress-striped active">
                <div class="progress-bar" role="progressbar" 
                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
            </div>
        </div>
    </div>
    <!-- /.progress bar -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- JavaScripts Extras -->
    <script type="text/javascript" src="{{ asset('js/jsgeneralfunctions.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/componentes.js') }}"></script>
		
    <script src="{{ asset('bootstrap/4.4.1/js/bootstrap-datepicker.min.js') }}"></script> 
    <script src="{{ asset('bootstrap/4.4.1/js/bootstrap-datepicker.pt-BR.min.js') }}" charset="UTF-8"></script>

    @yield('javascript')
    
  </body>
</html>
