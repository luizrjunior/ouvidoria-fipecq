function validar() {
    $('#carregando').show();
    $("#tipo_ouvidoria_id").prop('disabled', false);
}

function apresentarCamposSolicitante() {
    if($("#anonima").is(':checked')) {
        $("#divNaoAnonimo").hide();
    } else {
        $("#divNaoAnonimo").show();
    }
}

function carregarSolicitanteCPF() {
    if ($('#cpf').val() != "") {
        $('#carregando').show();
        var formURL = top.routeCarregarSolicitanteCPF;
        $.ajax({
            type: "POST",
            url: formURL,
            data: {
                _token: $("input[name='_token']").val(),
                cpf: $('#cpf').val()
            },
            dataType: "json",
            success: function (data) {
                if (data.nome != undefined) {
                    $('#solicitante_id').val(data.id);
                    if (data.tipo_solicitante_id != undefined) {
                        $('#tipo_solicitante_id').val(data.tipo_solicitante_id);
                    }
                    $('#cpf').val(data.cpf);
                    $('#nome').val(data.nome);
                    $("#uf").val(data.uf);
                    $("#cidade").val(data.cidade);
                    $('#email').val(data.email);
                    $('#telefone').val(data.telefone);
                    $('#celular').val(data.celular);
                    $("#institutora_id").val(data.institutora_id);
                }
                $('#carregando').hide();
            }
        });
    }
}

function carregarSelectSetores() {
    var formURL = top.routeCarregarSetores;
    $.ajax({
        type: 'POST',
        url: formURL,
        data: { 
            _token: $("input[name='_token']").val(),
            categoria_id: $("#categoria_id").val() 
        },
        dataType: "json",
        success: function (data) {
            var selectbox = $('#setor_id');
            selectbox.find('option').remove();
            $('<option>').val('').text(' -- SELECIONE -- ').appendTo(selectbox);
            $.each(data, function (i, d) {
                $('<option>').val(d.id).text(d.descricao).appendTo(selectbox);
            });
            if (top.valorSetor != "") {
                selectbox.val(top.valorSetor);
            }
            carregarSelectAssuntos();
        }
    });
}

function carregarSelectAssuntos() {
    var formURL = top.routeCarregarAssuntos;
    $.ajax({
        type: 'POST',
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            setor_id: $("#setor_id").val() 
        },
        dataType: "json",
        success: function (data) {
            var selectbox = $('#assunto_id');
            selectbox.find('option').remove();
            $('<option>').val('').text(' -- SELECIONE -- ').appendTo(selectbox);
            $.each(data, function (i, d) {
                $('<option>').val(d.id).text(d.descricao).appendTo(selectbox);
            });
            if (top.valorAssunto != "") {
                selectbox.val(top.valorAssunto);
            }
            carregarSelectClassificacoes();
        }
    });
}

function carregarSelectClassificacoes() {
    var formURL = top.routeCarregarClassificacoes;
    $.ajax({
        type: 'POST',
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            assunto_id: $("#assunto_id").val() 
        },
        dataType: "json",
        success: function (data) {
            var selectbox = $('#classificacao_id');
            selectbox.find('option').remove();
            $('<option>').val('').text(' -- SELECIONE -- ').appendTo(selectbox);
            $.each(data, function (i, d) {
                $('<option>').val(d.id).text(d.descricao).appendTo(selectbox);
            });
            if (top.valorClassificacao != "") {
                selectbox.val(top.valorClassificacao);
            }
            carregarSelectSubClassificacoes();
        }
    });
}

function carregarSelectSubClassificacoes() {
    var formURL = top.routeCarregarSubClassificacoes;
    $.ajax({
        type: 'POST',
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            classificacao_id: $("#classificacao_id").val() 
        },
        dataType: "json",
        success: function (data) {
            var selectbox = $('#sub_classificacao_id');
            selectbox.find('option').remove();
            $('<option>').val('').text(' -- SELECIONE -- ').appendTo(selectbox);
            $.each(data, function (i, d) {
                $('<option>').val(d.id).text(d.descricao).appendTo(selectbox);
            });
            selectbox.val(top.valorSubClassificacao);
            top.valorSetor = null;
            top.valorAssunto = null;
            top.valorClassificacao = null;
            top.valorSubClassificacao = null;
        }
    });
}

$(document).on("keydown", "#mensagem", function () {
    var caracteresRestantes = 1200;
    var caracteresDigitados = parseInt($(this).val().length);
    var caracteresRestantes = caracteresRestantes - caracteresDigitados;

    $(".caracteres").text(caracteresRestantes);
});

$(document).on("keydown", "#observacao", function () {
    var caracteresRestantes = 600;
    var caracteresDigitados = parseInt($(this).val().length);
    var caracteresRestantes = caracteresRestantes - caracteresDigitados;

    $(".caracteresObservacao").text(caracteresRestantes);
});

$(document).on("keydown", "#comentario", function () {
    var caracteresRestantes = 1200;
    var caracteresDigitados = parseInt($(this).val().length);
    var caracteresRestantes = caracteresRestantes - caracteresDigitados;

    $(".caracteresComentario").text(caracteresRestantes);
});

$(document).ready(function () {
    $("#cpf").mask("999.999.999-99");
    $("#telefone").mask("(99) 99999-9999");
    $("#celular").mask("(99) 99999-9999");

    $("#anonima").click(function () {
        apresentarCamposSolicitante();
    });

    $("#cpf").change(function () {
        carregarSolicitanteCPF();
    });

    $("#protocolo_psq").change(function () {
		$('#carregando').show();
		$("#formSolicitacaoOuvidoria").submit();
    });

    $("#categoria_id").change(function () {
        carregarSelectSetores();
    });

    $("#setor_id").change(function () {
        carregarSelectAssuntos();
    });

    $("#assunto_id").change(function () {
        carregarSelectClassificacoes();
    });

    $("#classificacao_id").change(function () {
        carregarSelectSubClassificacoes();
    });

    if (top.valorCategoria != "") {
        carregarSelectSetores();
    }

});

