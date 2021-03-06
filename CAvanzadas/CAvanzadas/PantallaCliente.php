<?php
require('includes/loginheader.php');
session_start();
require 'includes/ConsultasCliente.php';
require 'includes/ConsultaZonas.php';
if (isset($_SESSION['usuario'])&&($_SESSION['tipoUsuario'] <> 2))  {
$sql = devolverClientes();
?>
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
            $('#ventanaAgregarCliente').on('shown.bs.modal', function (e) {
                
                $(this).find('form').validator()

                $('#nuevoCliente').on('submit', function (e) {
                    if (e.isDefaultPrevented()) {
                    } else {
                        e.preventDefault()
                        // Si se cumple la validacion llama a la funcion de agregar
                        agregarCliente();
                    }
                })
                $('#ventanaAgregarCliente').on('hidden.bs.modal', function (e) {
                    $(this).find('form').off('submit').validator('destroy')
                })
            });
            $('#ventanaAgregarCliente').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });
        });
        

   $(document).ready(function(){
        $("#ventanaEliminarCliente").on("show.bs.modal", function(e) {
            nombreDinamico = $(e.relatedTarget).data('target-id');
            $("#eliminarDinamico").html("Desea eliminar el cliente " + nombreDinamico + "?");
        });
        
   });
   $(document).ready(function () {
       $("#ventanaModificarCliente").on("show.bs.modal", function (e) {
           id = $(e.relatedTarget).data('target-id');
       });
   });
   $(document).ready(function () {
       $("#ventanaAgregarZona").on("show.bs.modal", function (e) {
           id = $(e.relatedTarget).data('target-id');
       });
   });
 function agregarCliente() {
            $('#btnNuevoCliente').prop('disabled', true);
            var nombreCliente = $('#Nombre').val();
            if (nombreCliente == '') {
                swal({
                    title: "Advertencia!",
                    text: "Debe ingresar el Nombre del cliente!",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                $('#btnNuevoCliente').prop('disabled', false);
            }
            else {
             $.post("ajaxCliente.php", //Required URL of the page on server
                   { // Data Sending With Request To Server
                       action: "nuevoCliente",
                       Nombre: nombreCliente
                   },
             function (response, status) { // Required Callback Function
                 if(response=='')
                 {
                     $('#ventanaAgregarCliente').modal('hide');
                     carga('PantallaCliente');
                 }
                 else
                {
                     swal({
                         title: "Advertencia!",
                         text: response,
                         type: "warning",
                         confirmButtonText: "OK"
                     });
                     $('#btnNuevoCliente').prop('disabled', false);
                     $('#Nombre').val('');
                }
             });
            }
        };
        $("#btnModificarCliente").click(function () {
            $('#btnModificarCliente').prop('disabled', true);
            var nombreCliente = $('#NombreM').val();
            if (nombreCliente == '') {
                 swal({
                    title: "Advertencia!",
                    text: "Debe ingresar el Nombre del cliente!",
                    type: "warning",
                    confirmButtonText: "OK"
                 });
                 $('#btnModificarCliente').prop('disabled', false);
            }
            else {
                $.post("ajaxCliente.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "modificarCliente",
                          Nombre: nombreCliente,
                          idCliente : id
                      },
                function (response, status) { // Required Callback Function
                    if (response == '') {
                        $('#ventanaModificarCliente').modal('hide');
                        carga('PantallaCliente');
                    }
                    else {
                        swal({
                            title: "Advertencia!",
                            text: response,
                            type: "warning",
                            confirmButtonText: "OK"
                        });
                        $('#btnModificarCliente').prop('disabled', false);
                        $('#NombreM').val('');
                    }
                });
            }
        });
        $("#btnEliminarCliente").click(function () {
            $('#btnEliminarCliente').prop('disabled', true);
            var nombreCliente = nombreDinamico
            $.post("ajaxCliente.php", //Required URL of the page on server
                    { // Data Sending With Request To Server
                        action: "eliminarCliente",
                        Nombre: nombreCliente,
                    },
            function (response, status) { // Required Callback Function
                if (response == '') {
                    $('#ventanaEliminarCliente').modal('hide');
                    carga('PantallaCliente');
                }
                else {
                    swal({
                        title: "Advertencia!",
                        text: response,
                        type: "warning",
                        confirmButtonText: "OK"
                    });
                }
            });
        });
        function EliminarZona($idZona,$idCliente) {
            var idZona = $idZona;
            var idCliente = $idCliente;
            $.post("ajaxZona.php", //Required URL of the page on server
                  { // Data Sending With Request To Server
                      action: "eliminarZona",
                      idZona: idZona
                  },
            function (response, status) { // Required Callback Function
                $("#ventanaMostrarClienteBody").html("");
                $.post("ajaxCliente.php", //Required URL of the page on server
                  { // Data Sending With Request To Server
                      action: "mostrarCliente",
                      idCliente: idCliente
                  },
                function (response, status) { // Required Callback Function
                    $("#ventanaMostrarClienteBody").html(response);

                });
            });
        }
        $("#btnNuevaZona").click(function () {
            $('#btnNuevaZona').prop('disabled', true);
            var nombreZona = $('#NombreZ').val();
            if (nombreZona == '') {
                swal({
                    title: "Advertencia!",
                    text: "Debe ingresar el Nombre de la zona!",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                $('#btnNuevaZona').prop('disabled', false);
                $('#NombreZ').val('');
            }
            else {
                $.post("ajaxZona.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "nuevoZona",
                          Nombre: nombreZona,
                          idCliente: id,
                      },
                function (response, status) { // Required Callback Function
                    if (response == '') {
                        $('#ventanaAgregarZona').modal('hide');
                        $('#NombreZ').val('');
                        $('#btnNuevaZona').prop('disabled', false);
                        $("#ventanaMostrarClienteBody").html("");
                        $.post("ajaxCliente.php", //Required URL of the page on server
                          { // Data Sending With Request To Server
                              action: "mostrarCliente",
                              idCliente: id
                          },

                        function (response, status) { // Required Callback Function
                            $("#ventanaMostrarClienteBody").html(response);

                        });
                    } else {
                        swal({
                            title: "Advertencia!",
                            text: response,
                            type: "warning",
                            confirmButtonText: "OK"
                        });
                        $('#NombreZ').val('');
                        $('#btnNuevaZona').prop('disabled', false);
                    }
                });
            }
        });

        $("#ventanaMostrarCliente").on("show.bs.modal", function (e) {
            $("#ventanaMostrarClienteBody").html("");
            var idCliente = $(e.relatedTarget).data('target-id');
            var nombreCliente = $(e.relatedTarget).data('target-nombre');
            $("#ventanaMostrarClienteTitle").html('<span class="label label-info">'+nombreCliente+'</span>');
            $.post("ajaxCliente.php", //Required URL of the page on server
              { // Data Sending With Request To Server
                  action: "mostrarCliente",
                  idCliente: idCliente
              },
            function (response, status) { // Required Callback Function
                $("#ventanaMostrarClienteBody").html(response);
 
            });
            
        });
    </script>   

    <!--VENTANA MUESTRA DETALLE CIENTE-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaMostrarCliente">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="ventanaMostrarClienteTitle">Cliente</h4>
                </div>
                <div class="modal-body" id="ventanaMostrarClienteBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!--VENTANA PARA INGRESAR UN NUEVO CIENTE-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaAgregarCliente">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Agregar Cliente</h4>
                </div>
                <div class="modal-body">
                    <form role="form" data-toggle="validator" id="nuevoCliente" name="nuevoCliente">
                        <div class="form-group row">
                            <label for="Nombre" class="col-sm-2 col-form-label">
                                Nombre:
                            </label>
                            <div class="col-sm-8">
                                <input name="Nombre" data-error="Requerido" id="Nombre" type="text" class="form-control" aria-describedby="basic-addon2" required />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="btnNuevoCliente" type="submit" class="btn btn-success success">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--VENTANA PARA INGRESAR UN NUEVA ZONA-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaAgregarZona">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Agregar Zona</h4>
                </div>
                <div class="modal-body">
                    <form name="nuevoZona" method="POST" action="nuevoZona">
                        <div class="form-group row">
                            <label for="Nombre" class="col-sm-2 col-form-label">
                                Nombre:
                            </label>
                            <div class="col-sm-8">
                                <input name="NombreZ" id="NombreZ" type="text" class="form-control" aria-describedby="basic-addon2" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="btnNuevaZona" type="button" class="btn btn-success success">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--VENTANA PARA MODIFICAR UN NUEVO CIENTE-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaModificarCliente">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Modificar Cliente</h4>
                </div>
                <div class="modal-body">
                    <form name="modificarCliente" method="POST" action="modificarCliente">
                        <div class="modal-body" id="modificarDinamico">
                            <input name="idModificar" type="hidden" id="idModificar" class="form-control" aria-describedby="basic-addon2" />
                            <!-- esto se carga dinamico-->
                        </div>
                        <div class="form-group row">
                            <label for="Estado" class="col-sm-2 col-form-label">
                                Nombre:
                            </label>
                            <div class="col-sm-8">
                                <input name="Nombre" id="NombreM" type="text" class="form-control" aria-describedby="basic-addon2" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="btnModificarCliente" type="button" class="btn btn-success success">Modificar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--VENTANA PARA CONFIRMAR QUE SE VA A ELIMINAR EL CIENTE-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaEliminarCliente">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Eliminar Cliente</h4>
                </div>
                <div class="modal-body" id="eliminarDinamico">
                    <input name="NombreEliminar" id="NombreEliminar" class="form-control" aria-describedby="basic-addon2" />
                    <!-- esto se carga dinamico-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="btnEliminarCliente" type="button" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>


    


    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Clientes</h3>
            </div>
            <br />
<button type="button" class="btn btn-default btn-xs " data-target="#ventanaAgregarCliente" data-toggle="modal">
                            <span class="glyphicon glyphicon-plus"></span>Agregar Cliente</button>
            <!-- Table -->
            <table class="table">
                <tr>
                    <th>Nombre</th>
                    <th></th>
                </tr>
                <?php
    $rowcount = mysqli_num_rows($sql);
    if ($rowcount>0) {
        while($rs=mysqli_fetch_array($sql))
        {
                echo "<tr>"
                ."<td>".'<a href="#" data-toggle="modal" data-target-id="'.$rs[0].'" data-target-nombre="'.$rs[1].'" data-target="#ventanaMostrarCliente">'.$rs[1].'</a>'."</td>"
                ."<td>".'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[0].'" data-target="#ventanaModificarCliente" data-toggle="modal">
    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[1].'" data-target="#ventanaEliminarCliente" data-toggle="modal">
    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'
                ."</td>"
                ."</tr>";

        }
    }

                ?>
            </table>
        </div>
    </div>
</body>
</html>
<?php } ?>

