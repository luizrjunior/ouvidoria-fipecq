function validar() 
{
    $('#carregando').show();
}

function ativarDesativarCanalAtendimento(canal_atendimento_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarCanalAtendimento;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            canal_atendimento_id: canal_atendimento_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaCanalAtendimento);
        }
    });
}

function atualizarListaCanalAtendimento() 
{
    location.href=top.urlListaCanalAtendimentos;
}
