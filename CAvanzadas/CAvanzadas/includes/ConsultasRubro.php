<?php

function devolverRubros(){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM Rubro") or die ("Error al consultar rubros");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"SELECT * FROM Rubro WHERE Nombre like '"."%".$nombre."%"."'") or die ("Error al obtener rubro");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"INSERT INTO Rubro (Nombre,Unidad,CantidadStock) VALUES ('".$nombre."','".$unidad."','".$cantidadStock."')") or die ("Error al insertar rubro");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function modificarRubro($id,$nombre,$unidad,$cantidadStock)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"UPDATE Rubro SET Nombre='".$nombre."',Unidad='".$unidad."',CantidadStock='".$cantidadStock."' WHERE idRubro='".$id."'") or die ("Error al modificar rubro");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"DELETE FROM Rubro WHERE Nombre='".$nombre."'") or die ("Error al eliminar rubro");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function devolverRubro($nombreRubro){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM Rubro WHERE Nombre='".$nombreRubro."'") or die ("Error al obtener rubro");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function obtenerRubroPorId($idRubro){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM Rubro WHERE idRubro='".$idRubro."'") or die ("Error al obtener rubro");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

?>