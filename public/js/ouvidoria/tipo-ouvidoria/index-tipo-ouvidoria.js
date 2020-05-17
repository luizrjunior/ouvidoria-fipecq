function validar() 
{
    $('#carregando').show();
}

function ativarDesativarTipoOuvidoria(tipo_ouvidoria_id) 
{
    $('#carregando').show();
    var formURL = '/tipo-ouvidoria/ativar-desativar-tipo-ouvidoria';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            tipo_ouvidoria_id: tipo_ouvidoria_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaTipoOuvidoria);
        }
    });
}

function atualizarListaTipoOuvidoria() 
{
    location.href='/tipo-ouvidoria';
}

function confirmDestroy(id)
{
    top.id = id;
    Componentes.modalConfirmacao('Tem certeza que deseja excluir este registro?', destroyTipoOuvidoria);
}

function destroyTipoOuvidoria()
{
    $('#carregando').show();
    $('#formSearchTipoOuvidoria').attr('action', top.urlDestroyTipoOuvidoria + '/' + top.id);
    $("#_method").val('DELETE');
    $("#formSearchTipoOuvidoria").submit();
}
