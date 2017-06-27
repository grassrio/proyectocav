<?php
if(isset($_POST['submit'])){
    require('config.php');
    $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
    if ($connect)
    {
        mysqli_select_db($connect,$mysqldb);
        $username = $_POST['usuario'];
        $password = md5($_POST['password']);
        $sql = mysqli_query($connect,"SELECT * FROM Usuario WHERE NombreUsuario='$username' AND Password='$password'")
             or die ("Error al consultar usuarios");
        $rowcount = mysqli_num_rows($sql);
        if ($rowcount<1){
            echo 'Usuario o contraseña incorrecta';
            mysqli_close($connect);
        }else{
            session_start();
            $sql = mysqli_query($connect,"SELECT TipoUsuario FROM Usuario WHERE NombreUsuario='$username'")
            or die ("Error al consultar el tipo de usuario");

            $tipousuario = mysqli_fetch_array($sql);
            $_SESSION['usuario']=$username;
            $_SESSION['tipoUsuario']=$tipousuario;
            header("location:../index.php");
        }
    }
}
?>