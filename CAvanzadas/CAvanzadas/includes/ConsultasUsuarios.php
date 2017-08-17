<?php

    function insertarUsuario($NombreUsu,$pass,$cargo,$idEmpleado){
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $passConMd5 = md5($pass);
            $sql = mysqli_query($connect,"INSERT INTO Usuario (NombreUsuario,Password,TipoUsuario,idPersonal) VALUES ('".$NombreUsu."','".$passConMd5."','".$cargo."','".$idEmpleado."')") or die ("Error al insertar usuario");
            mysqli_close($connect);
            return $sql;
        }
        return $sql;
    }

    function existeUsuario($connect,$nombreUsuario,$pass)
    {
        $sql = mysqli_query($connect,"SELECT * FROM Usuario WHERE NombreUsuario='".$nombreUsuario."'AND Password='".$pass."'")
           or die ("Error al consultar usuarios");
        return $sql;
    }

    function DevolverUsuarios(){
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $sql = mysqli_query($connect,"SELECT * FROM Usuario") or die ("Error al consultar usuarios");
            mysqli_close($connect);
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

    function modificarUsuario($idUsuario,$pass){
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $passConMd5 = md5($pass);
            $sql = mysqli_query($connect,"UPDATE Usuario SET Password='".$passConMd5."' WHERE Id='".$idUsuario."'") or die ("Error al modificar usuario");
            mysqli_close($connect);
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
            $sql = mysqli_query($connect,"DELETE FROM Usuario WHERE NombreUsuario='".$nombre."'") or die ("Error al eliminar el usuario");
            mysqli_close($connect);
            return $sql;
        }
        return $sql;
    }

?>