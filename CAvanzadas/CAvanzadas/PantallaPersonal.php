<?php
require('includes/loginheader.php');
session_start();
$tipoUsuario = $_SESSION['tipoUsuario'];
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
            $('#ventanaAgregarPersonal').on('shown.bs.modal', function (e) {

                $(this).find('form').validator()

                $('#nuevoPersonal').on('submit', function (e) {
                    if (e.isDefaultPrevented()) {
                    } else {
                        e.preventDefault()
                        // Si se cumple la validacion llama a la funcion de agregar
                        agregarPersonal();
                    }
                })
                $('#ventanaAgregarPersonal').on('hidden.bs.modal', function (e) {
                    $(this).find('form').off('submit').validator('destroy')
                })
            });
            $('#ventanaAgregarPersonal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });

            $('#ventanaModificarPersonal').on('shown.bs.modal', function (e) {

                $(this).find('form').validator()

                $('#modificarPersonal').on('submit', function (e) {
                    if (e.isDefaultPrevented()) {
                    } else {
                        e.preventDefault()
                        // Si se cumple la validacion llama a la funcion de agregar
                        ModificarPersonal();
                    }
                })
                $('#ventanaModificarPersonal').on('hidden.bs.modal', function (e) {
                    $(this).find('form').off('submit').validator('destroy')
                })
            });
            $('#ventanaModificarPersonal').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });
        });
        $(document).ready(function () {
            $("#ventanaEliminarPersonal").on("show.bs.modal", function (e) {
                nombreDinamico = $(e.relatedTarget).data('target-id');
                $("#eliminarDinamico").html("Desea eliminar el empleado " + nombreDinamico + "?");
            });
        });

        $(document).ready(function () {
            $("#ventanaModificarPersonal").on("show.bs.modal", function (e) {
                id = $(e.relatedTarget).data('target-id');
            });
        });

        function agregarPersonal() {
            $('#btnNuevoPersonal').prop('disabled', true);
            var nombreCompleto = $('#nombreCompleto').val();
            var direccionPersonal = $('#direccionPersonal').val();
            var telefonoPersonal = $('#telefonoPersonal').val();
            var cargoPersonal = document.getElementById("cargoPersonal").value;
            var nombreUsuario = $('#Usuario').val();
            var passUsuario = $('#Contrasenia').val();
            if (nombreCompleto == '') {
                swal({
                    title: "Advertencia!",
                    text: "Debe ingresar el nombre del empleado!",
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
                          NombreCompleto: nombreCompleto,
                          Direccion: direccionPersonal,
                          Cargo: cargoPersonal,
                          Telefono: telefonoPersonal,
                          NombreUsu: nombreUsuario,
                          Pass: passUsuario,
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
                        $('#nombreCompleto').val('');
                        $('#apellidoPersonal').val('');
                        $('#direccionPersonal').val('');
                        $('#telefonoPersonal').val('');
                        $('#cargoPersonal').val('');
                    }

                });
            }
        };
        function ModificarPersonal() {
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
        };
        $("#btnEliminarPersonal").click(function () {
            $('#btnEliminarPersonal').prop('disabled', true);
            $.post("ajaxPersonal.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "eliminarPersonal",
                          NombreCompleto: nombreDinamico
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
                    <form role="form" data-toggle="validator" id="nuevoPersonal" name="nuevoPersonal">
                            <div class="form-group row">
                                <label for="Nombre" class="col-sm-2 col-form-label">
                                    Nombre Completo:
                                </label>
                                <div class="col-sm-8">
                                    <input name="nombreCompleto" data-error="Completa este campo" id="nombreCompleto" type="text" class="form-control" aria-describedby="basic-addon2" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Direccion" class="col-sm-2 col-form-label">
                                    Direccion:
                                </label>
                                <div class="col-sm-8">
                                    <input name="direccionPersonal" data-error="Completa este campo" id="direccionPersonal" type="text" class="form-control" aria-describedby="basic-addon2" required>
                                    <div class="help-block with-errors"></div>                                
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Telefono" class="col-sm-2 col-form-label">
                                    Telefono:
                                </label>
                                <div class="col-sm-8">
                                    <input name="telefonoPersonal" data-error="Completa este campo" id="telefonoPersonal" type="text" class="form-control" aria-describedby="basic-addon2" required>
                                    <div class="help-block with-errors"></div>                              
                                  </div>
                            </div>
                            <div class="form-group row">
                                <label for="Cargo" class="col-sm-2 col-form-label">
                                    Cargo:
                                </label>
                                <div class="col-sm-8">
                                    <select name='cargoPersonal' id='cargoPersonal'>
                                        <option value='Director' selected>Director</option>
                                        <option value='Administrador' selected>Administrador</option>
                                        <option value='Obrero' selected>Obrero</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Usuario" class="col-sm-2 col-form-label">
                                  Nombre usuario:
                                </label>
                                <div class="col-sm-8">
                                    <input name="Usuario" data-error="Completa este campo" id="Usuario" type="text" class="form-control" aria-describedby="basic-addon2" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        <div class="form-group row">
                            <label for="Contrasenia" class="col-sm-2 col-form-label">
                                Contraseña:
                            </label>
                            <div class="form-group col-sm-4">
                                <input name="Contrasenia" data-minlength="6" placeholder="Contraseña" id="Contrasenia" type="password" class="form-control" aria-describedby="basic-addon2" required>
                                <div class="help-block">Mínimo de 6 caracteres</div>
                            </div>
                            <div class="form-group col-sm-4">
                                <input name="CContrasenia" data-match="#Contrasenia" placeholder="Confirmar" data-match-error="Las contraseñas no coinciden" id="CContrasenia" type="password" class="form-control" aria-describedby="basic-addon2" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="btnNuevoPersonal" type="submit" class="btn btn-success success">Agregar</button>
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
                    <form role="form" data-toggle="validator" id="modificarPersonal" name="modificarPersonal">
                            <div class="form-group row">
                                <label for="Direccion" class="col-sm-2 col-form-label">
                                    Direccion:
                                </label>
                                <div class="col-sm-8">
                                    <input name="direccionPersonalM"  data-error="Completa este campo" id="direccionPersonalM" type="text" class="form-control" aria-describedby="basic-addon2" required>
                                    <div class="help-block with-errors"></div>                                      
                                 </div>
                            </div>
                            <div class="form-group row">
                                <label for="Telefono" class="col-sm-2 col-form-label">
                                    Telefono:
                                </label>
                                <div class="col-sm-8">
                                    <input name="telefonoPersonalM"  data-error="Completa este campo" id="telefonoPersonalM" type="number" class="form-control" aria-describedby="basic-addon2" required>
                                    <div class="help-block with-errors"></div>                                       
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
                                <button id="btnModificarPersonal" type="submit" class="btn btn-success success">Modificar</button>
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
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Empleados</h3>
            </div>
        </div>
                <?php
                if($tipoUsuario == 1){
                    echo'<button type="button" class="btn btn-default btn-xs " data-target="#ventanaAgregarPersonal" data-toggle="modal">
                                        <span class="glyphicon glyphicon-plus"></span>Agregar Personal</button>';
                }
                ?>
        <!-- Table -->
        <table class="table">
            <tr>
                <th>Nombre Completo</th>
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
           if($tipoUsuario == 1)
           {
               echo "<tr>"
               ."<td>".$rs[1]."</td>"
               ."<td>".$rs[4]."</td>"
               ."<td>".$rs[3]."</td>"
               ."<td>".'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[0].'" data-target="#ventanaModificarPersonal" data-toggle="modal">
<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'.'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[1].'" data-target="#ventanaEliminarPersonal" data-toggle="modal">
<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
</button>'
               ."</td>"
               ."</tr>";             
           }
           else
           {
               echo "<tr>"
               ."<td>".$rs[1]."</td>"
               ."<td>".$rs[4]."</td>"
               ."<td>".$rs[3]."</td>"
               ."</tr>";            
           }

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