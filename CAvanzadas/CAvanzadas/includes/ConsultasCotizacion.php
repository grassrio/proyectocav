<?php
function devolverCotizacion($idCotizacion){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM Cotizacion WHERE idCotizacion='".$idCotizacion."'") or die ("Error al obtener cotización");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"INSERT INTO Cotizacion (Nombre) VALUES ('".$nombre."')") or die ("Error al insertar cotización");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function modificarCotizacion($id,$nombre)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"UPDATE Cotizacion SET Nombre='".$nombre."' WHERE idCotizacion='".$id."'") or die ("Error al modificar cotización");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"DELETE FROM Cotizacion WHERE Nombre='".$nombre."'") or die ("Error al eliminar cotización");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"DELETE FROM RubroCotizacion WHERE nombreRubro='".$nombreRubro."' and idCotizacion='".$idCotizacion."'") or die ("Error al eliminar datos de cotización");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"SELECT * FROM Cotizacion") or die ("Error al consultar cotizaciones");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"SELECT * FROM RubroCotizacion WHERE idCotizacion='".$idCotizacion."'") or die ("Error al obtener datos de cotización");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function InsertarRubroCotizacion($idCotizacion,$nombreRubro,$unidadRubro,$Precio){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"INSERT INTO RubroCotizacion (nombreRubro,Unidad,idCotizacion,Precio) VALUES ('".$nombreRubro."','".$unidadRubro."','".$idCotizacion."','".$Precio."')")
         or die ("Error al obtener las cotización");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}
