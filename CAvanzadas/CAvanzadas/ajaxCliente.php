<?php
require 'includes/ConsultasCliente.php';
require 'includes/ConsultaZonas.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'nuevoCliente' :
            insertarCliente($_POST['Nombre']);
            break;
        case 'eliminarCliente' :
            eliminarCliente($_POST['Nombre']);
            break;
        case 'modificarCliente' :
            modificarCliente($_POST['idCliente'],$_POST['Nombre']);
            break;
        case 'mostrarCliente' :
            $idCliente = $_POST['idCliente'];
            $idZonasSql = obtenerZonas($idCliente);
            $rowcount = mysqli_num_rows($idZonasSql);
            if ($rowcount>0) {
                echo '<table class="table"><tr><th>Zonas</th><th></th></tr>';
                while($rs=mysqli_fetch_array($idZonasSql))
                {
                    $idZona=$rs[0];
                    $zona=devolverZona($idZona);
                    $rsZona=mysqli_fetch_array($zona);
                    echo '<tr><td>'.$rsZona[Nombre].'</td>
<td><button onclick="EliminarZona('.$rsZona[idZona].','.$idCliente.')" id="btnEliminarZona" type="button" class="btn btn-default">
<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>
</tr>';
                }
                echo "</table>";
            }else{
                echo "Sin zonas";
            }
            echo '<br><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target-id="'.$idCliente.'" data-target="#ventanaAgregarZona" data-toggle="modal">Agregar zona</button>';

            break;
    }
}
?>