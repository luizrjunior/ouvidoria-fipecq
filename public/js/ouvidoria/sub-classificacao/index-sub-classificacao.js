function validar() 
{
    $('#carregando').show();
}

function ativarDesativarSubClassificacao(sub_classificacao_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarSubClassificacao;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            sub_classificacao_id: sub_classificacao_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaSubClassificacao);
        }
    });
}

function atualizarListaSubClassificacao() 
{
    location.href=top.urlListaSubClassificacaos;
}

