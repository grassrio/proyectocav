<?php
require 'Clases/Usuario.php';

    function insertarUsuario($NombreUsu,$pass,$cargo,$idEmpleado){
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $usuario = new Usuario();
            $passConMd5 = md5($pass);
            $sql     = $usuario->insertarUsuario($connect,$NombreUsu,$passConMd5,$cargo,$idEmpleado);
            return $sql;
        }
        return $sql;
    }

?>