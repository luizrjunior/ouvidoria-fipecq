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
        case '6':
            $("#formRelatorios").prop('action', top.urlRelComparativo);
            break;
    }
    $("#formRelatorios").submit();
}
