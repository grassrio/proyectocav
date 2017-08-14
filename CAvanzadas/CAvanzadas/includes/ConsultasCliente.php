<?php

    function devolverClientes(){
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $sql = mysqli_query($connect,"SELECT * FROM Cliente") or die ("Error al consultar clientes");
            mysqli_close($connect);
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
            $sql = mysqli_query($connect,"SELECT idZona FROM ClienteZona WHERE idCliente='".$idCliente."'") or die ("Error al obtener zonas de cliente");
            mysqli_close($connect);
            return $sql;
        }
        return $sql;
    }

    function obtenerCliente($idCliente){
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $sql = mysqli_query($connect,"SELECT * FROM Cliente WHERE idCliente='".$idCliente."'") or die ("Error al obtener las zonas");
            mysqli_close($connect);
            return $sql;
        }
        return $sql;
    }

    function insertarCliente($nombre)
    {
        require('config.php');
        $connect = mysqli_connect($mysqlserver,$mysqluser,$mysqlpass) or die('Error al conectarse a la base de datos');
        if ($connect)
        {
            mysqli_select_db($connect,$mysqldb);
            $sql = mysqli_query($connect,"INSERT INTO Cliente (Nombre) VALUES ('".$nombre."')") or die ("Error al insertar cliente");
            mysqli_close($connect);
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
            $sql = mysqli_query($connect,"UPDATE Cliente SET Nombre='".$nombre."' WHERE idCliente='".$id."'") or die ("Error al modificar cliente");
            mysqli_close($connect);
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
            $sqlNumeroInforme = mysqli_query($connect,"Select ultimoInforme FROM Cliente WHERE idCliente='".$idCliente."'") or die ("Error al consultar último número de informe");
            $rsNumeroInforme=mysqli_fetch_array($sqlNumeroInforme);
            $numeroInforme = $rsNumeroInforme[ultimoInforme];
            $nuevoNumeroInforme = ($numeroInforme + 1);
            mysqli_query($connect,"UPDATE Cliente set ultimoInforme='".$nuevoNumeroInforme."' WHERE idCliente='".$idCliente."'") or die ("Error al incrementar número de informe");
            mysqli_close($connect);
            return $numeroInforme;
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
            $sql = mysqli_query($connect,"DELETE FROM Cliente WHERE Nombre='".$nombre."'") or die ("Error al eliminar cliente");
            mysqli_close($connect);
            return $sql;
        }
        return $sql;
    }
?>