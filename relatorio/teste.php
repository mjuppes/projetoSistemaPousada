<?php session_start(); 
include('../CONFIG/config.php');
include('../'.DIR_DAO);
include('../'.DIR_MPDF.'mpdf.php');
include('../'.DIR_ACTIONS.'genericFunction.php');

$mpdf = new mPDF();

$tabela = "<img src='logo1.jpg' width='90' /> ";

$mpdf->WriteHTML($tabela);
$mpdf->Output();
exit;
?>
