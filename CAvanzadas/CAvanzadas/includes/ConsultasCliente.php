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
    function obtenerZonas($idCliente){
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $cliente = new Cliente();
            $sql = $cliente->ObtenerZonas($connect,$idCliente);
            return $sql;
        }
        mysqli_close($connect);
        return $sql;
    }

    function obtenerCliente($idCliente){
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $cliente = new Cliente();
            $sql = $cliente->ObtenerCliente($connect,$idCliente);
            return $sql;
        }
        mysqli_close($connect);
        return $sql;
    }

    function insertarCliente($nombre)
    {
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $cliente = new Cliente();
            $sql = $cliente->InsertarCliente($connect,$nombre);
            return $sql;
        }
        return $sql;
    }

    function modificarCliente($id,$nombre)
    {
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $cliente = new Cliente();
            $sql = $cliente->ModificarCliente($connect,$id,$nombre);
            return $sql;
        }
        return $sql;
    }

    function obtenerNumeroInforme($idCliente){
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $cliente = new Cliente();
            $sql = $cliente->obtenerNumeroInforme($connect,$idCliente);
            mysqli_close($connect);
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