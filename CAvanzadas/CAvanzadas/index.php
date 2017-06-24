<?php
require('includes/config.php');
$link = mysql_connect($mysqlserver, $mysqluser, $mysqlpass) or die('No se pudo conectar: ' . mysql_error());
mysql_select_db($mysqldb) or die('No se pudo seleccionar la base de datos');

// Realizar una consulta MySQL
$query = 'SELECT * FROM Usuario';
$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());

// Imprimir los resultados en HTML
echo "<table>\n";
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

// Liberar resultados
mysql_free_result($result);

// Cerrar la conexión
mysql_close($link);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CAvanzadas</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/todc-bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>



    <form method="POST" action="">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Construcciones Avanzadas SRL</h3>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <input name="user" type="text" class="form-control" placeholder="Usuario" aria-describedby="basic-addon2" />
                </div>
                <div class="input-group">
                    <input name="pass" type="password" class="form-control" placeholder="Contraseña" aria-describedby="basic-addon2" />
                </div>
                <p>
                    <a class="btn btn-primary btn-lg" href="#" role="button" name="login" type="submit">Iniciar sesión</a>
                </p>
            </div>
        </div>
    </form>
    <?php
    if(isset($_POST['submit'])&&!empty($_POST['pass'])&&!empty($_POST['user'])){
        require("includes/login_usuario.php");
    }
    ?>
</body>
</html>