function validar() {
    $('#carregando').show();
    $("#tipo_solicitacao_id").prop('disabled', false);
}

function carregarSolicitanteCPF() {
    if ($('#cpf').val() != "") {
        $('#carregando').show();
        var formURL = '/solicitacao-ouvidoria/carregar-solicitante-cpf';
        $.ajax({
            type: "POST",
            url: formURL,
            data: {
                _token: $("input[name='_token']").val(),
                cpf: $('#cpf').val()
            },
            dataType: "json",
            success: function (data) {
                if (data.id != undefined) {
                    $('#solicitante_id').val(data.id);
                    $('#tipo_solicitante_id').val(data.tipo_solicitante_id);
                    $('#cpf').val(data.cpf);
                    $('#nome').val(data.nome);
                    $("#institutora_id").val(data.institutora_id);
                    $("#uf").val(data.uf);
                    $("#cidade").val(data.cidade);
                    $('#email').val(data.email);
                    $('#telefone').val(data.telefone);
                    $('#celular').val(data.celular);
                }
                $('#carregando').hide();
            }
        });
    }
}

$(document).ready(function () {
    $("#cpf").mask("999.999.999-99");
    $("#telefone").mask("(99) 99999-9999");
    $("#celular").mask("(99) 99999-9999");

    $("#cpf").change(function () {
        carregarSolicitanteCPF();
    });

    $("#protocolo_psq").change(function () {
		$('#carregando').show();
		$("#formSolicitacaoOuvidoria").submit();
    });
});

$(document).on("keydown", "#mensagem", function () {
    var caracteresRestantes = 255;
    var caracteresDigitados = parseInt($(this).val().length);
    var caracteresRestantes = caracteresRestantes - caracteresDigitados;

    $(".caracteres").text(caracteresRestantes);
});
