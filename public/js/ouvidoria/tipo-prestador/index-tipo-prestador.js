function validar() 
{
    $('#carregando').show();
}

function ativarDesativarTipoPrestador(tipo_prestador_id) 
{
    $('#carregando').show();
    var formURL = '/tipo-prestador/ativar-desativar-tipo-prestador';
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
    location.href='/tipo-prestador';
}

function confirmDestroy(id)
{
    top.id = id;
    Componentes.modalConfirmacao('Tem certeza que deseja excluir este registro?', destroyTipoPrestador);
}

function destroyTipoPrestador()
{
    $('#carregando').show();
    $('#formSearchTipoPrestador').attr('action', top.urlDestroyTipoPrestador + '/' + top.id);
    $("#_method").val('DELETE');
    $("#formSearchTipoPrestador").submit();
}
