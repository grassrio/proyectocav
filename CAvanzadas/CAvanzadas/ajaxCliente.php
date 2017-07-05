<?php
require 'includes/ConsultasCliente.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'nuevoCliente' :
            insertarCliente($_POST['Nombre'],$_POST['Zona']);
            break;
        case 'eliminarCliente' :
            eliminarCliente($_POST['Nombre']);
            break;
        case 'modificarCliente' :
            insertarCliente($_POST['idCliente'],$_POST['Nombre'],$_POST['Zona']);
            break;
    }
}
?>