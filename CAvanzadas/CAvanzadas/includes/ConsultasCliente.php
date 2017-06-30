<?php
require 'Clases/Cliente.php';
    function devolverClientes(){
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            $cliente = new Cliente();
            $sql = $cliente->ListaCliente($connect);
            return $sql;
        }
        return $sql;

    }
?>