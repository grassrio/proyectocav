<?php
class Licitacion
{
    public function InsertarLicitacion($connect,$idCliente,$idCotizacion,$idZona,$estado,$codigo)
    {
        $sql = mysqli_query($connect,"INSERT INTO Licitacion (idCliente,idCotizacion,idZona,estado,codigo,fecha) VALUES ('".$idCliente."','".$idCotizacion."','".$idZona."','".$estado."','".$codigo."',now())")
           or die ("Error al insertar licitacion");
        return $sql;
    }

    public function ModificarLicitacion($connect,$id,$estado)
    {
        $sql = mysqli_query($connect,"UPDATE Licitacion SET estado='".$estado."' WHERE idLicitacion='".$id."'")
            or die ("Error al modificar la licitacion");
        return $sql;
    }

    public function EliminarLicitacion($connect,$idLicitacionDinamico)
    {
        $sql = mysqli_query($connect,"DELETE FROM Licitacion WHERE idLicitacion='".$idLicitacionDinamico."'")
         or die ("Error al eliminar licitacion");
        return $sql;
    }
    public function listarLicitacion($connect)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Licitacion ORDER BY FECHA DESC")
         or die ("Error al listar las licitaciones");
        return $sql;
    }
    public function ObtenerIdLicitacion($connect,$codigo)
    {
        $sql = mysqli_query($connect,"SELECT idLicitacion FROM Licitacion WHERE Codigo='".$codigo."'")
         or die ("Error al obtener la Licitacion");
        return $sql;
    }

    public function ObtenerLicitacion($connect,$idLicitacion)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Licitacion WHERE idLicitacion='".$idLicitacion."'")
         or die ("Error al obtener la Licitacion");
        return $sql;
    }
}
