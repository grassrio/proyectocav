<?php
class Personal
{

    public function devolverPersonal($connect)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Personal")
           or die ("Error al consultar Personal");
        return $sql;
    }

    public function InsertarPersonal($connect,$nombre,$apellido,$direccion,$telefono,$cargo)
    {
        $sql = mysqli_query($connect,"INSERT INTO Personal (Nombre,Apellido,Direccion,Telefono,Cargo) VALUES ('".$nombre."','".$apellido."','".$direccion."','".$telefono."','".$cargo."')")
            or die ("Error al insertar personal");
        return $sql;
    }


    public function EliminarPersonal($connect,$id)
    {
        $sql = mysqli_query($connect,"DELETE FROM Personal WHERE idPersonal='".$id."'")
         or die ("Error al eliminar personal");
        return $sql;
    }

    public function ModificarPersonal($connect,$id,$direccion,$telefono,$cargo)
    {
        $sql = mysqli_query($connect,"UPDATE Personal SET Direccion='".$direccion."',Telefono='".$telefono."', Cargo='".$cargo."' WHERE idPersonal='".$id."'")
            or die ("Error al modificar rubro");
        return $sql;
    }
    public function DevolverUnPersonal($connect,$id)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Personal WHERE idPersonal='".$id."'")
           or die ("Error al consultar personal");
        return $sql;
    }
}