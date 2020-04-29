function somenteNumeros(e) {
    if (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
}

function retiraAcentos(str) {
    var com_acento = "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝŔÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿŕ";
    var sem_acento = "AAAAAAACEEEEIIIIDNOOOOOOUUUUYRsBaaaaaaaceeeeiiiionoooooouuuuybyr";
    var novastr = "";
    var i, a, troca;
    
    for (i = 0; i < str.length; i++) {
        troca = false;
        for (a = 0; a < com_acento.length; a++) {
            if (str.substr(i, 1) == com_acento.substr(a, 1)) {
                novastr += sem_acento.substr(a, 1);
                troca = true;
                break;
            }
        }
        if (troca == false) {
            novastr += str.substr(i, 1);
        }
    }
    return novastr;
}

function limparFormCep(sufixo) {
    $("#logradouro").val("");
    $("#bairro").val("");
    $("#uf" + sufixo).val("DF");
    $("#cidade_id" + sufixo).val("");
}

function consultarEnderecoPorCep(input, sufixo) {
    //Verifica se campo cep possui valor informado.
    if ($(input).val() != "") {

        //Nova variável "cep" somente com dígitos.
        var cep = $(input).val().replace(/\D/g, '');

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            $("#logradouro").val("Carregando...");
            $("#bairro").val("Carregando...");
            $("#cidade_id" + sufixo).val("");
            $("#uf" + sufixo).val("");
//                $("#ibge").val("...");

            //Consulta o webservice viacep.com.br/
            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                if (!("erro" in dados)) {
                    var cidade = dados.localidade.toUpperCase();
                    cidade = retiraAcentos(cidade);
                    //Atualiza os campos com os valores da consulta.
                    $("#logradouro").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                    $("#uf" + sufixo).val(dados.uf);
                    selectByText('#cidade_id' + sufixo, cidade);
//                        $("#ibge").val(dados.ibge); 
                } else {
                    //CEP pesquisado não foi encontrado.
                    limparFormCep(sufixo);
                    Componentes.modalAlerta("CEP não encontrado.", null);
                }
            });
        } else {
            //cep é inválido.
            limparFormCep(sufixo);
            Componentes.modalAlerta("Formato de CEP inválido.", null);
        }
    } else {
        //cep sem valor, limpa formulário.
        limparFormCep(sufixo);
    }
}

function pegarCidades(options, cidade_id, input) {
    var settings = $.extend({
        'default': $("#" + input).attr('default'),
        'uf': null
    }, options);

    if (settings.uf == null) {
        console.warn('Nenhuma UF informada');
    } else {
        $("#" + input).html('<option>Carregando..</option>');
        $.get("/cidades/" + settings.uf, null, function (json) {
            $("#" + input).html('<option value=""> - - Selecione - - </option>');
            $.each(json, function (key, value) {
                $("#" + input).append('<option value="' + value.id + '" ' + ((cidade_id == value.id) ? 'selected' : '') + '>' + value.nome + '</option>');
            });
        }, 'json');
    }
}

function selectByText(select, text) {
    $(select).find('option:contains("' + text + '")').prop('selected', true);
}

function formatarData(data, formato) {
    if (formato == 'pt-br') {
        return (data.substr(0, 10).split('-').reverse().join('/'));
    } else {
        return (data.substr(0, 10).split('/').reverse().join('-'));
    }
}

function showButtonRecalculator() {
    $('#btnRecalcularItem').show();
    $('#btnAdicionarItem').hide();
}

function hideButtonRecalculator() {
    $('#btnRecalcularItem').hide();
    $('#btnAdicionarItem').show();
}

function adicionarQuantidade() {
    var quantidade = parseInt($('#quantidade').val()) + 1;
    $('#quantidade').val(quantidade);
    showButtonRecalculator();
    calcularValorSubTotal();
}

function subtrairQuantidade() {
    var quantidade = parseInt($('#quantidade').val()) - 1;
    $('#quantidade').val(quantidade);
    showButtonRecalculator();
    calcularValorSubTotal();
}

function calcularValorSubTotal() {
    var formURL = top.urlCalcularValorSubTotal;
    if ($('#quantidade').val() !== "" || $('#custo_unitario').val() !== "") {
        $('#carregando').show();
        $.ajax({
            type: "POST",
            url: formURL,
            data: {
                _token: $("input[name='_token']").val(),
                quantidade: $('#quantidade').val(),
                custo_unitario: $('#custo_unitario').val(),
                desconto: $('#desconto').val(),
                valor_a_pagar_com_desconto: $('#sale_price_with_discount').val()
            },
            dataType: "json",
            success: function (data) {
                $('#quantidade').val(data.quantidade);
                if (data.valor_a_pagar.indexOf(".") !== -1) {
                    var valor_a_pagar = data.valor_a_pagar.replace(".", ",");
                    var n = valor_a_pagar.split(',');
                    if (n[1].length === 1) {
                        valor_a_pagar = n[0] + ',' + n[1] + '0';
                    }
                } else {
                    var valor_a_pagar = data.valor_a_pagar + ",00";
                }
                $('#valor_a_pagar').val('R$ ' + valor_a_pagar);
                if (data.valor_a_pagar_com_desconto.indexOf(".") !== -1) {
                    var valor_a_pagar_com_desconto = data.valor_a_pagar_com_desconto.replace(".", ",");
                    var n = valor_a_pagar_com_desconto.split(',');
                    if (n[1].length === 1) {
                        valor_a_pagar_com_desconto = n[0] + ',' + n[1] + '0';
                    }
                } else {
                    var valor_a_pagar_com_desconto = data.valor_a_pagar_com_desconto + ",00";
                }
                $('#valor_a_pagar_com_desconto').val('R$ ' + valor_a_pagar_com_desconto);
                hideButtonRecalculator();
                $('#carregando').hide();
            }
        });
    }
}

function calcularValorDesconto() {
    $("#valor_a_pagar").prop('disabled', false);
    var formURL = top.urlCalcularValorDesconto;
    var desconto = $("#desconto").val();
    var valor_a_pagar = $("#valor_a_pagar").val();

    $('#carregando').show();
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            desconto: desconto,
            valor_a_pagar: valor_a_pagar,
        },
        dataType: "json",
        success: function (data) {
            $("#valor_a_pagar").prop('disabled', true);
            $('#desconto').val(data.desconto);
            $('#valor_a_pagar_com_desconto').val(data.valor_a_pagar_com_desconto);
            $('#vl_troco_restante').val(data.valor_a_pagar_com_desconto);
            hideButtonRecalculator();
            $('#carregando').hide();
        }
    });
}

function calcularPorcentagemDesconto() {
    $("#valor_a_pagar").prop('disabled', false);
    var formURL = top.urlCalcularPorcentagemDesconto;
    var valor_a_pagar = $("#valor_a_pagar").val();
    var valor_a_pagar_com_desconto = $("#valor_a_pagar_com_desconto").val();

    $('#carregando').show();
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            valor_a_pagar: valor_a_pagar,
            valor_a_pagar_com_desconto: valor_a_pagar_com_desconto
        },
        dataType: "json",
        success: function (data) {
            $("#valor_a_pagar").prop('disabled', true);
            $('#desconto').val(data.desconto);
            $('#vl_troco_restante').val(valor_a_pagar_com_desconto);
            hideButtonRecalculator();
            $('#carregando').hide();
        }
    });
}

function calcularTrocoRestante() {
    var formURL = top.urlCalcularTrocoRestante;
    var unit_cost = $("#vl_recebido_total").val();
    var sale_price = $("#valor_a_pagar").val();

    $('#carregando').show();
    $.ajax({
        type: "POST",
        url: formURL,
        data: {
            _token: $("input[name='_token']").val(),
            unit_cost: unit_cost,
            sale_price: sale_price
        },
        dataType: "json",
        success: function (data) {
            $('#vl_troco_restante').val(data.vl_troco_restante);
            atualizarValoresVenda();
            $('#carregando').hide();
        }
    });
}

//$(document).bind("contextmenu",function(e){
//    return false;
//});