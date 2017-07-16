<?php
require 'includes/ConsultasPersonal.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'nuevoPersonal' :
            insertarPersonal($_POST['Nombre'],$_POST['Apellido'],$_POST['Direccion'],$_POST['Telefono'],$_POST['Cargo']);
            break;
        case 'eliminarPersonal' :
            eliminarPersonal($_POST['idPersonal']);
            break;
        case 'modificarPersonal' :
            modificarPersonal($_POST['idPersonal'],$_POST['Direccion'],$_POST['Telefono'],$_POST['Cargo']);
            break;
    }
}
?>