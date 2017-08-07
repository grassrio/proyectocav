<?php
require('includes/loginheader.php');
session_start();
$tipoUsuario = $_SESSION['tipoUsuario'];
require 'includes/ConsultasUsuarios.php';
$sql = DevolverUsuarios() ;
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
        var nombre;

       $(document).ready(function () {
           $("#ventanaEliminarUsuario").on("show.bs.modal", function (e) {
               nombre = $(e.relatedTarget).data('target-id');
               $("#EliminarUsuario").html("Desea eliminar usuario " + nombre + "?");
           });
       });

       $(document).ready(function () {
           $("#ventanaModificarUsuario").on("show.bs.modal", function (e) {
               id = $(e.relatedTarget).data('target-id');
           });
       });

       $('#ventanaModificarUsuario').on('shown.bs.modal', function (e) {

           $(this).find('form').validator()

           $('#modificarUsuario').on('submit', function (e) {
               if (e.isDefaultPrevented()) {
               } else {
                   e.preventDefault()
                   // Si se cumple la validacion llama a la funcion de agregar
                   ModificarUsuario();
               }
           })
           $('#ventanaModificarUsuario').on('hidden.bs.modal', function (e) {
               $(this).find('form').off('submit').validator('destroy')
           })
       });
       function ModificarUsuario() {
           $('#btnModificarUsuario').prop('disabled', true);
           var pass = $('#Contrasenia').val();
           $.post("ajaxPersonal.php", //Required URL of the page on server
                     { // Data Sending With Request To Server
                         action: "modificarUsuario",
                         Pass: pass,
                         IdUsuario:id,
                     },
               function (response, status) { // Required Callback Function
                   if (response == '') {
                       $('#ventanaModificarUsuario').modal('hide');
                       carga('PantallaUsuario');
                   }
                   else {
                       swal({
                           title: "Advertencia!",
                           text: response,
                           type: "warning",
                           confirmButtonText: "OK"
                       });
                       $('#btnModificarUsuario').prop('disabled', false);
                   }
               });
       };
       $("#btnEliminarUsuario").click(function () {
           $('#btnEliminarUsuario').prop('disabled', true);
           $.post("ajaxPersonal.php", //Required URL of the page on server
                   { // Data Sending With Request To Server
                       action: "eliminarUsuario",
                       NombreUsuario: nombre,
                   },
           function (response, status) { // Required Callback Function
               if (response != '') {
                   swal({
                       title: "Advertencia!",
                       text: response,
                       type: "warning",
                       confirmButtonText: "OK"
                   });
                   $('#btnEliminarUsuario').prop('disabled', false);
               }
               else {
                   $('#ventanaEliminarUsuario').modal('hide');
                   carga('PantallaUsuario');
               }
           });
       });

    </script>

    <!--VENTANA PARA CONFIRMAR QUE SE VA A ELIMINAR EL USUARIO-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaEliminarUsuario">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Eliminar Usuario</h4>
                </div>
                <div class="modal-body" id="EliminarUsuario">
                    <input name="EliminarUsuario" id="EliminarUsuario" type="hidden" class="form-control" aria-describedby="basic-addon2" />
                    <!-- esto se carga dinamico-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="btnEliminarUsuario" type="button" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    <!--VENTANA PARA MODIFICAR EL USUARIO-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaModificarUsuario">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Modificar Contraseña usuario</h4>
                </div>
                <div class="modal-body">
                    <form role="form" data-toggle="validator" id="modificarUsuario" name="modificarUsuario">
                        <div class="form-group row">
                            <label for="Contrasenia" class="col-sm-2 col-form-label">
                                Contraseña:
                            </label>
                            <div class="form-group col-sm-4">
                                <input name="Contrasenia" data-minlength="6" placeholder="Contraseña" id="Contrasenia" type="password" class="form-control" aria-describedby="basic-addon2" required />
                                <div class="help-block">Mínimo de 6 caracteres</div>
                            </div>
                            <div class="form-group col-sm-4">
                                <input name="CContrasenia" data-match="#Contrasenia" placeholder="Confirmar" data-match-error="Las contraseñas no coinciden" id="CContrasenia" type="password" class="form-control" aria-describedby="basic-addon2" required />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="btnModificarUsuario" type="submit" class="btn btn-success success">Modificar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Usuarios</h3>
            </div>
        </div>
        <!-- Table -->
        <table class="table">
            <tr>
                <th>Nombre</th>
                <th>Tipo Usuario</th>
                <th></th>
            </tr>
            <?php
    while($rs=mysqli_fetch_array($sql))
    {
        if($rs[3]==2)
        {
            $tipo = 'Obrero';
        }
        elseif($rs[3]==3)
        {
            $tipo = 'Administrativo';
        }
        else//el tipo de usuario es 1
        {
            $tipo = 'Director';
        }
        if ($tipoUsuario<>1)
        {
            echo "<tr>"
            ."<td>".$rs[1]."</td>"
            ."<td>".$tipo."</td>"
            ."</tr>";
        }
        else
        {
            echo "<tr>"
            ."<td>".$rs[1]."</td>"
            ."<td>".$tipo."</td>"
            ."<td>".'<button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[0].'" data-target="#ventanaModificarUsuario" data-toggle="modal">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-default" data-toggle="modal" data-target-id="'.$rs[1].'" data-target="#ventanaEliminarUsuario" data-toggle="modal">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'
            ."</td>"
            ."</tr>";
            }
    }
            ?>
        </table>
    </div>
</body>
</html>
<?php  }?>

