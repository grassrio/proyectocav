<?php
class Rubro
{
    private $nombre;
    private $unidad;
    private $cantidadStock;


    function construct( $nombre, $unidad, $cantidadStock)
    {
        $this->nombre = $nombre;
        $this->unidad = $unidad;
        $this->cantidadStock = $cantidadStock;

    }

    public function setNombre( $nombre ){	$this->nombre = $nombre; }
    public function getNombre(){ return $this->nombre; }


    public function BuscarRubro($connect,$nombre)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Rubro WHERE Nombre like '"."%".$nombre."%"."'")
           or die ("Error al buscar rubro");
        return $sql;
    }

    public function ExisteRubro($connect,$nombre)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Rubro WHERE Nombre='".$nombre."'")
           or die ("Error al consultar rubro");
        return $sql;
    }

    public function ListaRubro($connect)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Rubro")
           or die ("Error al consultar rubros");
        return $sql;
    }

    public function InsertarRubro($connect,$nombre,$unidad, $cantidadStock)
    {
        $sql = mysqli_query($connect,"INSERT INTO Rubro (Nombre,Unidad,CantidadStock) VALUES ('".$nombre."','".$unidad."','".$cantidadStock."')")
            or die ("Error al insertar rubro");
        return $sql;
    }


    public function EliminarRubro($connect,$nombre)
    {
        $sql = mysqli_query($connect,"DELETE FROM Rubro WHERE Nombre='".$nombre."'")
         or die ("Error al eliminar rubro");
        return $sql;
    }

    public function ModificarRubro($connect,$id,$nombre,$unidad, $cantidadStock)
    {
        $sql = mysqli_query($connect,"UPDATE Rubro SET Nombre='".$nombre."',Unidad='".$unidad."',CantidadStock='".$cantidadStock."' WHERE idRubro='".$id."'")
            or die ("Error al modificar rubro");
        return $sql;
    }
    public function DevolverRubro($connect,$idRubro)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Rubro WHERE idRubro='".$idRubro."'")
           or die ("Error al consultar rubro");
        return $sql;
    }
}