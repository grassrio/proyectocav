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
    <link href="css/todc-bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
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
                        <a href="Pantallalicitacion.php">Licitaciones</a>
                    </li>
                    <li>
                        <a href="PantallaCliente.php">Clientes</a>
                    </li>
                    <li>
                        <a href="#">Something else here</a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a href="#">Separated link</a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a href="#">One more separated link</a>
                    </li>
                </ul>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                <!-- busqueda -->
                <form class="navbar-form navbar-left">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="" />
                    </div>
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    </button>
                </form>

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
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Ingrese un cliente nuevo</h3>
        </div>
        <form method="POST" action="">
                 <div class="panel-body">
                    <div class="input-group">
                        <input name="Nombre" type="text" class="form-control" placeholder="Nombre" aria-describedby="basic-addon2" />
                    </div>
                    <div class="input-group">
                        <input name="Zona" type="text" class="form-control" placeholder="Zona" aria-describedby="basic-addon2" />
                    </div>
                    <p>
                        <input class="btn btn-primary" name="submit" type="submit" id="btn" value="Ingresar" />
                        <!--  <a class="btn btn-primary btn-lg" href="#" role="button" name="login" type="submit">Iniciar sesión</a>-->
                    </p>
                </div>
         </form>
    </div>
    <?php
    if(isset($_POST['submit'])){
        if (!empty($_POST['Nombre'])&&!empty($_POST['Zona'])){
            require("includes/ConsultasCliente.php");
            $sql = insertarCliente($_POST['Nombre'],$_POST['Zona']);
            echo 'Se ingreso correctamente el cliente.'
        }else{
            echo"Error: Debe ingresar el Nombre y las zonas para ingresar el cliente.";
        }
    }
    ?>
</body>
</html>
<?php } ?>

