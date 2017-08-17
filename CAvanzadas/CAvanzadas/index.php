<?php
require('includes/loginheader.php');
$fechaActual=date("Y-m-d");
session_start();
$tipoUsuario = $_SESSION['tipoUsuario'];
if (isset($_SESSION['usuario'])) {
    if ($tipoUsuario<>2){
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CAvanzadas</title>
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

    <style>
        body {
            background-image: url(img/imgPrincipal.jpg);
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            -moz-background-size: cover;
            -webkit-background-size: cover;
            -o-background-size: cover;
        }
    </style>

</head>
<body>


    <script type="text/javascript">

        $(document).ready(function () {
            $("#loading").hide();
            consultaBalizasProximoVencimiento();
            $(document).ajaxStart(function () {
                $("#loading").show();
            }).ajaxStop(function () {
                $("#loading").hide();
            });
        });

        function consultaBalizasProximoVencimiento() {
            $("#loading").show();
            $.ajax({
                url: 'ajaxBaliza.php',
                type: 'post',
                data: { "action": "consultaBalizasProximoVencimiento" },
                success: function (response) {
                    $("#lblCantidadBalizaVencimiento").empty();
                    $("#lblCantidadBalizaVencimiento").append(response);
                }
            });
        }

        function carga(script) {
            $("#loading").show();
            document.getElementById("iframeContenido").src = "";
            $("#contenido").show();
            $("#subcontenido").hide();
            jQuery('#main').animate({ opacity: 0 }, 200, function () { jQuery('#contenido').load(script + ".php", function () { consultaBalizasProximoVencimiento(); jQuery('#main').animate({ opacity: 1 }, 200) }) });
        }


        function cargaIframe(script) {
            $("#loading").show();
            $("#contenido").hide();
            $("#subcontenido").hide();
            document.getElementById("iframeContenido").src = script + ".php";
            document.getElementById("iframeContenido").style.visibility = "visible";
        }


        function onMyFrameLoad(iframe) {
            $("#loading").hide();
        };

        $(document).ready(function () {
            $('#ventanaSeleccionaFecha').on('shown.bs.modal', function (e) {
                $(this).find('form').validator()
                $('#consultaProductividad').on('submit', function (e) {
                    if (e.isDefaultPrevented()) {
                    }
                    else {
                        e.preventDefault()
                        ProductividadEmpleado();
                    }
                })
                $('#ventanaSeleccionaFecha').on('hidden.bs.modal', function (e) {
                    $(this).find('form').off('submit').validator('destroy')
                })
            });
            $('#ventanaSeleccionaFecha').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });
        });
        function ProductividadEmpleado() {
            $('#btnConsulta').prop('disabled', true);
            var fechaInicio = $('#fechaInicio').val();
            var fechaFin = $('#fechaFin').val();
            $.post("ajaxPersonal.php", //Required URL of the page on server
                  { // Data Sending With Request To Server
                      action: "ProductividadEmpleado",
                      FechaInicio: fechaInicio,
                      FechaFin: fechaFin,
                  },
            function (response, status) { // Required Callback Function
                document.getElementById("iframeContenido").src = "";
                $('#btnConsulta').prop('disabled', false);
                $("#contenido").hide();
                $('#ventanaSeleccionaFecha').modal('hide');
                $("#subcontenido").show();
                $("#subcontenido").html(response);
            });
        };
    </script>

    <!--CONSULTA PRODUCTIVIDAD-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaSeleccionaFecha">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Seleccione el periodo para realizar la consulta</h4>
                </div>
                <div class="modal-body">
                    <form role="form" data-toggle="validator" id="consultaProductividad" name="consultaProductividad">
                        <div class="form-group row">
                            <label for="fechaI" class="col-sm-2 col-form-label">
                                Fecha desde:
                            </label>
                            <div class="col-sm-8">
                                <input name="fechaInicio" data-error="Completa este campo" id="fechaInicio" type="date" value="<?php echo $fechaActual;?>" class="form-control" aria-describedby="basic-addon2" required />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Direccion" class="col-sm-2 col-form-label">
                                Fecha hasta:
                            </label>
                            <div class="col-sm-8">
                                <input name="fechaFin" data-error="Completa este campo" id="fechaFin" type="date" value="<?php echo $fechaActual;?>" class="form-control" aria-describedby="basic-addon2" required />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="btnConsulta" type="submit" class="btn btn-success success">Consulta</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="loading" style="position: absolute; top:50%; left:50%; z-index: 100000;">
        <img src="img/Loading.gif" />
    </div>


    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Construcciones Avanzadas SRL  -  Pavimentación y veredas</h3>
        </div>
    </div>

    <nav class="navbar navbar-toolbar">
        <div class="container-fluid">
            <div class="navbar-header">

                <a href="#" class="navbar-brand dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="JavaScript:cargaIframe('PantallaLicitacion')">Licitaciones</a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a href="JavaScript:carga('PantallaCliente')">Clientes</a>
                    </li>

                    <li>
                        <a href="JavaScript:carga('PantallaRubro')">Rubros</a>
                    </li>
                    <li>
                        <a href="JavaScript:carga('PantallaCotizacion')">Cotización</a>
                    </li>
                    <li>
                        <a href="JavaScript:carga('PantallaPersonal')">Personal</a>
                    </li>
                    <li>
                        <a href="JavaScript:carga('PantallaCuadrilla')">Cuadrilla</a>
                    </li>
                </ul>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->


            <ul class="nav navbar-nav">
                <li role="presentation">
                    <a href="JavaScript:carga('PantallaBaliza')">
                        Alertas
                        <span id="lblCantidadBalizaVencimiento" class="badge"></span>
                    </a>
                </li>
            </ul>

            <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                <div class="btn-group pull-right">
                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="glyphicon glyphicon-cog"></i>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">
                            <?php echo $_SESSION['usuario']; ?>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="JavaScript:carga('PantallaUsuario')">
                                <i class="glyphicon glyphicon-user"></i>Usuarios
                            </a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="#" data-toggle="modal" data-target-id="1" data-target-nombre="1" data-target="#ventanaSeleccionaFecha">Productividad</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="includes/logout.php">
                                <i class="glyphicon glyphicon-object-align-horizontal"></i>Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>


    <div id="main">
        <div id="contenido"></div>

        <div id="subcontenido"></div>
    </div>
    <iframe id="iframeContenido" onload="onMyFrameLoad(this), this.style.height = (this.contentDocument.body.scrollHeight) + 'px';" style="width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;">
        Your browser doesn't support iframes
    </iframe>




</body>
</html>
<?php
}else{
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CAvanzadas</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
    <link href="css/todc-bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css" />


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <style>
        body {
            background-image: url(img/imgPrincipal.jpg);
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            -moz-background-size: cover;
            -webkit-background-size: cover;
            -o-background-size: cover;
        }
    </style>

</head>
<body>
    <script>
        $(document).ready(function () {
            $("#ventanaMetrajesEstimados").on("show.bs.modal", function (e) {
                idObraActiva = $(e.relatedTarget).data('target-idobra');
                cargaMetrajesEstimados(idObraActiva);
            });
        });

        function cargaMetrajesEstimados($idObra) {
            $("#ventanaMetrajesEstimadosBodyTabla").html("");
            var idObra = $idObra
            $.post("ajaxLicitacion.php", //Required URL of the page on server
                  { // Data Sending With Request To Server
                      action: "metrajesEstimadosFuncionario",
                      idObra: idObra
                  },
            function (response, status) { // Required Callback Function
                $("#ventanaMetrajesEstimadosBodyTabla").html(response);
            });
        }
    </script>
    <!--VENTANA METRAJES ESTIMADOS-->
    <div class="modal fade" tabindex="1" role="dialog" id="ventanaMetrajesEstimados">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="ventanaMetrajesEstimadosTitle">Metrajes estimados</h4>
                </div>
                <div class="modal-body" id="ventanaMetrajesEstimadosBody">
                    <div class="panel">
                        <div id="ventanaMetrajesEstimadosBodyTabla"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Construcciones Avanzadas SRL  -  Pavimentación y veredas</h3>
        </div>
    </div>
    <nav class="navbar navbar-toolbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <ul class="nav nav-pills">
                    <li>
                        <a href="includes/logout.php">
                            <i class="glyphicon glyphicon-object-align-horizontal"></i>Cerrar sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        </div>
    </nav>
        <div class="panel panel-default">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Obras asignadas</h3>
            </div>
        </div>

        <table class="table">
            <tr>
                <th>Nº Obra</th>
                <th>Zona</th>
                <th>Dirección</th>
                <th>Esquina</th>
                <th>Esquina</th>
            </tr>
            <?php
                require 'includes/ConsultasUsuarios.php';
                require 'includes/ConsultasPersonal.php';
                require 'includes/ConsultasCuadrilla.php';
                require 'includes/ConsultasObra.php';
                require 'includes/ConsultaZonas.php';
                $nombreUsuario = $_SESSION['usuario'];
                //Obtengo usuario basandome en el nombre de usuario logeado
                $sqlUsuario = devolverUsuario($nombreUsuario);
                $rowcount = mysqli_num_rows($sqlUsuario);
                $cuadrillasFormaParteArray = array();
                if ($rowcount>0) {
                    $rsUsuario=mysqli_fetch_array($sqlUsuario);
                    $idObrero = $rsUsuario[idPersonal];
                    //Obtengo obrero por su idPersonal
                    $sqlObrero = obtenerObreroPorId($idObrero);
                    $rowcountObrero = mysqli_num_rows($sqlObrero);
                    if ($rowcountObrero>0) {
                        $rsObrero=mysqli_fetch_array($sqlObrero);
                        $NombreCompleto = $rsObrero[NombreCompleto];
                        //Obtengo todas las cuadrillas de las cuales forma parte
                        $sqlCuadrillasFormaParte = obtenerCuadrillaCompuestas($NombreCompleto);
                        $rowcountCuadrillas = mysqli_num_rows($sqlCuadrillasFormaParte);
                        //Si compone alguna cuadrilla
                        if ($rowcountCuadrillas>0) {
                            while($rsCuadrillasFormaParte=mysqli_fetch_array($sqlCuadrillasFormaParte)){
                                //Agrego al array las cuadrillas de las que forma parte para recorrer una sola vez
                                array_push($cuadrillasFormaParteArray,$rsCuadrillasFormaParte[idCuadrilla]);
                            }
                            $sqlObrasAsignadas = obtenerObrasAsignadas();
                            $rowcountObrasAsignadas = mysqli_num_rows($sqlObrasAsignadas);
                            //Si hay alguna obra en estado asignado
                            if ($rowcountObrasAsignadas>0) {
                                while($rsObrasAsignadas=mysqli_fetch_array($sqlObrasAsignadas)){
                                    //Verifico si la obra tiene asignada la cuadrilla a la que pertenece el obrero
                                    foreach($cuadrillasFormaParteArray as $idCuadrilla){
                                        if ($rsObrasAsignadas[idCuadrilla]==$idCuadrilla){
                                            //La obra tiene asignada la cuadrillaa la que pertenece
                                            //Mostramos la obra
                                            $idZona = $rsObrasAsignadas[idZona];
                                            $zona = devolverZona($idZona);
                                            $rsZona=mysqli_fetch_array($zona);
                                            echo "<tr>"
                                            .'<td><button type="button" data-target-idobra="'.$rsObrasAsignadas[idObra].'" class="btn btn-success btn-xs" data-target="#ventanaMetrajesEstimados" data-toggle="modal">'.$rsObrasAsignadas[Nombre].'</button></td>'  
                                            ."<td>".$rsZona[Nombre]."</td>"
                                            ."<td>".$rsObrasAsignadas[Direccion]."</td>"
                                            ."<td>".$rsObrasAsignadas[Esquina1]."</td>"
                                            ."<td>".$rsObrasAsignadas[Esquina2]."</td>"
                                            ."</tr>";
                                        }
                                    }
                                }
                            }

                        }


                    }
                }
            ?>
        </table>
    </div>

</body>
</html>
<?php
}
} ?>

