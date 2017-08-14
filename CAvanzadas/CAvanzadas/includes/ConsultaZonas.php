<?php

function devolverZona($idZona){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM Zona WHERE idZona='".$idZona."'")
           or die ("Error al consultar zona");
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
        //Inserta la zona
        $sql = mysqli_query($connect,"INSERT INTO Zona (Nombre) VALUES ('".$nombre."')") or die ("Error al insertar zona");
        //Obtiene id zonas
        $sql = mysqli_query($connect,"SELECT idZona FROM Zona WHERE Nombre='".$nombre."'") or die ("Error al obtener las zonas");
        $rs=mysqli_fetch_array($sql);
        $sql = mysqli_query($connect,"INSERT INTO ClienteZona (idZona,idCliente) VALUES ('".$rs[0]."','".$idCliente."')")
                 or die ("Error al insertar zona");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function modificarZona($idZona,$nombre)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"UPDATE Zona SET Nombre='".$nombre."' WHERE idZona='".$idZona."'") or die ("Error al modificar zona");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"DELETE FROM Zona WHERE idZona='".$idZona."'") or die ("Error al eliminar las zonas");
        $sql = mysqli_query($connect,"DELETE FROM ClienteZona WHERE idZona='".$idZona."'") or die ("Error al eliminar las zonas");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}