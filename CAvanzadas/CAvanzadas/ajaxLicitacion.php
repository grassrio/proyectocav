<?php
require 'includes/ConsultasLicitacion.php';
require 'includes/ConsultasCotizacion.php';
require 'includes/ConsultasCliente.php';
require 'includes/ConsultaZonas.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'nuevaLicitacion' :
            insertarLicitacion($_POST['idCliente'],$_POST['idCotizacion'],$_POST['Estado'],$_POST['Codigo'],$_POST['Presupuesto']);
            break;
        case 'eliminarLicitacion' :
            eliminarLicitacion($_POST['Codigo']);
            break;
        case 'modificarLicitacion' :
            modificarLicitacion($_POST['idLicitacion'],$_POST['Estado']);
            break;
        case 'obtenerLicitacion' :
            $idLicitacion = $_POST['idLicitacion'];
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
            echo '
                <!--VENTANA PARA INGRESAR UNA NUEVA OBRA-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaAgregarObra">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Agregar obra</h4>
                </div>
                <div class="modal-body">
                    <form name="nuevaObraForm" method="POST" action="nuevaObra" ">
                        <div class="form-group row">

                            <label for="nombreObra" class="col-sm-2 col-form-label">
                                Nombre
                            </label>
                            <div class="col-sm-8">
                                <input id="nombreObra" name="nombreObra" class="form-control" type="text" value="" placeholder="Nombre o número de obra" />
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="fechaRecibidoObra" class="col-sm-2 col-form-label">
                                Fecha recibido
                            </label>
                            <div class="col-sm-8">
                                <input class="form-control" type="date" value="'.$fechaActual.'" id="fechaRecibidoObra" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dSolicitudCotizacion" class="col-sm-2 col-form-label">
                                Solicitud de cotización
                            </label>
                            <div class="col-sm-8">
                                <fieldset disabled>
                                <select id="dSolicitudCotizacion" class="form-control">
                                    <option value=\''.$rsCotizacion[idCotizacion].'\'>'.$rsCotizacion[Nombre].'</option>
                                </select>
                                </fieldset>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="direccionObra" class="col-sm-2 col-form-label">
                                Dirección
                            </label>
                            <div class="col-sm-8">
                                <input id="direccionObra" class="form-control" type="text" value="" placeholder="" />
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
                                <select id="zonaObra" class="form-control">
                                <option disabled selected value>Seleccione zona</option>';
                                while ($rsZonasLicitacion=mysqli_fetch_array($zonasLicitacion))
                                {
                                    $idZona=$rsZonasLicitacion[idZona];
                                    $zona = devolverZona($idZona);
                                    $rsZona=mysqli_fetch_array($zona);

                                    echo "<option value='".$rsZona[idZona]."'>".$rsZona[Nombre]."</option>";
                                }
                                echo '</select>
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

                        <div class="panel panel-info" id="divOptBalizas" >
                        <div class="collapse" id="optBalizas" >
                            <br>
                            <div class="form-group row">

                                <label for="proveedorBaliza" class="col-sm-2 col-form-label">
                                    Proveedor
                                </label>
                                <div class="col-sm-8">
                                    <input id="proveedorBaliza" class="form-control" type="text" value="'.$rsCliente[Nombre].'" />
                                </div>
                            </div>
                            <div class="form-group row" >
                                <label for="balCantidad" class="col-sm-2 col-form-label">
                                    Nº balizas
                                </label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="number" value="1" min="1" id="balCantidad">
                                </div>
                            </div>
                            <div class="form-group row" >
                                <label for="balFechaInicio" class="col-sm-2 col-form-label">
                                    Fecha entrega
                                </label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="date" value="'.$fechaActual.'" id="balFechaInicio" />
                                </div>
                            </div>
                            <div class="form-group row" >
                                <label for="balFechaFin" class="col-sm-2 col-form-label">
                                    Fecha devolución
                                </label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="date" value="'.$fechaActual.'" id="balFechaFin" />
                                </div>

                            </div>
                        </div>
                        </div>



                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="btnNuevaObra" onclick="agregarObra(\''.$idLicitacion.'\')" type="button" class="btn btn-success success">Agregar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->





            <button type="button" class="btn-sm btn-default" onclick="mostrarocultar(\'mostrar\',\'contenido\'); mostrarocultar(\'ocultar\',\'subcontenido\');">
                            <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></button>
            <div class="panel panel-default">

                <div class="panel-heading">
                    <span class="label label-info">Licitación '.$rsLicitacion[codigo].'</span>
                </div>
            Estado: '.$rsLicitacion[estado].'
            </div>
            <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <h3 class="panel-title">Obras</h3>
            </div>


            <nav class="navbar navbar-toolbar navbar-default">
                <div class="container-fluid">


                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li>
                                <a type="button" class="btn btn-default" aria-label="Left Align" href="#ventanaAgregarObra" data-toggle="modal">
                                    <span onclick="" class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </a>
                            </li>

                        </ul>



                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>


             </div>
            ';
            break;
    }
}
?>