function validar() 
{
    $('#carregando').show();
}

function ativarDesativarSubClassificacao(sub_classificacao_cod) 
{
    $('#carregando').show();
    var formURL = '/sub-classificacao/ativar-desativar-sub-classificacao';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            sub_classificacao_cod: sub_classificacao_cod
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
    location.href='/sub-classificacao';
}

function confirmDestroy(id)
{
    top.id = id;
    Componentes.modalConfirmacao('Tem certeza que deseja excluir este registro?', destroySubClassificacao);
}

function destroySubClassificacao()
{
    $('#carregando').show();
    $('#formSearchSubClassificacao').attr('action', top.urlDestroySubClassificacao + '/' + top.id);
    $("#_method").val('DELETE');
    $("#formSearchSubClassificacao").submit();
}
