<?php

function AltaCuadrilla($nombre)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"INSERT INTO Cuadrilla (Nombre) VALUES ('".$nombre."')") or die ("Error al insertar cuadrilla");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"UPDATE Cuadrilla SET Nombre='".$nombre."' WHERE idCuadrilla='".$id."'") or die ("Error al modificar cuadrilla");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"DELETE FROM Cuadrilla WHERE Nombre='".$nombre."'") or die ("Error al eliminar cuadrilla");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"SELECT * FROM Cuadrilla") or die ("Error al listar cuadrillas");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"SELECT * FROM Cuadrilla WHERE idCuadrilla=".$idCuadrilla."") or die ("Error al obtener cuadrilla");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"SELECT * FROM PersonalCuadrilla WHERE idCuadrilla=".$idCuadrilla."") or die ("Error al obtener personal de cuadrilla");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function obtenerCuadrillaCompuestas($nombrePersonal)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM PersonalCuadrilla WHERE Nombre='".$nombrePersonal."'") or die ("Error al obtener cuadrillas de personal");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"INSERT INTO PersonalCuadrilla (idCuadrilla,Nombre,Porcentaje) VALUES ('".$idCuadrilla."','".$Nombre."','".$Porcentaje."')")
    or die ("Error al obtener insertar personal de cuadrilla");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"DELETE FROM PersonalCuadrilla WHERE Nombre='".$nombre."' and idCuadrilla='".$idCuadrilla."'") or die ("Error al eliminar personal de cuadrilla");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}
?>