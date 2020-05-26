function validar() 
{
    $('#carregando').show();
}

function ativarDesativarTipoOuvidoria(tipo_ouvidoria_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarTipoOuvidoria;
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
    location.href=top.urlListaTipoOuvidorias;
}

