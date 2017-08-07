<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CAvanzadas</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/todc-bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/md5.js"></script>


    <form method="POST" action="" onsubmit="pwd_encrypt(this);">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Construcciones Avanzadas SRL</h3>
            </div>
            <div class="panel-body">
                <div class="input-group">
                    <input name="usuario" type="text" class="form-control" placeholder="Usuario" aria-describedby="basic-addon2" />
                </div>
                <div class="input-group">
                    <input name="password" type="password" class="form-control" placeholder="Contraseña" aria-describedby="basic-addon2" />
                </div>
                <p>
                    <input class="btn btn-primary" name="submit" type="submit" id="btn" value="Ingresar" />
                    <!--  <a class="btn btn-primary btn-lg" href="#" role="button" name="login" type="submit">Iniciar sesión</a>-->
                </p>
            </div>
        </div>
    </form>
    <?php
    if(isset($_POST['submit'])){
        if (!empty($_POST['usuario'])&&!empty($_POST['password'])){
             require("includes/login_usuario.php");

        }else{
            echo"Error: Debe ingresar el usuario y la contraseña para ingresar.";
        }
    }
    ?>
</body>
</html>