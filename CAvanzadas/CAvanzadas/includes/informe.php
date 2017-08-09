<?php
require('fpdf.php');
$obrasInformar = '27,28';
$obrasInformarArray = explode(',',$obrasInformar);
$nombreLicitacion = 'SC 1000';
$fecha = date("d/m/Y");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$mes = $meses[date('n')-1];
$zona = 'ZONA1';

class PDF extends FPDF
{
    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
    }


    function CabeceraPrincipal($header, $data)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(144,210,142);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        // Cabecera
        $this->SetFont('Arial','',10);
        for($i=0;$i<count($header);$i++)
            $this->Cell(25,7,$header[$i],1,0,'C',true);
        $this->Ln();

        // Datos
        $this->SetFillColor(224,235,255);
        $this->SetFont('Arial','',9);
        foreach($data as $row)
        {
            foreach($row as $col)
                $this->Cell(25,6,$col,1);
            $this->Ln();
        }
        // Línea de cierre
        $this->Cell(100,0,'','T');
    }

}



$pdf = new PDF('L','mm','A4');

$header = array('CD Nº', 'Listado', 'Mes', 'Fecha');
$linea = $nombreLicitacion.";"."VE075".";".$mes.";".$fecha;
$data = array();
$data[] = explode(';',trim($linea));
$pdf->AliasNbPages();
$pdf->AddPage();

// TITULO
// Logo
$pdf->Image('../img/logoca.png',10,8,33);
// Arial bold 15
$pdf->SetFont('Arial','U',11);
// Movernos a la derecha
$pdf->Cell(110);
// Título
$pdf->Cell(10,10,'COMUNICADO DE CUMPLIDOS');
$pdf->Ln(8);
$pdf->SetFont('Arial','U',9);
$pdf->Cell(130);
$pdf->Cell(10,10,$zona.' - Veredas');
// Salto de línea
$pdf->Ln(20);
// FIN TITULO

$pdf->CabeceraPrincipal($header,$data);
$pdf->Ln(3);

//CABECERA OBRAS
$headerObras = array();
array_push($headerObras,"Nº Obra");
array_push($headerObras,"Fecha recibido");
array_push($headerObras,"Dirección");
array_push($headerObras,"Nº");
array_push($headerObras,"1 Esquina");
array_push($headerObras,"2 Esquina");
array_push($headerObras,"Zona");
array_push($headerObras,"Estado");
array_push($headerObras,"Observaciones");


// Colores, ancho de línea y fuente en negrita
$pdf->SetFillColor(144,210,142);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(.3);
$pdf->SetFont('','B');
$pdf->SetFont('Arial','',10);
for($i=0;$i<count($headerObras);$i++){
    $tamaño =strlen($headerObras[$i]);
    $pdf->Cell(($tamaño*2),7,$headerObras[$i],1,0,'C',true);
}
$pdf->Ln();

$pdf->Output();







?>