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
    $(document).ready(function(){
        $("#ventanaEliminarRubro").on("show.bs.modal", function(e) {
            nombreDinamico = $(e.relatedTarget).data('target-id');
            $("#eliminarDinamico").html("Desea eliminar el rubro " + nombreDinamico + "?");
        });
    });

    $(document).ready(function () {
        $("#ventanaModificarRubro").on("show.bs.modal", function (e) {
            id = $(e.relatedTarget).data('target-id');
        });
    });

        $("#btnNuevoRubro").click(function () {
            $('#btnNuevoRubro').prop('disabled', true);
            var nombreRubro = $('#Nombre').val();
            var unidadRubro = $('#Unidad').val();
            var cantidadStock = $('#cantidadStock').val();
            if (nombreRubro == '') {
                alert("Please enter UserId");
            }
            else {
             $.post("ajaxRubro.php", //Required URL of the page on server
                   { // Data Sending With Request To Server
                       action: "nuevoRubro",
                       Nombre: nombreRubro,
                       Unidad: unidadRubro,
                       cantidadStock: cantidadStock
                   },
             function (response, status) { // Required Callback Function
                 //$("#bingo").html(response);//"response" receives - whatever written in echo of above PHP script.
                 $('#ventanaAgregarRubro').modal('hide');
                 carga('PantallaRubro');
             });
            }
        });
        $("#btnModificarRubro").click(function () {
            $('#btnModificarRubro').prop('disabled', true);
            var nombreRubro = $('#NombreM').val();
            var unidadRubro = $('#UnidadM').val();
            var cantidadStock = $('#cantidadStockM').val();
            if (nombreRubro == '') {
                alert("Debe ingresar el Nombre del Rubro");
                if (unidadRubro == '') {
                    alert("Debe ingresar la unidad del Rubro");
                }
                if (cantidadStock == '') {
                    alert("Debe ingresar la Cantidad del Rubro");
                }
            }
            else {
                $.post("ajaxRubro.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "modificarRubro",
                          Nombre: nombreRubro,
                          Unidad: unidadRubro,
                          cantidadStock: cantidadStock,
                          idRubro: id,
                      },
                function (response, status) { // Required Callback Function
                    $('#ventanaModificarRubro').modal('hide');
                    carga('PantallaRubro');
                });
            }
        });
        $("#btnEliminarRubro").click(function () {
            $('#btnEliminarRubro').prop('disabled', true);
            var nombreRubro = nombreDinamico
                $.post("ajaxRubro.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "eliminarRubro",
                          Nombre: nombreRubro
                      },
                function (response, status) { // Required Callback Function
                    //$("#bingo").html(response);//"response" receives - whatever written in echo of above PHP script.
                    $('#ventanaEliminarRubro').modal('hide');
                    carga('PantallaRubro');
                });
        });


    </script>

    <!--VENTANA PARA INGRESAR UN NUEVO RUBRO-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaAgregarRubro">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Agregar rubro</h4>
                </div>
                <div class="modal-body">
                    <form name="nuevoRubro" method="POST" action="nuevoRubro">
                        <div class="form-group row">
                            <label for="Nombre" class="col-sm-2 col-form-label">
                                Nombre:
                            </label>
                            <div class="col-sm-8">
                                <input name="Nombre" id="Nombre" type="text" class="form-control" aria-describedby="basic-addon2" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Unidad" class="col-sm-2 col-form-label">
                                Unidad:
                            </label>
                            <div class="col-sm-8">
                                <input name="Unidad" id="Unidad" type="text" class="form-control" aria-describedby="basic-addon2" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Cantidad" class="col-sm-2 col-form-label">
                                Cantidad de stock:
                            </label>
                            <div class="col-sm-8">
                                <input name="cantidadStock" id="cantidadStock" type="text" class="form-control" value="0" aria-describedby="basic-addon2" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="btnNuevoRubro" type="button" class="btn btn-success success">Agregar</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--VENTANA PARA MODIFICAR UN RUBRO-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaModificarRubro">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Modificar Cliente</h4>
                </div>
                <div class="modal-body">
                    <form name="modificarRubro" method="POST" action="modificarRubro">
                        <div class="modal-body" id="modificarDinamico">
                            <input name="idModificar" type="hidden" id="idModificar" class="form-control" aria-describedby="basic-addon2" />
                            <!-- esto se carga dinamico-->
                        </div>
                             <div class="form-group row">
                                <label for="Nombre" class="col-sm-2 col-form-label">
                                    Nombre:
                                </label>
                                <div class="col-sm-8">
                                    <input name="NombreM" id="NombreM" type="text" class="form-control" aria-describedby="basic-addon2" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Unidad" class="col-sm-2 col-form-label">
                                    Unidad:
                                </label>
                                <div class="col-sm-8">
                                    <input name="UnidadM" id="UnidadM" type="text" class="form-control" aria-describedby="basic-addon2" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Cantidad" class="col-sm-2 col-form-label">
                                    Cantidad de stock:
                                </label>
                                <div class="col-sm-8">
                                    <input name="cantidadStockM" id="cantidadStockM" type="text" class="form-control" value="0" aria-describedby="basic-addon2" />
                                </div>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="btnModificarRubro" type="button" class="btn btn-success success">Modificar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--VENTANA PARA ELIMINAR UN NUEVO RUBRO-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaEliminarRubro">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Eliminar rubro</h4>
                </div>
                <div class="modal-body" id="eliminarDinamico">
                    <input name="NombreEliminar" id="NombreEliminar" type="hidden" class="form-control" aria-describedby="basic-addon2" />
                    <!-- esto se carga dinamico-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="btnEliminarRubro" type="button" class="btn btn-danger">Eliminar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <h3 class="panel-title">Rubros</h3>
        </div>


        <nav class="navbar navbar-toolbar navbar-default">
            <div class="container-fluid">


                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a type="button" class="btn btn-default" aria-label="Left Align" href="#ventanaAgregarRubro" data-toggle="modal">
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
                <th>Unidad</th>
                <th>Stock</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            require 'includes/ConsultasRubro.php';
            $sql = devolverRubros();
            $rowcount = mysqli_num_rows($sql);
            if ($rowcount>0) {
                while($rs=mysqli_fetch_array($sql))
                {
                    echo "<tr>"
                    ."<td>".$rs[1]."</td>"
                    ."<td>".$rs[2]."</td>"
                    ."<td>".$rs[3]."</td>"
                    ."<td>".'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[1].'" data-target="#ventanaEliminarRubro" data-toggle="modal">
<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
</button>
                            '
                    ."</td>"
                    ."<td>".'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[0].'" data-target="#ventanaModificarRubro" data-toggle="modal">
<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'
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