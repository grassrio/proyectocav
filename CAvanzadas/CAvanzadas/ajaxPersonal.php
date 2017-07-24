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
    }
}
?>