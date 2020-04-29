function validar() 
{
    $('#carregando').show();
}

$(document).ready(function () {
    $("#solicitante_cpf_psq").mask("999.999.999-99");
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
