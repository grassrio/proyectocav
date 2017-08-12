<?php
require 'includes/ConsultasPersonal.php';
require 'includes/ConsultasUsuarios.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'nuevoPersonal' :
            insertarPersonal($_POST['NombreCompleto'],$_POST['Direccion'],$_POST['Telefono'],$_POST['Cargo']);
            if ($_POST['Cargo'] =='Director' )
            {
                $cargo = 1;
            }
            elseif($_POST['Cargo'] =='Obrero')
            {
                $cargo = 2;
            }
            else
            {
                $cargo = 3;
            }
            $sql = devolverPersonal($_POST['NombreCompleto']);
            $passConMd5 = md5($_POST['Pass']);
            $rs=mysqli_fetch_array($sql);
            insertarUsuario($_POST['NombreUsu'],$passConMd5,$cargo,$rs[0]);
            break;
        case 'eliminarPersonal' :
            eliminarPersonal($_POST['NombreCompleto']);
            break;
        case 'modificarPersonal' :
            modificarPersonal($_POST['idPersonal'],$_POST['Direccion'],$_POST['Telefono'],$_POST['Cargo']);
            break;
        case 'modificarUsuario' :
            $passConMd5 = md5($_POST['Pass']);
            modificarUsuario($_POST['IdUsuario'],$passConMd5);
            break;
        case 'eliminarUsuario' :
            eliminarUsuario($_POST['NombreUsuario']);
            break;
        case 'MostrarProductividadPorObrero':
           // $sqlPorObrero =  MostrarProductividadPorObrero($_POST['nombreEmpleado']);
            $sqlPorObrero =  MostrarProductividadPorObrero($_POST['nombreEmpleado'],$_POST['fechaInicio'],$_POST['fechaFin']);
            $rowcount = mysqli_num_rows($sqlPorObrero);
            echo'  <!-- Table -->
             <table class="table">
                <tr>
                 <th>Rubro</th>
                 <th>Unidad</th>
                 <th>Metrajes Realizados</th>
                 <th>Ganancia por rubro $</th>
                </tr>';
                    if ($rowcount>0)
                    {
                        $total = 0;
                        while($obraSql=mysqli_fetch_array($sqlPorObrero))
                        {
                            $gananciaArray = array();
                            $ganancia = ($obraSql[3]*$obraSql[0])*($obraSql[4]/100);
                            $total = $ganancia+$total;
                            echo "<tr>"
                            ."<td>".$obraSql[1]."</td>"
                            ."<td>".$obraSql[2]."</td>"
                            ."<td>".$obraSql[0]."</td>"
                            ."<td>".$ganancia."</td>"
                            ."</tr>";
                        }
                    }else
                    {
                        echo 'sin datos';
                    }
                    '</table>';

                echo 'Ganancia total: $'.$total.'<br>';
            break;
        case 'ProductividadEmpleado' :
            $fechaInicio = $_POST['FechaInicio'];
            $fechaFin    = $_POST['FechaFin'];
            $sql =   ObrasFinalizadasEntreFecha($fechaInicio,$fechaFin);
            echo   '    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Metrajes realizados por los empleados entre '.$fechaInicio.' y '.$fechaFin.' </h3>
            </div>
        </div>
        <!-- Table -->
        <table class="table">
            <tr>
                <th>Nombre Completo</th>
                <th>Metrajes Realizados</th>
            </tr>';
                    $rowcount = mysqli_num_rows($sql);
                    if ($rowcount>0) {
                        while($rs=mysqli_fetch_array($sql))
                        {
                            echo "<tr>"
                            ."<td>".'<a href="#" data-toggle="modal" data-target-id="'.$fechaInicio.'|'.$fechaFin.'" data-target-nombre="'.$rs[0].'" data-target="#ventanaMostrarProductividadPorObrero">'.$rs[0].'</a>'."</td>"
                            ."<td>".$rs[1]."</td>"
                            ."</tr>";
                        }
                    }
                    else
                    {
                        echo'<tr><td>No hay Informaciom</td></tr>';
                    }
                    echo'
        </table>
    </div>';
                    echo'
                            <script>
                                function MostrarProductividadPorObrero($nombreEmpleado,$fechaInicio,$fechaFin) {
                                //  function MostrarProductividadPorObrero($nombreEmpleado) {
                                    $("#ventanaMostrarObraBody").html("");
                                    var nombreEmpleado = $nombreEmpleado;
                                    var fechaInicio = $fechaInicio;
                                    var fechaFin = $fechaFin;
                                    $.post("ajaxPersonal.php", //Required URL of the page on server
                                          { // Data Sending With Request To Server
                                              action: "MostrarProductividadPorObrero",
                                              nombreEmpleado: nombreEmpleado,
                                              fechaInicio: fechaInicio,
                                              fechaFin: fechaFin,
                                          },
                                    function (response, status) { // Required Callback Function
                                        $("#ventanaMostrarProductividadPorObreroBody").html(response);

                                    });
                                }


                                $("#ventanaMostrarProductividadPorObrero").on("show.bs.modal", function (e) {
                                $("#ventanaMostrarProductividadPorObreroBody").html("");
                                var nombreEmpleado = $(e.relatedTarget).data(\'target-nombre\');
                                var fechas = $(e.relatedTarget).data(\'target-id\');
                                var fecha = fechas.split("|");
                                $("#ventanaMostrarProductividadPorObreroTitle").html(\'<span class="label label-info">\' + nombreEmpleado +\'</span>\');
                                 MostrarProductividadPorObrero(nombreEmpleado,fecha[0],fecha[1]);
                                });
                            </script>

                            <!--VENTANA METRAJES ESTIMADOS-->
                                <div class="modal fade" tabindex="1" role="dialog" id="ventanaMostrarProductividadPorObrero">
                                    <div class="modal-dialog modal-lg"" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h4 class="modal-title" id="ventanaMostrarProductividadPorObreroTitle"></h4>
                                            </div>
                                            <div class="modal-body" id="ventanaMostrarProductividadPorObreroBody"></div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ';
            break;
    }
}
?>