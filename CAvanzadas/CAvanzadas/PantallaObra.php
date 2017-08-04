<?php
require('includes/loginheader.php');
session_start();
if (isset($_SESSION['usuario'])) {
    require 'includes/ConsultasLicitacion.php';
    require 'includes/ConsultasCotizacion.php';
    require 'includes/ConsultasCliente.php';
    require 'includes/ConsultaZonas.php';
    require 'includes/ConsultasObra.php';
    require 'includes/ConsultasCuadrilla.php';

    $idLicitacion = $_GET['idLicitacion'];
    $licitacion = obtenerLicitacion($idLicitacion);
    $rsLicitacion=mysqli_fetch_array($licitacion);
    $idCliente = $rsLicitacion[idCliente];
    $cliente = obtenerCliente($idCliente);
    $rsCliente=mysqli_fetch_array($cliente);

    $idCotizacion = $rsLicitacion[idCotizacion];
    $cotizacion = devolverCotizacion($idCotizacion);

    $idCliente = $rsLicitacion[idCliente];
    $zonasLicitacion = obtenerZonas($idCliente);



    $rsCotizacion=mysqli_fetch_array($cotizacion);
    $fechaActual=date("Y-m-d");
?>
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
        var idLicitacionDinamico;
        var id;
        var idObraActiva;
        var idLicitacionActiva;
        var cambiosActivos = false;
        $(document).ready(function () {
            $("#loading").hide();
            $(document).ajaxStart(function () {
                $("#loading").show();
            }).ajaxStop(function () {
                $("#loading").hide();
            });

            $('input[type="text"][placeholder="Search"]').attr('placeholder', 'Búsqueda rápida');
        });

        function guardarObservacion() {
            var idObraObservacion = $('#idObraObservacion').val();
            var observacion = $('#observacion').val();
            $.ajax({
                url: "ajaxLicitacion.php",
                method: "POST",
                data: { action: "guardarObservacion", idObraObservacion: idObraObservacion, observacion: observacion },
                dataType: "text",
                success: function (data) {
                    $('#autoSave').text('Guardado..');
                }
            });
        }


        $(document).ready(function () {
            $('#ventanaAgregarObra').on('shown.bs.modal', function (e) {

                $(this).find('form').validator()

                $('#nuevaObraForm').on('submit', function (e) {
                    if (e.isDefaultPrevented()) {
                    } else {
                        e.preventDefault()
                        agregarObra('.$idLicitacion.');
                    }
                })
                $('#ventanaAgregarObra').on('hidden.bs.modal', function (e) {
                    $(this).find('form').off('submit').validator('destroy')
                })
            });
            $('#ventanaAgregarObra').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });



            $("#ventanaAuditoriaEstado").on("show.bs.modal", function (e) {
                $("#ventanaAuditoriaEstadoBody").html("");
                var idObra = $(e.relatedTarget).data('target-id');
                $.post("ajaxLicitacion.php", //Required URL of the page on server
                  { // Data Sending With Request To Server
                      action: "auditoriaEstado",
                      idObra: idObra
                  },
                function (response, status) { // Required Callback Function
                    $("#ventanaAuditoriaEstadoBody").html(response);
                });
            });

            $("#ventanaMostrarObra").on("show.bs.modal", function (e) {
            $("#ventanaMostrarObraBody").html("");
            var idObra = $(e.relatedTarget).data('target-id');
            var nombreObra = $(e.relatedTarget).data('target-nombre');
            var estadoObra = $(e.relatedTarget).data('target-estado');
            $("#ventanaMostrarObraTitle").html('<span class="label label-info">' + nombreObra + '</span>');
            mostrarObra(idObra);

            });

            $("#ventanaMostrarObra").on("hide.bs.modal", function (e) {
            if (cambiosActivos=="true"){
                cambiosActivos == "false";
                $("#loading").show();
                window.location.reload();
                //desplegarLicitacion(idLicitacionActiva);
            }


            });




            $("#ventanaMetrajesEstimados").on("show.bs.modal", function (e) {
                idObraActiva = $(e.relatedTarget).data('target-id');
                var idCotizacion = $(e.relatedTarget).data('target-idcotizacion');
                $(this).find('form').validator()

                $('#agregarMetrajeForm').on('submit', function (e) {
                    if (e.isDefaultPrevented()) {
                    } else {
                        e.preventDefault()
                        // Si se cumple la validacion llama a la funcion de agregar
                        agregarMetraje(idObraActiva);
                    }
                })



                cargaMetrajesEstimados(idObraActiva);


            });

            $('#ventanaMetrajesEstimados').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });

        });

        function agregarObra() {
            $('#btnNuevaObra').prop('disabled', true);
            var idLicitacion = $('#idLicitacion').val();
            var NombreObra = $('#nombreObra').val();
            var idCotizacionObra = $('#dSolicitudCotizacion').val();
            var DireccionObra = $('#direccionObra').val();
            var NumeroPuertaObra = $('#nPuertaObra').val();
            var idZonaObra = $('#zonaObra').val();
            var ObservacionObra = $('#observacionObra').val();
            var FechaRecibidoObra = $('#fechaRecibidoObra').val();
            var Esquina1 = $('#esquina1').val();
            var Esquina2 = $('#esquina2').val();
            var RequiereBaliza = 0;
            if ($('#chReqBaliza').prop('checked')) {
                RequiereBaliza = 1;
            }
            $.post("ajaxLicitacion.php",
                       {
                           action: "nuevaObra",
                           idLicitacion: idLicitacion,
                           NombreObra: NombreObra,
                           idCotizacionObra: idCotizacionObra,
                           DireccionObra: DireccionObra,
                           NumeroPuertaObra: NumeroPuertaObra,
                           idZonaObra: idZonaObra,
                           ObservacionObra: ObservacionObra,
                           FechaRecibidoObra: FechaRecibidoObra,
                           Esquina1: Esquina1,
                           Esquina2: Esquina2,
                           RequiereBaliza: RequiereBaliza
                       },
                 function (response, status) {
                     if (response > 0) {
                         idObra = response;
                         if ($('#chReqBaliza').prop('checked')) {
                             var ProveedorBaliza = $('#proveedorBaliza').val();
                             var CantidadBaliza = $('#balCantidad').val();
                             var FechaInicioBaliza = $('#balFechaInicio').val();
                             var FechaFinBaliza = $('#balFechaFin').val();
                             $.post("ajaxLicitacion.php",
                                 {
                                     action: "agregarBaliza",
                                     idObra: idObra,
                                     ProveedorBaliza: ProveedorBaliza,
                                     CantidadBaliza: CantidadBaliza,
                                     FechaInicioBaliza: FechaInicioBaliza,
                                     FechaFinBaliza: FechaFinBaliza
                                 },
                             function (response, status) {
                                 if (response != '') {
                                     swal({
                                         title: "Error",
                                         text: "Error al agregar baliza",
                                         type: "warning",
                                         confirmButtonText: "OK"
                                     });
                                 }
                             });
                         }
                         $('#ventanaAgregarObra').modal('hide');
                         $("#loading").show();
                         window.location.reload();
                     }
                     else {
                         swal({
                             title: "Error",
                             text: "Error al agregar obra",
                             type: "warning",
                             confirmButtonText: "OK"
                         });
                     }

                 });
        };

        function mostrarObra($idObra) {
            $("#ventanaMostrarObraBody").html("");
            var idObra = $idObra;
            $.post("ajaxLicitacion.php", //Required URL of the page on server
                  { // Data Sending With Request To Server
                      action: "mostrarObra",
                      idObra: idObra
                  },
            function (response, status) { // Required Callback Function
                $("#ventanaMostrarObraBody").html(response);
                $(this).find('form').validator()

                $('#asignarCuadrillaForm').on('submit', function (e) {
                    if (e.isDefaultPrevented()) {
                    } else {
                        e.preventDefault()
                        cambiosActivos = "true";
                        asignarCuadrilla(idObra);
                    }
                })
                $("#pendienteBalizaForm").on("change", "input:checkbox", function () {
                    if ($('#chPendBaliza').prop('checked')) {
                        cambiosActivos = "true";
                        cambiarEstado(idObra, "Pendiente de baliza");
                    } else {
                        cambiosActivos = "true";
                        cambiarEstado(idObra, "Pendiente de cuadrilla");
                    }

                });
                $("#pendienteAsfaltoForm").on("change", "input:checkbox", function () {
                    if ($('#chPendAsfalto').prop('checked')) {
                        cambiosActivos = "true";
                        cambiarEstado(idObra, "Pendiente de asfalto");
                    } else {
                        cambiosActivos = "true";
                        cambiarEstado(idObra, "Asignado");
                    }

                });
            });
        }

        function agregarMetraje($idObra) {
            var idObra = $idObra
            var CantidadMetraje = $('#cantidadMetraje').val();
            var NombreRubro = document.getElementById("rubroCombo").value;
            $.post("ajaxLicitacion.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "agregarMetraje",
                          idObra: idObra,
                          NombreRubro: NombreRubro,
                          CantidadMetraje: CantidadMetraje
                      },
                function (response, status) { // Required Callback Function
                    cargaMetrajesEstimados(idObra);

                });

        }

        function asignarCuadrilla($idObra) {
            var idObra = $idObra
            var cmbCuadrilla = $('#cmbCuadrilla').val();
            $.post("ajaxLicitacion.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "asignarCuadrilla",
                          idObra: idObra,
                          idCuadrilla: cmbCuadrilla
                      },
                function (response, status) { // Required Callback Function
                    if (response == '') {
                        mostrarObra(idObra);
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

        }

        function cambiarEstado($idObra, $estado) {
            var idObra = $idObra;
            var estado = $estado;
            $.post("ajaxLicitacion.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "cambiarEstado",
                          idObra: idObra,
                          estado: estado
                      },
                function (response, status) { // Required Callback Function
                    if (response == '') {
                        mostrarObra(idObra);
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

        }

        function eliminarMetrajeEstimado($idMetrajeEstimado, $idObra) {
            var idObra = $idObra;
            var idMetrajeEstimado = $idMetrajeEstimado;
            $.post("ajaxLicitacion.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "eliminarMetrajeEstimado",
                          idMetrajeEstimado: idMetrajeEstimado
                      },
                function (response, status) { // Required Callback Function
                    cargaMetrajesEstimados(idObra);

                });
        }

        function cargaMetrajesEstimados($idObra) {
            $("#ventanaMetrajesEstimadosBodyTabla").html("");
            var idObra = $idObra
            $.post("ajaxLicitacion.php", //Required URL of the page on server
                  { // Data Sending With Request To Server
                      action: "metrajesEstimados",
                      idObra: idObra
                  },
            function (response, status) { // Required Callback Function
                $("#ventanaMetrajesEstimadosBodyTabla").html(response);
            });
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
                alert("ok");
                idLicitacionActiva = idLicitacion;
                $.post("ajaxLicitacion.php", //Required URL of the page on server
                          { // Data Sending With Request To Server
                              action: "obtenerLicitacion",
                              idLicitacion: idLicitacion
                          },
                    function (response, status) { // Required Callback Function
                        $("#contenido").hide();
                        $("#subcontenido").show();
                        $("#subcontenido").html(response);
                    });
            })
        });



    </script>
    
    <div id="loading" style="position: absolute; top:50%; left:50%; z-index: 100000;">
        <img src="img/Loading.gif" />
    </div>


    <!--VENTANA MUESTRA DETALLE OBRA-->
    <div class="modal fade" tabindex="0" role="dialog" id="ventanaMostrarObra">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="ventanaMostrarObraTitle">Obra</h4>
                </div>
                <div class="modal-body" id="ventanaMostrarObraBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!--VENTANA MUESTRA AUDITORIA ESTADOS-->
    <div class="modal fade" tabindex="1" role="dialog" id="ventanaAuditoriaEstado">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="ventanaAuditoriaEstadoTitle">Auditoria de estados</h4>
                </div>
                <div class="modal-body" id="ventanaAuditoriaEstadoBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!--VENTANA METRAJES ESTIMADOS-->
    <div class="modal fade" tabindex="1" role="dialog" id="ventanaMetrajesEstimados">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="ventanaMetrajesEstimadosTitle">Metrajes estimados</h4>
                </div>
                <div class="modal-body" id="ventanaMetrajesEstimadosBody">
                    <div class="panel">
                        <br>
                        <form role="form" data-toggle="validator" id="agregarMetrajeForm" name="agregarMetrajeForm">
                            <div class="form-group row">
                                <label for="Rubro" class="col-sm-2 col-form-label">
                                    Rubro:
                                </label>
                                <div class="col-sm-8">
                                    <select name='rubroCombo' id='rubroCombo'>
                                        <?php 
                                        $rubrosCotizacion = obtenerRubro($idCotizacion);
                                        while ($rsRubrosCotizacion=mysqli_fetch_array($rubrosCotizacion))
                                        {
                                        echo "
                                        <option value='".$rsRubrosCotizacion[nombreRubro]."|".$rsRubrosCotizacion[Unidad]."' selected>".$rsRubrosCotizacion[nombreRubro]."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cantidadMetraje" class="col-sm-2 col-form-label">
                                    Metraje
                                </label>
                                <div class="col-sm-8">
                                    <input type="number" min="1" id="cantidadMetraje" data-error="Requerido" class="form-control" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <span class="form-control-static pull-right"> <button id="btnAgregarMetraje" type="submit" class="btn btn-success success">Agregar metraje</button> </span>

                        </form>
                        <div id="ventanaMetrajesEstimadosBodyTabla"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!--VENTANA PARA INGRESAR UNA NUEVA OBRA-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaAgregarObra">
        <div class="modal-dialog modal-lg" style="overflow-y: scroll; overflow: inherit;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Agregar obra</h4>
                </div>
                <form role="form" data-toggle="validator" id="nuevaObraForm" name="nuevaObraForm">
                    <div class="modal-body">

                        <input type="hidden" id="idLicitacion" value="<?php echo $idLicitacion; ?>">
                        <div class="form-group row">

                            <label for="nombreObra" class="col-sm-2 col-form-label">
                                Nombre
                            </label>
                            <div class="col-sm-8">
                                <input id="nombreObra" name="nombreObra" class="form-control" type="text" value="" data-error="Requerido" placeholder="Nombre o número de obra" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="fechaRecibidoObra" class="col-sm-2 col-form-label">
                                Fecha recibido
                            </label>
                            <div class="col-sm-8">
                                <input class="form-control" type="date" value="<?php echo $fechaActual; ?>" id="fechaRecibidoObra" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dSolicitudCotizacion" class="col-sm-2 col-form-label">
                                Solicitud de cotización
                            </label>
                            <div class="col-sm-8">
                                <fieldset disabled>
                                    <select id="dSolicitudCotizacion" class="form-control">
                                        <option value='<?php echo $rsCotizacion[idCotizacion]?>'><?php echo $rsCotizacion[Nombre]; ?></option>
                                    </select>
                                </fieldset>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="direccionObra" class="col-sm-2 col-form-label">
                                Dirección
                            </label>
                            <div class="col-sm-8">
                                <input id="direccionObra" class="form-control" data-error="Requerido" type="text" value="" placeholder="" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="nPuertaObra" class="col-sm-2 col-form-label">
                                Nº de puerta
                            </label>
                            <div class="col-sm-8">
                                <input id="nPuertaObra" class="form-control" type="text" value="" placeholder="" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zonaObra" class="col-sm-2 col-form-label">
                                Zona
                            </label>
                            <div class="col-sm-8">
                                <select id="zonaObra" data-error="Requerido" class="form-control" required>
                                    <option disabled selected>Seleccione zona</option>
                                    <?php
                                    while ($rsZonasLicitacion=mysqli_fetch_array($zonasLicitacion))
                                    {
                                    $idZona=$rsZonasLicitacion[idZona];
                                    $zona = devolverZona($idZona);
                                    $rsZona=mysqli_fetch_array($zona);
                                    echo "
                                    <option value='".$rsZona[idZona]."'>".$rsZona[Nombre]."</option>";
                                    }
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="esquina1" class="col-sm-2 col-form-label">
                                Entre:
                            </label>
                            <div class="col-sm-8">
                                <input id="esquina1" class="form-control" type="text" value="" placeholder="Esquina 1" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="esquina2" class="col-sm-2 col-form-label">
                                Entre:
                            </label>
                            <div class="col-sm-8">
                                <input id="esquina2" class="form-control" type="text" value="" placeholder="Esquina 2" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="observacionObra" class="col-sm-2 col-form-label">
                                Observaciones
                            </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="observacionObra" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="reqBaliza" class="col-sm-2 col-form-label">
                                Requiere baliza
                            </label>
                            <div class="col-sm-8">
                                <div class="form-check has-success">
                                    <label data-toggle="collapse" data-target="#optBalizas">
                                        <input class="form-control" type="checkbox" id="chReqBaliza">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-info" id="divOptBalizas">
                            <div class="collapse" id="optBalizas">
                                <br>
                                <div class="form-group row">
                                    <label for="proveedorBaliza" class="col-sm-2 col-form-label">
                                        Proveedor
                                    </label>
                                    <div class="col-sm-8">
                                        <input id="proveedorBaliza" class="form-control" type="text" value="<?php echo $rsCliente[Nombre]; ?>" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="balCantidad" class="col-sm-2 col-form-label">
                                        Nº balizas
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="number" value="1" min="1" id="balCantidad">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="balFechaInicio" class="col-sm-2 col-form-label">
                                        Fecha entrega
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="date" value="<?php echo $fechaActual; ?>" id="balFechaInicio" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="balFechaFin" class="col-sm-2 col-form-label">
                                        Fecha devolución
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="date" value="<?php echo $fechaActual; ?>" id="balFechaFin" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="btnNuevaObra" type="submit" class="btn btn-success success">Agregar obra</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

        <span class="label label-info">Licitación <?php echo $rsLicitacion[codigo]; ?></span>
        Estado: <?php echo $rsLicitacion[estado]; ?>

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <h3 class="panel-title">Obras</h3>
        </div>
        <button type="button" class="btn btn-default btn-xs " data-target="#ventanaAgregarObra" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span>Agregar obra</button>
        <!-- Tabla Obras -->
        <table id="table" 
			 data-toggle="table"
			 data-search="true"
			 data-filter-control="true" 
			 data-show-export="true"
			 data-click-to-select="true">
	<thead>
		<tr>
			<th data-field="obra" data-formatter="identifierFormatter" data-filter-control="input" data-sortable="true">Nombre</th>
			<th data-field="direccion" data-filter-control="input" data-sortable="true">Dirección</th>
            <th data-field="estado" data-filter-control="select" data-sortable="true">Estado</th>
            <th data-field="fecharecibido" data-filter-control="input" data-sortable="true">Fecha recibido</th>
		</tr>
	</thead>
	<tbody>
        <?php
    $sqlObras = ListarObras($idLicitacion);
    $rowcount = mysqli_num_rows($sqlObras);
    if ($rowcount>0) {
        while($rsObra=mysqli_fetch_array($sqlObras))
        {
            echo "<tr>"
            .'<td data-toggle="modal" data-target-id="'.$rsObra[idObra].'" data-target-nombre="'.$rsObra[Nombre].'" data-target-estado="'.$rsObra[Estado].'" data-target="#ventanaMostrarObra">'.$rsObra[Nombre].'</td>'
            ."<td>".$rsObra[Direccion]."</td>"
            ."<td>".$rsObra[Estado]."</td>"
            ."<td>".$rsObra[fechaRecibido]."</td>"
            ."</tr>";
        }
    }?>
	</tbody>
</table>
    </div>
</body>
</html>
<?php } ?>
