<?php
session_start();

if(isset($_POST['submit'])){
    require('config.php');
   $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('No se pudo conectar: ' . mysqli_error());
 if ($connect)
 {
	 mysqli_select_db($connect,$mysqldb);
	$username = $_POST['user'];
	$password = $_POST['pass'];
	$sql = mysqli_query($connect,"SELECT * FROM Usuario WHERE NombreUsuario='$username' AND Password='$password'")
		 or die ("Faild");
	$rowcount = mysqli_num_rows($sql);
	if ($rowcount<1){
		echo 'Usuario o password incorrectas';
		mysqli_close($connect);
	}else{
		 $sql = mysqli_query($connect,"SELECT TipoUsuario FROM Usuario WHERE NombreUsuario='$username'")
		 or die ("Faild");

        $line = mysqli_fetch_array($sql);

        $_SESSION['tipoUsuario']=$line;
        $_SESSION['user']=$username;

		echo'session establecida!';
	}
  }
?>