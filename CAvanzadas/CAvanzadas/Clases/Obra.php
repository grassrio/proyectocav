<?php
class Obra
{
    public function InsertarObra($connect,$nombre,$idCotizacion,$direccion,$numeroPuerta,$idZona,$Observacion,$fechaRecibido,$idLicitacion,$Esquina1,$Esquina2)
    {
        $estado = "Pendiente de cuadrilla";
        mysqli_query($connect,"INSERT INTO Obra (Nombre,idCotizacion,Direccion,numeroPuerta,idZona,Estado,Observacion,fechaRecibido,fechaInformado,nombreInforme,idLicitacion,Esquina1,Esquina2) VALUES ('".$nombre."','".$idCotizacion."','".$direccion."','".$numeroPuerta."','".$idZona."','".$estado."','".$Observacion."','".$fechaRecibido."',NULL,NULL,'".$idLicitacion."','".$Esquina1."','".$Esquina2."')")
            or die ("Error al insertar obra");
        $idObra = $connect->insert_id;
        $this->AuditarEstado($connect,$idObra,"Ingresada",$estado);
        return $idObra;
    }

    public function agregarMetrajeEstimado($connect,$idObra,$nombreRubro,$unidadRubro,$cantidadMetraje){
        $sql = mysqli_query($connect,"INSERT INTO MetrajeObra (idObra,NombreRubro,MetrajeEstimado,MetrajeReal,Unidad) VALUES ('".$idObra."','".$nombreRubro."','".$cantidadMetraje."',NULL,'".$unidadRubro."')")
            or die ("Error al agregar metraje");
        return $sql;
    }

    public function eliminarMetrajeEstimado($connect,$idMetrajeEstimado){
        $sql = mysqli_query($connect,"DELETE FROM MetrajeObra WHERE idMetrajeObra='".$idMetrajeEstimado."'")
            or die ("Error al eliminar metraje estimado");
        return $sql;
    }

    public function asignarCuadrilla($connect,$idObra,$idCuadrilla){
        $sql = mysqli_query($connect,"UPDATE Obra SET idCuadrilla='".$idCuadrilla."', Estado='Asignado' WHERE idObra='".$idObra."'")
            or die ("Error al asignar cuadrilla");
        $estado = "Asignado";
        $this->AuditarEstado($connect,$idObra,"Pendiente de cuadrilla",$estado);
        return $sql;
    }


    public function MetrajesEstimados($connect,$idObra){
        $sql = mysqli_query($connect,"SELECT * FROM MetrajeObra WHERE idObra='".$idObra."'")
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
