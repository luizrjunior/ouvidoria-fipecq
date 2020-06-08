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
        $("#formRelatorios").submit();
    });

    $("#setor_id_psq").change(function () {
        $("#formRelatorios").submit();
    });

    $("#assunto_id_psq").change(function () {
        $("#formRelatorios").submit();
    });

    $("#classificacao_id_psq").change(function () {
        $("#formRelatorios").submit();
    });

});
