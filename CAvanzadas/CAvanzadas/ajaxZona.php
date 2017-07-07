<?php
require 'includes/ConsultaZonas.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'nuevoZona' :
            insertarZona($_POST['Nombre'],$_POST['idCliente']);
            break;
        case 'eliminarZona' :
            eliminarZona($_POST['Nombre']);
            break;
        case 'modificarZona' :
            modificarZona($_POST['idZona'],$_POST['Nombre']);
            break;
    }
}
?>