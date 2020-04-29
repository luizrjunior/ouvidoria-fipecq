function validar() {
    $('#carregando').show();
    $("#tipo_solicitacao_cod").prop('disabled', false);
}

function carregarSolicitanteCPF() {
    if ($('#solicitante_cpf').val() != "") {
        $('#carregando').show();
        var formURL = '/solicitacao-ouvidoria/carregar-solicitante-cpf';
        $.ajax({
            type: "POST",
            url: formURL,
            data: {
                _token: $("input[name='_token']").val(),
                solicitante_cpf: $('#solicitante_cpf').val()
            },
            dataType: "json",
            success: function (data) {
                if (data.solicitante_cod != undefined) {
                    $('#solicitante_cod').val(data.solicitante_cod);
                    $('#tipo_solicitante_cod').val(data.tipo_solicitante_cod);
                    $('#solicitante_cpf').val(data.solicitante_cpf);
                    $('#solicitante_nome').val(data.solicitante_nome);
                    $("#institutora_cod").val(data.institutora_cod);
                    $("#solicitante_uf").val(data.solicitante_uf);
                    $("#solicitante_cidade").val(data.solicitante_cidade);
                    $('#solicitante_email').val(data.solicitante_email);
                    $('#solicitante_telefone').val(data.solicitante_telefone);
                    $('#solicitante_celular').val(data.solicitante_celular);
                }
                $('#carregando').hide();
            }
        });
    }
}

$(document).ready(function () {
    $("#solicitante_cpf").mask("999.999.999-99");
    $("#solicitante_telefone").mask("(99) 99999-9999");
    $("#solicitante_celular").mask("(99) 99999-9999");

    $("#solicitante_cpf").change(function () {
        carregarSolicitanteCPF();
    });

    $("#solicitacao_ouvidoria_protocolo_psq").change(function () {
		$('#carregando').show();
		$("#formSolicitacaoOuvidoria").submit();
    });
});

$(document).on("keydown", "#solicitacao_ouvidoria_mensagem", function () {
    var caracteresRestantes = 255;
    var caracteresDigitados = parseInt($(this).val().length);
    var caracteresRestantes = caracteresRestantes - caracteresDigitados;

    $(".caracteres").text(caracteresRestantes);
});
