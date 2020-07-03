<?php session_start(); 
include('../CONFIG/config.php');
include('../'.DIR_DAO);
include('../'.DIR_MPDF2.'mpdf.php');
include('../'.DIR_ACTIONS.'genericFunction.php');
include('../'.DIR_CLASSES.'controllerMOV_ESTOQUE.php');
include('../'.DIR_CLASSES.'controllerPRODUTOS.php');


$mpdf = new mPDF('utf-8', 'A4-L'); 
switch($_GET['rel'])
{
	case 'relMovEstoque':

	if($_GET['formSelectTipo'] == 1)
	
		if(isset($_GET['formSelectProduto']))
		{
			$where = "id_produto=".$_GET['formSelectProduto'];
			$controllerPRODUTOS = new controllerPRODUTOS('selectEstoqueAtual',false,$where);
		}
		else
			$controllerPRODUTOS = new controllerPRODUTOS('selectEstoqueAtual');
		dump($controllerPRODUTOS->arrResposta);
		return;
		
	
		if(isset($_GET['formSelectProduto']) && !empty($_GET['formSelectProduto']))
		{
			$where = "id_produto=".$_POST['formSelectProduto'];
			$controllerMOV_ESTOQUE = new controllerMOV_ESTOQUE('select',false,$where);
		}
		else
			$controllerMOV_ESTOQUE = new controllerMOV_ESTOQUE('select');

		$html .= "<table width='100%'>";
		$html .= "	<thead>";
		$html .= "		<tr>";
		$html .= "			<td width='12,5%' style='background-color:#ddd;text-align: left;'>";
		$html .= "				<b>Produto</b>";
		$html .= "			</td>";
		$html .= "			<td width='12,5%' style='background-color:#ddd;text-align: left;'>";
		$html .= "				<b>Data da Movimentação</b>";
		$html .= "			</td>";
		$html .= "			<td width='12,5%' style='background-color:#ddd;text-align: left;'>";
		$html .= "				<b>Tipo Movimentação</b>";
		$html .= "			</td>";
		$html .= "			<td width='12,5%' style='background-color:#ddd;text-align: left;'>";
		$html .= "				<b>Tipo</b>";
		$html .= "			</td>";
		$html .= "			<td width='12,5%' style='background-color:#ddd;text-align: left;'>";
		$html .= "				<b>Quantidade</b>";
		$html .= "			</td>";
		$html .= "			<td width='12,5%' style='background-color:#ddd;text-align: left;'>";
		$html .= "				<b>Valor Atual</b>";
		$html .= "			</td>";
		$html .= "			<td width='12,5%' style='background-color:#ddd;text-align: left;'>";
		$html .= "				<b>Total</b>";
		$html .= "			</td>";
		$html .= "			<td width='12,5%' style='background-color:#ddd;text-align: left;'>";
		$html .= "				<b>Observação</b>";
		$html .= "			</td>";
		$html .= "		</tr>";
		$html .= "	</thead>";
		$html .= "	<tbody>";

		foreach($controllerMOV_ESTOQUE->arrResposta as $dados)
		{
			$html .= "	<tr>";
			$html .= "		<td width='25%' style='text-align: left;'>";
			$html .= "			$dados[nomeproduto]";
			$html .= "		</td>";
			$html .= "		<td width='20%' style='text-align: left;'>";
			$html .= "			$dados[data_movimentacao]";
			$html .= "		</td>";
			$html .= "		<td width='20%' style='text-align: left;'>";
			$html .= "			$dados[tipo_mov]";
			$html .= "		</td>";
			$html .= "		<td width='10%' style='text-align: left;'>";
			$html .= "			$dados[tipo_tab]";
			$html .= "		</td>";
			$html .= "		<td width='12,5%' style='text-align: left;'>";
			$html .= "			$dados[quantidade]";
			$html .= "		</td>";
			$html .= "		<td width='7,5%' style='text-align: left;'>";
			$html .= "			$dados[valor_atual]";
			$html .= "		</td>";
			$html .= "		<td width='12,5%' style='text-align: left;'>";
			$html .= "			$dados[valor_total_compra]";
			$html .= "		</td>";
			$html .= "		<td width='12,5%' style='text-align: left;'>";
			$html .= "			$dados[observacao]</b>";
			$html .= "		</td>";
			$html .= "	</tr>";
		}
		
		$html .= "	</tbody>";
$html .= "</table>";
$html = utf8_encode($html);

	break;
	
	default:
}
//$mpdf=new mPDF();
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;
?>