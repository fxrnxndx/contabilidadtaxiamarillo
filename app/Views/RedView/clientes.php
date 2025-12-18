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
                            <h5 class="text-white mb-0">Nuevo Cliente <span class="float-right"></span></h5>
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
                    <div class="card-header">
                        <h4>Lista de Clientes</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="tableClientes">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Correo</th>
                                        <th>Telefono</th>
                                        <th>Telefono 2</th>
                                        <th>Fecha Creacion</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($Clientes != false): ?>
                                        <?php foreach ($Clientes as $row): ?>
                                            <tr>
                                                <td><?php echo $row['id_cliente']; ?></td>
                                                <td><?php echo $row['nombre']; ?></td>
                                                <td><?php echo $row['apellidos']; ?></td>
                                                <td><?php echo $row['correo']; ?></td>
                                                <td><?php echo $row['telefono1']; ?></td>
                                                <td><?php echo $row['telefono2']; ?></td>
                                                <td> <?php echo $row['fecha_creacion']; ?></td>
                                                <td>
                                                    <a href="#" onclick="editarCliente('<?php echo $row['id_cliente']; ?>');"><i
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

<!-- MODA REGISTRO -->
<div class="modal fade" id="modalRegistro">
    <form action="<?php echo base_url('Home/registrarCliente'); ?>" method="POST">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title modal-text">Nuevo Cliente</h4>
                    <button type="button" class="close modal-text" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre" class="modal-text">Nombre</label>
                        <input type="text" class="form-control modal-inputs" id="nombre" name="nombre"
                            placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <label for="apellidos" class="modal-text">Apellidos</label>
                        <input type="text" class="form-control modal-inputs" id="apellidos" name="apellidos"
                            placeholder="Apellidos">
                    </div>
                    <div class="form-group">
                        <label for="correo" class="modal-text">Correo</label>
                        <input type="email" class="form-control modal-inputs" id="correo" name="correo"
                            placeholder="Correo">
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="modal-text">Telefono</label>
                        <input type="text" class="form-control modal-inputs" id="telefono" name="telefono"
                            placeholder="Telefono">
                    </div>
                    <div class="form-group">
                        <label for="telefono2" class="modal-text">Telefono 2</label>
                        <input type="text" class="form-control modal-inputs" id="telefono2" name="telefono2"
                            placeholder="Telefono 2">
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
</div>

<!-- MODA EDITAR -->
<div class="modal fade" id="modalEditar">
    <form action="<?php echo base_url('Home/actualizarCliente'); ?>" method="POST">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title modal-text">Editar Cliente</h4>
                    <button type="button" class="close modal-text" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombreEditar" class="modal-text">Nombre</label>
                        <input type="text" class="form-control modal-inputs" id="nombreEditar" name="nombreEditar"
                            placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <label for="apellidosEditar" class="modal-text">Apellidos</label>
                        <input type="text" class="form-control modal-inputs" id="apellidosEditar" name="apellidosEditar"
                            placeholder="Apellidos">
                    </div>
                    <div class="form-group">
                        <label for="correoEditar" class="modal-text">Correo</label>
                        <input type="email" class="form-control modal-inputs" id="correoEditar" name="correoEditar"
                            placeholder="Correo">
                    </div>
                    <div class="form-group">
                        <label for="telefonoEditar" class="modal-text">Telefono</label>
                        <input type="text" class="form-control modal-inputs" id="telefonoEditar" name="telefonoEditar"
                            placeholder="Telefono">
                    </div>
                    <div class="form-group">
                        <label for="telefono2Editar" class="modal-text">Telefono 2</label>
                        <input type="text" class="form-control modal-inputs" id="telefono2Editar" name="telefono2Editar"
                            placeholder="Telefono 2">
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" id="id_clienteEditar" name="id_clienteEditar" value="">
                    <button type="submit" class="btn btn-success modal-text">Guardar</button>
                    <a class="btn btn-danger modal-text" data-dismiss="modal">Cancelar</a>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#tableClientes').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
            },
            //botones
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                    header: true,
                    title: 'CLIENTES',
                    orientation: 'portrait',
                    pageSize: 'letter',
                    customize: function (doc) {
                        doc.defaultStyle.fontSize = 10;
                        doc.styles.tableHeader.fontSize = 12; //<-- set fontsize to 16 instead of 10 
                        doc.content[1].table.widths = ['14.28%', '14.28%', '14.28%', '14.28%', '14.28%', '14.28%', '14.28%'];
                        doc.defaultStyle.alignment = 'center';
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                }
            ],
            //ordenar
            order: [[1, 'asc']],
            //paginacion
            pageLength: 1000,
            //responsive
            responsive: true,
            //colapsar
            colReorder: true
        });
    });
</script>