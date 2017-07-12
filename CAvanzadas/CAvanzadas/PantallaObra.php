<?php
require('includes/loginheader.php');
session_start();
if (isset($_SESSION['usuario'])) {?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <h3 class="panel-title">Obras</h3>
        </div>


        <nav class="navbar navbar-toolbar navbar-default">
            <div class="container-fluid">


                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                    <ul class="nav navbar-nav">
                        

                    </ul>
                    <!-- busqueda -->
                    <form class="navbar-form navbar-left">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="" />
                        </div>
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </button>
                    </form>



                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>


    </div>

</body>
</html>
<?php } ?>