<?php
require 'Clases/Personal.php';

function devolverPersonal(){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $personal = new Personal();
        $sql = $personal->devolverPersonal($connect);
        return $sql;
    }
    return $sql;
}
function insertarPersonal($nombre,$apellido,$direccion,$telefono,$cargo)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $personal = new Personal();
        $sql = $personal->InsertarPersonal($connect,$nombre,$apellido,$direccion,$telefono,$cargo);
        return $sql;
    }
    return $sql;
}

function modificarPersonal($id,$direccion,$telefono,$cargo)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $personal = new Personal();
        $sql = $personal->ModificarPersonal($connect,$id,$direccion,$telefono,$cargo);
        return $sql;
    }
    return $sql;
}

function eliminarPersonal($id)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $personal = new Personal();
        $sql = $personal->EliminarPersonal($connect,$id);
        return $sql;
    }
    return $sql;
}

?>