<?php
function DevolverBalizasProximoVencimiento(){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM Baliza WHERE (DATEDIFF(fechaFin, NOW( )) <=2) AND fechaDevolucion IS NULL")
           or die ("Error al consultar Baliza");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}
function devolverBaliza($idBaliza)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"UPDATE Baliza SET fechaDevolucion=NOW() WHERE idBaliza='".$idBaliza."'")
           or die ("Error al devolver Baliza");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}
?>