<?php
require 'includes/ConsultasPersonal.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'nuevoPersonal' :
            insertarPersonal($_POST['NombreCompleto'],$_POST['Direccion'],$_POST['Telefono'],$_POST['Cargo']);
            break;
        case 'eliminarPersonal' :
            eliminarPersonal($_POST['NombreCompleto']);
            break;
        case 'modificarPersonal' :
            modificarPersonal($_POST['idPersonal'],$_POST['Direccion'],$_POST['Telefono'],$_POST['Cargo']);
            break;
    }
}
?>