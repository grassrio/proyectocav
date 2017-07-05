<?php
require 'Clases/Rubro.php';

function devolverRubros(){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $rubro = new Rubro();
        $sql = $rubro->ListaRubro($connect);
        return $sql;
    }
    return $sql;
}
function buscarRubros($nombre){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $rubro = new Rubro();
        $sql = $rubro->BuscarRubro($connect);
        return $sql;
    }
    return $sql;
}
function insertarRubro($nombre,$unidad,$cantidadStock)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $rubro = new Rubro();
        $sql = $rubro->InsertarRubro($connect,$nombre,$unidad,$cantidadStock);
        return $sql;
    }
    return $sql;
}

function modificarCliente($id,$nombre,$unidad,$cantidadStock)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $rubro = new Rubro();
        $sql = $rubro->ModificarRubro($connect,$id,$nombre,$unidad,$cantidadStock);
        return $sql;
    }
    return $sql;
}

function eliminarRubro($nombre)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $rubro = new Rubro();
        $sql = $rubro->EliminarRubro($connect,$nombre);
        return $sql;
    }
    return $sql;
}
?>