<?php
require 'includes/ConsultasCotizacion.php';
require 'includes/ConsultasRubro.php';
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
            $('#ventanaAgregarCotizacion').on('shown.bs.modal', function (e) {
                $(this).find('form').validator()
                $('#nuevaCotizacion').on('submit', function (e) {
                    if (e.isDefaultPrevented()) {
                    } else {
                        e.preventDefault()
                        // Si se cumple la validacion llama a la funcion de agregar
                        agregarCotizacion();
                    }
                })
                $('#ventanaAgregarCotizacion').on('hidden.bs.modal', function (e) {
                    $(this).find('form').off('submit').validator('destroy')
                })
            });
            $('#ventanaAgregarCotizacion').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });
            $('#ventanaModificarCotizacion').on('shown.bs.modal', function (e) {
                $(this).find('form').validator()
                $('#modificarCotizacion').on('submit', function (e) {
                    if (e.isDefaultPrevented()) {
                    } else {
                        e.preventDefault()
                        modificarCotizacion();
                    }
                })
                $('#ventanaModificarCotizacion').on('hidden.bs.modal', function (e) {
                    $(this).find('form').off('submit').validator('destroy')
                })
            });
            $('#ventanaModificarCotizacion').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });
            $('#ventanaAgregarRubro').on('shown.bs.modal', function (e) {

                $(this).find('form').validator()

                $('#nuevoRubro').on('submit', function (e) {
                    if (e.isDefaultPrevented()) {
                    } else {
                        e.preventDefault()
                        nuevoRubro();
                    }
                })
                $('#ventanaAgregarRubro').on('hidden.bs.modal', function (e) {
                    $(this).find('form').off('submit').validator('destroy')
                })
            });
            $('#ventanaAgregarRubro').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });
        });

   $(document).ready(function(){
        $("#ventanaEliminarCotizacion").on("show.bs.modal", function(e) {
            nombreDinamico = $(e.relatedTarget).data('target-id');
            $("#eliminarDinamico").html("Desea eliminar el cliente " + nombreDinamico + "?");
        });
   });
   $(document).ready(function () {
       $("#ventanaModificarCotizacion").on("show.bs.modal", function (e) {
           id = $(e.relatedTarget).data('target-id');
       });
   });
   $(document).ready(function () {
       $("#ventanaAgregarRubro").on("show.bs.modal", function (e) {
           id = $(e.relatedTarget).data('target-id');
       });
   });
   function agregarCotizacion () {
           $('#btnNuevoCotizacion').prop('disabled', true);
           var nombreCotizacion = $('#Nombre').val();
            if (nombreCotizacion == '') {
                alert("Debe ingresar el Nombre del cotizacion");
                swal({
                    title: "Advertencia!",
                    text: "Debe ingresar el nombre de la cotizacion!",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                $('#btnNuevoCotizacion').prop('disabled', false);
            }
            else {
                $.post("ajaxCotizacion.php", //Required URL of the page on server
                   { // Data Sending With Request To Server
                       action: "nuevaCotizacion",
                       Nombre: nombreCotizacion,
                   },
             function (response, status) { // Required Callback Function
                 $('#ventanaAgregarCotizacion').modal('hide');
                 $("#ventanaMostrarCotizacion").modal('hide');
                 carga('PantallaCotizacion');
             });
            }
        };
         function modificarCotizacion() {
           $('#btnModificarCotizacion').prop('disabled', true);
            var nombreCotizacion = $('#NombreM').val();
            if (nombreCotizacion == '') {
                alert("Debe ingresar el Nombre de la cotizacion");
            }
            else {
                $.post("ajaxCotizacion.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "modificarCotizacion",
                          Nombre: nombreCotizacion,
                          idCotizacion: id
                      },
                function (response, status) { // Required Callback Function
                    $('#ventanaModificarCotizacion').modal('hide');
                    carga('PantallaCotizacion');
                });
            }
        };
       $("#btnEliminarCotizacion").click(function () {
           $('#btnEliminarCotizacion').prop('disabled', true);
           var nombreCotizacion = nombreDinamico
            $.post("ajaxCotizacion.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "eliminarCotizacion",
                          Nombre: nombreCotizacion,
                      },
                function (response, status) { // Required Callback Function
                    $('#ventanaEliminarCotizacion').modal('hide');
                    carga('PantallaCotizacion');
                });
       });
       $("#ventanaMostrarCotizacion").on("show.bs.modal", function (e) {
           $("#ventanaMostrarCotizacionBody").html("");
           var idCotizacion = $(e.relatedTarget).data('target-id');
           var nombreCoti = $(e.relatedTarget).data('target-nombre');
           $("#ventanaMostrarCotizacionTitle").html('<span class="label label-info">' + nombreCoti + '</span>');
           $.post("ajaxCotizacion.php", //Required URL of the page on server
             { // Data Sending With Request To Server
                 action: "mostrarCotizacion",
                 idCotizacion: idCotizacion
             },
           function (response, status) { // Required Callback Function
               $("#ventanaMostrarCotizacionBody").html(response);

           });

       });

       function EliminarRubroPrecio($idRubro, $idCotizacion) {
           var idRubro = $idRubro;
           var idCotizacion = $idCotizacion;
           $.post("ajaxCotizacion.php", //Required URL of the page on server
                 { // Data Sending With Request To Server
                     action: "eliminarRubroPrecio",
                     idRubro: idRubro,
                     idCotizacion: idCotizacion
                 },
           function (response, status) { // Required Callback Function
               $("#ventanaMostrarCotizacionBody").html("");
               $.post("ajaxCotizacion.php", //Required URL of the page on server
                 { // Data Sending With Request To Server
                     action: "mostrarCotizacion",
                     idCotizacion: idCotizacion
                 },
               function (response, status) { // Required Callback Function
                   $("#ventanaMostrarCotizacionBody").html(response);

               });
           });
       }

       function nuevoRubro () {
           $('#btnNuevaRubro').prop('disabled', true);
           var Precio  = $('#Precio').val();
           var idRubro = document.getElementById("rubroCombo").value;
              $.post("ajaxCotizacion.php", //Required URL of the page on server
                 { // Data Sending With Request To Server
                     action: "nuevoRubro",
                     Precio: Precio,
                     idCotizacion: id,
                     nombreRubro: idRubro,
                 },
           function (response, status) { // Required Callback Function
               $('#ventanaAgregarRubro').modal('hide');
               $('#btnNuevaRubro').prop('disabled', false);
               $('#Precio').val("");
               $("#ventanaMostrarCotizacionBody").html("");
               $.post("ajaxCotizacion.php", //Required URL of the page on server
                 { // Data Sending With Request To Server
                     action: "mostrarCotizacion",
                     idCotizacion: id
                 },
               function (response, status) { // Required Callback Function
                   $("#ventanaMostrarCotizacionBody").html(response);

               });
           });
       };

    </script>

    <!--VENTANA MUESTRA DETALLE COTIZACION-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaMostrarCotizacion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="ventanaMostrarCotizacionTitle">Cliente</h4>
                </div>
                <div class="modal-body" id="ventanaMostrarCotizacionBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!--VENTANA PARA INGRESAR UNA NUEVA COTIZACI�N-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaAgregarCotizacion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Agregar Cotizacion</h4>
                </div>
                <div class="modal-body">
                    <form role="form" data-toggle="validator" id="nuevaCotizacion" name="nuevaCotizacion">
                            <div class="form-group row">
                                <label for="Nombre" class="col-sm-2 col-form-label">
                                    Nombre:
                                </label>
                                <div class="col-sm-8">
                                    <input name="Nombre" data-error="Completa este campo" id="Nombre" type="text" class="form-control" aria-describedby="basic-addon2" required />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="btnNuevoCotizacion" type="submit" class="btn btn-success success">Agregar</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

    <!--VENTANA PARA INGRESAR UN NUEVO RUBRO-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaAgregarRubro">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Agregar Rubro</h4>
                </div>
                <div class="modal-body">
                    <form role="form" data-toggle="validator" id="nuevoRubro" name="nuevoRubro">
                            <div class="form-group row">
                                <label for="Rubro" class="col-sm-2 col-form-label">
                                    Rubro:
                                </label>
                                <div class="col-sm-8">
                                    <select name='rubroCombo' id='rubroCombo'>
                                        <?php
    $sql = devolverRubros();
    while ($rs=mysqli_fetch_array($sql))
    {
        echo "<option value='".$rs[Nombre]."|".$rs[Unidad]."' selected>".$rs[Nombre]."</option>";
    }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Compra" class="col-sm-2 col-form-label">
                                    Precio:
                                </label>
                                <div class="col-sm-8">
                                    <input name="Precio" data-error="Completa este campo" id="Precio" type="number" class="form-control" aria-describedby="basic-addon2" required />
                                    <div class="help-block with-errors"></div>
                                 </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="btnNuevaRubro" type="submit" class="btn btn-success success">Agregar</button>
                            </div>
                        </form>
</div>
            </div>
        </div>
    </div>

    <!--VENTANA PARA MODIFICAR UNA NUEVA COTIZACI�N-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaModificarCotizacion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Modificar Cotizaci�n</h4>
                </div>
                <div class="modal-body">
                    <form role="form" data-toggle="validator" id="modificarCotizacion" name="modificarCotizacion">
                            <div class="modal-body" id="modificarDinamico">
                                <input name="idModificar" type="hidden" id="idModificar" class="form-control" aria-describedby="basic-addon2" />
                                <!-- esto se carga dinamico-->
                            </div>
                            <div class="form-group row">
                                <label for="Nombre" class="col-sm-2 col-form-label">
                                    Nombre:
                                </label>
                                <div class="col-sm-8">
                                    <input name="Nombre" data-error="Completa este campo" id="NombreM" type="text" class="form-control" aria-describedby="basic-addon2" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="btnModificarCotizacion" type="submit" class="btn btn-success success">Modificar</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--VENTANA PARA CONFIRMAR QUE SE VA A ELIMINAR LA COTIZACION-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaEliminarCotizacion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Eliminar Cotizaci�n</h4>
                </div>
                <div class="modal-body" id="eliminarDinamico">
                    <input name="NombreEliminar" id="NombreEliminar" class="form-control" aria-describedby="basic-addon2" />
                    <!-- esto se carga dinamico-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="btnEliminarCotizacion" type="button" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <h3 class="panel-title">Cotizaciones</h3>
        </div>
        <nav class="navbar navbar-toolbar navbar-default">
            <div class="container-fluid">
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a type="button" class="btn btn-default" aria-label="Left Align" href="#ventanaAgregarCotizacion" data-toggle="modal">
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
            </tr>
            <?php
            $sql = listaCotizacion();
            $rowcount = mysqli_num_rows($sql);
            if ($rowcount>0) {
                while($rs=mysqli_fetch_array($sql))
                {
                    echo "<tr>"
                    ."<td>".'</button><a href="#" data-toggle="modal" data-target-id="'.$rs[0].'" data-target-nombre="'.$rs[1].'" data-target="#ventanaMostrarCotizacion">'.$rs[1].'</a>'."</td>"
                    ."<td>".'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[0].'" data-target="#ventanaModificarCotizacion" data-toggle="modal">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[1].'" data-target="#ventanaEliminarCotizacion" data-toggle="modal">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'
                    ."</td>"
                    ."</tr>";
                }
            }
           ?>
        </table>
    </div>
</body>
</html>
<?php } ?>

