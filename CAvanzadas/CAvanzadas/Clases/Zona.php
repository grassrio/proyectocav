<?php
class Zona
{
    private $nombre;

    function construct( $nombre)
    {
        $this->nombre = $nombre;

    }

    public function setNombre( $nombre ){	$this->nombre= $nombre; }
    public function getNombre(){ return $this->nombre; }

    public function DevolverZona($connect,$idZona)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Zona WHERE idZona='".$idZona."'")
           or die ("Error al consultar zona");
        return $sql;
    }

    public function ExisteZona($connect,$nombre)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Zona WHERE Nombre='".$nombre."'")
           or die ("Error al consultar zona");
        return $sql;
    }

    public function ListaZona($connect)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Zona")
           or die ("Error al consultar zona");
        return $sql;
    }

    public function InsertarZona($connect,$nombre)
    {
        $sql = mysqli_query($connect,"INSERT INTO Zona (Nombre) VALUES ('".$nombre."')")
            or die ("Error al insertar zona");
        return $sql;
    }

    public function ObtenerIdZonas($connect,$nombre)
    {
        $sql = mysqli_query($connect,"SELECT idZona FROM Zona WHERE Nombre='".$nombre."'")
         or die ("Error al obtener las zonas");
        return $sql;
    }
    public function EliminarZona($connect,$nombre)
    {
        $sql = mysqli_query($connect,"DELETE FROM Zona WHERE Nombre='".$nombre."'")
         or die ("Error al obtener las zonas");
        return $sql;
    }

    public function ModificarZona($connect,$id,$nombre)
    {
        $sql = mysqli_query($connect,"UPDATE Zona SET Nombre='".$nombre."' WHERE idZona='".$id."'")
            or die ("Error al insertar zona");
        return $sql;
    }
}