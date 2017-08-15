<?php

function insertarLicitacion($idCliente,$idCotizacion,$idZona,$estado,$codigo,$presupuesto)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $lic = new Licitacion();
        mysqli_query($connect,"INSERT INTO Licitacion (idCliente,idCotizacion,idZona,estado,codigo,fecha) VALUES ('".$idCliente."','".$idCotizacion."','".$idZona."','".$estado."','".$codigo."',now())")
           or die ("Error al insertar licitación");
        $sql = mysqli_query($connect,"SELECT idLicitacion FROM Licitacion WHERE Codigo='".$codigo."'") or die ("Error al obtener licitación");
        $rs=mysqli_fetch_array($sql);
        $sql = mysqli_query($connect,"INSERT INTO PresupuestoLicitacion (PresupuestoTotal,Debe,Haber,idLicitacion) VALUES ('".$presupuesto."','".$presupuesto."','".'0'."','".$rs[0]."')")
                 or die ("Error al insertar presupuesto de licitación");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function descontarLicitacion($idLicitacion,$monto){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        mysqli_query($connect,"UPDATE PresupuestoLicitacion SET Haber=Haber + ".$monto." WHERE idLicitacion='".$idLicitacion."'") or die ("Error al actualizar cuenta de Licitación");
        mysqli_close($connect);
        return 1;
    }
    return $sql;
}

function asignarAmpliacion($idLicitacion,$idLicitacionAsignar){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sqlPresupuestoLicitacion=obtenerPresupuesto($idLicitacion);
        $rsPresupuestoLicitacion=mysqli_fetch_array($sqlPresupuestoLicitacion);
        $presupuestoActual=$rsPresupuestoLicitacion[Debe] - $rsPresupuestoLicitacion[Haber];
        if ($presupuestoActual<0){
            //Ampliacion de la licitacion actual
            $presupuestoActualAbsoluto=abs($presupuestoActual);
            //Obtenemos el presupuesto de la licitacion a la que se va a asignar la ampliacion
            $presupuestoLicitacionAux=obtenerPresupuesto($idLicitacionAsignar);
            $rsPresupuestoLicitacionAux=mysqli_fetch_array($presupuestoLicitacionAux);
            //Calculamos el presupuesto disponible de la licitacion a la que se va a asignar
            $presupuestoDisponibleLicitacionAux=($rsPresupuestoLicitacionAux[Debe]-$rsPresupuestoLicitacionAux[Haber]);
            //Si es posible asignarle la ampliacion se la asigna
            if (($presupuestoDisponibleLicitacionAux>0)&&($presupuestoDisponibleLicitacionAux>=$presupuestoActualAbsoluto)){
                //Asignamos el monto de la ampliacion a la licitacion destino
                mysqli_query($connect,"UPDATE PresupuestoLicitacion SET Haber=Haber + ".$presupuestoActualAbsoluto." WHERE idLicitacion='".$idLicitacionAsignar."'")
         or die ("Error al actualizar cuenta de Licitacion");
                //Descontamos el monto de la licitacion actual
                mysqli_query($connect,"UPDATE PresupuestoLicitacion SET Haber=Debe WHERE idLicitacion='".$idLicitacion."'")
         or die ("Error al actualizar cuenta de Licitacion");
            }else{
                return 'Error, no es posible asignar ampliación';
            }
        }
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
        $sql = mysqli_query($connect,"UPDATE Licitacion SET estado='".$estado."' WHERE idLicitacion='".$id."'") or die ("Error al modificar licitación");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function obtenerPresupuesto($idLicitacion)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM PresupuestoLicitacion WHERE idLicitacion='".$idLicitacion."'") or die ("Error al consultar presupuesto de licitación");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function eliminarLicitacion($idLicitacion)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"DELETE FROM Licitacion WHERE idLicitacion='".$idLicitacion."'") or die ("Error al eliminar licitación");
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
        $sql = mysqli_query($connect,"SELECT * FROM Licitacion WHERE idLicitacion='".$idLicitacion."'") or die ("Error al obtener licitación");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function obtenerLicitacionCliente($idCliente)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM Licitacion WHERE idCliente='".$idCliente."'") or die ("Error al obtener licitaciones de cliente");
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
        $sql = mysqli_query($connect,"SELECT * FROM Licitacion ORDER BY FECHA DESC") or die ("Error al listar las licitaciones");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}
?>