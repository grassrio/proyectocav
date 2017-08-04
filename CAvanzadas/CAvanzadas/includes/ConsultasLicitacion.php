<?php
require 'Clases/Licitacion.php';

function insertarLicitacion($idCliente,$idCotizacion,$estado,$codigo,$presupuesto)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $lic = new Licitacion();
        $sql = $lic->InsertarLicitacion($connect,$idCliente,$idCotizacion,$estado,$codigo);
        $sql = $lic->ObtenerIdLicitacion($connect,$codigo);
        $rs=mysqli_fetch_array($sql);
        $sql = mysqli_query($connect,"INSERT INTO PresupuestoLicitacion (PresupuestoTotal,Debe,Haber,idLicitacion) VALUES ('".$presupuesto."','".$presupuesto."','".'0'."','".$rs[0]."')")
                 or die ("Error al insertar PresupuestoLicitacion");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function modificarLicitacion($id,$estado)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $lic = new Licitacion();
        $sql = $lic->ModificarLicitacion($connect,$id,$estado);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function eliminarLicitacion($idLicitacionDinamico)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $lic = new Licitacion();
        $sql = $lic->EliminarLicitacion($connect,$idLicitacionDinamico);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function obtenerLicitacion($idLicitacion)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $lic = new Licitacion();
        $sql = $lic->ObtenerLicitacion($connect,$idLicitacion);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function ListarLicitaciones()
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $lic = new Licitacion();
        $sql = $lic->ListarLicitacion($connect);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}
?>