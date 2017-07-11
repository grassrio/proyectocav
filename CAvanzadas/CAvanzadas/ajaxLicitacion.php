<?php
require 'includes/ConsultasLicitacion.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'nuevaLicitacion' :
            insertarLicitacion($_POST['idCliente'],$_POST['idCotizacion'],$_POST['Estado'],$_POST['Codigo'],$_POST['Presupuesto']);
            break;
        case 'eliminarLicitacion' :
            eliminarLicitacion($_POST['Codigo']);
            break;
        case 'modificarLicitacion' :
            modificarLicitacion($_POST['idLicitacion'],$_POST['Estado']);
            break;
    }
}
?>