<?php
require('includes/loginheader.php');
session_start();
require 'includes/ConsultasCliente.php';
$sql = devolverClientes();
$rowcount = mysqli_num_rows($sql);
if ($rowcount>0) {?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
   

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <h3  class="panel-title">Clientes</h3>
        </div>


        <nav class="navbar navbar-toolbar navbar-default">
            <div class="container-fluid">


                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                    <ul class="nav navbar-nav">
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
                            <a type="button" class="btn btn-default" aria-label="Left Align" href="FormularioIngresoCliente.php">
                                <span onclick="" class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a>
                        </li>
                        <li>
                            <button type="button" class="btn btn-default" aria-label="Left Align">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </button>
                        </li>
                        <li>
                            <a type="button" class="btn btn-default" aria-label="Left Align">
                                <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                            </a>
                        </li>
                    </ul>
                    <!-- busqueda -->
                    <form class="navbar-form navbar-left">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="" />
                        </div>
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </button>
                    </form>



                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <!-- Table -->
        <table class="table">
            <tr>
                <th>Nombre</th>
                <th>Zonas</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
            <?php
                while($rs=mysqli_fetch_array($sql))
                {
                    echo "<tr>"
                    ."<td>".$rs[1]."</td>"
                    ."<td>".$rs[2]."</td>"
                    ."<td>"."<input type="."reset"." name="."editar"." value="."editar".$rs[1]."/>"."</td>"
                    ."<td>".'<form method="POST" action="">
                                <a type="button" class="btn btn-default" aria-label="Left Align">
                                     <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>
                            </form>'
                    ."</td>"
                    ."</tr>";
                }


            ?>
        </table>
    </div>
</body>
</html>
<?php } ?>

