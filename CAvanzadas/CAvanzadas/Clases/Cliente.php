<?php
class Cliente
{
    private $nombre;
    private $zona = array();


    function construct( $nombre, $unaZona)
    {
        $this->nombre = $nombre;

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

    public function InsertarCliente($connect)
    {
        $sql = mysqli_query($connect,"INSERT INTO CLIENTE (Nombre,Zona) VALUES ('".$this->nombre."','".$this->zona."')")
            or die ("Error al insertar cliente");
        return $sql;
    }

    public function ObtenerZonas($connect)
    {

        $sql = mysqli_query($connect,"SELECT zona FROM Cliente WHERE Nombre='".$this->nombre."'")
         or die ("Error al obtener las zonas");
        return $sql;
    }
}