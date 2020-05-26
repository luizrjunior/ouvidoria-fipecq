function validar() 
{
    $('#carregando').show();
}

function ativarDesativarClassificacao(classificacao_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarClassificacao;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            classificacao_id: classificacao_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaClassificacao);
        }
    });
}

function atualizarListaClassificacao() 
{
    location.href=top.urlListaClassificacaos;
}

