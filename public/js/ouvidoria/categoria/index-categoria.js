function validar() 
{
    $('#carregando').show();
}

function ativarDesativarCategoria(categoria_id) 
{
    $('#carregando').show();
    var formURL = top.urlAtivarDesativarCategoria;
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            categoria_id: categoria_id
        },
        dataType: "json",
        success: function (data) {
            $('#carregando').hide();
            Componentes.modalAlerta(data.textoMsg, atualizarListaCategoria);
        }
    });
}

function atualizarListaCategoria() 
{
    location.href=top.urlListaCategorias;
}
