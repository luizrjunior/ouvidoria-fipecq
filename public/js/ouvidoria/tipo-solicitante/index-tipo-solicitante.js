function validar() 
{
    $('#carregando').show();
}

function ativarDesativarTipoSolicitante(tipo_solicitante_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativaTipoSolicitante;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            tipo_solicitante_id: tipo_solicitante_id
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
    location.href=top.urlTipoSolicitantes;
}

