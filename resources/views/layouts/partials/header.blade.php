<div class="d-flex align-items-center p-3 px-md-4 bg-light border-bottom shadow-sm">
    <h5 class="my-0">
        <img src='{{ url('images/logo_fipecqvida.png') }}' style="width: 100%;">
    </h5>&nbsp;
    <small class="mr-md-auto text-muted">Caixa de Assistencia Social da FIPECq</small>
    <button type="button" class="btn btn-dark" onclick="location.href='http://www.fipecqvida.org.br/';">FIPECq Vida</button>&nbsp;
    <button type="button" class="btn btn-dark" onclick="location.href='/home';">Ouvidoria</button>&nbsp;
    <button type="button" class="btn btn-dark" onclick="location.href='/fale-com-ouvidor';">Fale com o Ouvidor</button>&nbsp;
    <button type="button" class="btn btn-dark" onclick="location.href='/ouvidoria';">Administração</button>&nbsp;
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
        <div class="btn-group" role="group">
            <button id="btnGroupDrop1" type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Cadastros
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <a class="dropdown-item" href="/tipo-solicitante">Tipo de Solicitante</a>
                <a class="dropdown-item" href="/tipo-ouvidoria">Tipo de Ouvidoria</a>
                <a class="dropdown-item" href="/tipo-prestador">Tipo de Prestador</a>
                <a class="dropdown-item" href="/situacao">Situação</a>
                <a class="dropdown-item" href="/assunto">Assunto</a>
                <a class="dropdown-item" href="/classificacao">Classificação</a>
                <a class="dropdown-item" href="/sub-classificacao">SubClassificação</a>
                <a class="dropdown-item" href="/canal-atendimento">Canal de Atendimento</a>
            </div>
        </div>
    </div>&nbsp;
    <button type="button" class="btn btn-dark">Rel. Pesq. Satisfação</button>&nbsp;
    <button type="button" class="btn btn-dark">Relatórios</button>&nbsp;
    <button type="button" class="btn btn-danger">Sair</button>
</div>

<div class="col-md-3">
    <img src="{{ url('images/logo_ouvidoria.png') }}" class="p-4">
</div>

