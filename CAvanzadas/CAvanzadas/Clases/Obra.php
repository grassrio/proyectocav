<?php
class Obra
{
    public function InsertarObra($connect,$nombre,$idCotizacion,$direccion,$numeroPuerta,$idZona,$Observacion,$fechaRecibido,$idLicitacion,$Esquina1,$Esquina2,$RequiereBaliza)
    {
        $estado = "Pendiente de cuadrilla";
        mysqli_query($connect,"INSERT INTO Obra (Nombre,idCotizacion,Direccion,numeroPuerta,idZona,Estado,Observacion,fechaRecibido,fechaInformado,nombreInforme,idLicitacion,Esquina1,Esquina2,RequiereBaliza) VALUES ('".$nombre."','".$idCotizacion."','".$direccion."','".$numeroPuerta."','".$idZona."','".$estado."','".$Observacion."','".$fechaRecibido."',NULL,NULL,'".$idLicitacion."','".$Esquina1."','".$Esquina2."','".$RequiereBaliza."')")
            or die ("Error al insertar obra");
        $idObra = $connect->insert_id;
        $this->AuditarEstado($connect,$idObra,"Ingresada",$estado);
        return $idObra;
    }

    public function agregarMetrajeEstimado($connect,$idObra,$nombreRubro,$unidadRubro,$cantidadMetraje){
        $existeMetraje = mysqli_query($connect,"SELECT * FROM MetrajeObra WHERE idObra='".$idObra."' AND NombreRubro='".$nombreRubro."' AND MetrajeEstimado is not null")
            or die ("Error al consultar metraje");
        $rowcount = mysqli_num_rows($existeMetraje);
        if ($rowcount==0){
            $sql = mysqli_query($connect,"INSERT INTO MetrajeObra (idObra,NombreRubro,MetrajeEstimado,MetrajeReal,Unidad) VALUES ('".$idObra."','".$nombreRubro."','".$cantidadMetraje."',NULL,'".$unidadRubro."')")
            or die ("Error al agregar metraje");
            return $sql;
        }else{
            return "Error, el metraje ya existe";
        }

    }

    public function agregarMetrajeRealizado($connect,$idObra,$nombreRubro,$unidadRubro,$cantidadMetraje){
        $existeMetraje = mysqli_query($connect,"SELECT * FROM MetrajeObra WHERE idObra='".$idObra."' AND NombreRubro='".$nombreRubro."' AND MetrajeReal is not null")
            or die ("Error al consultar metraje");
        $rowcount = mysqli_num_rows($existeMetraje);
        if ($rowcount==0){
            $sql = mysqli_query($connect,"INSERT INTO MetrajeObra (idObra,NombreRubro,MetrajeEstimado,MetrajeReal,Unidad) VALUES ('".$idObra."','".$nombreRubro."',NULL,'".$cantidadMetraje."','".$unidadRubro."')")
            or die ("Error al agregar metraje");
            return $sql;
        }else{
            return "Error, el metraje ya existe";
        }

    }

    public function eliminarMetrajeEstimado($connect,$idMetrajeEstimado){
        $sql = mysqli_query($connect,"DELETE FROM MetrajeObra WHERE idMetrajeObra='".$idMetrajeEstimado."'")
            or die ("Error al eliminar metraje estimado");
        return $sql;
    }

    public function eliminarMetrajeRealizado($connect,$idMetrajeRealizado){
        $sql = mysqli_query($connect,"DELETE FROM MetrajeObra WHERE idMetrajeObra='".$idMetrajeRealizado."'")
            or die ("Error al eliminar metraje realizado");
        return $sql;
    }

    public function guardarObservacion($connect,$idObraObservacion,$observacion){
        $sql = mysqli_query($connect,"UPDATE Obra SET Observacion='".$observacion."' WHERE idObra='".$idObraObservacion."'")
            or die ("Error al guardar observacion");
        return $sql;
    }

    public function asignarCuadrilla($connect,$idObra,$idCuadrilla){
        $sql = mysqli_query($connect,"UPDATE Obra SET idCuadrilla='".$idCuadrilla."', Estado='Asignado' WHERE idObra='".$idObra."'")
            or die ("Error al asignar cuadrilla");
        $estado = "Asignado";
        $this->AuditarEstado($connect,$idObra,"Pendiente de cuadrilla",$estado);
        return $sql;
    }

    public function informarObra($connect,$idObra,$nombreInforme){
        $sqlInformarObra = mysqli_query($connect,"UPDATE Obra SET nombreInforme='".$nombreInforme."',fechaInformado=now() WHERE idObra='".$idObra."'")
            or die ("Error al informar obra");
        $this->cambiarEstado($connect,$idObra,"Informado");
        return $sqlInformarObra;
    }

    public function cambiarEstado($connect,$idObra,$estado){
        $sql = null;
        $sqlEstadoAnterior = mysqli_query($connect,"SELECT Estado FROM Obra WHERE idObra='".$idObra."'")
            or die ("Error al consultar estado anterior de obra");
        $rsEstadoAnterior=mysqli_fetch_array($sqlEstadoAnterior);
        $estadoAnterior = $rsEstadoAnterior[Estado];
        $estadoPosterior = $estado;
        switch ($estadoAnterior){
            case 'Pendiente de cuadrilla':
                if ($estadoPosterior=='Pendiente de baliza'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    $this->AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                break;
            case 'Pendiente de baliza':
                if ($estadoPosterior=='Pendiente de cuadrilla'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    $this->AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                break;
            case 'Asignado':
                if ($estadoPosterior=='Pendiente de asfalto'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    $this->AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                if ($estadoPosterior=='Facturar 0,3'){
                    mysqli_query($connect,"DELETE FROM MetrajeObra WHERE idObra='".$idObra."' AND MetrajeReal is not NULL") or die ("Error al eliminar metrajes realizados");
                    mysqli_query($connect,"INSERT INTO MetrajeObra (idObra,NombreRubro,MetrajeEstimado,MetrajeReal,Unidad) VALUES ('".$idObra."','Vereda',NULL,'0.3','m2')")
            or die ("Error al agregar metraje minimo");
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    $this->AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                if ($estadoPosterior=='Ejecutado'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET fechaFinalizado=now() ,Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    $this->AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                break;
            case 'Pendiente de asfalto':
                if ($estadoPosterior=='Asignado'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    $this->AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                break;
            case 'Ejecutado':
                if ($estadoPosterior=='Informado'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    $this->AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                break;
            case 'Facturar 0,3':
                if ($estadoPosterior=='Informado'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    $this->AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                break;
            case 'Informado':
                if ($estadoPosterior=='Pendiente de cuadrilla'){
                    $sql = mysqli_query($connect,"UPDATE Obra SET Estado='".$estadoPosterior."' WHERE idObra='".$idObra."'") or die ("Error al cambiar estado");
                    $this->AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior);
                }
                break;
        }
        return $sql;
    }

    public function MetrajesEstimados($connect,$idObra){
        $sql = mysqli_query($connect,"SELECT * FROM MetrajeObra WHERE idObra='".$idObra."' AND MetrajeEstimado<>'NULL'")
            or die ("Error al consultar estados de obra");
        return $sql;
    }

    public function MetrajesRealizados($connect,$idObra){
        $sql = mysqli_query($connect,"SELECT * FROM MetrajeObra WHERE idObra='".$idObra."' AND MetrajeReal<>'NULL'")
            or die ("Error al consultar estados de obra");
        return $sql;
    }

    private function AuditarEstado($connect,$idObra,$estadoAnterior,$estadoPosterior){
        $sql = mysqli_query($connect,"INSERT INTO EstadoObra (idObra,EstadoAnterior,EstadoPosterior,Fecha) VALUES ('".$idObra."','".$estadoAnterior."','".$estadoPosterior."',now())")
            or die ("Error al auditar estado");
        return $sql;
    }

    public function auditoriaEstado($connect,$idObra){
        $sql = mysqli_query($connect,"SELECT * FROM EstadoObra WHERE idObra='".$idObra."'")
            or die ("Error al consultar estados de obra");
        return $sql;
    }

    public function ListarObras($connect,$idLicitacion){
        $sql = mysqli_query($connect,"SELECT * FROM Obra WHERE idLicitacion='".$idLicitacion."'")
            or die ("Error al insertar obra");

        return $sql;
    }

    public function agregarBaliza($connect,$idObra,$Proveedor,$Cantidad,$fechaInicio,$fechaFin)
    {
        $sql = mysqli_query($connect,"INSERT INTO Baliza (idObra,Proveedor,Cantidad,fechaInicio,fechaFin,fechaDevolucion) VALUES ('".$idObra."','".$Proveedor."','".$Cantidad."','".$fechaInicio."','".$fechaFin."',NULL)")
            or die ("Error al insertar baliza");
        return $sql;
    }

    public function obtenerObra($connect,$idObra){
        $sql = mysqli_query($connect,"SELECT * FROM Obra WHERE idObra='".$idObra."'")
            or die ("Error al obtener obra");
        return $sql;
    }

}
