function validar() 
{
    $('#carregando').show();
}

function ativarDesativarCanalAtendimento(canal_atendimento_cod) 
{
    $('#carregando').show();
    var formURL = '/canal-atendimento/ativar-desativar-canal-atendimento';
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            canal_atendimento_cod: canal_atendimento_cod
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
    location.href='/canal-atendimento';
}

function confirmDestroy(id)
{
    top.id = id;
    Componentes.modalConfirmacao('Tem certeza que deseja excluir este registro?', destroyCanalAtendimento);
}

function destroyCanalAtendimento()
{
    $('#carregando').show();
    $('#formSearchCanalAtendimento').attr('action', top.urlDestroyCanalAtendimento + '/' + top.id);
    $("#_method").val('DELETE');
    $("#formSearchCanalAtendimento").submit();
}
