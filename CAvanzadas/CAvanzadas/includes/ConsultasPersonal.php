<?php

function devolverPersonal(){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM Personal") or die ("Error al obtener Personal");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function insertarPersonal($nombreCompleto,$direccion,$telefono,$cargo)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"INSERT INTO Personal (NombreCompleto,Direccion,Telefono,Cargo) VALUES ('".$nombreCompleto."','".$direccion."','".$telefono."','".$cargo."')")
            or die ("Error al insertar personal");
        mysqli_close($connect);
        return $sql;

    }
    return $sql;
}

function modificarPersonal($id,$direccion,$telefono,$cargo)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"UPDATE Personal SET Direccion='".$direccion."',Telefono='".$telefono."', Cargo='".$cargo."' WHERE idPersonal='".$id."'")
            or die ("Error al modificar personal");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function eliminarPersonal($NombreCompleto)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"DELETE FROM Personal WHERE NombreCompleto='".$NombreCompleto."'")
         or die ("Error al eliminar personal");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}
function devolverObrero($nombreCompleto)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM Personal WHERE NombreCompleto='".$nombreCompleto."'") or die ("Error al consultar personal");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}
function devolverObreros()
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM Personal WHERE Cargo ='Obrero'") or die ("Error al consultar personal");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function obtenerObreroPorId($idObrero)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM Personal WHERE idPersonal='".$idObrero."'") or die ("Error al consultar personal");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}
function ObrasFinalizadasEntreFecha($fechaInicio,$fechaFin)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT pc.Nombre,SUM(mo.MetrajeReal) FROM PersonalCuadrilla pc, Obra o, MetrajeObra mo WHERE mo.idObra=o.idObra AND o.fechaFinalizado>='".$fechaInicio."' AND o.fechaFinalizado<='".$fechaFin."' AND o.idCuadrilla=pc.idCuadrilla AND mo.MetrajeReal>0 GROUP BY pc.Nombre")
         or die ("Error al calcular la productividad");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}
function MostrarProductividadPorObrero($nombreEmpleado,$fechaInicio,$fechaFin)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT mo.MetrajeReal,mo.NombreRubro,mo.Unidad,rc.Precio,pc.Porcentaje FROM RubroCotizacion rc,PersonalCuadrilla pc, Obra o, MetrajeObra mo WHERE mo.idObra=o.idObra AND o.idCuadrilla=pc.idCuadrilla AND pc.Nombre='".$nombreEmpleado."' AND  o.fechaFinalizado>='".$fechaInicio."' AND o.fechaFinalizado<='".$fechaFin."'AND rc.nombreRubro=mo.NombreRubro AND mo.MetrajeReal>0 and rc.idCotizacion=o.idCotizacion")
         or die ("Error al calcular la productividad");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

?>