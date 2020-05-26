function validar() 
{
    $('#carregando').show();
}

function ativarDesativarSituacao(situacao_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarSituacao;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            situacao_id: situacao_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaSituacao);
        }
    });
}

function atualizarListaSituacao() 
{
    location.href=top.urlListaSituacaos;
}

