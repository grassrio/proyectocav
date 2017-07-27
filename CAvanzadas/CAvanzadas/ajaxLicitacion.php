<?php
require 'includes/ConsultasLicitacion.php';
require 'includes/ConsultasCotizacion.php';
require 'includes/ConsultasCliente.php';
require 'includes/ConsultaZonas.php';
require 'includes/ConsultasObra.php';

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'nuevaLicitacion' :
            insertarLicitacion($_POST['idCliente'],$_POST['idCotizacion'],$_POST['Estado'],$_POST['Codigo'],$_POST['Presupuesto']);
            break;
        case 'nuevaObra' :
            $idObra = insertarObra($_POST['NombreObra'],$_POST['idCotizacionObra'],$_POST['DireccionObra'],$_POST['NumeroPuertaObra'],$_POST['idZonaObra'],$_POST['ObservacionObra'],$_POST['FechaRecibidoObra'],$_POST['idLicitacion'],$_POST['Esquina1'],$_POST['Esquina2']);
            echo $idObra;
            break;
        case 'agregarBaliza' :
            agregarBaliza($_POST['idObra'],$_POST['ProveedorBaliza'],$_POST['CantidadBaliza'],$_POST['FechaInicioBaliza'],$_POST['FechaFinBaliza']);
            break;
        case 'auditoriaEstado' :
            $idObra = $_POST['idObra'];
            $estadoObraSql = auditoriaEstado($idObra);
            $rowcount = mysqli_num_rows($estadoObraSql);
            if ($rowcount>0){
                echo '
                <!-- Tabla Auditoria de estados -->
                <table class="table">
                <tr>
                    <th>Estado anterior</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
                ';
                while($rsEstadoObra=mysqli_fetch_array($estadoObraSql))
                {
                    echo "<tr>"
                    ."<td>".$rsEstadoObra[EstadoAnterior]."</td>"
                    ."<td>".$rsEstadoObra[EstadoPosterior]."</td>"
                    ."<td>".$rsEstadoObra[Fecha]."</td>"
                    ."</tr>";
                }



                echo '</table>
                      </div>
                ';
            }
            break;
        case 'agregarMetraje' :
                $idObra=$_POST['idObra'];
                $nombreUnidadRubro_explode = explode('|', $_POST['NombreRubro']);
                $nombreRubro = $nombreUnidadRubro_explode[0];
                $unidadRubro = $nombreUnidadRubro_explode[1];
                $cantidadMetraje=$_POST['CantidadMetraje'];
                agregarMetrajeEstimado($idObra,$nombreRubro,$unidadRubro,$cantidadMetraje);
                break;
        case 'eliminarMetrajeEstimado' :
            $idMetrajeEstimado = $_POST['idMetrajeEstimado'];
            eliminarMetrajeEstimado($idMetrajeEstimado);
            break;
        case 'metrajesEstimados' :
            $idObra=$_POST['idObra'];
            $metrajeObraSql = metrajesEstimados($idObra);
            $rowcount = mysqli_num_rows($metrajeObraSql);
            if ($rowcount>0){
                echo '
                <br>
                <br>
                <br>
                <div class="panel panel-info" >
                <!-- Tabla Metrajes Estimados -->
                <table class="table">
                <tr>
                    <th>Rubro</th>
                    <th>Cantidad</th>
                    <th></th>
                </tr>
                ';
                while($rsMetrajeObra=mysqli_fetch_array($metrajeObraSql))
                {
                    echo "<tr>"
                    ."<td>".$rsMetrajeObra[NombreRubro]."</td>"
                    ."<td>".$rsMetrajeObra[MetrajeEstimado]." ".$rsMetrajeObra[Unidad]."</td>"
                    .'<td><button onclick="eliminarMetrajeEstimado('.$rsMetrajeObra[idMetrajeObra].','.$idObra.')" type="button" class="btn btn-default">
                              <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>'
                    ."</tr>";
                }



                echo '</table>
                      </div>
                ';
            }else{
                echo "<br> Sin metrajes";
            }
            break;
        case 'eliminarLicitacion' :
            eliminarLicitacion($_POST['Codigo']);
            break;
        case 'modificarLicitacion' :
            modificarLicitacion($_POST['idLicitacion'],$_POST['Estado']);
            break;

        case 'mostrarObra' :
            $idObra = $_POST['idObra'];
            $obraSql = obtenerObra($idObra);
            $rowcount = mysqli_num_rows($obraSql);
            if ($rowcount>0){
                $rsObra=mysqli_fetch_array($obraSql);
                $idZona = $rsObra[idZona];
                $zona = devolverZona($idZona);
                $rsZona=mysqli_fetch_array($zona);

                $idCotizacion = $rsObra[idCotizacion];
                $cotizacion = devolverCotizacion($idCotizacion);
                $rsCotizacion=mysqli_fetch_array($cotizacion);
                echo '

      <span class="form-control-static pull-right"><div class="bs-glyphicons"> <ul class="bs-glyphicons-list"><button data-toggle="modal" data-target-id="'.$rsObra[idObra].'" data-target="#ventanaAuditoriaEstado"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> <span class="glyphicon-class">Estados</span></button></ul> </div> </span>
      <span class="form-control-static pull-right"><div class="bs-glyphicons"> <ul class="bs-glyphicons-list"><button><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> <span class="glyphicon-class">Fotos</span></button></ul> </div> </span>
';
                echo 'Cotización: '.$rsCotizacion[Nombre].'<br>
                      Zona: '.$rsZona[Nombre].'<br>
                      Dirección: '.$rsObra[Direccion].'<br>
                      Esquina: '.$rsObra[Esquina1].'<br>
                      Esquina: '.$rsObra[Esquina2].'<br><br>'
                    ;

                $estado = $rsObra[Estado];
                switch($estado){
                    case 'Pendiente de cuadrilla' :
                        echo '<button type="button" data-target-id="'.$rsObra[idObra].'" data-target-idCotizacion="'.$rsObra[idCotizacion].'" class="btn btn-success btn-xs" data-target="#ventanaMetrajesEstimados" data-toggle="modal">Metrajes estimados</button><br><br>';
                        if ($_SESSION['tipoUsuario']=1){
                            echo '<button type="button" data-target-id="'.$rsObra[idObra].'" class="btn btn-success btn-xs" data-target="#ventanaAsignarCuadrilla" data-toggle="modal">Asignar cuadrilla</button><br>';
                        }else{
                            echo '<button type="button" data-target-id="'.$rsObra[idObra].'" class="btn btn-success btn-xs disabled" data-target="#ventanaAsignarCuadrilla" data-toggle="modal">Asignar cuadrilla</button><br>';
                        }
                        break;
                }

            }
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
<script>
        $(document).ready(function () {
            $(\'#ventanaAgregarObra\').on(\'shown.bs.modal\', function (e) {

                $(this).find(\'form\').validator()

                $(\'#nuevaObraForm\').on(\'submit\', function (e) {
                    if (e.isDefaultPrevented()) {
                    } else {
                        e.preventDefault()
                        agregarObra('.$idLicitacion.');
                    }
                })
                $(\'#ventanaAgregarObra\').on(\'hidden.bs.modal\', function (e) {
                    $(this).find(\'form\').off(\'submit\').validator(\'destroy\')
                })
            });
            $(\'#ventanaAgregarObra\').on(\'hidden.bs.modal\', function () {
                $(this).find(\'form\')[0].reset();
            });



            $("#ventanaAuditoriaEstado").on("show.bs.modal", function (e) {
                $("#ventanaAuditoriaEstadoBody").html("");
                var idObra = $(e.relatedTarget).data(\'target-id\');
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
            var idObra = $(e.relatedTarget).data(\'target-id\');
            var nombreObra = $(e.relatedTarget).data(\'target-nombre\');
            var estadoObra = $(e.relatedTarget).data(\'target-estado\');
            $("#ventanaMostrarObraTitle").html(\'<span class="label label-info">\' + nombreObra + \'</span>  -  \' + estadoObra);
            $.post("ajaxLicitacion.php", //Required URL of the page on server
              { // Data Sending With Request To Server
                  action: "mostrarObra",
                  idObra: idObra
              },
            function (response, status) { // Required Callback Function
                $("#ventanaMostrarObraBody").html(response);

            });





            $("#ventanaMetrajesEstimados").on("show.bs.modal", function (e) {
                var idObra = $(e.relatedTarget).data(\'target-id\');
                var idCotizacion = $(e.relatedTarget).data(\'target-idcotizacion\');
                $(this).find(\'form\').validator()

                $(\'#agregarMetrajeForm\').on(\'submit\', function (e) {
                    if (e.isDefaultPrevented()) {
                    } else {
                        e.preventDefault()
                        // Si se cumple la validacion llama a la funcion de agregar
                        agregarMetraje(idObra)
                    }
                })



                cargaMetrajesEstimados(idObra);


            });

            $(\'#ventanaMetrajesEstimados\').on(\'hidden.bs.modal\', function () {
                $(this).find(\'form\')[0].reset();
            });

        });


        });
</script>



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
        <div class="modal-dialog modal-lg"" role="document">
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
        <div class="modal-dialog modal-lg"" role="document">
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
                        <select name=\'rubroCombo\' id=\'rubroCombo\'>';
            $rubrosCotizacion = obtenerRubro($idCotizacion);
            while ($rsRubrosCotizacion=mysqli_fetch_array($rubrosCotizacion))
            {
                echo "<option value='".$rsRubrosCotizacion[nombreRubro]."|".$rsRubrosCotizacion[Unidad]."' selected>".$rsRubrosCotizacion[nombreRubro]."</option>";
            }
            echo '
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Agregar obra</h4>
                </div>
<form role="form" data-toggle="validator" id="nuevaObraForm" name="nuevaObraForm">
                <div class="modal-body">

                    <input type="hidden" id="idLicitacion" value="'.$idLicitacion.'">
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
                                <option disabled selected value>Seleccione zona</option>';
                                while ($rsZonasLicitacion=mysqli_fetch_array($zonasLicitacion))
                                {
                                    $idZona=$rsZonasLicitacion[idZona];
                                    $zona = devolverZona($idZona);
                                    $rsZona=mysqli_fetch_array($zona);

                                    echo "<option value='".$rsZona[idZona]."'>".$rsZona[Nombre]."</option>";
                                }
                                echo '</select>
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

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="btnNuevaObra" type="submit" class="btn btn-success success">Agregar obra</button>

                </div>
</form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



<nav class="navbar navbar-toolbar navbar-default">
                <div class="container-fluid">


                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li>
                                <button type="button" class="btn-xs btn-default" onclick="mostrarocultar(\'mostrar\',\'contenido\'); mostrarocultar(\'ocultar\',\'subcontenido\');">
                            <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></button>
            <div class="panel panel-default">
                            </li>
                            <li>
                                 <span class="label label-info">Licitación '.$rsLicitacion[codigo].'</span>
                            </li>

                        </ul>



                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>



                <div class="panel-heading">
                    Estado: '.$rsLicitacion[estado].'
                </div>

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
<button type="button" class="btn btn-success btn-xs" data-target="#ventanaAgregarObra" data-toggle="modal">Agregar obra</button>
                            </li>

                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>

        <!-- Tabla Obras -->
        <table class="table">
            <tr>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Estado</th>
                <th>Recibido</th>
            </tr>
            ';
                $sqlObras = ListarObras($idLicitacion);
                $rowcount = mysqli_num_rows($sqlObras);
                if ($rowcount>0) {
                    while($rsObra=mysqli_fetch_array($sqlObras))
                    {
                        echo "<tr>"
                        .'<td><a href="#" data-toggle="modal" data-target-id="'.$rsObra[idObra].'" data-target-nombre="'.$rsObra[Nombre].'" data-target-estado="'.$rsObra[Estado].'" data-target="#ventanaMostrarObra">'.$rsObra[Nombre].'</a></td>'
                        ."<td>".$rsObra[Direccion]."</td>"
                        ."<td>".$rsObra[Estado]."</td>"
                        ."<td>".$rsObra[fechaRecibido]."</td>"
                        ."</tr>";
                    }
                }



                echo '</table>
                       </div>
            ';
            break;
    }
}
?>