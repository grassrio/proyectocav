<?php
require('includes/loginheader.php');
require 'includes/ConsultasCotizacion.php';
require 'includes/ConsultasLicitacion.php';
require 'includes/ConsultasCliente.php';
session_start();
if (isset($_SESSION['usuario'])) {?>
    <script>

        var nombreDinamico;
        var id;
        var idLicitacionActiva;
        var cambiosActivos = false;
        $(document).ready(function () {
            $("#ventanaEliminarLicitacion").on("show.bs.modal", function (e) {
                nombreDinamico = $(e.relatedTarget).data('target-id');
                $("#eliminarDinamico").html("Desea eliminar la licitación " + nombreDinamico + "?");
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
                         desplegarLicitacion(idLicitacion);
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

        $(document).ready(function () {
            $("#ventanaModificarLicitacion").on("show.bs.modal", function (e) {
                id = $(e.relatedTarget).data('target-id');
            });
        });
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
                    if (response == '') {
                        $('#ventanaAgregarLicitacion').modal('hide');
                        carga('PantallaLicitacion');
                    }
                    else {
                        swal({
                            title: "Advertencia!",
                            text: response,
                            type: "warning",
                            confirmButtonText: "OK"
                        });
                        $('#btnNuevaLicitacion').prop('disabled', false);
                        $('#Codigo').val('');
                        $('#Presupuesto').val('');
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
                        carga('PantallaLicitacion');
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
        function desplegarLicitacion($idLicitacion) {
            var idLicitacion = $idLicitacion;
            idLicitacionActiva = $idLicitacion;
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

        }
        function mostrarocultar(action, id) {
            if (action == "mostrar") {
                $("#" + id).show();
            } else {
                $("#" + id).hide();
            }

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
                        cambiarEstado(idObra,"Pendiente de baliza");
                    } else {
                        cambiosActivos = "true";
                        cambiarEstado(idObra, "Pendiente de cuadrilla");
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

        function cambiarEstado($idObra,$estado) {
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
    


    <div class="container">



        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <div class="pull-right">
                    <button type="button" class="btn btn-default btn-xs " data-target="#ventanaAgregarLicitacion" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span>Agregar licitación</button>
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filtros</button>
                </div>
                <h3 class="panel-title">Licitaciones</h3>


            </div>
            <table class="table">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Nº Licitación" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Cliente" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Fecha" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Estado" disabled></th>
                    </tr>
                </thead>
                <tbody><?php
    $sql = ListarLicitaciones();
    $rowcount = mysqli_num_rows($sql);
    if ($rowcount>0) {
        while($rs=mysqli_fetch_array($sql))
        {
            $sqlCliente = obtenerCliente($rs[idCliente]);
            $rsCliente=mysqli_fetch_array($sqlCliente);
            echo "<tr>"
            .'<td><a href="#" onclick="desplegarLicitacion('.$rs[idLicitacion].')">'.$rs[4].'</a></td>'
            ."<td>".$rsCliente[Nombre]."</td>"
            ."<td>".$rs[fecha]."</td>"
            ."<td>".$rs[estado]."</td>"
            ."<td></td>"
            ."<td>".'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[0].'" data-target="#ventanaModificarLicitacion" data-toggle="modal">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'
            .'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[4].'" data-target="#ventanaEliminarLicitacion" data-toggle="modal">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'
            ."</td>"
            ."</tr>";
        }
    }
                       ?>
                </tbody>
            </table>
        </div>
    </div>






    <?php } ?>
