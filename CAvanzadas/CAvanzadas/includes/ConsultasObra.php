<?php
require 'Clases/Obra.php';
function insertarObra($nombre,$idCotizacion,$direccion,$numeroPuerta,$idZona,$Observacion,$fechaRecibido,$idLicitacion,$Esquina1,$Esquina2,$RequiereBaliza)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $obra = new Obra();
        $idObra = $obra->InsertarObra($connect,$nombre,$idCotizacion,$direccion,$numeroPuerta,$idZona,$Observacion,$fechaRecibido,$idLicitacion,$Esquina1,$Esquina2,$RequiereBaliza);
        mysqli_close($connect);
        return $idObra;
    }
    return $sql;
}

function agregarMetrajeEstimado($idObra,$nombreRubro,$unidadRubro,$cantidadMetraje){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $obra = new Obra();
        $sql = $obra->agregarMetrajeEstimado($connect,$idObra,$nombreRubro,$unidadRubro,$cantidadMetraje);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function eliminarMetrajeEstimado($idMetrajeEstimado){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $obra = new Obra();
        $sql = $obra->eliminarMetrajeEstimado($connect,$idMetrajeEstimado);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}


function auditoriaEstado($idObra){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $obra = new Obra();
        $sql = $obra->auditoriaEstado($connect,$idObra);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function asignarCuadrilla($idObra,$idCuadrilla){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $obra = new Obra();
        $sql = $obra->asignarCuadrilla($connect,$idObra,$idCuadrilla);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function cambiarEstado($idObra,$estado){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $obra = new Obra();
        $sql = $obra->cambiarEstado($connect,$idObra,$estado);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function guardarObservacion($idObraObservacion,$observacion){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $obra = new Obra();
        $sql = $obra->guardarObservacion($connect,$idObraObservacion,$observacion);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function metrajesEstimados($idObra){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $obra = new Obra();
        $sql = $obra->MetrajesEstimados($connect,$idObra);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function obtenerObra($idObra){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $obra = new Obra();
        $sql = $obra->ObtenerObra($connect,$idObra);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function agregarBaliza($idObra,$Proveedor,$Cantidad,$fechaInicio,$fechaFin){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $obra = new Obra();
        $sql = $obra->agregarBaliza($connect,$idObra,$Proveedor,$Cantidad,$fechaInicio,$fechaFin);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function ListarObras($idLicitacion){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $obra = new Obra();
        $sql = $obra->ListarObras($connect,$idLicitacion);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}
?>