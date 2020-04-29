function validar() 
{
    $('#carregando').show();
}

function ativarDesativarClassificacao(classificacao_cod) 
{
    $('#carregando').show();
    var formURL = '/classificacao/ativar-desativar-classificacao';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            classificacao_cod: classificacao_cod
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
    location.href='/classificacao';
}

function confirmDestroy(id)
{
    top.id = id;
    Componentes.modalConfirmacao('Tem certeza que deseja excluir este registro?', destroyClassificacao);
}

function destroyClassificacao()
{
    $('#carregando').show();
    $('#formSearchClassificacao').attr('action', top.urlDestroyClassificacao + '/' + top.id);
    $("#_method").val('DELETE');
    $("#formSearchClassificacao").submit();
}
