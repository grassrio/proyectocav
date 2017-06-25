<?php
require('includes/loginheader.php');
session_start();
if (isset($_SESSION['usuario'])) { ?>

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

    <a class="btn btn-primary" href="includes/logout.php" role="button" name="login" type="submit">Cerrar sesión</a>
</body>
</html>

<?php } ?>

