<?php
require 'Clases/Zona.php';

function devolverZona($idZona){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $zona = new Zona();
        $sql = $zona->DevolverZona($connect,$idZona);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function InsertarZona($nombre,$idCliente)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $zona = new Zona();
        $sql = $zona->InsertarZona($connect,$nombre);
        $sql = $zona->ObtenerIdZonas($connect,$nombre);
        $rs=mysqli_fetch_array($sql);
        $sql = mysqli_query($connect,"INSERT INTO ClienteZona (idZona,idCliente) VALUES ('".$rs[0]."','".$idCliente."')")
                 or die ("Error al insertar zona");


        return $sql;
    }
    return $sql;
}

function modificarZona($id,$nombre)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $zona = new Zona();
        $sql = $zona->ModificarZona($connect,$id,$nombre);
        return $sql;
    }
    return $sql;
}

function eliminarZona($idZona)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $zona = new Zona();
        $sql = $zona->EliminarZona($connect,$idZona);

        return $sql;
    }
    return $sql;
}