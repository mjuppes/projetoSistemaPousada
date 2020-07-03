<?php
require('../fpdf.php');

/*define("pasta_arquivo", "../fotos/");*/

/*$id_busca = $_GET['id'];

$SQL_busca_dados = @Query ("
	
");

$busca_dados = fetch_array($SQL_busca_dados);
*/

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);



$Y = 15;
$X = 0;

$pdf->SetAutoPageBreak(false);


$pdf->SetFillColor(79,98,40);

$pdf->SetFont('Arial','B',9);
$pdf->Text(85+$X, 18+$Y, 'LOCALIZAÇÃO:');
$pdf->SetFont('Arial','',10);
$pdf->SetXY(20+$X,14+$Y); $pdf->MultiCell(155,6,"",1,"J",false);

/*------------------------------------------------------------------------------------------------*/
#  RETANGULOS 
$pdf->SetFont('Arial','',9);
$pdf->Text(21+$X,24+$Y, 'Setor:');
$pdf->Text(52+$X,24+$Y, 'Logradouro:');
$pdf->Text(132+$X,24+$Y,'Trecho:');
#retorno
$pdf->SetFont('Arial','',10);
$pdf->SetXY(20+$X,20+$Y); $pdf->Cell(31,6,"",1,"C",false,"");
$pdf->SetXY(51+$X,20+$Y); $pdf->Cell(80,6,"",1,"L",false,"");
$pdf->SetXY(131+$X,20+$Y);$pdf->Cell(44,6,"",1,"C",false,"");

/* -------------------------------------------------------------------------------------------------- */

#2º LINHA

#label
$pdf->SetFont('Arial','B',9);
$pdf->Text(84+$X,32+$Y,'SERVIÇO:');
#retorno
$pdf->SetFont('Arial','',10);
$pdf->SetXY(20+$X,26+$Y); $pdf->Cell(155,12,"",1,"J",false);

/*------------------------------------------------------------------------------------------------*/

#3º LINHA

#  AÇÕES PREVISTAS

#label
$pdf->SetFont('Arial','',8);
$pdf->Text(21+$X,42+$Y,'Programa:');
#retorno
$pdf->SetFont('Arial',"",8);
$pdf->SetXY(20+$X,38+$Y); $pdf->Cell(155,6,"",1,"J",false);

# REGISTROS FOTOGRÁFICOS
$posicao = $marg_left;
$height  = 67;
$pdf->SetFont('Arial','B',8);
$pdf->Rect($posicao+=131+$X,43+$Y,115,$height,'D');
$pdf->Text(195+$X,47+$Y, 'Registro Fotográficos:');

/*----------------------------------------------------------------------------------------------------*/

#4º LINHA

#retorno
/*$pdf->image(pasta_arquivo.$busca_dados[registro_fotografico],152+$X,50+$Y,112,48,'JPG');*/

$height  = 10;
$pdf->Rect(151+$X,43+$Y,115,6,'D');
$pdf->Rect(151+$X,100+$Y,115,$height,'D');/* Legenda Fotográfica Área */
#label
$pdf->SetFont('Arial','B',8);
$pdf->Text(152+$X,104+$Y,'Legenda:');
#retorno
$pdf->SetFont('Arial',"",8);
$pdf->SetXY(170+$X,101+$Y); $pdf->MultiCell(93,4,"$busca_dados[legenda_foto]",0,"J",false);

/*-----------------------------------------------------------------------------------------------------*/
	
#5º LINHA
# DATA VISTORIA / REGISTRO FOTOGRAFICO
$posicao = $marg_left;
$height  = 7;
$pdf->Rect($posicao+$X,115+$Y,131,$height,'D');/* data da vistoria */
$pdf->Rect($posicao+=131+$X,115+$Y,115,$height,'D');/* registro fotografico */
#label
$pdf->SetFont('Arial','B',8);
$pdf->Text(21+$X,120+$Y,'Data Vistoria:');
$pdf->Text(195+$X,120+$Y,'Registro Fotográficos:');
#retorno
$pdf->SetFont('Arial',"",8);
$pdf->SetXY(45+$X,115+$Y); $pdf->Cell(100,$height+0.5,"$busca_dados[dataVistoria]",0,"C",false,"");										
										
										
/*---------------------------------------------------------------------------------------------------*/
										
# 6º LINHA
# OBESERVAÇÕES 										

$posicao = $marg_left;
$height  = 63;
$pdf->Rect($posicao+$X,122+$Y,131,$height,'D');
#label
$pdf->SetFont('Arial','B',8);
$pdf->Text(21+$X,127+$Y,'Observações:');
#retorno
$pdf->SetFont('Arial','',8);
$pdf->SetXY(22+$X,130+$Y); $pdf->MultiCell(122,4,"$busca_dados[observacao]",0,"J",false);

# IMAGEM ACOMPANHAMENTO 
$pdf->Rect($posicao+=131+$X,122+$Y,115,$height,'D');/* Faz parte do registro fotográfico */
/*$pdf->image(pasta_arquivo.$busca_dados[registros_fotograficos],152+$X,124+$Y,112,50,'JPG');*/

# LEGENDA FOTOGRÁFICA ACOMPANHAMENTO						
$height  = 10;
$pdf->Rect(151+$X,175+$Y,115,$height,'D');
#label
$pdf->SetFont('Arial','B',8);
$pdf->Text(152+$X,179+$Y,'Legenda:');
#retorno
$pdf->SetFont('Arial',"",8);
$pdf->SetXY(170+$X,176+$Y); $pdf->MultiCell(94,4,"$busca_dados[legendaAcomp]",0,"J",false);

$pdf->Output();
?>
