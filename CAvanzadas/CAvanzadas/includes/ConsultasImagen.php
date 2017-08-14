<?php
function obtenerImagenes($idObra)
{
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $sql = mysqli_query($connect,"SELECT * FROM Imagen WHERE idObra='".$idObra."'") or die ("Error al obtener imágenes");
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

if($_SERVER['REQUEST_METHOD']=="DELETE"){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        parse_str(file_get_contents("php://input"),$datosDELETE);
        $idImagen= $datosDELETE['key'];
        mysqli_select_db($connect,$mysqldb);
        $sqlNombreImagen=mysqli_query($connect,"Select nombreImagen FROM Imagen WHERE idImagen='".$idImagen."'") or die ("Error al obtener imagen");
        $nombreImagen=mysqli_fetch_array($sqlNombreImagen);
        $sql = mysqli_query($connect,"DELETE FROM Imagen WHERE idImagen='".$idImagen."'") or die ("Error al eliminar imagen");
        $rutaFoto="../".$directorioImagenes.$nombreImagen[nombreImagen];
        unlink($rutaFoto);
        mysqli_close($connect);
        echo 0;
        return;
    }
    echo 0;
    return;
}

if(isset($_FILES['imagenes']['name']) && isset($_POST['idObra'])){
    require('config.php');
    $idObra=$_POST['idObra'];
    $Imagenes =count(isset($_FILES['imagenes']['name'])?$_FILES['imagenes']['name']:0);
    $infoImagenesSubidas = array();
    for($i = 0; $i < $Imagenes; $i++) {

        // El nombre y nombre temporal del archivo que vamos para adjuntar
        $nombreArchivo=isset($_FILES['imagenes']['name'][$i])?$_FILES['imagenes']['name'][$i]:null;
        $extension= strtolower(end(explode(".", $nombreArchivo)));
        if ($extension=="jpeg" || $extension=="jpg" || $extension=="bmp" || $extension=="png" ||$extension=="gif" || $extension=="avi"){
            $nombreTemporal=isset($_FILES['imagenes']['tmp_name'][$i])?$_FILES['imagenes']['tmp_name'][$i]:null;
            $nombreArchivo=$idObra.$nombreArchivo;
            $rutaArchivo=$directorioImagenes.$nombreArchivo;
            $idImagen='0';
            $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
            if ($connect)
            {
                mysqli_select_db($connect,$mysqldb);
                $sqlExisteImagen=mysqli_query($connect,"Select * FROM Imagen WHERE idObra='".$idObra."' and nombreImagen='".$nombreArchivo."'");
                $rowcount = mysqli_num_rows($sqlExisteImagen);
                if ($rowcount>0){
                    $existeImagen=mysqli_fetch_array($sqlExisteImagen);
                    $idImagen=$existeImagen[idImagen];
                }else{
                    mysqli_query($connect,"INSERT INTO Imagen (idObra,nombreImagen) VALUES ('".$idObra."','".$nombreArchivo."')") or die ("Error al insertar imagen");
                    $idImagen = $connect->insert_id;
                }
                mysqli_close($connect);
            }
            $rutaArchivoTemp="../".$rutaArchivo;
            if ($idImagen>0){
                move_uploaded_file($nombreTemporal,$rutaArchivoTemp);

                $infoImagenesSubidas[$i]=array("caption"=>"$nombreArchivo","height"=>"120px","url"=>"includes/ConsultasImagen.php","key"=>$idImagen);
                $ImagenesSubidas[$i]="<img  height='120px'  src='$rutaArchivo' class='file-preview-image'>";
            }
        }



	}

    $arr = array("file_id"=>0,"overwriteInitial"=>true,"initialPreviewConfig"=>$infoImagenesSubidas,
                 "initialPreview"=>$ImagenesSubidas);
    echo json_encode($arr);
}

?>