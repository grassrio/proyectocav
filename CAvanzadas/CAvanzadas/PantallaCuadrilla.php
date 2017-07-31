<?php
require('includes/loginheader.php');
require 'includes/ConsultasCuadrilla.php';
require 'includes/ConsultasPersonal.php';
session_start();
if (isset($_SESSION['usuario'])) {?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
    </head>
    <body>
        <script>
            var nombreDinamico;
            var id;

            $(document).ready(function () {
                $('#ventanaAgregarCuadrilla').on('shown.bs.modal', function (e) {
                    $(this).find('form').validator()
                    $('#nuevaCuadrilla').on('submit', function (e) {
                        if (e.isDefaultPrevented()) {
                        } else {
                            e.preventDefault()
                            // Si se cumple la validacion llama a la funcion de agregar
                            agregarCuadrilla();
                        }
                    })
                    $('#ventanaAgregarCuadrilla').on('hidden.bs.modal', function (e) {
                        $(this).find('form').off('submit').validator('destroy')
                    })
                });
                $('#ventanaAgregarCuadrilla').on('hidden.bs.modal', function () {
                    $(this).find('form')[0].reset();
                });
                $('#ventanaModificarCuadrilla').on('shown.bs.modal', function (e) {
                    $(this).find('form').validator()
                    $('#modificarCuadrilla').on('submit', function (e) {
                        if (e.isDefaultPrevented()) {
                        } else {
                            e.preventDefault()
                            modificarCuadrilla();
                        }
                    })
                    $('#ventanaModificarCuadrilla').on('hidden.bs.modal', function (e) {
                        $(this).find('form').off('submit').validator('destroy')
                    })
                });
                $('#ventanaModificarCuadrilla').on('hidden.bs.modal', function () {
                    $(this).find('form')[0].reset();
                });
                $('#ventanaAgregarObrero').on('shown.bs.modal', function (e) {

                    $(this).find('form').validator()

                    $('#nuevoObrero').on('submit', function (e) {
                        if (e.isDefaultPrevented()) {
                        } else {
                            e.preventDefault()
                           nuevaObra();
                        }
                    })
                    $('#ventanaAgregarObrero').on('hidden.bs.modal', function (e) {
                        $(this).find('form').off('submit').validator('destroy')
                    })
                });
                $('#ventanaAgregarObrero').on('hidden.bs.modal', function () {
                    $(this).find('form')[0].reset();
                });
            });

            $(document).ready(function () {
                $("#ventanaEliminarCuadrilla").on("show.bs.modal", function (e) {
                    nombreDinamico = $(e.relatedTarget).data('target-id');
                    $("#eliminarDinamico").html("Desea eliminar la cuadrilla "+ nombreDinamico+ "?");
                });
            });

            $(document).ready(function () {
                $("#ventanaModificarCuadrilla").on("show.bs.modal", function (e) {
                    id = $(e.relatedTarget).data('target-id');
                });
            });
            $(document).ready(function () {
                $("#ventanaAgregarObrero").on("show.bs.modal", function (e) {
                    id = $(e.relatedTarget).data('target-id');
                });
            });
            function agregarCuadrilla() {
                $('#btnNuevoCuadrilla').prop('disabled', true);
                var nombreCuadrilla = $('#nombreCuadrilla').val();
                if (nombreCuadrilla == '') {
                    swal({
                        title: "Advertencia!",
                        text: "Debe ingresar el nombre de la cuadrilla!",
                        type: "warning",
                        confirmButtonText: "OK"
                    });
                    $('#btnNuevoCuadrilla').prop('disabled', false);
                } 
                else
                {
                    $.post("ajaxCuadrilla.php", //Required URL of the page on server
                          { // Data Sending With Request To Server
                              action: "nuevaCuadrilla",
                              Nombre: nombreCuadrilla
                          },
                    function (response, status) { // Required Callback Function
                        if (response == '') {
                            $('#ventanaAgregarCuadrilla').modal('hide');
                            carga('PantallaCuadrilla');
                        } else {
                            swal({
                                title: "Advertencia!",
                                text: response,
                                type: "warning",
                                confirmButtonText: "OK"
                            });
                            $('#btnNuevoCuadrilla').prop('disabled', false);
                            $('#nombreCuadrilla').val('');
                        }
                    });
                }
            };
            function modificarCuadrilla() {
                $('#btnModificarCuadrilla').prop('disabled', true);
                var nombreCuadrilla = $('#nombreCuadrillaM').val();
                if (nombreCuadrilla == '') {
                    swal({
                        title: "Advertencia!",
                        text: "Debe ingresar el nombre de la cuadrilla!",
                        type: "warning",
                        confirmButtonText: "OK"
                    });
                    $('#btnModificarCuadrilla').prop('disabled', false);
                }
                else
                {
                    $.post("ajaxCuadrilla.php", //Required URL of the page on server
                          { // Data Sending With Request To Server
                              action: "modificarCuadrilla",
                              Nombre: nombreCuadrilla,
                              idCuadrilla: id
                          },
                    function (response, status) { // Required Callback Function
                        if (response == '') {
                            $('#ventanaModificarCuadrilla').modal('hide');
                            carga('PantallaCuadrilla');
                        }
                        else {
                            swal({
                                title: "Advertencia!",
                                text: response,
                                type: "warning",
                                confirmButtonText: "OK"
                            });
                            $('#btnModificarCuadrilla').prop('disabled', false);
                            $('#nombreCuadrillaM').val('');
                        }

                    });
                }
            };
            $("#btnEliminarCuadrilla").click(function () {
                $('#btnEliminarCuadrilla').prop('disabled', true);
                $.post("ajaxCuadrilla.php", //Required URL of the page on server
                          { // Data Sending With Request To Server
                              action: "eliminarCuadrilla",
                              Nombre: nombreDinamico,
                          },
                    function (response, status) { // Required Callback Function
                        if (response == '') {
                            $('#ventanaEliminarCuadrilla').modal('hide');
                            carga('PantallaCuadrilla');
                        }
                        else {
                            swal({
                                title: "Advertencia!",
                                text: response,
                                type: "warning",
                                confirmButtonText: "OK"
                            });
                            $('#btnEliminarCuadrilla').prop('disabled', false);
                        }

                    });
            });
            $("#ventanaMostrarCuadrilla").on("show.bs.modal", function (e) {
                $("#ventanaMostrarCuadrillaBody").html("");
                var idCuadrilla = $(e.relatedTarget).data('target-id');
                var nombreCuadrilla = $(e.relatedTarget).data('target-nombre');
                $("#ventanaMostrarCuadrillaTitle").html('<span class="label label-info">' + nombreCuadrilla + '</span>');
                $.post("ajaxCuadrilla.php", //Required URL of the page on server
                  { // Data Sending With Request To Server
                      action: "mostrarCuadrilla",
                      idCuadrilla: idCuadrilla
                  },
                function (response, status) { // Required Callback Function
                    $("#ventanaMostrarCuadrillaBody").html(response);

                });

            });
            function EliminarObrero($idPersonal,$idCuadrilla) {
                var idCuadrilla = $idCuadrilla;
                var idObrero = $idPersonal;
                $.post("ajaxCuadrilla.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "eliminarObrero",
                          idCuadrilla: idCuadrilla,
                          idObrero: idObrero,
                      },
                function (response, status) { // Required Callback Function
                    $("#ventanaMostrarCuadrillaBody").html("");
                    $.post("ajaxCuadrilla.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "mostrarCuadrilla",
                          idCuadrilla: idCuadrilla
                      },
                    function (response, status) { // Required Callback Function
                        $("#ventanaMostrarCuadrillaBody").html(response);
                    });

                });
            }
            function nuevaObra () {
                $('#btnNuevoObrero').prop('disabled', true);
                var porcentaje = $('#Porcentaje').val();
                var NombreCompleto = document.getElementById("ObreroCombo").value;
                alert(porcentaje);
                alert(NombreCompleto);
                alert(id);
                if (porcentaje < 0 || porcentaje > 100) {
                    swal({
                        title: "Advertencia!",
                        text: "El porcentaje tiene que ser mayor que 0 y menor que 100!",
                        type: "warning",
                        confirmButtonText: "OK"
                    });
                    $('#btnNuevoObrero').prop('disabled', false);
                    $('#Porcentaje').val('');
                }
                else {
                    $.post("ajaxCuadrilla.php", //Required URL of the page on server
                          { // Data Sending With Request To Server
                              action: "nuevoObrero",
                              Porcentaje: porcentaje,
                              idCuadrilla: id,
                              Nombre: NombreCompleto,
                          },
                    function (response, status) { // Required Callback Function
                        if (response == '')
                        {
                            $('#ventanaAgregarObrero').modal('hide');
                            $('#Porcentaje').val('');
                            $('#btnNuevoObrero').prop('disabled', false);
                            $("#ventanaMostrarCuadrillaBody").html("");
                            $.post("ajaxCuadrilla.php", //Required URL of the page on server
                                { // Data Sending With Request To Server
                                    action: "mostrarCuadrilla",
                                    idCuadrilla: id
                                },

                            function (response, status) { // Required Callback Function
                                $("#ventanaMostrarCuadrillaBody").html(response);
                            });
                        }
                        else
                        {
                            alert(response);
                        }

                    });
                }
            };
        </script>

        <!--VENTANA MUESTRA DETALLE CUADRILLA-->
        <div class="modal fade" tabindex="-1" role="dialog" id="ventanaMostrarCuadrilla">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="ventanaMostrarCuadrillaTitle">Cuadrilla</h4>
                    </div>
                    <div class="modal-body" id="ventanaMostrarCuadrillaBody"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!--VENTANA PARA INGRESAR UN NUEVA CUADRILLA-->
        <div class="modal fade" tabindex="-1" role="dialog" id="ventanaAgregarCuadrilla">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Agregar Cuadrilla</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" data-toggle="validator" id="nuevaCuadrilla" name="nuevaCuadrilla">
                                <div class="form-group row">
                                    <label for="Nombre" class="col-sm-2 col-form-label">
                                        Nombre:
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="nombreCuadrilla" data-error="Completa este campo" id="nombreCuadrilla" type="text" class="form-control" aria-describedby="basic-addon2" required />
                                        <div class="help-block with-errors"></div>                                   
                                     </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button id="btnNuevoCuadrilla" type="submit" class="btn btn-success success">Agregar</button>
                                </div>
                            </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!--VENTANA PARA INGRESAR OBRERO-->
        <div class="modal fade" tabindex="-1" role="dialog" id="ventanaAgregarObrero">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Agregar Obrero</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" data-toggle="validator" id="nuevoObrero" name="nuevoObrero">
                                <div class="form-group row">
                                    <label for="Obrero" class="col-sm-2 col-form-label">
                                        Obrero:
                                    </label>
                                    <div class="col-sm-8">
                                        <select name='ObreroCombo' id='ObreroCombo'>
                                            <?php
                                            $sql = devolverObreros();
                                            while ($rs=mysqli_fetch_array($sql))
                                            {
                                                echo "<option value='".$rs[1]."' selected>".$rs[1]."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Porcentaje" class="col-sm-2 col-form-label">
                                        Porcentaje:
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="Porcentaje" data-error="Completa este campo" id="Porcentaje" type="number" class="form-control" aria-describedby="basic-addon2" required />
                                        <div class="help-block with-errors"></div>
                                      </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button id="btnNuevoObrero" type="submit" class="btn btn-success success">Agregar</button>
                                </div>
                            </form>
</div>
                </div>
            </div>
        </div>

        <!--VENTANA PARA MODIFICAR CUADRILLA -->
        <div class="modal fade" tabindex="-1" role="dialog" id="ventanaModificarCuadrilla">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Modificar Cuadrilla</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" data-toggle="validator" id="modificarCuadrilla" name="modificarCuadrilla">
                                <div class="form-group row">
                                    <label for="Nombre" class="col-sm-2 col-form-label">
                                        Nombre:
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="nombreCuadrillaM" data-error="Completa este campo" id="nombreCuadrillaM" type="text" class="form-control" aria-describedby="basic-addon2" required />
                                        <div class="help-block with-errors"></div>                                
                                   </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button id="btnModificarCuadrilla" type="submit" class="btn btn-success success">Modificar</button>
                                </div>
                            </form>
</div>
                </div>
            </div>
        </div>

        <!--VENTANA PARA ELIMINAR CUADRILLA-->
        <div class="modal fade" tabindex="-1" role="dialog" id="ventanaEliminarCuadrilla">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Eliminar Cuadrilla</h4>
                    </div>
                    <div class="modal-body" id="eliminarDinamico">
                        <input name="NombreEliminar" id="NombreEliminar" type="hidden" class="form-control" aria-describedby="basic-addon2" />
                        <!-- esto se carga dinamico-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="btnEliminarCuadrilla" type="button" class="btn btn-danger">Eliminar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Cuadrillas</h3>
                </div>
            </div>
            <nav class="navbar navbar-toolbar navbar-default">
                <div class="container-fluid">
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li>
                                <a type="button" class="btn btn-default" aria-label="Left Align" href="#ventanaAgregarCuadrilla" data-toggle="modal">
                                    <span onclick="" class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </a>
                            </li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
            <!-- Table -->
            <table class="table">
                <tr>
                    <th>Nombre</th>
                      <th></th>
                    <th></th>
                </tr>
                <?php
        $sql = listarCuadrillas();
        $rowcount = mysqli_num_rows($sql);
        if ($rowcount>0) {
            while($rs=mysqli_fetch_array($sql))
            {
                echo "<tr>"
                ."<td>".'<a href="#" data-toggle="modal" data-target-id="'.$rs[0].'" data-target-nombre="'.$rs[1].'" data-target="#ventanaMostrarCuadrilla">'.$rs[1].'</a>'."</td>"
                ."<td>".'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[0].'" data-target="#ventanaModificarCuadrilla" data-toggle="modal">
    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'.'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[1].'" data-target="#ventanaEliminarCuadrilla" data-toggle="modal">
    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
    </button>'
                ."</td>"
                ."</tr>";
            }
        }
        else
        {
            echo'<tr><td>No hay cuadrillas registradas en el sistema</td></tr>';
        }

                ?>

            </table>
        </div>

    </body>
    </html>
<?php } ?>