<?php
class Cotizacion
{
    private $nombre;

    function construct( $nombre)
    {
        $this->nombre = $nombre;

    }

    public function setNombre( $nombre ){	$this->nombre = $nombre; }
    public function getNombre(){ return $this->nombre; }

    public function DevolverCotizacion($connect,$idCotizacion)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Cotizacion WHERE idCotiacion='".$idCotizacion."'")
           or die ("Error al consultar cotización");
        return $sql;
    }

    public function ExisteCotizacion($connect,$nombre)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Cotizacion WHERE Nombre='".$nombre."'")
           or die ("Error al consultar cotización");
        return $sql;
    }

    public function ListaCotizacion($connect)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Cotizacion")
           or die ("Error al consultar cotización");
        return $sql;
    }

    public function InsertarCotizacion($connect,$nombre)
    {
        $sql = mysqli_query($connect,"INSERT INTO Cotizacion (Nombre) VALUES ('".$nombre."')")
            or die ("Error al insertar cotización");
        return $sql;
    }

    public function ObtenerIdCotizacion($connect,$nombre)
    {
        $sql = mysqli_query($connect,"SELECT idCotizacion FROM Cotizacion WHERE Nombre='".$nombre."'")
         or die ("Error al obtener las cotización");
        return $sql;
    }
    public function EliminarCotizacion($connect,$nombre)
    {
        $sql = mysqli_query($connect,"DELETE FROM Cotizacion WHERE Nombre='".$nombre."'")
         or die ("Error al obtener las cotización");
        return $sql;
    }

    public function EliminarRubroPrecio($connect,$idRubro,$idCotizacion)
    {
        $sql = mysqli_query($connect,"DELETE FROM RubroCotizacion WHERE idRubro='".$idRubro."' and idCotizacion='".$idCotizacion."'")
         or die ("Error al obtener las cotización");
        return $sql;
    }

    public function ModificarCotización($connect,$id,$nombre)
    {
        $sql = mysqli_query($connect,"UPDATE Cotizacion SET Nombre='".$nombre."' WHERE idCotizacion='".$id."'")
            or die ("Error al insertar cotización");
        return $sql;
    }
    public function ObtenerRubro($connect,$idCotizacion)
    {
        $sql = mysqli_query($connect,"SELECT idRubro,Precio FROM RubroCotizacion WHERE idCotizacion='".$idCotizacion."'")
         or die ("Error al obtener las cotización");
        return $sql;
    }
    public function InsertarRubroCotizacion($connect,$idCotizacion,$idRubro,$Precio)
    {
        $sql = mysqli_query($connect,"INSERT INTO RubroCotizacion (idRubro,idCotizacion,Precio) VALUES ('".$idRubro."','".$idCotizacion."','".$Precio."')")
         or die ("Error al obtener las cotización");
        return $sql;
    }
}

