function validar() 
{
    $('#carregando').show();
}

function ativarDesativarAssunto(assunto_id) 
{
    $('#carregando').show();
    var formURL = '/assunto/ativar-desativar-assunto';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            assunto_id: assunto_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaAssunto);
        }
    });
}

function atualizarListaAssunto() 
{
    location.href='/assunto';
}

function confirmDestroy(id)
{
    top.id = id;
    Componentes.modalConfirmacao('Tem certeza que deseja excluir este registro?', destroyAssunto);
}

function destroyAssunto()
{
    $('#carregando').show();
    $('#formSearchAssunto').attr('action', top.urlDestroyAssunto + '/' + top.id);
    $("#_method").val('DELETE');
    $("#formSearchAssunto").submit();
}
