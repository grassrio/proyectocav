<?php
function obtenerImagenes($idObra)
{
    require 'Clases/Imagen.php';
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $imagen = new Imagen();
        $sql = $imagen->obtenerImagenes($connect,$idObra);
        mysqli_close($connect);
        return $sql;
    }
    return $sql;
}

if($_SERVER['REQUEST_METHOD']=="DELETE"){
    require('config.php');
    require '../Clases/Imagen.php';
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        parse_str(file_get_contents("php://input"),$datosDELETE);
        $idImagen= $datosDELETE['key'];
        mysqli_select_db($connect,$mysqldb);
        $imagen = new Imagen();
        $sql = $imagen->borrarImagen($connect,$idImagen);
        mysqli_close($connect);
        return $sql;
    }
    echo 0;
}

if(isset($_FILES['imagenes']['name']) && isset($_POST['idObra'])){
    require('config.php');
    require '../Clases/Imagen.php';
    $idObra=$_POST['idObra'];
    $Imagenes =count(isset($_FILES['imagenes']['name'])?$_FILES['imagenes']['name']:0);
    $infoImagenesSubidas = array();
    for($i = 0; $i < $Imagenes; $i++) {

        // El nombre y nombre temporal del archivo que vamos para adjuntar
        $nombreArchivo=isset($_FILES['imagenes']['name'][$i])?$_FILES['imagenes']['name'][$i]:null;
        $extension= end(explode(".", $nombreArchivo));
        if ($extension=="jpeg" || $extension=="jpg" || $extension=="bmp" || $extension=="png" ||$extension=="gif" || $extension=="avi"){
            $nombreTemporal=isset($_FILES['imagenes']['tmp_name'][$i])?$_FILES['imagenes']['tmp_name'][$i]:null;

            $nombreArchivo=$idObra.$nombreArchivo;

            $rutaArchivo=$directorioImagenes.$nombreArchivo;
            $idImagen='0';
            $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
            if ($connect)
            {
                mysqli_select_db($connect,$mysqldb);
                $imagen = new Imagen();
                $idImagen = $imagen->insertarImagen($connect,$idObra,$nombreArchivo);
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