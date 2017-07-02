<?php
require 'Clases/Cliente.php';
    function devolverClientes(){
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $cliente = new Cliente();
            $sql = $cliente->ListaCliente($connect);
            return $sql;
        }
        return $sql;
    }
    function insertarCliente($nombre,$zona)
    {
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $cliente = new Cliente();
            $sql = $cliente->InsertarCliente($connect,$nombre,$zona);
            return $sql;
        }
        return $sql;
    }

    function eliminarCliente($nombre)
    {
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $cliente = new Cliente();
            $sql = $cliente->EliminarCliente($connect,$nombre);
            return $sql;
        }
        return $sql;
    }
?>