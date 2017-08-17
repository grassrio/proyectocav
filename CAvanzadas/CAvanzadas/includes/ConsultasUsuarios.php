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

    function DevolverUsuarios(){
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $usuario = new Usuario();
            $sql     = $usuario->DevolverUsuarios($connect);
            return $sql;
        }
        return $sql;
    }

    function devolverUsuario($nombreUsuario){
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $sql = mysqli_query($connect,"SELECT * FROM Usuario WHERE NombreUsuario='".$nombreUsuario."'") or die ("Error al obtener usuario");
            mysqli_close($connect);
            return $sql;
        }
        return $sql;
    }

    function modificarUsuario($id,$pass){
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $usuario = new Usuario();
            $passConMd5 = md5($pass);
            $sql     = $usuario->ModificarUsuario($connect,$id,$passConMd5);
            return $sql;
        }
        return $sql;
    }
    function eliminarUsuario($nombre){
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $usuario = new Usuario();
            $sql     = $usuario->EliminarUsuario($connect,$nombre);
            return $sql;
        }
        return $sql;
    }

?>