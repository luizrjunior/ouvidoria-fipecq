function validar() 
{
    $('#carregando').show();
}

function ativarDesativarTipoPrestador(tipo_prestador_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarTipoPrestador;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            tipo_prestador_id: tipo_prestador_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaTipoPrestador);
        }
    });
}

function atualizarListaTipoPrestador() 
{
    location.href=top.urlListaTipoPrestadors;
}

