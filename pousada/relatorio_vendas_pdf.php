<?php
session_start();

include('../CONFIG/config.php');
include('../'.DIR_DAO);
include('../'.DIR_CLASSES.'controllerVENDA.php');
require('../funcoes/fpdf/fpdf.php');


$Bd = new Bd(CONEXAO);

class PDF extends FPDF 
{
	function Header()
	{
		$this->SetLineWidth(0.5);
		$h = 6;
		$this->SetMargins(30,25,20);
		$this->SetX(100);
		//$this->Image("../img/logo3.jpg",30,10,80,17,"jpg");
		$this->SetY(30);
	}
	function AcceptPageBreak(){
			
		return false;	
		
	}
}
$controllerVENDA = new controllerVENDA('selectVendas');

$pdf= new FPDF();

$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(40, 5, 'Nome');
$pdf->SetX(40);
$pdf->Cell(40, 5, 'Categoria');
$pdf->SetX(80);
$pdf->Cell(40, 5, 'Nome do produto');
$pdf->SetX(120);
$pdf->Cell(40, 5, 'Data da venda');
$pdf->SetX(160);
$pdf->Cell(40, 5, 'Valor');

foreach($controllerVENDA->arrResposta as $dados) 
{
	$pdf->ln();
	$pdf->SetFont('Arial', '', 7);
	$pdf->Cell(40, 5, $dados['nomehospede']);
	$pdf->SetX(40);
	$pdf->Cell(60, 5, $dados['nomecategoria']);
	$pdf->SetX(80);
	$pdf->Cell(40, 5, $dados['nomeproduto']);
	$pdf->SetX(120);
	$pdf->Cell(40, 5, $dados['datavenda']);
	$pdf->SetX(160);
	$pdf->Cell(40, 5, $dados['valor']);
}
$pdf->AddPage();
$pdf->Output();
?>