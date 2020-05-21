function validar() {
    $('#carregando').show();
}

$(document).on("keydown", "#resposta_3", function () {
    var caracteresRestantes = 1200;
    var caracteresDigitados = parseInt($(this).val().length);
    var caracteresRestantes = caracteresRestantes - caracteresDigitados;

    $(".caracteres").text(caracteresRestantes);
});

