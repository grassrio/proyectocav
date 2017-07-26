<?php
require 'Clases/Usuario.php';
if(isset($_POST['submit'])){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $username = $_POST['usuario'];
        $password = md5($_POST['password']);
        $usuario = new Usuario();
        $usuario->construct($username,$password);
        $sql = $usuario->ExisteUsuario($connect);
        $rowcount = mysqli_num_rows($sql);
        if ($rowcount<1){
            echo 'Usuario o contraseña incorrecta';
            mysqli_close($connect);
        }else{
            session_start();
            $sql = $usuario->ObtenertipoUsuario($connect);
            $tipoUsuarioSql = mysqli_fetch_array($sql);
            $_SESSION['usuario']=$username;
            $_SESSION['tipoUsuario']=$tipoUsuarioSql[TipoUsuario];
            header("location:../index.php");
        }
    }
}
?>