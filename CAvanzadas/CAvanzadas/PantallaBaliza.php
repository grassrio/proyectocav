<?php
require('includes/loginheader.php');
session_start();
require 'includes/ConsultasBaliza.php';
require 'includes/ConsultasObra.php';
if (isset($_SESSION['usuario'])&&($_SESSION['tipoUsuario'] <> 2)) {
$sql = DevolverBalizasProximoVencimiento();
$rowcount = mysqli_num_rows($sql);
if ($rowcount>0) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
    <script>
        var id;

       $(document).ready(function(){
           $("#ventanaDevolverBaliza").on("show.bs.modal", function (e) {
                id = $(e.relatedTarget).data('target-id');
                $("#DevolverBaliza").html("¿Confirma que la baliza fue devuelta al proveedor?");
            });

       });

       $("#btnDevolverBaliza").click(function () {
           $('#btnDevolverBaliza').prop('disabled', true);
           $.post("ajaxBaliza.php", //Required URL of the page on server
                   { // Data Sending With Request To Server
                       action: "devolverBaliza",
                       idBaliza: id
                   },
           function (response, status) { // Required Callback Function
               if (response == 'Error al devolver Baliza') {
                   swal({
                       title: "Advertencia!",
                       text: response,
                       type: "warning",
                       confirmButtonText: "OK"
                   });
                   $('#btnDevolverBaliza').prop('disabled', false);
               }
               else {
                   $('#ventanaDevolverBaliza').modal('hide');
                   carga('PantallaBaliza');
               }
           });
       });
      
    </script>

   <!--VENTANA PARA CONFIRMAR QUE SE VA A DEVOLVER LA BALIZA-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaDevolverBaliza">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Confirmar</h4>
                </div>
                <div class="modal-body" id="DevolverBaliza">
                    <input name="DevolverBaliza" id="DevolverBaliza" class="form-control" aria-describedby="basic-addon2" />
                    <!-- esto se carga dinamico-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="btnDevolverBaliza" type="button" class="btn btn-danger">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Alerta Balizas</h3>
            </div>
        </div>
        <!-- Table -->
        <table class="table">
            <tr>
                <th>Obra</th>
                <th>Proveedor</th>
                <th>Cantidad</th>
                <th>Fecha límite</th>
                <th></th>
            </tr>
            <?php
    while($rsBaliza=mysqli_fetch_array($sql))
    {
        $sqlObra=obtenerObra($rsBaliza[idObra]);
        $rsObra=mysqli_fetch_array($sqlObra);
        echo "<tr>"
        ."<td>".$rsObra[Nombre]."</td>"
        ."<td>".$rsBaliza[Proveedor]."</td>"
        ."<td>".$rsBaliza[Cantidad]."</td>"
        ."<td>".$rsBaliza[fechaFin]."</td>"
        ."<td>".'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rsBaliza[idBaliza].'" data-target="#ventanaDevolverBaliza" data-toggle="modal">
<span class="glyphicon glyphicon-send" aria-hidden="true"></span> Baliza devuelta</button>'."</td>"
        ."</tr>";
    }


            ?>
        </table>
    </div>
</body>
</html>
<?php }
}?>

