function validar() {
    $('#carregando').show();
    $('#print').val('');
    $("#formRelatorios").prop('target', "");
}

function imprimir(value) {
    $('#print').val(value);
    $("#formRelatorios").prop('target', "_blank");
    $("#formRelatorios").submit();
}

function abrirRelatorio(expr) {
    $('#carregando').show();
    $('#print').val('');
    $("#formRelatorios").prop('target', "");
    switch (expr) {
        case '0':
            $("#formRelatorios").prop('action', top.urlRelTipoOuvidoria);
            break;
        case '1':
            $("#formRelatorios").prop('action', top.urlRelFaixaEtaria);
            break;
        case '2':
            $("#formRelatorios").prop('action', top.urlRelTempoEspera);
            break;
        case '3':
            $("#formRelatorios").prop('action', top.urlRelInstitutora);
            break;
        case '4':
            $("#formRelatorios").prop('action', top.urlRelatorios);
            break;
        case '5':
            $("#formRelatorios").prop('action', top.urlRelPersonalizado);
            break;
    }
    $("#formRelatorios").submit();
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
