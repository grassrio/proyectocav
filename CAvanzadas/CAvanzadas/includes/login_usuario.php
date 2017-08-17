<?php
require 'includes/ConsultasUsuarios.php';
if(isset($_POST['submit'])){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $usuario = $_POST['usuario'];
        $pass = md5($_POST['password']);
        $sqlUsuario = existeUsuario($connect,$usuario,$pass);
        $rowcount = mysqli_num_rows($sqlUsuario);
        if ($rowcount<1){
            echo 'Usuario o contraseña incorrecta';
            mysqli_close($connect);
        }else{
            //Si el usuario existe seteo los valores de sesion
            session_start();
            $rsUsuario = mysqli_fetch_array($sqlUsuario);
            $_SESSION['usuario']=$rsUsuario[NombreUsuario];
            $_SESSION['tipoUsuario']=$rsUsuario[TipoUsuario];
            header("location:../index.php");
        }
    }
}
?>