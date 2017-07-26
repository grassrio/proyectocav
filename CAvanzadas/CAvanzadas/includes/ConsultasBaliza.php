<?php
require 'Clases/Baliza.php';
function DevolverBalizasProximoVencimiento(){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $baliza = new Baliza();
        $sql = $baliza->BalizasProximoVencimiento($connect);
        return $sql;
    }
    return $sql;
}
function devolverBaliza($id)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $baliza = new Baliza();
        $sql = $baliza->devolverBalizas($connect,$id);
        return $sql;
    }
    return $sql;
}
?>