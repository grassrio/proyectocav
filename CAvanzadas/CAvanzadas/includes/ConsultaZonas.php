<?php
require 'Clases/Zona.php';

function devolverZona(){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $zona = new Zona();
        $sql = $zona->ListaZona($connect);
        return $sql;
    }
    return $sql;
}
function insertarZona($nombre,$idCliente)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $zona = new Zona();
        $sql = $zona->InsertarZona($connect,$nombre);
        $rowcount = mysqli_num_rows($sql);
        if ($rowcount>0)
        {
            $rs=mysqli_fetch_array($sql);
            $sql = mysqli_query($connect,"INSERT INTO ClienteZona (idCliente,idZona) VALUES ('".$idCliente."','".$rs[0]."')")
                 or die ("Error al insertar zona");
            return $sql;
        }

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

function eliminarZona($nombre)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $zona = new Zona();
        $sql = $zona->EliminarZona($connect,$nombre);

        return $sql;
    }
    return $sql;
}