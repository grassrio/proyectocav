<?php
require 'includes/ConsultasCotizacion.php';
require 'includes/ConsultasRubro.php';

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'nuevaCotizacion' :
            InsertarCotizacion($_POST['Nombre']);
            break;
        case 'nuevoRubro' :
            InsertarRubroCotizacion($_POST['idCotizacion'],$_POST['idRubro'],$_POST['Precio']);
            break;
        case 'eliminarCotizacion' :
            eliminarCotizacion($_POST['Nombre']);
            break;
        case 'modificarCotizacion' :
            modificarCotizacion($_POST['idCotizacion'],$_POST['Nombre']);
            break;
        case 'mostrarCotizacion' :
            $idCotizacion = $_POST['idCotizacion'];
            $idRubrosql = obtenerRubro($idCotizacion);
            $rowcount = mysqli_num_rows($idRubrosql);
            if ($rowcount>0) {
                echo '<table class="table"><tr><th>Rubros</th><th>Precio</th><th></th></tr>';
                while($rs=mysqli_fetch_array($idRubrosql))
                {
                    $idRubro=$rs[0];
                    $rubro=devolverRubro($idRubro);
                    $rsrubro=mysqli_fetch_array($rubro);
                    echo '<tr><td>'.$rsrubro[Nombre].'</td>
                              <td>'.$rs[Precio].'</td>
                              <td><button id="btnEliminarZona" type="button" class="btn btn-default">
                              <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>
                        </tr>';
                }
                echo "</table>";
            }else{
                echo "Sin rubros";
            }
            echo '<br><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target-id="'.$idCotizacion.'" data-target="#ventanaAgregarRubro" data-toggle="modal">Agregar rubro</button>';

            break;
    }
}
?>