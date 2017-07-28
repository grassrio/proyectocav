<?php
require 'Clases/Cuadrilla.php';

function AltaCuadrilla($nombre)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cuadrilla = new Cuadrilla();
        $sql  = $cuadrilla->InsertarCuadrilla($connect,$nombre);
        return $sql;
    }
    return $sql;
}

function modificarCuadrilla($id,$nombre)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cuadrilla = new Cuadrilla();
        $sql  = $cuadrilla->ModificarCuadrilla($connect,$id,$nombre);
        return $sql;
    }
    return $sql;
}

function eliminarCuadrilla($nombre)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cuadrilla = new Cuadrilla();
        $sql  = $cuadrilla->EliminarCuadrilla($connect,$nombre);
        return $sql;
    }
    return $sql;
}
function listarCuadrillas()
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cuadrilla = new Cuadrilla();
        $sql  = $cuadrilla->ListarCuadrillas($connect);
        return $sql;
    }
    return $sql;
}

function obtenerCuadrilla($idCuadrilla)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cuadrilla = new Cuadrilla();
        $sql  = $cuadrilla->ObtenerCuadrilla($connect,$idCuadrilla);
        return $sql;
    }
    return $sql;
}

function obtenerObreros($idCuadrilla)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cuadrilla = new Cuadrilla();
        $sql  = $cuadrilla->obtenerObreros($connect,$idCuadrilla);
        return $sql;
    }
    return $sql;
}
function nuevoObreroCuadrilla($idCuadrilla,$Porcentaje,$Nombre)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cuadrilla = new Cuadrilla();
        $sql  = $cuadrilla->nuevoObreroCuadrilla($connect,$idCuadrilla,$Porcentaje,$Nombre);
        return $sql;
    }
    return $sql;
}
function eliminarObreroCuadrilla($nombre,$idCuadrilla)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cuadrilla = new Cuadrilla();
        $sql  = $cuadrilla->eliminarObreroCuadrilla($connect,$nombre,$idCuadrilla);
        return $sql;
    }
    return $sql;
}
?>