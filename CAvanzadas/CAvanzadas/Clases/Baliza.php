<?php
class Baliza
{
    public function BalizasProximoVencimiento($connect)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Baliza WHERE (DATEDIFF(fechaFin, NOW( )) <=2) AND fechaDevolucion IS NULL")
           or die ("Error al consultar Baliza");
        return $sql;
    }

    public function devolverBalizas($connect,$id)
    {
        $sql = mysqli_query($connect,"UPDATE Baliza SET fechaDevolucion=NOW() WHERE idBaliza='".$id."'")
           or die ("Error al devolver Baliza");
        return $sql;
    }
}
?>
 