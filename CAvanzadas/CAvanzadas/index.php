<?php
require('includes/loginheader.php');
$fechaActual=date("Y-m-d");
session_start();
if (isset($_SESSION['usuario'])) {?>
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

</head>
<body>
    

    <script type="text/javascript">

        $(document).ready(function () {
            $("#loading").hide();
            $(document).ajaxStart(function () {
                $("#loading").show();
            }).ajaxStop(function () {
                $("#loading").hide();
            });
        });



        function carga(script) {
            $("#contenido").show();
            $("#subcontenido").hide();
            jQuery('#main').animate({ opacity: 0 }, 200, function () { jQuery('#contenido').load(script + ".php", function () { jQuery('#main').animate({ opacity: 1 }, 200) }) });
            ;
        }
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

        <nav class="navbar navbar-toolbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">

                    <a href="#" class="navbar-brand dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="JavaScript:carga('PantallaLicitacion')">Licitaciones</a>
                        </li>
                        <li>
                            <a href="JavaScript:carga('PantallaObra')">Obras</a>
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
                            <span class="badge">
                                <?php
                                require 'includes/ConsultasBaliza.php';
                                $sql = DevolverBalizasProximoVencimiento();
                                $rowcount = mysqli_num_rows($sql);
                                if($rowcount>0){
                                    echo $rowcount;
                                }
                                else
                                {
                                    echo '0';
                                }
                                ?>
                            </span>
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



</body>
</html>
<?php } ?>

