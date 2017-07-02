<?php
class Cliente
{
    private $nombre;
    private $zona;


    function construct( $nombre, $unaZona)
    {
        $this->nombre = $nombre;
        $this->zona = $unaZona;

    }

    public function setNombre( $nombre ){	$this->nombreUsu = $nombre; }
    public function getNombre(){ return $this->nombreUsu; }

    public function agregarZona($unaZona)
    {
        $this->zona[] = $unaZona;
    }

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

    public function InsertarCliente($connect,$nombre,$zona)
    {
        $sql = mysqli_query($connect,"INSERT INTO Cliente (Nombre,Zona) VALUES ('".$nombre."','".$zona."')")
            or die ("Error al insertar cliente");
        return $sql;
    }

    public function ObtenerZonas($connect)
    {
        $sql = mysqli_query($connect,"SELECT zona FROM Cliente WHERE Nombre='".$this->nombre."'")
         or die ("Error al obtener las zonas");
        return $sql;
    }
    public function EliminarCliente($connect,$nombre)
    {
        $sql = mysqli_query($connect,"DELETE FROM Cliente WHERE Nombre='".$this->nombre."'")
         or die ("Error al obtener las zonas");
        return $sql;
    }
}