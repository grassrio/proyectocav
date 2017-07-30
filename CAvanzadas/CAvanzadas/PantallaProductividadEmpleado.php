<?php
require('includes/loginheader.php');
$fechaActual=date("Y-m-d");
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
    <script>
        $(document).ready(function () {
            $('#ventanaSeleccionaFecha').on('shown.bs.modal', function (e) {
                $(this).find('form').validator()
                $('#consultaProductividad').on('submit', function (e) {
                    if (e.isDefaultPrevented()) {
                    }
                    else {
                        e.preventDefault()
                        ProductividadEmpleado();
                    }
                })
                $('#ventanaSeleccionaFecha').on('hidden.bs.modal', function (e) {
                    $(this).find('form').off('submit').validator('destroy')
                })
            });
            $('#ventanaSeleccionaFecha').on('hidden.bs.modal', function () {
                $(this).find('form')[0].reset();
            });
        });
        function ProductividadEmpleado() {
            $('#btnConsulta').prop('disabled', true);
            var fechaInicio = $('#fechaInicio').val();
            var fechaFin = $('#fechaFin').val();
                $.post("ajaxPersonal.php", //Required URL of the page on server
                      { // Data Sending With Request To Server
                          action: "ProductividadEmpleado",
                          FechaInicio: fechaInicio,
                          FechaFin: fechaFin,
                      },
                function (response, status) { // Required Callback Function
                    $("#contenido").hide();
                    $("#subcontenido").show();
                    $("#subcontenido").html(response);
                });            
        };
    </script>

    <!--CONSULTA PRODUCTIVIDAD-->
    <div class="modal fade" tabindex="-1" role="dialog" id="ventanaSeleccionaFecha">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Seleccione el periodo para realizar la consulta</h4>
                </div>
                <div class="modal-body">
                    <form role="form" data-toggle="validator" id="consultaProductividad" name="consultaProductividad">
                        <div class="form-group row">
                            <label for="fechaI" class="col-sm-2 col-form-label">
                                Fecha desde:
                            </label>
                            <div class="col-sm-8">
                                <input name="fechaInicio" data-error="Completa este campo" id="fechaInicio" type="date" value="<?php echo $fechaActual;?>" class="form-control" aria-describedby="basic-addon2" required />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Direccion" class="col-sm-2 col-form-label">
                                Fecha hasta:
                            </label>
                            <div class="col-sm-8">
                                <input name="fechaFin" data-error="Completa este campo" id="fechaFin" type="date" value="<?php echo $fechaActual;?>" class="form-control" aria-describedby="basic-addon2" required />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button id="btnConsulta" type="submit" class="btn btn-success success">Consulta</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <h3 class="panel-title">Empleados</h3>
        </div>

        <nav class="navbar navbar-toolbar navbar-default">
            <div class="container-fluid">
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse bs-example-toolbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <button type="button" class="btn btn-success btn-xs" data-target="#ventanaSeleccionaFecha" data-toggle="modal">Ingresar Fechas</button>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <!-- Table -->
        <table class="table">
            <tr>
                <th>Nombre Completo</th>
                <th>Metrajes Realizados</th>
            </tr>
            <?php
            
    $rowcount = mysqli_num_rows($sql);
    if ($rowcount>0) {
        while($rs=mysqli_fetch_array($sql))
        {
            echo "<tr>"
            ."<td>".$rs[0]."</td>"
            ."<td>".$rs[1]."</td>"
            ."</tr>";
        }
    }
    else
    {
        echo'<tr><td>No hay Informaciom</td></tr>';
    }
            ?>
        </table>
    </div>
</body>
</html>
<?php } ?>