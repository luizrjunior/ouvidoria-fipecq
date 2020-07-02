<div class="d-flex align-items-center p-3 px-md-4 bg-light border-bottom shadow-sm">
    <h5 class="my-0">
        <img src='{{ url('images/logo_fipecqvida.png') }}' style="width: 100%;">
    </h5>&nbsp;
    <small class="mr-md-auto text-muted">Caixa de Assistencia Social da FIPECq</small>
    <button type="button" class="btn btn-dark" onclick="location.href='http://www.fipecqvida.org.br/';">FIPECq Vida</button>&nbsp;
    @if (Session::get('perfil') == "admin")
    <button type="button" class="btn btn-dark" onclick="location.href='{{ url('/home/admin') }}';">Ouvidoria</button>&nbsp;
    @else
    <button type="button" class="btn btn-dark" onclick="location.href='{{ url('/home') }}';">Ouvidoria</button>&nbsp;
    @endif
    <button type="button" class="btn btn-dark" onclick="location.href='{{ url('/fale-com-ouvidor') }}';">Fale com o Ouvidor</button>&nbsp;
    @if (Session::get('perfil') == "admin")
    <button type="button" class="btn btn-dark" onclick="location.href='{{ url('/ouvidoria') }}';">Administração</button>&nbsp;
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
        <div class="btn-group" role="group">
            <button id="btnGroupDrop1" type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Cadastros
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <a class="dropdown-item" href="{{ url('/tipo-solicitante') }}">Tipos Solicitantes</a>
                <a class="dropdown-item" href="{{ url('/tipo-ouvidoria') }}">Tipos Ouvidorias</a>
                <a class="dropdown-item" href="{{ url('/situacao') }}">Situações Ouvidorias</a>
                <a class="dropdown-item" href="{{ url('/canal-atendimento') }}">Canais Atendimentos</a>
                <a class="dropdown-item" href="{{ url('/categoria') }}">Categorias</a>
                <a class="dropdown-item" href="{{ url('/setor') }}">Setores / Áreas</a>
                <a class="dropdown-item" href="{{ url('/assunto') }}">Assuntos</a>
                <a class="dropdown-item" href="{{ url('/classificacao') }}">Classificações</a>
                <a class="dropdown-item" href="{{ url('/sub-classificacao') }}">SubClassificações</a>
            </div>
        </div>
    </div>&nbsp;
    <button type="button" class="btn btn-dark" onclick="location.href='{{ url('/pesquisa-satisfacao/relatorio') }}';">
        Rel. Pesq. Satisfação
    </button>&nbsp;
    <button type="button" class="btn btn-dark" onclick="location.href='{{ url('/relatorio/tipo-solicitacao') }}';">
        Relatórios
    </button>&nbsp;
    @endif
    <button type="button" class="btn btn-danger" onclick="window.close();">Sair</button>
</div>

<div class="col-md-3">
    <img src="{{ url('images/logo_ouvidoria.png') }}" width="280px" class="p-4">
</div>

