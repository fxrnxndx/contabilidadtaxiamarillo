<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
        <!--Start Dashboard Content-->
        <!--INICIO AGREGAR -->
        <div class="card col-4 ">
            <div class="card-content">
                <div class="row row-group ">
                    <div class="col-8 border-light">
                        <div class="card-body">
                            <h5 class="text-white mb-0">Nueva Reservacion <span class="float-right"></span></h5>
                            <div class="form-group">
                                <a href="#" class="btn btn-light px-5" data-toggle="modal"
                                    data-target="#modalRegistro"><i class="zmdi zmdi-account-add"></i>Agregar</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--FIN AGREGAR -->
        <!--INICIO TABLA -->
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="estatus">Filtrar por estatus</label>
                            <select name="estatus" id="estatus" class="form-control" onchange="filtrarReservaciones()">
                                <option value="PENDIENTE/CONFIRMADO">Pendiente / Confirmado</option>
                                <option value="PENDIENTE">Pendiente</option>
                                <option value="CONFIRMADO">Confirmado</option>
                                <option value="CANCELADO">Cancelado</option>
                                <option value="VIAJE REALIZADO">Viaje Realizado</option>
                                <option value="TODOS">Todos</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-header">
                        <h4>Lista de Reservaciones</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="tableReservaciones">
                                <thead>
                                    <tr>
                                        <th>No. Reserv</th>
                                        <th>Dias Faltantes</th>
                                        <th>Fecha Servicio</th>
                                        <th>Status</th>
                                        <th>Domicilio Origen</th>
                                        <th>Domicilio Destino</th>
                                        <th>Costo Servicio</th>
                                        <th>Hora Servicio</th>
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Num Pasajeros</th>
                                        <th>Notas</th>
                                        <th>Fecha Creacion</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($Reservaciones != false): ?>
                                        <?php foreach ($Reservaciones as $row): ?>
                                            <tr>
                                                <td><?php echo $row['id_reservacion']; ?></td>
                                                <td><?php echo $row['dias_faltantes']; ?></td>
                                                <td><?php echo $row['fecha_servicio']; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                                <td><?php echo $row['domicilio_origen']; ?></td>
                                                <td><?php echo $row['domicilio_destino']; ?></td>
                                                <td><?php echo $row['costo_servicio']; ?></td>
                                                <td><?php echo $row['hora_servicio']; ?></td>
                                                <td><?php echo $row['nombre']; ?></td>
                                                <td><?php echo $row['apellidos']; ?></td>
                                                <td><?php echo $row['num_pasajeros']; ?></td>
                                                <td><?php echo $row['notas']; ?></td>
                                                <td><?php echo $row['fecha_creacion']; ?></td>
                                                <td>
                                                    <a href="#"
                                                        onclick="editarReservacion('<?php echo $row['id_reservacion']; ?>');"><i
                                                            class="zmdi zmdi-brush"></i> <span>Editar</span></a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!--End Row-->
            <!--FIN TABLA -->


            <!--INICIO DE DISEÑO -->
            <div class="row" style="display:none">
                <div class="col-12 col-lg-4 col-xl-4">
                    <div class="card">

                        <div class="card-body">
                            <input type="hidden" value=3 id='NewLunes'>
                            <div class="chart-container-1">
                                <canvas id="chart1"></canvas>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-lg-4 col-xl-4">
                    <div class="card">

                        <div class="card-body">
                            <div class="chart-container-2">
                                <canvas id="chart2"></canvas>
                            </div>
                        </div>

                    </div>
                </div>
            </div><!--FIN DE DISEÑO -->
            <!--End Dashboard Content-->

            <!--start overlay-->
            <div class="overlay toggle-menu"></div>
            <!--end overlay-->

        </div>
        <!-- End container-fluid-->

    </div><!--End content-wrapper-->
    <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->


</div><!--End wrapper-->

<!-- MODAL REGISTRO RESERVACION -->
<div class="modal fade" id="modalRegistro">
    <form action="<?php echo base_url('Home/registrarReservacion'); ?>" method="POST">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title modal-text">Nueva Reservacion</h4>
                    <button type="button" class="close modal-text" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <a class="btn btn-info modal-text" href="#" onclick="buscarCliente()">Buscar Cliente</a>
                            <a class="btn btn-warning modal-text" href="#" onclick="nuevoCliente()">Nuevo Cliente</a>
                        </div>
                        <input type="text" class="form-control modal-inputs" placeholder="Cliente" id="cliente"
                            name="cliente" readonly>
                        <input type="hidden" id="id_cliente" name="id_cliente">
                    </div>
                    <div class="form-group">
                        <label for="fecha_servicio" class="modal-text">Fecha Servicio *</label>
                        <input type="date" class="form-control modal-inputs" id="fecha_servicio" name="fecha_servicio"
                            placeholder="Fecha Servicio" required>
                    </div>
                    <div class="form-group">
                        <label for="hora_servicio" class="modal-text">Hora Servicio *</label>
                        <input type="time" class="form-control modal-inputs" id="hora_servicio" name="hora_servicio"
                            placeholder="Hora Servicio" required>
                    </div>
                    <div class="form-group">
                        <label for="num_pasajeros" class="modal-text">Numero de Pasajeros *</label>
                        <input type="number" class="form-control modal-inputs" id="num_pasajeros" name="num_pasajeros"
                            placeholder="Numero de Pasajeros" required>
                    </div>
                    <div class="form-group">
                        <label for="domicilio_origen" class="modal-text">Domicilio Origen *</label>
                        <input type="text" class="form-control modal-inputs" id="domicilio_origen"
                            name="domicilio_origen" placeholder="Domicilio Origen" required>
                    </div>
                    <div class="form-group">
                        <label for="domicilio_destino" class="modal-text">Domicilio Destino *</label>
                        <input type="text" class="form-control modal-inputs" id="domicilio_destino"
                            name="domicilio_destino" placeholder="Domicilio Destino" required>
                    </div>
                    <div class="form-group">
                        <label for="costo_servicio" class="modal-text">Costo Servicio *</label>
                        <input type="number" step="0.01" class="form-control modal-inputs" id="costo_servicio"
                            name="costo_servicio" placeholder="Costo Servicio" required>
                    </div>
                    <div class="form-group">
                        <label for="notas" class="modal-text">Notas</label>
                        <textarea class="form-control modal-inputs" id="notas" name="notas" placeholder="Notas"
                            rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status" class="modal-text">Status *</label>
                        <select class="form-control modal-inputs" id="status" name="status" required>
                            <option value="">Seleccione un Status</option>
                            <option value="PENDIENTE">Pendiente</option>
                            <option value="CONFIRMADO">Confirmado</option>
                        </select>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success modal-text">Guardar</button>
                    <a class="btn btn-danger modal-text" data-dismiss="modal">Cancelar</a>
                </div>

            </div>
        </div>
    </form>
</div><!--End modal reservacion-->

<!-- MODAL EDITAR RESERVACION -->
<div class="modal fade" id="modalEditar">
    <form action="<?php echo base_url('Home/actualizarReservacion'); ?>" method="POST">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title modal-text">Editar Reservacion</h4>
                    <button type="button" class="close modal-text" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="clienteEditar" class="modal-text">Cliente</label>
                        <input type="text" class="form-control modal-inputs" id="clienteEditar" name="clienteEditar"
                            placeholder="Cliente" readonly>
                    </div>
                    <div class="form-group">
                        <label for="fecha_servicioEditar" class="modal-text">Fecha Servicio</label>
                        <input type="date" class="form-control modal-inputs" id="fecha_servicioEditar"
                            name="fecha_servicioEditar" placeholder="Fecha Servicio">
                    </div>
                    <div class="form-group">
                        <label for="hora_servicioEditar" class="modal-text">Hora Servicio</label>
                        <input type="time" class="form-control modal-inputs" id="hora_servicioEditar"
                            name="hora_servicioEditar" placeholder="Hora Servicio">
                    </div>
                    <div class="form-group">
                        <label for="num_pasajerosEditar" class="modal-text">Numero de Pasajeros</label>
                        <input type="number" class="form-control modal-inputs" id="num_pasajerosEditar"
                            name="num_pasajerosEditar" placeholder="Numero de Pasajeros">
                    </div>
                    <div class="form-group">
                        <label for="domicilio_origenEditar" class="modal-text">Domicilio Origen</label>
                        <input type="text" class="form-control modal-inputs" id="domicilio_origenEditar"
                            name="domicilio_origenEditar" placeholder="Domicilio Origen">
                    </div>
                    <div class="form-group">
                        <label for="domicilio_destinoEditar" class="modal-text">Domicilio Destino</label>
                        <input type="text" class="form-control modal-inputs" id="domicilio_destinoEditar"
                            name="domicilio_destinoEditar" placeholder="Domicilio Destino">
                    </div>
                    <div class="form-group">
                        <label for="costo_servicioEditar" class="modal-text">Costo Servicio</label>
                        <input type="number" step="0.01" class="form-control modal-inputs" id="costo_servicioEditar"
                            name="costo_servicioEditar" placeholder="Costo Servicio">
                    </div>
                    <div class="form-group">
                        <label for="notasEditar" class="modal-text">Notas</label>
                        <input type="text" class="form-control modal-inputs" id="notasEditar" name="notasEditar"
                            placeholder="Notas">
                    </div>
                    <div class="form-group">
                        <label for="statusEditar" class="modal-text">Status</label>
                        <select class="form-control modal-inputs" id="statusEditar" name="statusEditar">
                            <option value="">Seleccione un Status</option>
                            <option value="PENDIENTE">Pendiente</option>
                            <option value="CONFIRMADO">Confirmado</option>
                            <option value="CANCELADO">Cancelado</option>
                        </select>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" id="id_reservacionEditar" name="id_reservacionEditar" value="">
                    <button type="submit" class="btn btn-success modal-text">Guardar</button>
                    <a class="btn btn-danger modal-text" data-dismiss="modal">Cancelar</a>
                </div>

            </div>
        </div>
    </form>
</div><!--End modal reservacion editar-->

<!-- MODAL SELECCIONAR CLIENTE -->
<div class="modal fade" id="modalSeleccionarCliente">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title modal-text">Seleccionar Cliente</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="col-md-12">
                    <input type="text" class="form-control modal-inputs" id="buscadorCliente" name="buscadorCliente"
                        placeholder="Buscar">
                </div>
                <div class="table-responsive col-md-12">
                    <table id="tableClientes" class="table table-striped table-bordered modal-text">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Telefono</th>
                                <th>Correo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Clientes as $cliente) { ?>
                                <tr>
                                    <td><?php echo $cliente['id_cliente']; ?></td>
                                    <td><?php echo $cliente['nombre']; ?></td>
                                    <td><?php echo $cliente['apellidos']; ?></td>
                                    <td><?php echo $cliente['telefono1']; ?></td>
                                    <td><?php echo $cliente['correo']; ?></td>
                                    <td>
                                        <a href="#" class="btn btn-info modal-text"
                                            onclick="seleccionarCliente(<?php echo $cliente['id_cliente']; ?>)">Seleccionar</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <a href="#" class="btn btn-danger modal-text" onclick="cerrarModal()">Cancelar</a>
            </div>

        </div>
    </div>
</div><!--End modal seleccionar cliente-->

<!-- MODAL REGISTRO NUEVO CLIENTE -->
<div class="modal fade" id="modalRegistroCliente">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title modal-text">Nuevo Cliente</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label for="nombreCliente" class="modal-text">Nombre</label>
                    <input type="text" class="form-control modal-inputs" id="nombreCliente" name="nombreCliente"
                        placeholder="Nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellidosCliente" class="modal-text">Apellidos</label>
                    <input type="text" class="form-control modal-inputs" id="apellidosCliente" name="apellidosCliente"
                        placeholder="Apellidos" required>
                </div>
                <div class="form-group">
                    <label for="correoCliente" class="modal-text">Correo</label>
                    <input type="email" class="form-control modal-inputs" id="correoCliente" name="correoCliente"
                        placeholder="Correo">
                </div>
                <div class="form-group">
                    <label for="telefonoCliente" class="modal-text">Telefono</label>
                    <input type="text" class="form-control modal-inputs" id="telefono1Cliente" name="telefonoCliente"
                        placeholder="Telefono">
                </div>
                <div class="form-group">
                    <label for="telefono2Cliente" class="modal-text">Telefono 2</label>
                    <input type="text" class="form-control modal-inputs" id="telefono2Cliente" name="telefono2Cliente"
                        placeholder="Telefono 2">
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <a href="#" class="btn btn-success modal-text" onclick="registrarClienteGETID()">Agregar</a>
                <a class="btn btn-danger modal-text" onclick="cerrarModal()">Cancelar</a>
            </div>

        </div>
    </div>
</div><!--End modal registro cliente-->

<script>
    $(document).ready(function () {
        $('#tableReservaciones').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
            },
            //botones
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                    },
                    header: true,
                    title: 'RESERVACIONES',
                    orientation: 'landscape',
                    pageSize: 'legal',
                    customize: function (doc) {
                        doc.defaultStyle.fontSize = 10;
                        doc.styles.tableHeader.fontSize = 12; //<-- set fontsize to 16 instead of 10 
                        doc.content[1].table.widths = ['7.69%', '7.69%', '7.69%', '7.69%', '7.69%', '7.69%', '7.69%', '7.69%', '7.69%', '7.69%', '7.69%', '7.69%', '7.69%'];
                        doc.defaultStyle.alignment = 'center';
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                    }
                }
            ],
            //entradas en el footer 
            //ordenar
            order: [[2, 'asc']],
            //paginacion
            pageLength: 1000,
            //responsive
            responsive: true,
            //colapsar
            colReorder: true
        });
    });

    $("#buscadorCliente").on("keyup", function () {
        //buscar en el body de la tabla
        var value = $(this).val().toLowerCase();
        $("#tableClientes tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
</script>