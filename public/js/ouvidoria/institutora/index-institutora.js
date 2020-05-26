function validar() 
{
    $('#carregando').show();
}

function ativarDesativarInstitutora(institutora_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarInstitutora;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            institutora_id: institutora_id
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
    location.href=top.urlListaInstitutoras;
}

