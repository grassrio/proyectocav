<?php
require 'includes/ConsultasRubro.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'nuevoRubro' :
            insertarRubro($_POST['Nombre'],$_POST['Unidad'],$_POST['cantidadStock']);
            break;
        case 'eliminarRubro' :
            eliminarRubro($_POST['Nombre']);
            break;
    }
}
?>