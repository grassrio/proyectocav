<?php
require 'includes/ConsultasBaliza.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'devolverBaliza' :
            devolverBaliza($_POST['idBaliza']);
            break;
        case 'consultaBalizasProximoVencimiento' :
            $balizasProximoVencimiento=DevolverBalizasProximoVencimiento();
            $rowcount = mysqli_num_rows($balizasProximoVencimiento);
            echo $rowcount;
            break;
    }
}
?>