<?php
require('includes/loginheader.php');
session_start();
if (isset($_SESSION['usuario'])&&($_SESSION['tipoUsuario'] <> 2)) {
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
    <link href="css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <script src="js/fileinput.min.js" type="text/javascript"></script>
    <script src="js/fileinput_locale_es.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap-table.min.css" />
</head>
<body>
    <script>
        var idLicitacionDinamico;
        var id;
        var idObraActiva;
        var idClienteLicitacion = "<?php echo $idCliente; ?>";
        var idLicitacionActiva = "<?php echo $idLicitacion; ?>";
        var cambiosActivos = false;
        var idZonaLicitacion = "<?php echo $rsLicitacion[idZona]; ?>";
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
                    $("#lblGuardarObservacion").empty();
                    $("#lblGuardarObservacion").append("Guardado...");
                }
            });
        }


        $(document).ready(function () {
            $("#cmbAsignarAmpliacion").change(function () {
                var idLicitacionAmpliar = document.getElementById("cmbAsignarAmpliacion").value;
                asignarAmpliacion(idLicitacionActiva, idLicitacionAmpliar);
                $("#loading").show();
                window.location.reload();
            });


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
                $('#dSolicitudCotizacion').prop('disabled', 'disabled');
            });


            $("#zonaObra").change(function () {
                var zonaObraSel = document.getElementById("zonaObra").value;
                if (zonaObraSel != idZonaLicitacion) {
                    swal({
                      title: "La zona de trabajo es distinta a la licitación",
                      text: "¿Desea utilizar otra cotización para la obra?",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#18a113",
                      cancelButtonColor: '#d33',
                      confirmButtonText: "Si",
                      cancelButtonText: "No",
                      confirmButtonClass: 'btn btn-success',
                      cancelButtonClass: 'btn btn-danger',
                      closeOnConfirm: true,
                      closeOnCancel: true
                    },
                    function(isConfirm){
                      if (isConfirm) {
                          $('#dSolicitudCotizacion').prop('disabled', false);
                      }
                    });

                }
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

            $("#ventanaFotosObra").on("show.bs.modal", function (e) {
                $("#ventanaFotosObraBody").html("");
                var idObra = $(e.relatedTarget).data('target-id');
                $.post("ajaxLicitacion.php", //Required URL of the page on server
                  { // Data Sending With Request To Server
                      action: "fotosObra",
                      idObra: idObra
                  },
                function (response, status) { // Required Callback Function
                    $("#ventanaFotosObraBody").html(response);
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
                cargaSelectMetrajesEstimados(idObraActiva);
                cargaMetrajesEstimados(idObraActiva);
            });

            $('#ventanaMetrajesRealizados').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });

            $("#ventanaMetrajesRealizados").on("show.bs.modal", function (e) {
                idObraActiva = $(e.relatedTarget).data('target-id');
                var idCotizacion = $(e.relatedTarget).data('target-idcotizacion');
                $(this).find('form').validator()

                $('#agregarMetrajeRealizadoForm').on('submit', function (e) {
                    if (e.isDefaultPrevented()) {
                    } else {
                        e.preventDefault()
                        // Si se cumple la validacion llama a la funcion de agregar
                        agregarMetrajeRealizado(idObraActiva);
                    }
                })

                cargaSelectMetrajesRealizados(idObraActiva);
                cargaMetrajesRealizados(idObraActiva);

            });

            $('#ventanaMetrajesRealizados').on('hidden.bs.modal', function () {
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
                     if (response.indexOf('Error') >= 0) {
                         swal({
                             title: "Error",
                             text: response,
                             type: "warning",
                             confirmButtonText: "OK"
                         });
                     } else {
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
                                 if (response.indexOf('Error') >= 0) {
                                     swal({
                                         title: "Error",
                                         text: response,
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

                $('#reclamarObraForm').on('submit', function (e) {
                        if (e.isDefaultPrevented()) {
                        } else {
                            e.preventDefault()
                            // Si se cumple la validacion llama a la funcion de agregar
                            cambiosActivos = "true";
                            cambiarEstado(idObra, "Pendiente de cuadrilla");
                        }
                })

                $('#cambiarEstadoFinalForm').on('submit', function (e) {
                    if (e.isDefaultPrevented()) {
                    } else {
                        e.preventDefault()
                        cambiosActivos = "true";
                        var estadoFinal = document.getElementById("cmbEstadoFinal").value;
                        cambiarEstado(idObra, estadoFinal);
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
                    $('#cantidadMetraje').val('');
                    cargaMetrajesEstimados(idObra);

                });
        }

        function asignarAmpliacion($idLicitacion,$idLicitacionAsignar) {
            var idLicitacion = $idLicitacion
            var idLicitacionAsignar = $idLicitacionAsignar
            $.post("ajaxLicitacion.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "asignarAmpliacion",
                          idLicitacion: idLicitacion,
                          idLicitacionAsignar: idLicitacionAsignar
                      },
                function (response, status) { // Required Callback Function
                    if (response.indexOf('Error') >= 0) {
                        swal({
                            title: "Advertencia!",
                            text: response,
                            type: "warning",
                            confirmButtonText: "OK"
                        });
                    } else {
                        $("#loading").show();
                        window.location.reload();
                    }
                });

        }

        function agregarMetrajeRealizado($idObra) {
            var idObra = $idObra
            var CantidadMetraje = $('#cantidadMetrajeRealizado').val();
            var NombreRubro = document.getElementById("rubroComboRealizado").value;
            $.post("ajaxLicitacion.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "agregarMetrajeRealizado",
                          idObra: idObra,
                          NombreRubro: NombreRubro,
                          CantidadMetraje: CantidadMetraje
                      },
                function (response, status) { // Required Callback Function
                    $('#cantidadMetrajeRealizado').val('');
                    cargaMetrajesRealizados(idObra);
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
                    if (response.indexOf('Error') >= 0) {
                        swal({
                            title: "Advertencia!",
                            text: response,
                            type: "warning",
                            confirmButtonText: "OK"
                        });
                    } else {
                        mostrarObra(idObra);
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
                        mostrarObra(idObra);
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

        function eliminarMetrajeRealizado($idMetrajeRealizado, $idObra) {
            var idObra = $idObra;
            var idMetrajeRealizado = $idMetrajeRealizado;
            $.post("ajaxLicitacion.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "eliminarMetrajeRealizado",
                          idMetrajeRealizado: idMetrajeRealizado
                      },
                function (response, status) { // Required Callback Function
                    cargaMetrajesRealizados(idObra);

                });
        }

        function informar() {
            var obrasInformarArray = new Array();
            $('input[name="btSelectItem"]:checked').each(function () {
                obrasInformarArray.push($(this).data('index'));
            });
            var obrasInformar = "";
            for (var i = 0; i < obrasInformarArray.length; i++) {
                if (i==0){
                    obrasInformar = obrasInformarArray[i];
                } else if (i > 0){
                    obrasInformar = obrasInformar + "," + obrasInformarArray[i];
                }
            }
            if (obrasInformar != "") {
                $.post("ajaxCliente.php", //Required URL of the page on server
                          { // Data Sending With Request To Server
                              action: "obtenerNumeroInforme",
                              idCliente: idClienteLicitacion
                          },
                    function (response, status) { // Required Callback Function
                        if (response.indexOf('Error') >= 0) {
                            swal({
                                title: "Advertencia!",
                                text: response,
                                type: "warning",
                                confirmButtonText: "OK"
                            });
                        } else {
                            nombreInforme = "VE 0" + response;
                            $.ajax({
                                type: 'POST',
                                url: "informe.php",
                                data: {
                                    idLicitacion: idLicitacionActiva,
                                    obrasInformar: obrasInformar,
                                    nombreInforme: nombreInforme
                                },
                                dataType: 'json'
                                }).done(function (data) {
                                var $a = $("<a>");
                                $a.attr("href", data.file);
                                $("body").append($a);
                                nombreInformeBajar = nombreInforme + ".xls";
                                $a.attr("download", nombreInformeBajar);
                                $a[0].click();
                                $a.remove();
                                $("#loading").show();
                                window.location.reload();
                            });
                        }
                    });


            }
        }

        function cargaSelectMetrajesRealizados($idObra) {
            $("#rubroComboRealizado").html("");
            var idObra = $idObra
            $.post("ajaxLicitacion.php", //Required URL of the page on server
                  { // Data Sending With Request To Server
                      action: "selectMetrajes",
                      idObra: idObra
                  },
            function (response, status) { // Required Callback Function
                if (response.indexOf('Error') >= 0) {
                    swal({
                        title: "Advertencia!",
                        text: response,
                        type: "warning",
                        confirmButtonText: "OK"
                    });
                } else {
                    $("#rubroComboRealizado").html(response);
                }
            });
        }

        function cargaSelectMetrajesEstimados($idObra) {
            $("#rubroCombo").html("");
            var idObra = $idObra
            $.post("ajaxLicitacion.php", //Required URL of the page on server
                  { // Data Sending With Request To Server
                      action: "selectMetrajes",
                      idObra: idObra
                  },
            function (response, status) { // Required Callback Function
                if (response.indexOf('Error') >= 0) {
                    swal({
                        title: "Advertencia!",
                        text: response,
                        type: "warning",
                        confirmButtonText: "OK"
                    });
                } else {
                    $("#rubroCombo").html(response);
                }
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

        function cargaMetrajesRealizados($idObra) {
            $("#ventanaMetrajesRealizadosBodyTabla").html("");
            var idObra = $idObra
            $.post("ajaxLicitacion.php", //Required URL of the page on server
                  { // Data Sending With Request To Server
                      action: "metrajesRealizados",
                      idObra: idObra
                  },
            function (response, status) { // Required Callback Function
                $("#ventanaMetrajesRealizadosBodyTabla").html(response);
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
    <div id="informeDiv" name="informeDiv"></div>

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

    <!--VENTANA FOTOS-->
    <div class="modal fade" tabindex="1" role="dialog" id="ventanaFotosObra">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="ventanaFotosObraTitle">Fotos</h4>
                </div>
                <div class="modal-body" id="ventanaFotosObraBody"></div>
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
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cantidadMetraje" class="col-sm-2 col-form-label">
                                    Metraje
                                </label>
                                <div class="col-sm-8">
                                    <input type="number" min="1" step="0.01" id="cantidadMetraje" data-error="Requerido" class="form-control" required>
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

    <!--VENTANA METRAJES REALIZADOS-->
    <div class="modal fade" tabindex="1" role="dialog" id="ventanaMetrajesRealizados">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="ventanaMetrajesRealizadosTitle">Metrajes realizados</h4>
                </div>
                <div class="modal-body" id="ventanaMetrajesRealizadosBody">
                    <div class="panel">
                        <br>
                        <form role="form" data-toggle="validator" id="agregarMetrajeRealizadoForm" name="agregarMetrajeRealizadoForm">
                            <div class="form-group row">
                                <label for="Rubro" class="col-sm-2 col-form-label">
                                    Rubro:
                                </label>
                                <div class="col-sm-8">
                                    <select name='rubroComboRealizado' id='rubroComboRealizado'>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cantidadMetrajeRealizados" class="col-sm-2 col-form-label">
                                    Metraje realizado
                                </label>
                                <div class="col-sm-8">
                                    <input type="number" min="1" step="0.01" id="cantidadMetrajeRealizado" data-error="Requerido" class="form-control" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <span class="form-control-static pull-right"> <button id="btnAgregarMetraje" type="submit" class="btn btn-success success">Agregar metraje</button> </span>

                        </form>
                        <div id="ventanaMetrajesRealizadosBodyTabla"></div>
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
                                    <select id="dSolicitudCotizacion" class="form-control" disabled required>
                                        <?php
                                        $idCotizacionLicitacionActiva=$rsCotizacion[idCotizacion];
                                        $sqlCotizaciones = listaCotizacion();
                                        while($rsCotizaciones = mysqli_fetch_array($sqlCotizaciones)){
                                            if ($rsCotizaciones[idCotizacion]==$idCotizacionLicitacionActiva){
                                                echo "<option value='".$idCotizacionLicitacionActiva."' selected>".$rsCotizacion[Nombre]."</option>";
                                            }else{
                                                echo "<option value='".$rsCotizaciones[idCotizacion]."'>".$rsCotizaciones[Nombre]."</option>";
                                            }
                                        }
                                        ?>
                                        
                                    </select>
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
    <?php
    $idLicitacion =  $rsLicitacion[idLicitacion];

    $sqlPresupuestoLicitacion=obtenerPresupuesto($idLicitacion);
    $rsPresupuestoLicitacion=mysqli_fetch_array($sqlPresupuestoLicitacion);
    $presupuestoActual=$rsPresupuestoLicitacion[Debe] - $rsPresupuestoLicitacion[Haber];
    if ($presupuestoActual<0){
        echo '&nbsp;&nbsp;&nbsp; [&nbsp;Presupuesto inicial: $&nbsp;'.$rsPresupuestoLicitacion[PresupuestoTotal].'&nbsp;]';
        echo '&nbsp;&nbsp;&nbsp; [&nbsp;Disponible: $&nbsp;0&nbsp;]';
        echo '&nbsp;&nbsp;&nbsp; [&nbsp;Ampliación: $&nbsp;'.$presupuestoActual.'&nbsp;]&nbsp;&nbsp;&nbsp;';
        echo 'Asignar ampliación:&nbsp;';
        echo '<select name=\'cmbAsignarAmpliacion\' id=\'cmbAsignarAmpliacion\' required>
              <option disabled selected value>Seleccione licitación</option>';
        $licitacionesCliente = obtenerLicitacionCliente($idCliente);
        while ($rsLicitacionesCliente=mysqli_fetch_array($licitacionesCliente)){
            if ($rsLicitacionesCliente[estado]=='Aprobada' && $rsLicitacionesCliente[idLicitacion]!=$idLicitacion){
                $presupuestoLicitacionAux=obtenerPresupuesto($rsLicitacionesCliente[idLicitacion]);
                $rsPresupuestoLicitacionAux=mysqli_fetch_array($presupuestoLicitacionAux);
                $presupuestoDisponibleLicitacionAux=($rsPresupuestoLicitacionAux[Debe]-$rsPresupuestoLicitacionAux[Haber]);
                $presupuestoActualAbsoluto=abs($presupuestoActual);
                if (($presupuestoDisponibleLicitacionAux>0)&&($presupuestoDisponibleLicitacionAux>=$presupuestoActualAbsoluto)){
                    echo "<option value='".$rsLicitacionesCliente[idLicitacion]."'>".$rsLicitacionesCliente[codigo]."</option>";
                }
            }
            
        }                                  
        echo '</select>';
    }else{
        echo '&nbsp;&nbsp;&nbsp; [&nbsp;Presupuesto inicial: $&nbsp;'.$rsPresupuestoLicitacion[PresupuestoTotal].'&nbsp;]';
        echo '&nbsp;&nbsp;&nbsp; [&nbsp;Disponible: $&nbsp;'.$presupuestoActual.'&nbsp;]';
    }
    ?>


        <div class="panel panel-info">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <h3 class="panel-title">Informes</h3>
        </div>
    <?php
        $informesArray = array();
        $obrasArray = array();

        $sqlObras = ListarObras($idLicitacion);
        $rowcount = mysqli_num_rows($sqlObras);
        if ($rowcount>0) {
            //Cargo las obras en un array
            while($rsObra=mysqli_fetch_array($sqlObras)){
                if ($rsObra[nombreInforme]!=NULL){
                    $colocar=true;
                    foreach($informesArray as $llave => $nombreInforme){
                        if ($nombreInforme==$rsObra[nombreInforme]){
                            $colocar=false;
                        }
                    }
                    if($colocar){
                        array_push($informesArray,$rsObra[nombreInforme]);
                    }
                }
                array_push($obrasArray,$rsObra);
            }
        }
        //Imprime los informes a los que refieren las obras
        foreach($informesArray as $nombreInforme){
            $nombreInformeExt=$nombreInforme.'.xls';
            echo '&nbsp;';
            echo '<a href="/informes/'.$nombreInformeExt.'" download>'.$nombreInforme.'</a>';
            echo '&nbsp;&nbsp;';
        }
    ?>
    </div>


    <div class="panel panel-info">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <h3 class="panel-title">Obras</h3>
        </div>
    <?php
    if ($presupuestoActual>0 && $rsLicitacion[estado]=='Aprobada'){
        echo '<br><button type="button" class="btn btn-default btn-xs " data-target="#ventanaAgregarObra" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span>Agregar obra</button>';
    }
    ?>
        
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
            <th data-field="informar"></th>
		</tr>
	</thead>
	<tbody>
    <?php
        foreach($obrasArray as $rsObra)
        {
            echo "<tr>"
            .'<td data-toggle="modal" data-target-id="'.$rsObra[idObra].'" data-target-nombre="'.$rsObra[Nombre].'" data-target-estado="'.$rsObra[Estado].'" data-target="#ventanaMostrarObra">'.$rsObra[Nombre].'</td>'
            ."<td>".$rsObra[Direccion]."</td>"
            ."<td>".$rsObra[Estado]."</td>"
            ."<td>".$rsObra[fechaRecibido]."</td>";
            if ($rsObra[Estado]=='Facturar 0,3' || $rsObra[Estado]=='Ejecutado'){
                echo '<td class="bs-checkbox "><input data-index="'.$rsObra[idObra].'" name="btSelectItem" type="checkbox" style="outline: 1px solid #1e850e;"></td>';
            }else{
                echo '<td></td>';
            }
            echo "</tr>";
        }
    ?>

	</tbody>
</table>
        <span class="form-control-static pull-right">
        <div class="bs-glyphicons"> <ul class="bs-glyphicons-list">
            <button onclick="informar()" class="btn btn-success btn-xs">
            <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> <span class="glyphicon-class">Informar obras</span>
            </button>
            </ul> </div> 
        </span>
    </div>

</body>
</html>
<?php } ?>

