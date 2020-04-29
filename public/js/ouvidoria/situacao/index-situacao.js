function validar() 
{
    $('#carregando').show();
}

function ativarDesativarSituacao(situacao_cod) 
{
    $('#carregando').show();
    var formURL = '/situacao/ativar-desativar-situacao';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            situacao_cod: situacao_cod
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaSituacao);
        }
    });
}

function atualizarListaSituacao() 
{
    location.href='/situacao';
}

function confirmDestroy(id)
{
    top.id = id;
    Componentes.modalConfirmacao('Tem certeza que deseja excluir este registro?', destroySituacao);
}

function destroySituacao()
{
    $('#carregando').show();
    $('#formSearchSituacao').attr('action', top.urlDestroySituacao + '/' + top.id);
    $("#_method").val('DELETE');
    $("#formSearchSituacao").submit();
}
