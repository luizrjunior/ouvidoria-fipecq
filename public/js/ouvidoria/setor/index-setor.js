function validar() 
{
    $('#carregando').show();
}

function ativarDesativarSetor(setor_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarSetor;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            setor_id: setor_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaSetor);
        }
    });
}

function atualizarListaSetor() 
{
    location.href=top.urlListaSetores;
}

