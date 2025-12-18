//funcion para editar cliente
function editarCliente(id_cliente) {
    $.ajax({
        url: "consultaCliente",
        type: "POST",
        data: { id_cliente: id_cliente },
        success: function (data) {
            var json = JSON.parse(data);
            $("#id_clienteEditar").val(json.id_cliente);
            $("#nombreEditar").val(json.nombre);
            $("#apellidosEditar").val(json.apellidos);
            $("#correoEditar").val(json.correo);
            $("#telefonoEditar").val(json.telefono1);
            $("#telefono2Editar").val(json.telefono2);
            $("#modalEditar").modal('show');
        }
    });
}

function buscarCliente() {
    $("#modalRegistro").modal('hide');
    $("#modalSeleccionarCliente").modal('show');
}

function seleccionarCliente(id_cliente) {
    //buscar datos de cliente para cargarlo en inputs
    $.ajax({
        url: "consultaCliente",
        type: "POST",
        data: { id_cliente: id_cliente },
        success: function (data) {
            var json = JSON.parse(data);
            $("#id_cliente").val(json.id_cliente);
            $("#cliente").val(json.nombre + " " + json.apellidos);
            $("#modalSeleccionarCliente").modal('hide');
            $("#modalRegistro").modal('show');
        },
        error: function (data) {
            alert("Error al seleccionar cliente");
            $("#modalSeleccionarCliente").modal('hide');
            $("#modalRegistro").modal('show');
        }
    });
}

//nuevo cliente
function nuevoCliente() {
    $("#modalRegistro").modal('hide');
    $("#modalRegistroCliente").modal('show');
}

//REGISTRAR NUEVO CLIENTE
function registrarClienteGETID() {
    var data = {
        nombre: $("#nombreCliente").val(),
        apellidos: $("#apellidosCliente").val(),
        correo: $("#correoCliente").val(),
        telefono1: $("#telefono1Cliente").val(),
        telefono2: $("#telefono2Cliente").val()
    };
    $.ajax({
        url: "registrarClienteGETID",
        type: "POST",
        data: data,
        success: function (data) {
            var json = JSON.parse(data);
            if (json.status == "success") {
                //obtener el id del cliente
                var id_cliente = json.id_cliente;
                //cargar el id del cliente en el input
                $("#id_cliente").val(id_cliente);
                $("#cliente").val(json.nombre_apellidos);
                $("#modalRegistroCliente").modal('hide');
                $("#modalRegistro").modal('show');
            } else if (json.status == "error") {
                alert(json.message);
            }
        },
        error: function (data) {
            var json = JSON.parse(data);
            alert(json.message);
            $("#modalRegistroCliente").modal('hide');
            $("#modalRegistro").modal('show');
        }
    });
}

function cerrarModal() {
    $("#modalRegistroCliente").modal('hide');
    $("#modalSeleccionarCliente").modal('hide');
    $("#modalRegistro").modal('show');
}

//editar reservacion
function editarReservacion(id_reservacion) {
    $.ajax({
        url: "consultaReservacion",
        type: "POST",
        data: { id_reservacion: id_reservacion },
        success: function (data) {
            var json = JSON.parse(data);
            $("#id_reservacionEditar").val(json.id_reservacion);
            $("#id_clienteEditar").val(json.id_cliente);
            $("#clienteEditar").val(json.nombre + " " + json.apellidos);
            $("#fecha_servicioEditar").val(json.fecha_servicio);
            $("#hora_servicioEditar").val(json.hora_servicio);
            $("#num_pasajerosEditar").val(json.num_pasajeros);
            $("#domicilio_origenEditar").val(json.domicilio_origen);
            $("#domicilio_destinoEditar").val(json.domicilio_destino);
            $("#costo_servicioEditar").val(json.costo_servicio);
            $("#notasEditar").val(json.notas);
            $("#statusEditar").val(json.status);
            $("#modalEditar").modal('show');
        }
    });
}

//filtrar reservaciones
function filtrarReservaciones() {
    var estatus = $("#estatus").val();
    $.ajax({
        url: "filtrarReservaciones",
        type: "POST",
        data: { estatus: estatus },
        success: function (data) {
            var json = JSON.parse(data);
            //insertar datos al datatables
            var table = $('#tableReservaciones').DataTable();
            table.clear().draw();
            json.forEach(function (row) {
                table.row.add([
                    row.id_reservacion,
                    row.dias_faltantes,
                    row.fecha_servicio,
                    row.status,
                    row.domicilio_origen,
                    row.domicilio_destino,
                    row.costo_servicio,
                    row.hora_servicio,
                    row.nombre,
                    row.apellidos,
                    row.num_pasajeros,
                    row.notas,
                    row.fecha_creacion,
                    '<a href="#" onclick="editarReservacion(' + row.id_reservacion + ')"><i class="zmdi zmdi-brush"></i> <span>Editar</span></a>'
                ]);
            });
            table.draw();
        }
    });
}