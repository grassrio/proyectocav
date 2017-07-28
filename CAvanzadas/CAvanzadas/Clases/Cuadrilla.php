<?php
class Cuadrilla
{
    public function InsertarCuadrilla($connect,$nombre)
    {
        $sql = mysqli_query($connect,"INSERT INTO Cuadrilla (Nombre) VALUES ('".$nombre."')")
            or die ("Error al insertar cuadrilla");
        return $sql;
    }

    public function EliminarCuadrilla($connect,$nombre)
    {
        $sql = mysqli_query($connect,"DELETE FROM Cuadrilla WHERE Nombre='".$nombre."'")
         or die ("Error al eliminar la cuadrilla");
        return $sql;
    }

    public function ModificarCuadrilla($connect,$id,$nombre)
    {
        $sql = mysqli_query($connect,"UPDATE Cuadrilla SET Nombre='".$nombre."' WHERE idCuadrilla='".$id."'")
            or die ("Error al modificar cuadrilla");
        return $sql;
    }
    public function ListarCuadrillas($connect)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Cuadrilla")
            or die ("Error al listar las cuadrillas");
        return $sql;
    }

    public function ObtenerCuadrilla($connect,$idCuadrilla){
        $sql = mysqli_query($connect,"SELECT * FROM Cuadrilla WHERE idCuadrilla=".$idCuadrilla."")
            or die ("Error al obtener cuadrilla");
        return $sql;
    }

    public function ObtenerObreros($connect,$idCuadrilla)
    {
        $sql = mysqli_query($connect,"SELECT * FROM PersonalCuadrilla WHERE idCuadrilla=".$idCuadrilla."")
            or die ("Error al obtener los obreros");
        return $sql;
    }
    public function nuevoObreroCuadrilla($connect,$idCuadrilla,$Porcentaje,$Nombre)
    {
        $sql = mysqli_query($connect,"INSERT INTO PersonalCuadrilla (idCuadrilla,Nombre,Porcentaje) VALUES ('".$idCuadrilla."','".$Nombre."','".$Porcentaje."')")
    or die ("Error al obtener los obreros");
        return $sql;
    }

    public function eliminarObreroCuadrilla($connect,$nombre,$idCuadrilla)
   {
       $sql = mysqli_query($connect,"DELETE FROM PersonalCuadrilla WHERE Nombre='".$nombre."' and idCuadrilla='".$idCuadrilla."'")
or die ("Error al eliminar la cuadrilla");
       return $sql;
   }
}