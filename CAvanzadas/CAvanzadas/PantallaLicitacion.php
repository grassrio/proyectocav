<?php
require('includes/loginheader.php');
require 'includes/ConsultasCotizacion.php';
require 'includes/ConsultasLicitacion.php';
require 'includes/ConsultasCliente.php';
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
        $("#ventanaEliminarLicitacion").on("show.bs.modal", function(e) {
            nombreDinamico = $(e.relatedTarget).data('target-id');
            $("#eliminarDinamico").html("Desea eliminar el rubro " + nombreDinamico + "?");
        });
    });

    $(document).ready(function () {
        $("#ventanaModificarLicitacion").on("show.bs.modal", function (e) {
            id = $(e.relatedTarget).data('target-id');
        });
    });

        $("#btnNuevaLicitacion").click(function () {
            $('#btnNuevaLicitacion').prop('disabled', true);
            var codigo       = $('#Codigo').val();
            var idCliente    = document.getElementById("clienteCombo").value;
            var idCotizacion = document.getElementById("cotizacionCombo").value;
            var estado = document.getElementById("estadoCombo").value;
            if (estado == 1)
            {
                estado = 'Aprobada';
            }
            else
            {
                estado = 'Rechazada';
            }
            var presupuesto = $('#Presupuesto').val();
            if (codigo == '') {
                alert("Ingresar numero de compra directa para continuar");
            }
            else {
             $.post("ajaxLicitacion.php", //Required URL of the page on server
                   { // Data Sending With Request To Server
                       action: "nuevaLicitacion",
                       idCliente: idCliente,
                       idCotizacion: idCotizacion,
                       Estado: estado,
                       Codigo: codigo,
                       Presupuesto: presupuesto,
                   },
             function (response, status) { // Required Callback Function
                 //$("#bingo").html(response);//"response" receives - whatever written in echo of above PHP script.
                 $('#ventanaAgregarLicitacion').modal('hide');
                 carga('PantallaLicitacion');
             });
            }
        });
        $("#btnModificarLicitacion").click(function () {
            $('#btnModificarLicitacion').prop('disabled', true);
            var estado = document.getElementById("estadoCombo1").value;
            alert(estado);
            if (estado == 1) {
                estado = 'Aprobada';
            }
            else {
                estado = 'Rechazada';
            }
            alert(id);
            alert(estado);
            if (estado == '') {
                alert("Debe ingresar el estado");

            }
            else {
                $.post("ajaxLicitacion.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "modificarLicitacion",
                          Estado: estado,
                          idLicitacion: id,
                      },
                function (response, status) { // Required Callback Function
                    $('#ventanaModificarLicitacion').modal('hide');
                    carga('PantallaLicitacion');
                });
            }
        });
        $("#btnEliminarLicitacion").click(function () {
            $('#btnEliminarLicitacion').prop('disabled', true);
            var nombreLicitacion = nombreDinamico
            $.post("ajaxLicitacion.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "eliminarLicitacion",
                          Codigo: nombreLicitacion
                      },
                function (response, status) { // Required Callback Function
                    //$("#bingo").html(response);//"response" receives - whatever written in echo of above PHP script.
                    $('#ventanaEliminarLicitacion').modal('hide');
                    carga('PantallaLicitacion');
                });
        });


    </script>

    <!--VENTANA PARA INGRESAR UN NUEVO LICITACION-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaAgregarLicitacion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Agregar licitacion</h4>
                </div>
                <div class="modal-body">
                    <form name="NuevaLicitacion" method="POST" action="NuevaLicitacion">
                        <div class="form-group row">
                            <label for="Compra" class="col-sm-2 col-form-label">
                                Codigo compra:
                            </label>
                            <div class="col-sm-8">
                                <input name="Codigo" id="Codigo" type="text" class="form-control" aria-describedby="basic-addon2" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Presupuesto" class="col-sm-2 col-form-label">
                                Presupuesto:
                            </label>
                            <div class="col-sm-8">
                                <input name="Presupuesto" id="Presupuesto" type="text" class="form-control" aria-describedby="basic-addon2" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cliente" class="col-sm-2 col-form-label">
                                Selecione el cliente:
                            </label>
                            <div class="col-sm-8">
                                <select name='clienteCombo' id='clienteCombo'><?php
                                $sql = devolverClientes();
                                while ($rs=mysqli_fetch_array($sql))
                                {
                                    echo "<option value='".$rs[0]."' selected>".$rs[1]."</option>";
                                }
                                                                          ?>
                                </select>
                                </div>
                            </div>
                        <div class="form-group row">
                            <label for="cotizacion" class="col-sm-2 col-form-label">
                                Selecione una cotizacion:
                            </label>
                            <div class="col-sm-8">
                                <select name='cotizacionCombo' id='cotizacionCombo'><?php
                                    $sql = listaCotizacion();
                                    while ($rs=mysqli_fetch_array($sql))
                                    {
                                        echo "<option value='".$rs[0]."' selected>".$rs[1]."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Estado" class="col-sm-2 col-form-label">
                                Selecione el Estado:
                            </label>
                            <div class="col-sm-8">
                                <select name='estadoCombo' id='estadoCombo'>
                                    <option value='1' selected>Aprobada</option>
                                    <option value='2' selected>Rechazada</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="btnNuevaLicitacion" type="button" class="btn btn-success success">Agregar</button>
                        </div>
                    </form>
                </div>
                </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--VENTANA PARA MODIFICAR UN LICITACION-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaModificarLicitacion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Modificar Licitacion</h4>
                </div>
                <form name="modificarRubro" method="POST" action="modificarRubro">
                    <div class="modal-body" id="modificarDinamico">
                        <input name="idModificar" type="hidden" id="idModificar" class="form-control" aria-describedby="basic-addon2" />
                        <!-- esto se carga dinamico-->
                    </div>
                    <div class="modal-body">
                        Selecione el Estado:
                        <select name='estadoCombo1' id='estadoCombo1'>
                             <option value='1' selected>Aprobada</option>
                             <option value='2' selected>Rechazada</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="btnModificarLicitacion" type="button" class="btn btn-success success">Modificar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--VENTANA PARA ELIMINAR UN NUEVO LICITACION-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaEliminarLicitacion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Eliminar licitacion</h4>
                </div>
                <div class="modal-body" id="eliminarDinamico">
                    <input name="NombreEliminar" id="NombreEliminar" type="hidden" class="form-control" aria-describedby="basic-addon2" />
                    <!-- esto se carga dinamico-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="btnEliminarLicitacion" type="button" class="btn btn-danger">Eliminar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <h3 class="panel-title">Licitacion</h3>
        </div>


        <nav class="navbar navbar-toolbar navbar-default">
            <div class="container-fluid">


                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a type="button" class="btn btn-default" aria-label="Left Align" href="#ventanaAgregarLicitacion" data-toggle="modal">
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
                <th>Numero compra directa</th>
                <th>Estado</th>
                <th></th>
            </tr>
            <?php
                $sql = ListarLicitaciones();
                $rowcount = mysqli_num_rows($sql);
                if ($rowcount>0) {
                    while($rs=mysqli_fetch_array($sql))
                    {
                        echo "<tr>"
                        ."<td>".$rs[4]."</td>"
                        ."<td>".$rs[3]."</td>"
                        ."<td></td>"
                        ."<td>".'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[4].'" data-target="#ventanaEliminarLicitacion" data-toggle="modal">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'
                            .'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[0].'" data-target="#ventanaModificarLicitacion" data-toggle="modal">
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