<?php
require('includes/loginheader.php');
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
</head>
<body>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
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
    </script>
        



    <div id="loading" style="position: absolute; top:50%; left:50%; z-index: 100000;">
        <img src="img/Loading.gif" />
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Construcciones Avanzadas SRL</h3>
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
                            <a href="JavaScript:carga('PantallaCliente')">Clientes</a>
                        </li>

                        <li>
                            <a href="JavaScript:carga('PantallaRubro')">Rubros</a>
                        </li>
                        <li>
                            <a href="JavaScript:carga('PantallaCotizacion')">Cotización</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="JavaScript:carga('PantallaLicitacion')">Licitaciones</a>
                        </li>
                        <li>
                            <a href="JavaScript:carga('PantallaObra')">Obras</a>
                        </li>
                      
                    </ul>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                  <!--    <ul class="nav navbar-nav">
                        <li class="active">
                            <button type="button" class="btn btn-default" aria-label="Left Align">
                                <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-default" aria-label="Left Align">
                                <span class="glyphicon glyphicon-filter" aria-hidden="true"></span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-default" aria-label="Left Align">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-default" aria-label="Left Align">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-default" aria-label="Left Align">
                                <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                            </button>
                        </li>
                    </ul>-->
                    <!-- busqueda 
                    <form class="navbar-form navbar-left">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="" />
                        </div>
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </button>
                    </form>
                                            -->

                    <!-- desplegable derecha -->
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
                                <a href="#">
                                    <i class="glyphicon glyphicon-user"></i>Usuarios
                                </a>
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

