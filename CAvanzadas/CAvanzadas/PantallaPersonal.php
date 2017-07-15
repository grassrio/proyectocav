<?php
require('includes/loginheader.php');
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
            $("#ventanaEliminarPersonal").on("show.bs.modal", function (e) {
                id = $(e.relatedTarget).data('target-id');
                $("#eliminarDinamico").html("Desea eliminar el empleado ?");
            });
        });

        $(document).ready(function () {
            $("#ventanaModificarPersonal").on("show.bs.modal", function (e) {
                id = $(e.relatedTarget).data('target-id');
            });
        });

        $("#btnNuevoPersonal").click(function () {
            $('#btnNuevoPersonal').prop('disabled', true);
            var nombrePersonal = $('#nombrePersonal').val();
            var apellidoPersonal = $('#apellidoPersonal').val();
            var direccionPersonal = $('#direccionPersonal').val();
            var telefonoPersonal = $('#telefonoPersonal').val();
            var cargoPersonal = document.getElementById("cargoPersonal").value;
            if (nombrePersonal == '') {
                swal({
                    title: "Advertencia!",
                    text: "Debe ingresar el nombre del empleado!",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                $('#btnNuevoPersonal').prop('disabled', false);
            } else if (apellidoPersonal == '') {
                swal({
                    title: "Advertencia!",
                    text: "Debe ingresar el apellido del empleado!",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                $('#btnNuevoPersonal').prop('disabled', false);
            }
            else if (telefonoPersonal == '') {
                swal({
                    title: "Advertencia!",
                    text: "Debe ingresar el telefono del empleado!",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                $('#btnNuevoPersonal').prop('disabled', false);
            }
            else if (direccionPersonal == '') {
                swal({
                    title: "Advertencia!",
                    text: "Debe ingresar la direccion del empleado!",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                $('#btnNuevoPersonal').prop('disabled', false);
            }
            else {
                $.post("ajaxPersonal.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "nuevoPersonal",
                          Nombre: nombrePersonal,
                          Apellido: apellidoPersonal,
                          Direccion: direccionPersonal,
                          Cargo: cargoPersonal,
                          Telefono: telefonoPersonal,
                      },
                function (response, status) { // Required Callback Function
                    if (response == '') {
                        $('#ventanaAgregarPersonal').modal('hide');
                        carga('PantallaPersonal');

                    } else {
                        swal({
                            title: "Advertencia!",
                            text: response,
                            type: "warning",
                            confirmButtonText: "OK"
                        });
                           $('#btnNuevoPersonal').prop('disabled', false);
                        $('#nombrePersonal').val('');
                        $('#apellidoPersonal').val('');
                        $('#direccionPersonal').val('');
                        $('#telefonoPersonal').val('');
                        $('#cargoPersonal').val('');
                    }

                });
            }
        });
        $("#btnModificarPersonal").click(function () {
            $('#btnModificarPersonal').prop('disabled', true);
            var direccionPersonal = $('#direccionPersonalM').val();
            var telefonoPersonal = $('#telefonoPersonalM').val();
            var cargoPersonal = document.getElementById("cargoPersonalM").value;
            if (telefonoPersonal == '') {
                swal({
                    title: "Advertencia!",
                    text: "Debe ingresar el telefono del empleado!",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                $('#btnModificarPersonal').prop('disabled', false);
            }
            else if (direccionPersonal == '') {
                swal({
                    title: "Advertencia!",
                    text: "Debe ingresar la direccion del empleado!",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                $('#btnModificarPersonal').prop('disabled', false);
            }
            else {
                $.post("ajaxPersonal.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "modificarPersonal",
                          Direccion: direccionPersonal,
                          Cargo: cargoPersonal,
                          Telefono: telefonoPersonal,
                          idPersonal: id,
                      },
                function (response, status) { // Required Callback Function
                    if (response == '') {
                        $('#ventanaModificarPersonal').modal('hide');
                        carga('PantallaPersonal');
                    }
                    else {
                        swal({
                            title: "Advertencia!",
                            text: response,
                            type: "warning",
                            confirmButtonText: "OK"
                        });
                        $('#btnModificarPersonal').prop('disabled', false);
                        $('#direccionPersonalM').val('');
                        $('#telefonoPersonalM').val('');
                    }

                });
            }
        });
        $("#btnEliminarPersonal").click(function () {
            $('#btnEliminarPersonal').prop('disabled', true);
            $.post("ajaxPersonal.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "eliminarPersonal",
                          idPersonal: id
                      },
                function (response, status) { // Required Callback Function
                    if (response == '') {
                        $('#ventanaEliminarPersonal').modal('hide');
                        carga('PantallaPersonal');
                    }
                    else {
                        swal({
                            title: "Advertencia!",
                            text: response,
                            type: "warning",
                            confirmButtonText: "OK"
                        });
                        $('#btnEliminarPersonal').prop('disabled', false);
                    }

                });
        });

    </script>

    <!--VENTANA PARA INGRESAR UN NUEVO EMPLEADO-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaAgregarPersonal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Agregar Empleado</h4>
                </div>
                <div class="modal-body">
                    <form name="nuevoPersonal" method="POST" action="nuevoRubro">
                        <div class="form-group row">
                            <label for="Nombre" class="col-sm-2 col-form-label">
                                Nombre:
                            </label>
                            <div class="col-sm-8">
                                <input name="nombrePersonal" id="nombrePersonal" type="text" class="form-control" aria-describedby="basic-addon2" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Apellido" class="col-sm-2 col-form-label">
                                Apellido:
                            </label>
                            <div class="col-sm-8">
                                <input name="apellidoPersonal" id="apellidoPersonal" type="text" class="form-control" aria-describedby="basic-addon2" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Direccion" class="col-sm-2 col-form-label">
                                Direccion:
                            </label>
                            <div class="col-sm-8">
                                <input name="direccionPersonal" id="direccionPersonal" type="text" class="form-control"  aria-describedby="basic-addon2" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Telefono" class="col-sm-2 col-form-label">
                                Telefono:
                            </label>
                            <div class="col-sm-8">
                                <input name="telefonoPersonal" id="telefonoPersonal" type="text" class="form-control"  aria-describedby="basic-addon2" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Telefono" class="col-sm-2 col-form-label">
                                Telefono:
                            </label>
                            <div class="col-sm-8">
                                <select name='cargoPersonal' id='cargoPersonal'>
                                    <option value='Director' selected>Director</option>
                                    <option value='Administrador' selected>Administrador</option>
                                    <option value='Obrero' selected>Obrero</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="btnNuevoPersonal" type="button" class="btn btn-success success">Agregar</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--VENTANA PARA MODIFICAR UN PERSONAL-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaModificarPersonal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Modificar Personal</h4>
                </div>
                <div class="modal-body">
                    <form name="modificarPersonal" method="POST" action="modificarPersonal">
                        <div class="form-group row">
                            <label for="Direccion" class="col-sm-2 col-form-label">
                                Direccion:
                            </label>
                            <div class="col-sm-8">
                                <input name="direccionPersonalM" id="direccionPersonalM" type="text" class="form-control" value="0" aria-describedby="basic-addon2" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Telefono" class="col-sm-2 col-form-label">
                                Telefono:
                            </label>
                            <div class="col-sm-8">
                                <input name="telefonoPersonalM" id="telefonoPersonalM" type="text" class="form-control" value="0" aria-describedby="basic-addon2" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Cargo" class="col-sm-2 col-form-label">
                                Cargo:
                            </label>
                            <div class="col-sm-8">
                                <select name='cargoPersonalM' id='cargoPersonalM'>
                                    <option value='Director' selected>Director</option>
                                    <option value='Administrador' selected>Administrador</option>
                                    <option value='Obrero' selected>Obrero</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="btnModificarPersonal" type="button" class="btn btn-success success">Modificar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--VENTANA PARA ELIMINAR-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaEliminarPersonal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Eliminar personal</h4>
                </div>
                <div class="modal-body" id="eliminarDinamico">
                    <input name="NombreEliminar" id="NombreEliminar" type="hidden" class="form-control" aria-describedby="basic-addon2" />
                    <!-- esto se carga dinamico-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="btnEliminarPersonal" type="button" class="btn btn-danger">Eliminar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <h3 class="panel-title">Empleados</h3>
        </div>


        <nav class="navbar navbar-toolbar navbar-default">
            <div class="container-fluid">
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a type="button" class="btn btn-default" aria-label="Left Align" href="#ventanaAgregarPersonal" data-toggle="modal">
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
                <th>Apellido</th>
                <th>Cargo</th>
                <th>Telefono</th>
                <th></th>
                <th></th>
            </tr>
            <?php
    require 'includes/ConsultasPersonal.php';
    $sql = devolverPersonal();
    $rowcount = mysqli_num_rows($sql);
    if ($rowcount>0) {
        while($rs=mysqli_fetch_array($sql))
        {
            echo "<tr>"
            ."<td>".$rs[1]."</td>"
            ."<td>".$rs[2]."</td>"
            ."<td>".$rs[5]."</td>"
            ."<td>".$rs[4]."</td>"
            ."<td>".'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[0].'" data-target="#ventanaEliminarPersonal" data-toggle="modal">
<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
</button>'.'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[0].'" data-target="#ventanaModificarPersonal" data-toggle="modal">
<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'
            ."</td>"
            ."</tr>";
        }
    }
    else
    {
        echo'<tr><td>No hay Empleados</td></tr>';
    }

            ?>

        </table>
    </div>

</body>
</html>
<?php } ?>