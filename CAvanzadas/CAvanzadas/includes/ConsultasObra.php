<?php

function insertarObra($nombre,$idCotizacion,$direccion,$numeroPuerta,$idZona,$Observacion,$fechaRecibido,$idLicitacion,$Esquina1,$Esquina2,$RequiereBaliza)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $estado = "Pendiente de cuadrilla";
        mysqli_query($connect,"INSERT INTO Obra (Nombre,idCotizacion,Direccion,numeroPuerta,idZona,Estado,Observacion,fechaRecibido,fechaInformado,nombreInforme,idLicitacion,Esquina1,Esquina2,RequiereBaliza) VALUES ('".$nombre."','".$idCotizacion."','".$direccion."','".$numeroPuerta."','".$idZona."','".$estado."','".$Observacion."','".$fechaRecibido."',NULL,NULL,'".$idLicitacion."','".$Esquina1."','".$Esquina2."','".$RequiereBaliza."')")
            or die ("Error al insertar obra");
        $idObra = $connect->insert_id;
        AuditarEstado($connect,$idObra,"Ingresada",$estado);
        mysqli_close($connect);
        return $idObra;
    }
    return $sql;
}

function agregarMetrajeEstimado($idObra,$nombreRubro,$unidadRubro,$cantidadMetraje){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $existeMetraje = mysqli_query($connect,"SELECT * FROM MetrajeObra WHERE idObra='".$idObra."' AND NombreRubro='".$nombreRubro."' AND MetrajeEstimado is not null") or die ("Error al consultar metraje");
        $rowcount = mysqli_num_rows($existeMetraje);
        if ($rowcount==0){
            $sql = mysqli_query($connect,"INSERT INTO MetrajeObra (idObra,NombreRubro,MetrajeEstimado,MetrajeReal,Unidad) VALUES ('".$idObra."','".$nombreRubro."','".$cantidadMetraje."',NULL,'".$unidadRubro."')")
            or die ("Error al agregar metraje");
            mysqli_close($connect);
            return $sql;
        }else{
            mysqli_close($connect);
            return "Error, el metraje ya existe";
        }
    }
    return $sql;
}

function agregarMetrajeRealizado($idObra,$nombreRubro,$unidadRubro,$cantidadMetraje){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $existeMetraje = mysqli_query($connect,"SELECT * FROM MetrajeObra WHERE idObra='".$idObra."' AND NombreRubro='".$nombreRubro."' AND MetrajeReal is not null") or die ("Error al consultar metraje");
        $rowcount = mysqli_num_rows($existeMetraje);
        if ($rowcount==0){
            $sql = mysqli_query($connect,"INSERT INTO MetrajeObra (idObra,NombreRubro,MetrajeEstimado,MetrajeReal,Unidad) VALUES ('".$idObra."','".$nombreRubro."',NULL,'".$cantidadMetraje."','".$unidadRubro."')")
            or die ("Error al agregar metraje");
            mysqli_close($connect);
            return $sql;
        }else{
            mysqli_close($connect);
            return "Error, el metraje ya existe";
        }
    }
    return $sql;
}

function eliminarMetrajeEstimado($idMetrajeEstimado){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"DELETE FROM MetrajeObra WHERE idMetrajeObra='".$idMetrajeEstimado."'") or die ("Error al eliminar metraje estimado");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function eliminarMetrajeRealizado($idMetrajeRealizado){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"DELETE FROM MetrajeObra WHERE idMetrajeObra='".$idMetrajeRealizado."'") or die ("Error al eliminar metraje realizado");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}


function auditoriaEstado($idObra){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM EstadoObra WHERE idObra='".$idObra."'") or die ("Error al consultar estados de obra");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function asignarCuadrilla($idObra,$idCuadrilla){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"UPDATE Obra SET idCuadrilla='".$idCuadrilla."', Estado='Asignado' WHERE idObra='".$idObra."'") or die ("Error al asignar cuadrilla");
        $estado = "Asignado";
        AuditarEstado($connect,$idObra,"Pendiente de cuadrilla",$estado);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function cambiarEstado($idObra,$estado){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = null;
        $sqlEstadoAnterior = mysqli_query($connect,"SELECT Estado FROM Obra WHERE idObra='".$idObra."'") or die ("Error al consultar estado anterior de obra");
        $rsEstadoAnterior=mysqli_fetch_array($sqlEstadoAnterior);
        $estadoAnterior = $rsEstadoAnterior[Estado];
        $estadoPosterior = $estado;
        switch ($estadoAnterior){
            case 'Pendiente de cuadrilla':
                if ($estadoPosterior=='Pendiente de baliza'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                break;
            case 'Pendiente de baliza':
                if ($estadoPosterior=='Pendiente de cuadrilla'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                break;
            case 'Asignado':
                if ($estadoPosterior=='Pendiente de asfalto'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                if ($estadoPosterior=='Facturar 0,3'){
                    mysqli_query($connect,"DELETE FROM MetrajeObra WHERE idObra='".$idObra."' AND MetrajeReal is not NULL") or die ("Error al eliminar metrajes realizados");
                    mysqli_query($connect,"INSERT INTO MetrajeObra (idObra,NombreRubro,MetrajeEstimado,MetrajeReal,Unidad) VALUES ('".$idObra."','Vereda',NULL,'0.3','m2')")
            or die ("Error al agregar metraje minimo");
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                if ($estadoPosterior=='Ejecutado'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET fechaFinalizado=now() ,Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                break;
            case 'Pendiente de asfalto':
                if ($estadoPosterior=='Asignado'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                break;
            case 'Ejecutado':
                if ($estadoPosterior=='Informado'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                break;
            case 'Facturar 0,3':
                if ($estadoPosterior=='Informado'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                break;
            case 'Informado':
                if ($estadoPosterior=='Pendiente de cuadrilla'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                break;
        }
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function guardarObservacion($idObraObservacion,$observacion){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"UPDATE Obra SET Observacion='".$observacion."' WHERE idObra='".$idObraObservacion."'") or die ("Error al guardar observación");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function metrajesEstimados($idObra){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM MetrajeObra WHERE idObra='".$idObra."' AND MetrajeEstimado<>'NULL'") or die ("Error al consultar metrajes estimados");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function metrajesRealizados($idObra){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM MetrajeObra WHERE idObra='".$idObra."' AND MetrajeReal<>'NULL'") or die ("Error al consultar metrajes reales");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function obtenerObra($idObra){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM Obra WHERE idObra='".$idObra."'") or die ("Error al obtener obra");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function obtenerObrasAsignadas(){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM Obra WHERE Estado='Asignado'") or die ("Error al obtener obras");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function agregarBaliza($idObra,$Proveedor,$Cantidad,$fechaInicio,$fechaFin){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"INSERT INTO Baliza (idObra,Proveedor,Cantidad,fechaInicio,fechaFin,fechaDevolucion) VALUES ('".$idObra."','".$Proveedor."','".$Cantidad."','".$fechaInicio."','".$fechaFin."',NULL)")
            or die ("Error al insertar baliza");
        mysqli_close($connect);
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
        $sql = mysqli_query($connect,"SELECT * FROM Obra WHERE idLicitacion='".$idLicitacion."'") or die ("Error al obtener obras de licitación");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function informarObra($idObra,$nombreInforme){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"UPDATE Obra SET nombreInforme='".$nombreInforme."',fechaInformado=now() WHERE idObra='".$idObra."'") or die ("Error al informar obra");
        cambiarEstado($idObra,"Informado");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

function AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior){
    $sql = mysqli_query($connect,"INSERT INTO EstadoObra (idObra,EstadoAnterior,EstadoPosterior,Fecha) VALUES ('".$idObra."','".$estadoAnterior."','".$estadoPosterior."',now())")
            or die ("Error al auditar estado");
    return $sql;
}

?>