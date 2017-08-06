<?php
class Imagen
{
   public function obtenerImagenes($connect,$idObra){
       $sql = mysqli_query($connect,"SELECT * FROM Imagen WHERE idObra='".$idObra."'")
           or die ("Error al consultar imagenes");
       return $sql;
   }

   public function borrarImagen($connect,$idImagen){
       require('../includes/config.php');
       $sqlNombreImagen=mysqli_query($connect,"Select nombreImagen FROM Imagen WHERE idImagen='".$idImagen."'")
           or die ("Error al consultar imagen");
       $nombreImagen=mysqli_fetch_array($sqlNombreImagen);
       $sql = mysqli_query($connect,"DELETE FROM Imagen WHERE idImagen='".$idImagen."'")
           or die ("Error al consultar imagenes");
       unlink($directorioImagenes.$nombreImagen[nombreImagen]);
       echo 0;
   }

   public function insertarImagen($connect,$idObra,$nombreArchivo){
       $sqlExisteImagen=mysqli_query($connect,"Select * FROM Imagen WHERE idObra='".$idObra."' and nombreImagen='".$nombreArchivo."'");
       $rowcount = mysqli_num_rows($sqlExisteImagen);
       if ($rowcount>0){
           $existeImagen=mysqli_fetch_array($sqlExisteImagen);
           $idImagen=$existeImagen[idImagen];
           return $idImagen;
       }else{
           mysqli_query($connect,"INSERT INTO Imagen (idObra,nombreImagen) VALUES ('".$idObra."','".$nombreArchivo."')")
            or die ("Error al insertar imagen");
           $idImagen = $connect->insert_id;
           return $idImagen;
       }
   }
}