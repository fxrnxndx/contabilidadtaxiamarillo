function mayus(e) {
    e.value = e.value.toUpperCase();
}

function paso2() {
    //validamos que el formulario no tenga espacios en blanco
    console.log("RFC:" + $('#rfcempresa').val() + " " + "ticket:" + $('#ticket').val() + " " + "cantidad:" + $('#cantidad').val() + " " + "pago:" + $('#pago').val() + " " + "fechaticket:" + $('#fechaticket').val() + " ");
    if ($('#rfcempresa').val() == "" || $('#ticket').val() == "" || $('#cantidad').val() == "" || $('#pago').val() == "" || $('#fechaticket').val() == "") {
        $('#mensaje').text("Faltan campos por llenar");
        $('#modalMensajes').modal('show');
        return;
    }
    const form = document.getElementById('paso1');

    if (!form) {
        $('#mensaje').text("Error en formulario, no encontrado");
        $('#modalMensajes').modal('show');
        return;
    }

    if (!form.checkValidity()) {
        form.reportValidity();
        $('#mensaje').text("Valide los campos");
        $('#modalMensajes').modal('show');
        return;
    }
    $('#paso1').addClass('d-none');
    $('#paso2').removeClass('d-none');
}

function generarSolicitud() {
    var buttonSend = $('#generarSolicitud');
    buttonSend.addClass('Bloqueo'); // Deshabilita el boton para evitar multiples envios
    buttonSend.html('Solicitando... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    if ($('#rfcreceptor').val() == "" || $('#razonsocial').val() == "" || $('#email').val() == "" || $('#cp').val() == "" || $('#Regimen').val() == "" || $('#cfdi').val() == "" || $('#tipoFormulario').val() == "") {
        $('#mensaje').text("Faltan campos por llenar");
        $('#modalMensajes').modal('show');
        return;
    }
    const form = document.getElementById('paso2');
    if (!form) {
        $('#mensaje').text("Error en formulario, no encontrado");
        $('#modalMensajes').modal('show');
        buttonSend.removeClass('Bloqueo');
        buttonSend.html('Generar Solicitud');
        return;
    }

    if (!form.checkValidity()) {
        form.reportValidity();
        $('#mensaje').text("Valide los campos");
        $('#modalMensajes').modal('show');
        buttonSend.removeClass('Bloqueo');
        buttonSend.html('Generar Solicitud');

        return;
    }
    var datos = new FormData();
    datos.append('rfcempresa', $('#rfcempresa').val());
    datos.append('ticket', $('#ticket').val());
    datos.append('cantidad', $('#cantidad').val());
    datos.append('pago', $('#pago').val());
    datos.append('fechaticket', $('#fechaticket').val());
    datos.append('rfcreceptor', $('#rfcreceptor').val());
    datos.append('razonsocial', $('#razonsocial').val());
    datos.append('email', $('#email').val());
    datos.append('cp', $('#cp').val());
    datos.append('Regimen', $('#Regimen').val());
    datos.append('cfdi', $('#cfdi').val());
    datos.append('tipoFormulario', $('#tipoFormulario').val());

    $.ajax({
        url: 'https://facturel.mx/Home/verificar_ticket',
        type: 'POST',
        data: datos,
        processData: false,
        contentType: false,
        success: function (respuesta) {
            $('#mensaje').text(respuesta);
            $('#modalMensajes').modal('show');
            buttonSend.removeClass('Bloqueo');
            buttonSend.html('Generar Solicitud');
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText); // 👈 útil para ver el error en consola
            $('#mensaje').text('Ocurrió un error');
            $('#modalMensajes').modal('show');
            buttonSend.removeClass('Bloqueo');
            buttonSend.html('Generar Solicitud');
        }
    });
}