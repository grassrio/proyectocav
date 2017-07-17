<?php
class Cliente
{
    private $nombre;
    private $zona;


    function construct( $nombre, $unaZona)
    {
        $this->nombre = $nombre;
    }

    public function setNombre( $nombre ){	$this->nombreUsu = $nombre; }
    public function getNombre(){ return $this->nombreUsu; }


    public function ExisteCliente($connect)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Cliente WHERE Nombre='".$this->nombre."'")
           or die ("Error al consultar cliente");
        return $sql;
    }

    public function ListaCliente($connect)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Cliente")
           or die ("Error al consultar cliente");
        return $sql;
    }

    public function InsertarCliente($connect,$nombre)
    {
        $sql = mysqli_query($connect,"INSERT INTO Cliente (Nombre) VALUES ('".$nombre."')")
            or die ("Error al insertar cliente");
        return $sql;
    }

    public function ObtenerZonas($connect,$idCliente)
    {
        $sql = mysqli_query($connect,"SELECT idZona FROM ClienteZona WHERE idCliente='".$idCliente."'")
         or die ("Error al obtener las zonas");
        return $sql;
    }

    public function ObtenerCliente($connect,$idCliente)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Cliente WHERE idCliente='".$idCliente."'")
         or die ("Error al obtener las zonas");
        return $sql;
    }

    public function EliminarCliente($connect,$nombre)
    {
        $sql = mysqli_query($connect,"DELETE FROM Cliente WHERE Nombre='".$nombre."'")
         or die ("Error al eliminar las zonas");
        return $sql;
    }

    public function ModificarCliente($connect,$id,$nombre)
    {
        $sql = mysqli_query($connect,"UPDATE Cliente SET Nombre='".$nombre."' WHERE idCliente='".$id."'")
            or die ("Error al modificar el cliente");
        return $sql;
    }
}