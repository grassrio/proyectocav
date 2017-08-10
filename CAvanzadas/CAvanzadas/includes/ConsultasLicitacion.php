<?php
require 'Clases/Licitacion.php';

function insertarLicitacion($idCliente,$idCotizacion,$idZona,$estado,$codigo,$presupuesto)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $lic = new Licitacion();
        $sql = $lic->InsertarLicitacion($connect,$idCliente,$idCotizacion,$idZona,$estado,$codigo);
        $sql = $lic->ObtenerIdLicitacion($connect,$codigo);
        $rs=mysqli_fetch_array($sql);
        $sql = mysqli_query($connect,"INSERT INTO PresupuestoLicitacion (PresupuestoTotal,Debe,Haber,idLicitacion) VALUES ('".$presupuesto."','".$presupuesto."','".'0'."','".$rs[0]."')")
                 or die ("Error al insertar PresupuestoLicitacion");
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
        $lic = new Licitacion();
        $sql = $lic->descontarLicitacion($connect,$idLicitacion,$monto);
        mysqli_close($connect);
        return $sql;
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
                return 'Error, no es posible asignar la ampliación';
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
        $lic = new Licitacion();
        $sql = $lic->ModificarLicitacion($connect,$id,$estado);
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

function eliminarLicitacion($idLicitacionDinamico)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $lic = new Licitacion();
        $sql = $lic->EliminarLicitacion($connect,$idLicitacionDinamico);
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
        $lic = new Licitacion();
        $sql = $lic->ObtenerLicitacion($connect,$idLicitacion);
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
        $lic = new Licitacion();
        $sql = $lic->obtenerLicitacionCliente($connect,$idCliente);
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
        $lic = new Licitacion();
        $sql = $lic->ListarLicitacion($connect);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}
?>