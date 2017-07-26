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
    public function insertarUsuario($connect,$NombreUsu,$pass,$cargo,$idEmpleado)
    {

        $sql = mysqli_query($connect,"INSERT INTO Usuario (NombreUsuario,Password,TipoUsuario,idPersonal) VALUES ('".$NombreUsu."','".$pass."','".$cargo."','".$idEmpleado."')")
         or die ("Error al insertar el usuario");
        return $sql;
    }

    public function DevolverUsuarios($connect)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Usuario")
         or die ("Error al consultar el tipo de usuario");
        return $sql;
    }
    public function EliminarUsuario($connect,$nombre)
    {
        $sql = mysqli_query($connect,"DELETE FROM Usuario WHERE NombreUsuario='".$nombre."'")
         or die ("Error al eliminar el usuario");
        return $sql;
    }
    public function ModificarUsuario($connect,$idUsuario,$pass)
    {
        $sql = mysqli_query($connect,"UPDATE Usuario SET Password='".$pass."' WHERE Id='".$idUsuario."'")
         or die ("Error al modificar el tipo de usuario");
        return $sql;
    }
}
?>