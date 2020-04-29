function validar() 
{
    $('#carregando').show();
}

function ativarDesativarTipoSolicitante(tipo_solicitante_cod) 
{
    $('#carregando').show();
    var formURL = '/tipo-solicitante/ativar-desativar-tipo-solicitante';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            tipo_solicitante_cod: tipo_solicitante_cod
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaTipoSolicitante);
        }
    });
}

function atualizarListaTipoSolicitante() 
{
    location.href='/tipo-solicitante';
}

function confirmDestroy(id)
{
    top.id = id;
    Componentes.modalConfirmacao('Tem certeza que deseja excluir este registro?', destroyTipoSolicitante);
}

function destroyTipoSolicitante()
{
    $('#carregando').show();
    $('#formSearchTipoSolicitante').attr('action', top.urlDestroyTipoSolicitante + '/' + top.id);
    $("#_method").val('DELETE');
    $("#formSearchTipoSolicitante").submit();
}
