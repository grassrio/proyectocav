<?php
/** Incluir la libreria PHPExcel */
require_once 'includes/PHPExcel.php';
require 'includes/ConsultasObra.php';

$nombreLicitacion = 'SC 1000';
$nombreInforme = 'VE 075';
$fecha = date("d/m/Y");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$mes = $meses[date('n')-1];
$zona = 'ZONA1';



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

    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columna,$fila)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
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


//Imprime la primera tabla
$objPHPExcel->setActiveSheetIndex(0)
->setCellValueByColumnAndRow(5,2, 'COMUNICADO DE CUMPLIDOS')
->setCellValueByColumnAndRow(5,4, 'Veredas')
->setCellValueByColumnAndRow(0,8, utf8_encode('CD Nº'))
->setCellValueByColumnAndRow(1,8, 'Listado')
->setCellValueByColumnAndRow(2,8, 'Mes')
->setCellValueByColumnAndRow(3,8, 'Fecha')
->setCellValueByColumnAndRow(0,9, $nombreLicitacion)
->setCellValueByColumnAndRow(1,9, $nombreInforme)
->setCellValueByColumnAndRow(2,9, $mes)
->setCellValueByColumnAndRow(3,9, $fecha)
;
pintar(0,8,'74CEA7');
pintar(1,8,'74CEA7');
pintar(2,8,'74CEA7');
pintar(3,8,'74CEA7');





//Array de idCotizaciones distintas con obras a procesar
$obrasInformarArray = array();
//Comienzo de donde imprime el header
$filaHeaderObra = 11;


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
            array_push($headerObras,array('Header' => $rubroDinamico[NombreRubro],'Unidad' => $rubroDinamico[Unidad]));
        }
        //-------------------------------------
        array_push($headerObras,array('Header' => "Observaciones",'Unidad' => ""));

        $i=0;
        foreach($headerObras as $llave => $header){
            $columna = $i;
            $titulo=$header[Header];
            $unidad=$header[Unidad];
            if ($unidad!=""){
                $titulo = $titulo." ".$unidad ;
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columna,($filaHeaderObra-1),utf8_encode($titulo));
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($columna)->setAutoSize(true);
            pintar($columna,($filaHeaderObra-1),'74CEA7');
            bordear($columna,($filaHeaderObra-1));
            $i++;
        }


        $cantidadRubrosDinamicos = count($rubrosDinamicosArray);
        $numeroColumnaObservacion = $cantidadHeadersPreviosDinamico + $cantidadRubrosDinamicos;
        for($i=0;$i<count($obrasPorCotizacion);$i++){

            $obra = $obrasPorCotizacion[$i];
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,($filaHeaderObra+$i),utf8_encode($obra[Nombre]));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,($filaHeaderObra+$i),utf8_encode($obra[fechaRecibido]));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,($filaHeaderObra+$i),utf8_encode($obra[Direccion]));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,($filaHeaderObra+$i),utf8_encode($obra[numeroPuerta]));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,($filaHeaderObra+$i),utf8_encode($obra[Esquina1]));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,($filaHeaderObra+$i),utf8_encode($obra[Esquina2]));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,($filaHeaderObra+$i),utf8_encode("zonita"));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,($filaHeaderObra+$i),utf8_encode($obra[Estado]));
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
                }
            }



            //-------
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($numeroColumnaObservacion,($filaHeaderObra+$i),utf8_encode($obra[Observacion]));

        }//Termina de imprimir las obras y metrajes ejecutados

        $filaParaTotales = $filaHeaderObra + count($obrasPorCotizacion) + 2;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,($filaParaTotales), 'Subtotal');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,($filaParaTotales+1), 'Precio unitario');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,($filaParaTotales+2), 'Importe');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,($filaParaTotales+3), 'Total');

        for($i=($cantidadHeadersPreviosDinamico+1);$i<=($cantidadHeadersPreviosDinamico+$cantidadRubrosDinamicos);$i++){
            $colLetra=chr(64 + $i);
            $expresionSuma='=sum('.$colLetra.$filaHeaderObra.':'.$colLetra.($filaHeaderObra + count($obrasPorCotizacion) - 1).')';

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($i-1),$filaParaTotales, $expresionSuma);
            pintar(($i-1),$filaParaTotales,'CEA774');
        }


        //Terminan las obras de este idCotizacion y modifica el comienzo del header para otras cotizaciones
        $filaHeaderObra = 25;

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