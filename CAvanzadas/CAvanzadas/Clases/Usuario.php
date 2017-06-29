<?php

class Usuario
{
    private $nombreUsu;
    private $pass;

    function construct( $nombreUsu, $pass)
    {
        $this->nombreUsu = $nombreUsu;
        $this->pass = $pass;
    }

    public function setNombreUsu( $nombre ){	$this->nombreUsu = $nombre; }
    public function getNombreUsu(){ return $this->nombreUsu; }
    public function setPass( $pass ){	$this->pass = $pass; }
    public function getPass(){ return $this->pass; }

    public function ExisteUsuario($connect)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Usuario WHERE NombreUsuario='".$this->nombreUsu."'AND Password='".$this->pass."'")
           or die ("Error al consultar usuarios");
        return $sql;
    }

    public function ObtenertipoUsuario($connect)
    {

        $sql = mysqli_query($connect,"SELECT TipoUsuario FROM Usuario WHERE NombreUsuario='".$this->nombreUsu."'")
         or die ("Error al consultar el tipo de usuario");
        return $sql;
    }
}
?>