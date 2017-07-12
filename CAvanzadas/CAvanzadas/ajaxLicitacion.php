<?php
require 'includes/ConsultasLicitacion.php';
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
            $licitacion = obtenerLicitacion($_POST['idLicitacion']);
            $rsLicitacion=mysqli_fetch_array($licitacion);
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
                    <form name="nuevaObra" method="POST" action="nuevaObra">
                        <div class="form-group row">

                            <label for="nombreObra" class="col-sm-2 col-form-label">
                                Nombre
                            </label>
                            <div class="col-sm-8">
                                <input id="nombreObra" class="form-control" type="text" value="" placeholder="Nombre o número de obra" />
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="fechaRecibido" class="col-sm-2 col-form-label">
                                Fecha recibido
                            </label>
                            <div class="col-sm-8">
                                <input class="form-control" type="date" value="'.$fechaActual.'" id="example-date-input" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cotizacion" class="col-sm-2 col-form-label">
                                Solicitud de cotización
                            </label>
                            <div class="col-sm-8">
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="direccion" class="col-sm-2 col-form-label">
                                Dirección
                            </label>
                            <div class="col-sm-8">
                                <input id="direccion" class="form-control" type="text" value="" placeholder="" />
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="npuerta" class="col-sm-2 col-form-label">
                                Nº de puerta
                            </label>
                            <div class="col-sm-8">
                                <input id="npuerta" class="form-control" type="text" value="" placeholder="" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cotizacion" class="col-sm-2 col-form-label">
                                Zona
                            </label>
                            <div class="col-sm-8"></div>
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
                            <label for="reqBaliza" class="col-sm-2 col-form-label">
                                Requiere baliza
                            </label>
                            <div class="col-sm-8">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" />
                                </label>
                            </div>
                        </div>


                        <div class="form-group row">

                            <label for="observacion" class="col-sm-2 col-form-label">
                                Observaciones
                            </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="btnNuevaObra" type="button" class="btn btn-success success">Agregar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


            <div class="panel panel-default">
            <button type="button" class="btn-sm btn-default" onclick="mostrarocultar(\'mostrar\',\'contenido\'); mostrarocultar(\'ocultar\',\'subcontenido\');">
                            <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span></button>
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