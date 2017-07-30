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
function insertarPersonal($nombreCompleto,$direccion,$telefono,$cargo)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $personal = new Personal();
        $sql = $personal->InsertarPersonal($connect,$nombreCompleto,$direccion,$telefono,$cargo);
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

function eliminarPersonal($NombreCompleto)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $personal = new Personal();
        $sql = $personal->EliminarPersonal($connect,$NombreCompleto);
        return $sql;
    }
    return $sql;
}
function devolverObrero($nombreCompleto)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $personal = new Personal();
        $sql = $personal->devolverObrero($connect,$nombreCompleto);
        return $sql;
    }
    return $sql;
}
function devolverObreros()
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $personal = new Personal();
        $sql = $personal->devolverObreros($connect);
        return $sql;
    }
    return $sql;
}

function obtenerObreroPorId($idObrero)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $personal = new Personal();
        $sql  = $personal->DevolverUnPersonal($connect,$idObrero);
        return $sql;
    }
    return $sql;
}
function ObrasFinalizadasEntreFecha($fechaInicio,$fechaFin)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $personal = new Personal();
        $sql = mysqli_query($connect,"SELECT pc.Nombre,SUM(mo.MetrajeReal) FROM PersonalCuadrilla pc, Obra o, MetrajeObra mo WHERE o.Estado='Ejecutado' AND mo.idObra=o.idObra AND o.fechaFinalizado>='".$fechaInicio."' AND o.fechaFinalizado<='".$fechaFin."' AND o.idCuadrilla=pc.idCuadrilla")
         or die ("Error al calcular la productividad");
        return $sql;
    }
    return $sql;
}
?>