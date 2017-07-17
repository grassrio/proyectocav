<?php
require 'Clases/Cotizacion.php';

function devolverCotizacion($idCotizacion){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cotizacion = new Cotizacion();
        $sql = $cotizacion->DevolverCotizacion($connect,$idCotizacion);
        return $sql;
    }
    return $sql;
}

function InsertarCotizacion($nombre)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cotizacion = new Cotizacion();
        $sql = $cotizacion->InsertarCotizacion($connect,$nombre);
//        $sql = $cotizacion->ObtenerIdCotizacion($connect,$nombre);
//        $rs=mysqli_fetch_array($sql);
//        $sql = mysqli_query($connect,"INSERT INTO RubroCotizacion (idCotizacion,idRubro,Precio) VALUES ('".$rs[0]."','".$idRubro."','".$precio."')")
//                 or die ("Error al insertar cotizacion");


//       return $sql;
    }
    mysqli_close($connect);
    return $sql;
}

function modificarCotizacion($id,$nombre)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cotizacion = new Cotizacion();
        $sql = $cotizacion->ModificarCotización($connect,$id,$nombre);
        return $sql;
    }
    return $sql;
}

function eliminarCotizacion($nombre)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cotizacion = new Cotizacion();
        $sql = $cotizacion->EliminarCotizacion($connect,$nombre);

        return $sql;
    }
    return $sql;
}

function eliminarRubroPrecio($nombreRubro,$idCotizacion)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cotizacion = new Cotizacion();
        $sql = $cotizacion->EliminarRubroPrecio($connect,$nombreRubro,$idCotizacion);

        return $sql;
    }
    return $sql;
}

function listaCotizacion()
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cotizacion = new Cotizacion();
        $sql = $cotizacion->ListaCotizacion($connect);

        return $sql;
    }
    return $sql;
}

function obtenerRubro($idCotizacion){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cotizacion = new Cotizacion();
        $sql = $cotizacion->ObtenerRubro($connect,$idCotizacion);
        return $sql;
    }
    return $sql;
}

function InsertarRubroCotizacion($idCotizacion,$nombreRubro,$Precio){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $cotizacion = new Cotizacion();
        $sql = $cotizacion->InsertarRubroCotizacion($connect,$idCotizacion,$nombreRubro,$Precio);
        return $sql;
    }
    return $sql;
}
