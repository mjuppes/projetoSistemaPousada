<?php
require('../fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

$pdf->Cell(160,10,'LOCALIZAÇÃO',1,1,'C');

$pdf->Cell(15,10,'Setor:',1,0,'C');
$pdf->Cell(20,10,'Setor A:',1,0,'C');

$pdf->Cell(20,10,'Logradouro:',1,0,'C');
$pdf->Cell(70,10,'Av. Brasil',1,0,'C');

$pdf->Cell(15,10,'Trecho:',1,0,'C');
$pdf->Cell(20,10,'650089',1,1,'C');

$pdf->Cell(160,10,'SERVIÇO',1,1,'C');

$pdf->Cell(30,10,'Programa:',1,0,'C');
$pdf->Cell(130,10,'A - Pavimento',1,1,'C');

$pdf->Cell(30,10,'Sub-Programa:',1,0,'C');
$pdf->Cell(130,10,'A.1 - Pavimento Flexível',1,0,'C');

$pdf->Output();

?>
