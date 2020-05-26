function validar() 
{
    $('#carregando').show();
}

function ativarDesativarAssunto(assunto_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarAssunto;
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
    location.href=top.urlListaAssuntos;
}
