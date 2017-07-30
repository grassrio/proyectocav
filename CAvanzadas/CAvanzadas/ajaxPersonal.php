<?php
require 'includes/ConsultasPersonal.php';
require 'includes/ConsultasUsuarios.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'nuevoPersonal' :
            insertarPersonal($_POST['NombreCompleto'],$_POST['Direccion'],$_POST['Telefono'],$_POST['Cargo']);
            if ($_POST['Cargo'] =='Director' )
            {
                $cargo = 1;
            }
            elseif($_POST['Cargo'] =='Obrero')
            {
                $cargo = 2;
            }
            else
            {
                $cargo = 3;
            }
            $sql = devolverPersonal($_POST['NombreCompleto']);
            $passConMd5 = md5($_POST['Pass']);
            $rs=mysqli_fetch_array($sql);
            insertarUsuario($_POST['NombreUsu'],$passConMd5,$cargo,$rs[0]);
            break;
        case 'eliminarPersonal' :
            eliminarPersonal($_POST['NombreCompleto']);
            break;
        case 'modificarPersonal' :
            modificarPersonal($_POST['idPersonal'],$_POST['Direccion'],$_POST['Telefono'],$_POST['Cargo']);
            break;
        case 'modificarUsuario' :
            $passConMd5 = md5($_POST['Pass']);
            modificarUsuario($_POST['IdUsuario'],$passConMd5);
            break;
        case 'eliminarUsuario' :
            eliminarUsuario($_POST['NombreUsuario']);
            break;
        case 'ProductividadEmpleado' :
            $sql =   ObrasFinalizadasEntreFecha($_POST['FechaInicio'],$_POST['FechaFin']);
            echo   '    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <h3 class="panel-title">Empleados</h3>
        </div>

        <nav class="navbar navbar-toolbar navbar-default">
            <div class="container-fluid">
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <button type="button" class="btn btn-success btn-xs" data-target="#ventanaSeleccionaFecha" data-toggle="modal">Ingresar Fechas</button>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <!-- Table -->
        <table class="table">
            <tr>
                <th>Nombre Completo</th>
                <th>Metrajes Realizados</th>
            </tr>';
                    $rowcount = mysqli_num_rows($sql);
                    if ($rowcount>0) {
                        while($rs=mysqli_fetch_array($sql))
                        {
                            echo "<tr>"
                            ."<td>".$rs[0]."</td>"
                            ."<td>".$rs[1]."</td>"
                            ."</tr>";
                        }
                    }
                    else
                    {
                        echo'<tr><td>No hay Informaciom</td></tr>';
                    }
                    echo'
        </table>
    </div>';
            break;
    }
}
?>