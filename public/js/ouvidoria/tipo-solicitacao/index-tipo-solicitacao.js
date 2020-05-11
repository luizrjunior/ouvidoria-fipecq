function validar() 
{
    $('#carregando').show();
}

function ativarDesativarTipoSolicitacao(tipo_solicitacao_id) 
{
    $('#carregando').show();
    var formURL = '/tipo-solicitacao/ativar-desativar-tipo-solicitacao';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            tipo_solicitacao_id: tipo_solicitacao_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaTipoSolicitacao);
        }
    });
}

function atualizarListaTipoSolicitacao() 
{
    location.href='/tipo-solicitacao';
}

function confirmDestroy(id)
{
    top.id = id;
    Componentes.modalConfirmacao('Tem certeza que deseja excluir este registro?', destroyTipoSolicitacao);
}

function destroyTipoSolicitacao()
{
    $('#carregando').show();
    $('#formSearchTipoSolicitacao').attr('action', top.urlDestroyTipoSolicitacao + '/' + top.id);
    $("#_method").val('DELETE');
    $("#formSearchTipoSolicitacao").submit();
}
