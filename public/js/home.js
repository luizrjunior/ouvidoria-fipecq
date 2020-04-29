function validar() {
    $('#carregando').show();
}

function showProtocoloCPF()
{
    $('#divInputProtocolo').show();
    $('#divInputCPF').hide();
    if ($('input:radio[name=docC]:checked').val() == 'cpf') {
        $('#divInputProtocolo').hide();
        $('#divInputCPF').show();
    }
}

function abrirLink(link) {
    $('#carregando').show();
    location.href=link;
}

$(document).ready(function () {
    showProtocoloCPF();
    $("#solicitante_cpf_psq").mask("999.999.999-99");

    $("#btnFaleComOuvidor").click(function () {
        abrirLink('/fale-com-ouvidor');
    });

    $("#btnCartaServico").click(function () {
        abrirLink('/carta-servico');
    });
});