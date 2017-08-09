<?php
require_once 'includes/PHPExcel.php';
require 'includes/ConsultasObra.php';
require 'includes/ConsultasCotizacion.php';
require 'includes/ConsultaZonas.php';

$nombreInforme = 'VE 075';
$fecha = date("d/m/Y");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$mes = $meses[date('n')-1];


$idObrasInformar = '27,28,30';
$idObrasInformarArray = explode(',',$idObrasInformar);


// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

function pintar($columna,$fila,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columna,$fila)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => $color)));
}

function bordear($columna,$fila){
    global $objPHPExcel;
    $styleBordersArray = array(
    'borders' => array(
    'allborders' => array(
    'style' => PHPExcel_Style_Border::BORDER_THIN))
    );
    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($columna,$fila)->getStyle()->applyFromArray($styleBordersArray, True);
}

// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle($nombreInforme);

// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

//Dibuja el logo de cavanzadas
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('test_img');
$objDrawing->setDescription('test_img');
$objDrawing->setPath('img/logoca.png');
$objDrawing->setCoordinates('A1');
$objDrawing->setOffsetX(5);
$objDrawing->setOffsetY(5);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

//Imprime el titulo y subtitulo
$objPHPExcel->setActiveSheetIndex(0)
->setCellValueByColumnAndRow(5,2, 'COMUNICADO DE CUMPLIDOS')
->setCellValueByColumnAndRow(5,3, 'Veredas')
;



$styleBordersArray = array(
'borders' => array(
'allborders' => array(
'style' => PHPExcel_Style_Border::BORDER_THIN))
);


//Array de idCotizaciones distintas con obras a procesar
$obrasInformarArray = array();
//Comienzo de donde imprime el header
$filaHeaderInforme = 7;
$filaHeaderObra = 10;


foreach($idObrasInformarArray as $llave => $idObra)
{
    $obra = obtenerObra($idObra);
    $rsObra=mysqli_fetch_array($obra);
    if ($obrasInformarArray[$rsObra[idCotizacion]]==null){
        $obrasInformarArray[$rsObra[idCotizacion]] = array();
    }

    array_push($obrasInformarArray[$rsObra[idCotizacion]],$rsObra);
}

//obrasInformarArray[idCotizacion] ==> array con obras de esa cotizacion
foreach($obrasInformarArray as $idCotizacion=>$obrasPorCotizacion){
    //Para las obras de cada cotizacion distinta
    $sqlCotizacion = devolverCotizacion($idCotizacion);
    $rsCotizacion=mysqli_fetch_array($sqlCotizacion);
    $nombreLicitacion = $rsCotizacion[Nombre];
    //Imprime la primer tabla
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValueByColumnAndRow(0,$filaHeaderInforme, utf8_encode('CD Nº'))
    ->setCellValueByColumnAndRow(1,$filaHeaderInforme, 'Listado')
    ->setCellValueByColumnAndRow(2,$filaHeaderInforme, 'Mes')
    ->setCellValueByColumnAndRow(3,$filaHeaderInforme, 'Fecha')
    ->setCellValueByColumnAndRow(0,($filaHeaderInforme+1), $nombreLicitacion)
    ->setCellValueByColumnAndRow(1,($filaHeaderInforme+1), $nombreInforme)
    ->setCellValueByColumnAndRow(2,($filaHeaderInforme+1), $mes)
    ->setCellValueByColumnAndRow(3,($filaHeaderInforme+1), $fecha)
    ;
    bordear(0,$filaHeaderInforme);
    bordear(1,$filaHeaderInforme);
    bordear(2,$filaHeaderInforme);
    bordear(3,$filaHeaderInforme);
    pintar(0,$filaHeaderInforme,'74CEA7');
    pintar(1,$filaHeaderInforme,'74CEA7');
    pintar(2,$filaHeaderInforme,'74CEA7');
    pintar(3,$filaHeaderInforme,'74CEA7');
    bordear(0,($filaHeaderInforme+1));
    bordear(1,($filaHeaderInforme+1));
    bordear(2,($filaHeaderInforme+1));
    bordear(3,($filaHeaderInforme+1));
    //vamos a procesar todas las obras de cada cotizacion

    $rubrosDinamicosArray = array();
    $metrajesRealizadosArray = array();

    foreach($obrasPorCotizacion as $obra){
        $idObra = $obra[idObra];
        $metrajesRealizadosObra = metrajesRealizados($idObra);
        while($rsMetrajesRealizadosObra=mysqli_fetch_array($metrajesRealizadosObra)){
            //Verifica si el rubro ya esta en el array
            $colocar = true;
            foreach($rubrosDinamicosArray as $llave => $rubroDinamico){
                if ($rubroDinamico[NombreRubro]==$rsMetrajesRealizadosObra[NombreRubro]){
                    $colocar=false;
                }
            }
            if ($colocar==true){
                array_push($rubrosDinamicosArray,array('NombreRubro' =>$rsMetrajesRealizadosObra[NombreRubro],'Unidad' =>$rsMetrajesRealizadosObra[Unidad]));
            }
            array_push($metrajesRealizadosArray,array('idObra' => $rsMetrajesRealizadosObra[idObra],'NombreRubro' => $rsMetrajesRealizadosObra[NombreRubro],'MetrajeReal' => $rsMetrajesRealizadosObra[MetrajeReal],'Unidad' => $rsMetrajesRealizadosObra[Unidad]));
        }
    }


        $headerObras = array();
        $cantidadHeadersPreviosDinamico=8;
        array_push($headerObras,array('Header' => "Nº Obra",'Unidad' => ""));
        array_push($headerObras,array('Header' => "Fecha recibido",'Unidad' => ""));
        array_push($headerObras,array('Header' => "Dirección",'Unidad' => ""));
        array_push($headerObras,array('Header' => "Nº",'Unidad' => ""));
        array_push($headerObras,array('Header' => "1º Esquina",'Unidad' => ""));
        array_push($headerObras,array('Header' => "2º Esquina",'Unidad' => ""));
        array_push($headerObras,array('Header' => "Zona",'Unidad' => ""));
        array_push($headerObras,array('Header' => "Estado",'Unidad' => ""));

        //Coloco los headers del array dinamico
        foreach($rubrosDinamicosArray as $llave => $rubroDinamico){
            if ($rubroDinamico[Unidad]==""){
                array_push($headerObras,array('Header' => $rubroDinamico[NombreRubro],'Unidad' => "/u"));
            }else{
                array_push($headerObras,array('Header' => $rubroDinamico[NombreRubro],'Unidad' => $rubroDinamico[Unidad]));
            }

        }
        //-------------------------------------
        array_push($headerObras,array('Header' => "Observaciones",'Unidad' => ""));

        //Imprimo los headsrsObra con rubros dinamicos
        $i=0;
        foreach($headerObras as $llave => $header){
            $columna = $i;
            $titulo=$header[Header];
            $unidad=$header[Unidad];
            if ($unidad!=""){
                $titulo = $titulo." ".$unidad ;
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columna,($filaHeaderObra-1))->getAlignment()->setTextRotation(90);
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columna,($filaHeaderObra-1),utf8_encode($titulo));
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($columna)->setAutoSize(true);
            pintar($columna,($filaHeaderObra-1),'74CEA7');
            bordear($columna,($filaHeaderObra-1));
            $i++;
        }
        //Imprimo etiqueta cantidades
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cantidadHeadersPreviosDinamico,($filaHeaderObra-2), 'Cantidades');
        $cantidadRubrosDinamicos = count($rubrosDinamicosArray);
        $colLetraCantidades=chr(64 + ($cantidadHeadersPreviosDinamico+1));
        $colLetraFinalCantidades=chr(64 + ($cantidadHeadersPreviosDinamico+$cantidadRubrosDinamicos));
        pintar($cantidadHeadersPreviosDinamico,($filaHeaderObra-2),'74CEA7');
        $filasJuntasCantidades=$colLetraCantidades.($filaHeaderObra-2).':'.$colLetraFinalCantidades.($filaHeaderObra-2);
        $objPHPExcel->getActiveSheet()->mergeCells($filasJuntasCantidades);
        $objPHPExcel->getActiveSheet()->getStyle($filasJuntasCantidades)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
        //




        $numeroColumnaObservacion = $cantidadHeadersPreviosDinamico + $cantidadRubrosDinamicos;
        for($i=0;$i<count($obrasPorCotizacion);$i++){

            $obra = $obrasPorCotizacion[$i];
            $idZonaObra = $obra[idZona];
            $sqlZona = devolverZona($idZonaObra);
            $rsZona=mysqli_fetch_array($sqlZona);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,($filaHeaderObra+$i),utf8_encode($obra[Nombre]));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,($filaHeaderObra+$i),utf8_encode($obra[fechaRecibido]));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,($filaHeaderObra+$i),utf8_encode($obra[Direccion]));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,($filaHeaderObra+$i),utf8_encode($obra[numeroPuerta]));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,($filaHeaderObra+$i),utf8_encode($obra[Esquina1]));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,($filaHeaderObra+$i),utf8_encode($obra[Esquina2]));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,($filaHeaderObra+$i),utf8_encode($rsZona[Nombre]));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,($filaHeaderObra+$i),utf8_encode($obra[Estado]));
            for($h=0;$h<$cantidadHeadersPreviosDinamico;$h++){
                bordear($h,($filaHeaderObra+$i));
            }

            //Imprimimos los metrajes realizados de la obra
            foreach($metrajesRealizadosArray as $llave => $metrajeRealizado){
                if ($metrajeRealizado[idObra]==$obra[idObra]){
                    $key=-1;
                    foreach($rubrosDinamicosArray as $llave => $rubroDinamico){
                        if ($rubroDinamico[NombreRubro]==$metrajeRealizado[NombreRubro]){
                            $key=$llave;
                        }
                    }
                    $columnaImprimir = $cantidadHeadersPreviosDinamico+$key;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnaImprimir,($filaHeaderObra+$i),utf8_encode($metrajeRealizado[MetrajeReal]));
                    bordear($columnaImprimir,($filaHeaderObra+$i));
                }
            }



            //-------
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($numeroColumnaObservacion,($filaHeaderObra+$i),utf8_encode($obra[Observacion]));
            bordear($numeroColumnaObservacion,($filaHeaderObra+$i));

        }//Termina de imprimir las obras y metrajes ejecutados

        //Se imprimen los totales
        $filaParaTotales = $filaHeaderObra + count($obrasPorCotizacion) + 1;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($cantidadHeadersPreviosDinamico-1),($filaParaTotales), 'Subtotal $');
        pintar(($cantidadHeadersPreviosDinamico-1),$filaParaTotales,'CEA774');
        bordear(($cantidadHeadersPreviosDinamico-1),$filaParaTotales);

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($cantidadHeadersPreviosDinamico-1),($filaParaTotales+1), 'Precio unitario $/u');
        pintar(($cantidadHeadersPreviosDinamico-1),($filaParaTotales+1),'79d6ae');
        bordear(($cantidadHeadersPreviosDinamico-1),($filaParaTotales+1));

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($cantidadHeadersPreviosDinamico-1),($filaParaTotales+2), 'Importe $');
        pintar(($cantidadHeadersPreviosDinamico-1),($filaParaTotales+2),'CEA774');
        bordear(($cantidadHeadersPreviosDinamico-1),($filaParaTotales+2));

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($cantidadHeadersPreviosDinamico-1),($filaParaTotales+3), 'Total $');
        pintar(($cantidadHeadersPreviosDinamico-1),($filaParaTotales+3),'47b283');
        bordear(($cantidadHeadersPreviosDinamico-1),($filaParaTotales+3));
        //Imprime la formula para sumar los subtotales
        for($i=($cantidadHeadersPreviosDinamico+1);$i<=($cantidadHeadersPreviosDinamico+$cantidadRubrosDinamicos);$i++){
            $colLetra=chr(64 + $i);
            $expresionSuma='=sum('.$colLetra.$filaHeaderObra.':'.$colLetra.($filaHeaderObra + count($obrasPorCotizacion) - 1).')';

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($i-1),$filaParaTotales, $expresionSuma);
            pintar(($i-1),$filaParaTotales,'CEA774');
            bordear(($i-1),$filaParaTotales);
        }

        //Imprime los precios unitarios del rubro segun la cotizacion de estas obras
            $idRubrosql = obtenerRubro($idCotizacion);
            $rowcount = mysqli_num_rows($idRubrosql);
            if ($rowcount>0) {
                while($rsRubro=mysqli_fetch_array($idRubrosql))
                {
                    //Aca se tiene cada Rubro cotizado para estas obras
                    //Busco el numero de columna dinamico donde se importa el rubro
                    $key=-1;
                    foreach($rubrosDinamicosArray as $llave => $rubroDinamico){
                        if ($rubroDinamico[NombreRubro]==$rsRubro[nombreRubro]){
                            $key=$llave;
                        }
                    }
                    $columnaImprimir = $cantidadHeadersPreviosDinamico+$key;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnaImprimir,($filaParaTotales+1),$rsRubro[Precio]);
                    pintar($columnaImprimir,($filaParaTotales+1),'79d6ae');
                    bordear($columnaImprimir,($filaParaTotales+1));
                }
            }

        //Imprime la formula para calcular el importe
            for($i=($cantidadHeadersPreviosDinamico+1);$i<=($cantidadHeadersPreviosDinamico+$cantidadRubrosDinamicos);$i++){
                $colLetra=chr(64 + $i);
                $expresionMultiplicacion='=('.$colLetra.$filaParaTotales.'*'.$colLetra.($filaParaTotales+1).')';
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($i-1),($filaParaTotales+2), $expresionMultiplicacion);
                pintar(($i-1),($filaParaTotales+2),'CEA774');
                bordear(($i-1),($filaParaTotales+2));
            }

        //Imprime el resultado total
            pintar($cantidadHeadersPreviosDinamico,($filaParaTotales+3),'47b283');
            $colLetra=chr(64 + ($cantidadHeadersPreviosDinamico+1));
            $colLetraFinal=chr(64 + ($cantidadHeadersPreviosDinamico+$cantidadRubrosDinamicos));
            $expresionSumaTotal='=sum('.$colLetra.($filaParaTotales+2).':'.$colLetraFinal.($filaParaTotales+2).')';
            $filasJuntasTotal=$colLetra.($filaParaTotales+3).':'.$colLetraFinal.($filaParaTotales+3);
            $objPHPExcel->getActiveSheet()->mergeCells($filasJuntasTotal);
            $objPHPExcel->getActiveSheet()->getStyle($filasJuntasTotal)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($cantidadHeadersPreviosDinamico,($filaParaTotales+3), $expresionSumaTotal);

            $objPHPExcel->getActiveSheet()->getStyle($filasJuntasTotal)->applyFromArray($styleBordersArray, True);


        //Terminan las obras de este idCotizacion y modifica el comienzo del header para otras cotizaciones
            $filaHeaderInforme = ($filaParaTotales+5);
            $filaHeaderObra = ($filaHeaderInforme+3);

}










// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
$headerNombreDoc='Content-Disposition: attachment;filename="'.$nombreInforme.'.xlsx"';
header($headerNombreDoc);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>