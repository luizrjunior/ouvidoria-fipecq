function validar() {
    $('#carregando').show();
}

function carregarSelectSetores() {
    var formURL = top.routeCarregarSetores;
    $.ajax({
        type: 'POST',
        url: formURL,
        data: { 
            _token: $("input[name='_token']").val(),
            categoria_id: $("#categoria_id_psq").val() 
        },
        dataType: "json",
        success: function (data) {
            var selectbox = $('#setor_id_psq');
            selectbox.find('option').remove();
            $('<option>').val('').text(' -- SELECIONE -- ').appendTo(selectbox);
            $.each(data, function (i, d) {
                $('<option>').val(d.id).text(d.descricao).appendTo(selectbox);
            });
            if (top.valorSetor != "") {
                selectbox.val(top.valorSetor);
                carregarSelectAssuntos();
            }
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
            setor_id: $("#setor_id_psq").val() 
        },
        dataType: "json",
        success: function (data) {
            var selectbox = $('#assunto_id_psq');
            selectbox.find('option').remove();
            $('<option>').val('').text(' -- SELECIONE -- ').appendTo(selectbox);
            $.each(data, function (i, d) {
                $('<option>').val(d.id).text(d.descricao).appendTo(selectbox);
            });
            if (top.valorAssunto != "") {
                selectbox.val(top.valorAssunto);
                carregarSelectClassificacoes();
            }
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
            assunto_id: $("#assunto_id_psq").val() 
        },
        dataType: "json",
        success: function (data) {
            var selectbox = $('#classificacao_id_psq');
            selectbox.find('option').remove();
            $('<option>').val('').text(' -- SELECIONE -- ').appendTo(selectbox);
            $.each(data, function (i, d) {
                $('<option>').val(d.id).text(d.descricao).appendTo(selectbox);
            });
            if (top.valorClassificacao != "") {
                selectbox.val(top.valorClassificacao);
                carregarSelectSubClassificacoes();
            }
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
            classificacao_id: $("#classificacao_id_psq").val() 
        },
        dataType: "json",
        success: function (data) {
            var selectbox = $('#sub_classificacao_id_psq');
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

$(document).ready(function () {
    $("#cpf_psq").mask("999.999.999-99");
    $("#data_inicio").mask("99/99/9999");
    $('#data_inicio').datepicker({	
        format: "dd/mm/yyyy",	
        language: "pt-BR"
    });

    $("#data_termino").mask("99/99/9999");
    $('#data_termino').datepicker({	
        format: "dd/mm/yyyy",	
        language: "pt-BR"
    });

    $("#categoria_id_psq").change(function () {
        carregarSelectSetores();
    });

    $("#setor_id_psq").change(function () {
        carregarSelectAssuntos();
    });

    $("#assunto_id_psq").change(function () {
        carregarSelectClassificacoes();
    });

    $("#classificacao_id_psq").change(function () {
        carregarSelectSubClassificacoes();
    });

    if (top.valorCategoria != "") {
        carregarSelectSetores();
    }

});
