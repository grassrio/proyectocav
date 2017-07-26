<?php
class Obra
{
    public function InsertarObra($connect,$nombre,$idCotizacion,$direccion,$numeroPuerta,$idZona,$Estado,$Observacion,$fechaRecibido,$idLicitacion,$Esquina1,$Esquina2)
    {
        mysqli_query($connect,"INSERT INTO Obra (Nombre,idCotizacion,Direccion,numeroPuerta,idZona,Estado,Observacion,fechaRecibido,fechaInformado,nombreInforme,idLicitacion,Esquina1,Esquina2) VALUES ('".$nombre."','".$idCotizacion."','".$direccion."','".$numeroPuerta."','".$idZona."','".$Estado."','".$Observacion."','".$fechaRecibido."',NULL,NULL,'".$idLicitacion."','".$Esquina1."','".$Esquina2."')")
            or die ("Error al insertar obra");
        $idObra = $connect->insert_id;
        return $idObra;
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

}
