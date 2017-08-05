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

    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
    <link href="css/todc-bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css" />


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/validator.min.js"></script>

    <script src="js/bootstrap-table.min.js"></script>
    <script src="js/bootstrap-table-export.min.js"></script>
    <script src="js/tableExport.min.js"></script>
    <script src="js/bootstrap-table-filter-control.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/bootstrap-table.min.css" />
</head>
<body>
    <script>
        $(document).ready(function () {
            mostrarocultar('ocultar', 'btnAtras');
            $("#loading").hide();
            $(document).ajaxStart(function () {
                $("#loading").show();
            }).ajaxStop(function () {
                $("#loading").hide();
            });

            $('input[type="text"][placeholder="Search"]').attr('placeholder', 'Búsqueda rápida');
        });

        function cargaIframe(idLicitacion) {
            $("#loading").show();
            mostrarocultar('ocultar', 'divLicitaciones');
            mostrarocultar('mostrar', 'btnAtras');
            document.getElementById("iframeObras").src = "PantallaObra.php?idLicitacion=" + idLicitacion;
            document.getElementById("iframeObras").style.visibility = "visible";
        }

        function onMyFrameLoad(iframe) {
            $("#loading").hide();
            mostrarocultar('mostrar', 'iframeObras');
        };

        var idLicitacionDinamico;
        var id;
        var idLicitacionActiva;
        var cambiosActivos = false;
        $(document).ready(function () {
            $("#ventanaEliminarLicitacion").on("show.bs.modal", function (e) {
                idLicitacionDinamico = $(e.relatedTarget).data('target-id');
                $("#eliminarDinamico").html("Desea eliminar la licitación ?");
            });
        });



        $(document).ready(function () {
            $("#ventanaModificarLicitacion").on("show.bs.modal", function (e) {
                id = $(e.relatedTarget).data('target-id');
            });
        });

        $(document).ready(function () {
        $("#btnNuevaLicitacion").click(function () {
            $('#btnNuevaLicitacion').prop('disabled', true);
            var codigo = $('#Codigo').val();
            var idCliente = document.getElementById("clienteCombo").value;
            var idCotizacion = document.getElementById("cotizacionCombo").value;
            var estado = document.getElementById("estadoCombo").value;
            if (estado == 1) {
                estado = 'Aprobada';
            }
            else {
                estado = 'Rechazada';
            }
            var presupuesto = $('#Presupuesto').val();
            if (codigo == '') {
                swal({
                    title: "Advertencia!",
                    text: "Ingresar numero de compra directa para continuar!",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                $('#btnNuevaLicitacion').prop('disabled', false);
            } else if (presupuesto == '') {
                swal({
                    title: "Advertencia!",
                    text: "Ingresar numero de compra directa para continuar!",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                $('#btnNuevaLicitacion').prop('disabled', false);
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
                function (response, status) {
                    if (response.indexOf('Error') >= 0) {
                        swal({
                            title: "Advertencia!",
                            text: response,
                            type: "warning",
                            confirmButtonText: "OK"
                        });
                        $('#btnNuevaLicitacion').prop('disabled', false);
                        $('#Codigo').val('');
                        $('#Presupuesto').val('');
                    } else {
                        $('#ventanaAgregarLicitacion').modal('hide');
                        $("#loading").show();
                        window.location.reload();
                    }
                });
            }
        });
        

        $("#btnModificarLicitacion").click(function () {
            $('#btnModificarLicitacion').prop('disabled', true);
            var estado = document.getElementById("estadoCombo1").value;

            if (estado == 1) {
                estado = 'Aprobada';
            }
            else {
                estado = 'Rechazada';
            }
            if (estado == '') {
                swal({
                    title: "Advertencia!",
                    text: "Debe ingresar el estado!",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                $('#btnModificarLicitacion').prop('disabled', false);
            }
            else {
                $.post("ajaxLicitacion.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "modificarLicitacion",
                          Estado: estado,
                          idLicitacion: id,
                      },
                function (response, status) { // Required Callback Function
                    if (response == '') {
                        $('#ventanaModificarLicitacion').modal('hide');
                        $("#loading").show();
                        window.location.reload();
                    }
                    else {
                        swal({
                            title: "Advertencia!",
                            text: response,
                            type: "warning",
                            confirmButtonText: "OK"
                        });
                        $('#btnModificarLicitacion').prop('disabled', false);
                    }

                });
            }
        });
        $("#btnEliminarLicitacion").click(function () {
            $('#btnEliminarLicitacion').prop('disabled', true);
            $.post("ajaxLicitacion.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "eliminarLicitacion",
                          idLicitacionDinamico: idLicitacionDinamico
                      },
                function (response, status) { // Required Callback Function
                    //$("#bingo").html(response);//"response" receives - whatever written in echo of above PHP script.
                    $('#ventanaEliminarLicitacion').modal('hide');
                    $("#loading").show();
                    window.location.reload();
                });
        });

        });

        function mostrarocultar(action, id) {
            if (action == "mostrar") {
                $("#" + id).show();
            } else {
                $("#" + id).hide();
            }

        }



        function identifierFormatter(value, row, index) {
            return [
                    '<a href="#">',
                        value,
                    '</a>'].join('');
        }

        $(function () {
            $('table').on('click', '.clickableRow', function () {
                var $this = $(this);
                var idLicitacion = $this.data('id');
                cargaIframe(idLicitacion);
            })
        });

        function actionFormatter(value, row, index) {
            return [
                '<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="',
                value,
                '" data-target="#ventanaModificarLicitacion" data-toggle="modal"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>',
                '<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="',
                value,
                '" data-target="#ventanaEliminarLicitacion" data-toggle="modal"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'
            ].join('');
        }


    </script>


    <div id="loading" style="position: absolute; top:50%; left:50%; z-index: 100000;">
        <img src="img/Loading.gif" />
    </div>

    <!--VENTANA PARA INGRESAR UN NUEVO LICITACION-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaAgregarLicitacion">
        <div class="modal-dialog" style="overflow-y: scroll; overflow: inherit;" role="document">
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
                <div class="modal-body">
                    <form name="modificarRubro" method="POST" action="modificarRubro">
                        <div class="modal-body" id="modificarDinamico">
                            <input name="idModificar" type="hidden" id="idModificar" class="form-control" aria-describedby="basic-addon2" />
                            <!-- esto se carga dinamico-->
                        </div>
                        <div class="form-group row">
                            <label for="Estado" class="col-sm-2 col-form-label">
                                Selecione el Estado:
                            </label>
                            <div class="col-sm-8">
                                <select name='estadoCombo1' id='estadoCombo1'>
                                    <option value='1' selected>Aprobada</option>
                                    <option value='2' selected>Rechazada</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="btnModificarLicitacion" type="button" class="btn btn-success success">Modificar</button>
                        </div>
                    </form>
                </div>
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

<div id="divLicitaciones">
<div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Licitaciones</h3>
            </div>
<br>
<br>
<button type="button" class="btn btn-default btn-xs " data-target="#ventanaAgregarLicitacion" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span>Agregar licitación</button>

<table id="table" 
			 data-toggle="table"
			 data-search="true"
			 data-filter-control="true" 
			 data-show-export="true"
			 data-click-to-select="true">
	<thead>
		<tr>
			<th data-field="licitacion" data-formatter="identifierFormatter" data-filter-control="input" data-sortable="true">Nº Licitación</th>
			<th data-field="cliente" data-filter-control="select" data-sortable="true">Cliente</th>
			<th data-field="fecha" data-filter-control="input" data-sortable="true">Fecha</th>
            <th data-field="estado" data-filter-control="select" data-sortable="true">Estado</th>
            <th data-field="action" data-formatter="actionFormatter"></th>
		</tr>
	</thead>
	<tbody>
        <?php
    $sql = ListarLicitaciones();
    $rowcount = mysqli_num_rows($sql);
    if ($rowcount>0) {
        while($rs=mysqli_fetch_array($sql))
        {
            $sqlCliente = obtenerCliente($rs[idCliente]);
            $rsCliente=mysqli_fetch_array($sqlCliente);
            echo "<tr>"
            .'<td class="clickableRow" data-id=\''.$rs[idLicitacion].'\'>'.$rs[4].'</td>'
            ."<td>".$rsCliente[Nombre]."</td>"
            ."<td>".$rs[fecha]."</td>"
            ."<td>".$rs[estado]."</td>"
            ."<td>".$rs[idLicitacion]."</td>"
            ."</tr>";
        }
    }
        ?>
	</tbody>
</table>
</div>
</div>
    <button id="btnAtras" type="button" class="btn-xs btn-default" onclick="mostrarocultar('ocultar', 'iframeObras'); mostrarocultar('ocultar', 'btnAtras'); mostrarocultar('mostrar', 'divLicitaciones');">
                            <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                        </button>
    <iframe id="iframeObras" onload="onMyFrameLoad(this), this.style.height = ((this.contentDocument.body.scrollHeight)*1.5) + 'px';" style="width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;">
        Your browser doesn't support iframes
    </iframe>
    </body>

</html>
    <?php } ?>
