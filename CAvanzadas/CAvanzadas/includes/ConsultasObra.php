<?php
require 'Clases/Obra.php';
function insertarObra($nombre,$idCotizacion,$direccion,$numeroPuerta,$idZona,$Estado,$Observacion,$fechaRecibido,$idLicitacion,$Esquina1,$Esquina2)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $obra = new Obra();
        $idObra = $obra->InsertarObra($connect,$nombre,$idCotizacion,$direccion,$numeroPuerta,$idZona,$Estado,$Observacion,$fechaRecibido,$idLicitacion,$Esquina1,$Esquina2);
        return $idObra;
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
        return $sql;
    }
    return $sql;
}
?>