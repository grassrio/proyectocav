<?php
require('includes/loginheader.php');
session_start();
require 'includes/ConsultasCliente.php';
$sql = devolverClientes();
$rowcount = mysqli_num_rows($sql);
if ($rowcount>0) {?>
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
   $(document).ready(function(){
        $("#ventanaEliminarCliente").on("show.bs.modal", function(e) {
            nombreDinamico = $(e.relatedTarget).data('target-id');
            $("#eliminarDinamico").html("Desea eliminar el cliente " + id + "?");
        });
   });
   $(document).ready(function () {
       $("#ventanaModificarCliente").on("show.bs.modal", function (e) {
           id = $(e.relatedTarget).data('target-id');
       });
   });
        $("#btnNuevoCliente").click(function () {
            $('#btnNuevoCliente').prop('disabled', true);
            var nombreCliente = $('#Nombre').val();
            var zona = $('#zona').val();
            if (nombreCliente == '') {
                alert("Debe ingresar el Nombre del cliente");
                if(zona ==''){
                    alert("Debe ingresar la zona del cliente");
                }
            }
            else {
             $.post("ajaxCliente.php", //Required URL of the page on server
                   { // Data Sending With Request To Server
                       action: "nuevoCliente",
                       Nombre: nombreCliente,
                       Zona: zona,
                   },
             function (response, status) { // Required Callback Function
                 $('#ventanaAgregarCliente').modal('hide');
                 carga('PantallaCliente');
             });
            }
        });
        $("#btnModificarCliente").click(function () {
            $('#btnModificarCliente').prop('disabled', true);
            var nombreCliente = $('#NombreM').val();
            var zona = $('#zonaM').val();
            if (nombreCliente == '') {
                alert("Debe ingresar el Nombre del cliente");
                if (zona == '') {
                    alert("Debe ingresar la zona del cliente");
                }
            }
            else {
                $.post("ajaxCliente.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "modificarCliente",
                          Nombre: nombreCliente,
                          Zona: zona,
                          idCliente : id,
                      },
                function (response, status) { // Required Callback Function
                    $('#ventanaModificarCliente').modal('hide');
                    carga('PantallaCliente');
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
                    $('#ventanaEliminarCliente').modal('hide');
                    carga('PantallaCliente');
                });
        });
    </script>   

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
                <form name="nuevoCliente" method="POST" action="nuevoCliente">
                    <div class="modal-body">
                        Nombre
                        <input name="Nombre" id="Nombre" type="text" class="form-control" aria-describedby="basic-addon2" />
                        Zona
                        <input name="zona" id="zona" type="text" class="form-control" aria-describedby="basic-addon2" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="btnNuevoCliente" type="button" class="btn btn-success success">Agregar</button>
                    </div>
                </form>
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
                <form name="modificarCliente" method="POST" action="modificarCliente">
                    <div class="modal-body" id="modificarDinamico">
                        <input name="idModificar" type="hidden" id="idModificar" class="form-control" aria-describedby="basic-addon2" />
                        <!-- esto se carga dinamico-->
                    </div>
                    <div class="modal-body">
                        Nombre
                        <input name="Nombre" id="NombreM" type="text" class="form-control" aria-describedby="basic-addon2" />
                        Zona
                        <input name="zona" id="zonaM" type="text" class="form-control" aria-describedby="basic-addon2" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="btnModificarCliente" type="button" class="btn btn-success success">Modificar</button>
                    </div>
                </form>
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
        <div class="panel-heading">
            <h3  class="panel-title">Clientes</h3>
        </div>
        <nav class="navbar navbar-toolbar navbar-default">
            <div class="container-fluid">
                            <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a type="button" class="btn btn-default" aria-label="Left Align" href="#ventanaAgregarCliente" data-toggle="modal">
                                <span onclick="" class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a>
                        </li>
                    </ul>
                    <!-- busqueda -->
                    <form class="navbar-form navbar-left">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="" />
                        </div>
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </button>
                    </form>



                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <!-- Table -->
        <table class="table">
            <tr>
                <th>Nombre</th>
                <th>Zonas</th>
                <th>Eliminar</th>
                <th>Editar</th>
            </tr>
            <?php
                while($rs=mysqli_fetch_array($sql))
                {
                    echo "<tr>"
                    ."<td>".$rs[1]."</td>"
                    ."<td>".$rs[2]."</td>"
                    ."<td>".'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[1].'" data-target="#ventanaEliminarCliente" data-toggle="modal">
<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'
                    ."</td>"
                    ."<td>".'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[0].'" data-target="#ventanaModificarCliente" data-toggle="modal">
<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'
                    ."</td>"
                    ."</tr>";
                }


            ?>
        </table>
    </div>
</body>
</html>
<?php } ?>

