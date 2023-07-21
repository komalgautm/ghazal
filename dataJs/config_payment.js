"use strict";
$("#save_config").on('submit', function (event) {

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/tools/config_payment_ajax.php",
        data: parametros,
        beforeSend: function (objeto) {
            $("#resultados_ajax").html("Enviando...");
        },
        success: function (datos) {
            $("#resultados_ajax").html(datos);

            $("html, body").animate({
                scrollTop: 0
            }, 600);

        }
    });
    event.preventDefault();

});