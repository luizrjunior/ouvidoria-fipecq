function validar() {
    $('#print').val('');
    $("#formRelatorioPesquisaSatisfacao").prop('target', "");
    $('#carregando').show();
}

function imprimir(value) {
    $('#print').val(value);
    $("#formRelatorioPesquisaSatisfacao").prop('target', "_blank");
    $("#formRelatorioPesquisaSatisfacao").submit();
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
});
