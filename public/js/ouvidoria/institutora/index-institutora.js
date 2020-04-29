function validar() 
{
    $('#carregando').show();
}

function ativarDesativarInstitutora(institutora_cod) 
{
    $('#carregando').show();
    var formURL = '/institutora/ativar-desativar-institutora';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            institutora_cod: institutora_cod
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaInstitutora);
        }
    });
}

function atualizarListaInstitutora() 
{
    location.href='/institutora';
}

function confirmDestroy(id)
{
    top.id = id;
    Componentes.modalConfirmacao('Tem certeza que deseja excluir este registro?', destroyInstitutora);
}

function destroyInstitutora()
{
    $('#carregando').show();
    $('#formSearchInstitutora').attr('action', top.urlDestroyInstitutora + '/' + top.id);
    $("#_method").val('DELETE');
    $("#formSearchInstitutora").submit();
}
