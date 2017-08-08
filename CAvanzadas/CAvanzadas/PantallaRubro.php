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
        $('#ventanaAgregarRubro').on('shown.bs.modal', function (e) {

            $(this).find('form').validator()

            $('#nuevoRubro').on('submit', function (e) {
                if (e.isDefaultPrevented()) {
                } else {
                    e.preventDefault()
                    // Si se cumple la validacion llama a la funcion de agregar
                    agregarRubro();
                }
            })
            $('#ventanaAgregarRubro').on('hidden.bs.modal', function (e) {
                $(this).find('form').off('submit').validator('destroy')
            })
        });
        $('#ventanaAgregarRubro').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });
        $('#ventanaModificarRubro').on('shown.bs.modal', function (e) {

            $(this).find('form').validator()

            $('#modificarRubro').on('submit', function (e) {
                if (e.isDefaultPrevented()) {
                } else {
                    e.preventDefault()
                    // Si se cumple la validacion llama a la funcion de agregar
                    modificarRubro();
                }
            })
            $('#ventanaModificarRubro').on('hidden.bs.modal', function (e) {
                $(this).find('form').off('submit').validator('destroy')
            })
        });
        $('#ventanaModificarRubro').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });
    });
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

    function agregarRubro() {
        $('#btnNuevoRubro').prop('disabled', true);
        var nombreRubro = $('#Nombre').val();
        var unidadRubro = $('#Unidad').val();
        var cantidadStock = $('#cantidadStock').val();
        if (nombreRubro == '') {
            swal({
                title: "Advertencia!",
                text: "Debe ingresar el nombre del rubro!",
                type: "warning",
                confirmButtonText: "OK"
            });
            $('#btnNuevoRubro').prop('disabled', false);
        } else if (unidadRubro == '') {
            swal({
                title: "Advertencia!",
                text: "Debe ingresar la unidad del rubro!",
                type: "warning",
                confirmButtonText: "OK"
            });
            $('#btnNuevoRubro').prop('disabled', false);
        } else if (cantidadStock == '') {
            swal({
                title: "Advertencia!",
                text: "Debe ingresar la cantidad del rubro!",
                type: "warning",
                confirmButtonText: "OK"
            });
            $('#btnNuevoRubro').prop('disabled', false);
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
                if (response == '') {
                    $('#ventanaAgregarRubro').modal('hide');
                    carga('PantallaRubro');

                } else {
                    swal({
                        title: "Advertencia!",
                        text: response,
                        type: "warning",
                        confirmButtonText: "OK"
                    });
                    $('#btnNuevoRubro').prop('disabled', false);
                    $('#btnNuevoRubro').prop('disabled', false);
                    $('#Nombre').val('');
                    $('#Unidad').val('');
                    $('#cantidadStock').val('');
                }

            });
        }
    };
    function modificarRubro() {
            $('#btnModificarRubro').prop('disabled', true);
            var nombreRubro = $('#NombreM').val();
            var unidadRubro = $('#UnidadM').val();
            var cantidadStock = $('#cantidadStockM').val();
            if (nombreRubro == '') {
                swal({
                    title: "Advertencia!",
                    text: "Debe ingresar el nombre del rubro!",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                $('#btnModificarRubro').prop('disabled', false);
            } else if (unidadRubro == '') {
                swal({
                    title: "Advertencia!",
                    text: "Debe ingresar la unidad del rubro!",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                $('#btnModificarRubro').prop('disabled', false);
            } else if (cantidadStock == '') {
                swal({
                    title: "Advertencia!",
                    text: "Debe ingresar la cantidad del rubro!",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                $('#btnModificarRubro').prop('disabled', false);
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
                    if (response=='')
                    {
                        $('#ventanaModificarRubro').modal('hide');
                        carga('PantallaRubro');
                    }
                    else {
                        swal({
                            title: "Advertencia!",
                            text: response,
                            type: "warning",
                            confirmButtonText: "OK"
                        });
                        $('#btnModificarRubro').prop('disabled', false);
                         $('#NombreM').val('');
                         $('#UnidadM').val('');
                         $('#cantidadStockM').val('');
                         $('#btnModificarRubro').prop('disabled', false);
                    }
                    
                });
            }
        };
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
                    <form role="form" data-toggle="validator" id="nuevoRubro" name="nuevoRubro">
                        <div class="form-group row">
                            <label for="Nombre" class="col-sm-2 col-form-label">
                                Nombre:
                            </label>
                            <div class="col-sm-8">
                                <input name="Nombre" data-error="Completa este campo" id="Nombre" type="text" class="form-control" aria-describedby="basic-addon2" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Unidad" class="col-sm-2 col-form-label">
                                Unidad:
                            </label>
                            <div class="col-sm-8">
                                <input name="Unidad" data-error="Completa este campo" id="Unidad" type="text" class="form-control" aria-describedby="basic-addon2" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Cantidad" class="col-sm-2 col-form-label">
                                Cantidad de stock:
                            </label>
                            <div class="col-sm-8">
                                <input name="cantidadStock" data-error="Completa este campo" id="cantidadStock" type="number" class="form-control" value="0" aria-describedby="basic-addon2" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="btnNuevoRubro" type="submit" class="btn btn-success success">Agregar</button>
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
                    <form role="form" data-toggle="validator" id="modificarRubro" name="modificarRubro">
                            <div class="modal-body" id="modificarDinamico">
                                <input name="idModificar" type="hidden" id="idModificar" class="form-control" aria-describedby="basic-addon2" />
                                <!-- esto se carga dinamico-->
                            </div>
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label for="Nombre" class="col-sm-2 col-form-label">
                                        Nombre:
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="NombreM" data-error="Completa este campo" id="NombreM" type="text" class="form-control" aria-describedby="basic-addon2" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Unidad" class="col-sm-2 col-form-label">
                                        Unidad:
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="UnidadM" data-error="Completa este campo" id="UnidadM" type="text" class="form-control" aria-describedby="basic-addon2" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Cantidad" class="col-sm-2 col-form-label">
                                        Cantidad de stock:
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="cantidadStockM" data-error="Completa este campo" id="cantidadStockM" type="text" class="form-control" value="0" aria-describedby="basic-addon2" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="btnModificarRubro" type="submit" class="btn btn-success success">Modificar</button>
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
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Rubros</h3>
            </div>
        </div>
        <?php
    if($tipoUsuario == 1){
        echo'<button type="button" class="btn btn-default btn-xs " data-target="#ventanaAgregarRubro" data-toggle="modal">
                            <span class="glyphicon glyphicon-plus"></span>Agregar Rubro</button>';
    }
        ?>
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
                    if ($tipoUsuario == 1)
                    {
                        echo "<tr>"
                        ."<td>".$rs[1]."</td>"
                        ."<td>".$rs[2]."</td>"
                        ."<td>".$rs[3]."</td>"
                        ."<td>".'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[0].'" data-target="#ventanaModificarRubro" data-toggle="modal">
<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'.'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[1].'" data-target="#ventanaEliminarRubro" data-toggle="modal">
<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
</button>'."</td>"
                        ."</tr>";
                    }else
                    {
                        echo "<tr>"
                        ."<td>".$rs[1]."</td>"
                        ."<td>".$rs[2]."</td>"
                        ."<td>".$rs[3]."</td>"
                        ."</tr>";
                    }

                }
            }


            ?>

        </table>
    </div>

</body>
</html>
<?php } ?>