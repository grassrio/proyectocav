<?php
require 'includes/ConsultasCuadrilla.php';
require 'includes/ConsultasPersonal.php';

  if(isset($_POST['action']) && !empty($_POST['action'])) {
      $action = $_POST['action'];
      switch($action) {
          case 'nuevaCuadrilla' :
              AltaCuadrilla($_POST['Nombre']);
              break;
          case 'eliminarCuadrilla' :
              eliminarCuadrilla($_POST['Nombre']);
              break;
          case 'modificarCuadrilla' :
              modificarCuadrilla($_POST['idCuadrilla'],$_POST['Nombre']);
              break;
          case 'nuevoObrero':
              nuevoObreroCuadrilla($_POST['idCuadrilla'],$_POST['Porcentaje'],$_POST['Nombre']);
              break;
          case 'eliminarObrero' :
              $obero=obtenerObreroPorId($_POST['idObrero']);
              $rsobero=mysqli_fetch_array($obero);
              eliminarObreroCuadrilla($rsobero[NombreCompleto],$_POST['idCuadrilla']);
          case 'mostrarCuadrilla' :
              $idCuadrilla = $_POST['idCuadrilla'];
              $ObreroSql = obtenerObreros($idCuadrilla);
              $rowcount = mysqli_num_rows($ObreroSql);
              if ($rowcount>0) {
                  echo '<table class="table"><tr><th>Obreros</th><th>Porcentaje</th></tr>';
                  while($rs=mysqli_fetch_array($ObreroSql))
                  {
                      $nombre   =$rs[1];
                      $obrero = devolverObrero($nombre);
                      $rsObrero=mysqli_fetch_array($obrero);

                      echo '<tr><td>'.$rs[1].'</td>
<td>'.$rs[2].'</td>
<td><button onclick="EliminarObrero('.$rsObrero[0].','.$idCuadrilla.')" id="btnEliminarObrero" type="button" class="btn btn-default">
<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>
</tr>';
                  }
                  echo "</table>";
              }else{
                  echo "Sin Obreros";
              }
              echo '<br><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target-id="'.$idCuadrilla.'" data-target="#ventanaAgregarObrero" data-toggle="modal">Agregar obrero</button>';

              break;

      }
  }
?>