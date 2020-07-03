<?php session_start(); 
include('../CONFIG/config.php');
include('../'.DIR_DAO);
include('../'.DIR_MPDF.'mpdf.php');
include('../'.DIR_ACTIONS.'genericFunction.php');
include('../'.DIR_CLASSES.'controllerRESERVA.php');
include('../'.DIR_CLASSES.'controllerHOSPEDE.php');
include('../'.DIR_CLASSES.'controllerPAGAMENTO.php');


$where = " and t.idreserva  = ".$_GET['idreserva'];

$tabela = "";
$tabela.="<style>
			table,thead
			{
				border:1px solid black;
			}
			img
			{
				opacity:0.0;
				filter:alpha(opacity=40); /* For IE8 and earlier */
				margin-left: 90%;
			}
		   </style>";

$arr = array("idhospede"=>$_GET['idhospede']);

$controllerHOSPEDE = new controllerHOSPEDE('selectRelHospede',$arr);
$tabela .="<html><head></head><body>
 <table width='100%' ><thead >";
	$tabela.="<tr class='table fundo'>";
		$tabela.= utf8_encode("<th style='text-align: center;' colspan='9'>".utf8_encode("Informacoes do hospede")."</th>");
	$tabela.="</tr>";
	$tabela.="<tr style='background-color: #DCDCDC'>";
		$tabela.="<th style='font-size:80%' width='20%' align='center'>Nome</th>";
		$tabela.="<th style='font-size:80%' width='5%' align='center'>Rg</th>";
		$tabela.="<th style='font-size:80%' width='5%' align='center'>Cpf</th>";
		$tabela.="<th style='font-size:80%' width='15%' align='center'>Nome da empresa</th>";
		$tabela.="<th style='font-size:80%' width='10%' align='center'>CNPJ</th>";
		$tabela.="<th style='font-size:80%' width='20%' align='center'>Cidade</th>";
		$tabela.="<th style='font-size:80%' width='20%' align='center'>Estado</th>";
		$tabela.="<th style='font-size:80%' width='20%' align='center'>Telefone</th>";
		$tabela.="<th style='font-size:80%' width='25%' align='center'>Data de nascimento</th>";
$tabela.="</thead>";
$tabela.="<tbody>";

$i = 0;
foreach($controllerHOSPEDE->arrResposta as $dados)
{
		$tabela.="<tr>";
		$tabela.="<td align='center' style='font-size:80%'>".utf8_encode($dados['nome'])."</td>";
		$tabela.="<td align='center' style='font-size:80%'>$dados[rg]</td>";
		$tabela.="<td align='center' style='font-size:80%'>$dados[cpf] </td>";
		$tabela.="<td align='center' style='font-size:80%'>".utf8_encode($dados['nomeempresa'])."</td>";
		$tabela.="<td align='center' style='font-size:80%'>".utf8_encode($dados['cnpj'])."</td>";
		$tabela.="<td align='center' style='font-size:80%'>".utf8_encode($dados['nomecidade'])."</td>";
		$tabela.="<td align='center' style='font-size:80%'>".utf8_encode($dados['nomeestado'])." </td>";
		$tabela.="<td align='center' style='font-size:80%'>$dados[telefone] </td>";
		$tabela.="<td align='center' style='font-size:80%'>$dados[datanascimento] </td>";
		$tabela.="</tr>";
}
$tabela.="</tbody>";
$tabela.="</table><br>";


$controllerRESERVA = new controllerRESERVA('selectHistoricoReserva',$arr,$where);

if(!empty($controllerRESERVA->arrResposta))
{
	$tabela .="<table width='100%'>";
		$tabela .="<thead >";
			$tabela.="<tr class='fundo'>";
				$tabela.= utf8_encode("<th style='text-align: center;' colspan='6'>Reserva</th>");
			$tabela.="</tr>";
			$tabela.="<tr style='background-color: #DCDCDC'>";
				$tabela.="<th style='font-size:80%' width='30%' align='center'>Quarto</th>";
				$tabela.="<th style='font-size:80%' width='15%' align='center'>Data Inicial</th>";
				$tabela.="<th style='font-size:80%' width='10%' align='center'>Data Final</th>";
				$tabela.="<th style='font-size:80%' width='10%' align='center'>".utf8_encode("Opção")."</th>";
				//$tabela.="<th style='font-size:80%' width='20%' align='center'>Tipo de pagamento</th>";
				$tabela.="<th style='font-size:80%' width='20%' align='center'>".utf8_encode("Valor Diária")."</th>";
				$tabela.="<th style='font-size:80%' width='20%' align='center'>Total</th>";
				//$tabela.="<th style='font-size:80%' width='20%' align='center'>Restante</th>";
			$tabela.="</tr>";
		$tabela.="</thead>";
		$tabela.="<tbody>";

		$i = 0;
		foreach($controllerRESERVA->arrResposta as $dados)
		{
			if($i %2)
			{
				$tabela.="<tr style='background-color: #DCDCDC'>";
				$tabela.="<td style='font-size:80%' align='center'>".utf8_encode($dados['nomequarto'])."</td>";
				$tabela.="<td style='font-size:80%' align='center'>$dados[datainicial]</td>";
				$tabela.="<td style='font-size:80%' align='center'>$dados[datafinal] </td>";
				$tabela.="<td style='font-size:80%' align='center'>$dados[opcao] </td>";
				//$tabela.="<td style='font-size:80%' align='center'>$dados[tipopagamento] </td>";
				$tabela.="<td style='font-size:80%' align='center'>$dados[totreserv]</td>";
				$tabela.="<td style='font-size:80%' align='center'>$dados[calcreserv] </td>";
				//$tabela.="<td style='font-size:80%' align='center'>$dados[resto] </td>";
				$tabela.="</tr>";
			}
			else
			{
				$tabela.="<tr>";
				$tabela.="<tr>";
				$tabela.="<td style='font-size:80%' align='center'>".utf8_encode($dados['nomequarto'])."</td>";
				$tabela.="<td style='font-size:80%' align='center'>$dados[datainicial]</td>";
				$tabela.="<td style='font-size:80%' align='center'>$dados[datafinal] </td>";
				$tabela.="<td style='font-size:80%' align='center'>$dados[opcao] </td>";
				//$tabela.="<td style='font-size:80%' align='center'>$dados[tipopagamento] </td>";
				$tabela.="<td style='font-size:80%' align='center'>$dados[totreserv]</td>";
				$tabela.="<td style='font-size:80%' align='center'>$dados[calcreserv] </td>";
				//$tabela.="<td style='font-size:80%' align='center'>$dados[resto] </td>";
				$tabela.="</tr>";
			}
			$i++;
		}
		$tabela.="</tbody>";
	$tabela.="</table><br>";
}


$where = " r.idreserva = ".$_GET['idreserva'];

$controllerRESERVA = new controllerRESERVA('selectConsumoVenda',$arr,$where);

if(!empty($controllerRESERVA->arrResposta))
{
	$tabela .="<table width='100%'>";
		$tabela .="<thead >";
			$tabela.="<tr class='fundo'>";
				$tabela.= utf8_encode("<th style='text-align: center;'  style='font-size:80%' colspan='6'>Relatorio de consumo e servico</th>");
			$tabela.="</tr>";
			$tabela.="<tr style='background-color: #DCDCDC'>";
				$tabela.="<th  style='font-size:80%' width='10%' align='center'>Categoria</th>";
				$tabela.="<th style='font-size:80%' width='10%' align='center'>Produto</th>";
				$tabela.="<th style='font-size:80%' width='5%' align='center'>Quantidade</th>";
				$tabela.="<th style='font-size:80%' width='20%' align='center'>Valor total</th>";
				$tabela.="<th style='font-size:80%' width='15%' align='center'>Data</th>";
				$tabela.="<th style='font-size:80%' width='35%' align='center'>Nome</th>";
			$tabela.="</tr>";
		$tabela.="</thead>";
		$tabela.="<tbody>";

			$i = 0;
			foreach($controllerRESERVA->arrResposta as $dados)
			{
				if($i %2)
				{
					$tabela.="<tr style='background-color: #DCDCDC'>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[nomecategoria]</td>";
					$tabela.="<td style='font-size:80%' align='center'>".utf8_encode($dados['nomeproduto'])."</td>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[qtd] </td>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[valor] </td>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[datavenda] </td>";
					$tabela.="<td style='font-size:80%' align='center'>".utf8_encode($dados['nome'])."</td>";
					$tabela.="</tr>";
				}
				else
				{
					$tabela.="<tr>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[nomecategoria]</td>";
					$tabela.="<td style='font-size:80%' align='center'>".utf8_encode($dados['nomeproduto'])."</td>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[qtd] </td>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[valor] </td>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[datavenda] </td>";
					$tabela.="<td style='font-size:80%' align='center'>".utf8_encode($dados['nome'])."</td>";
					$tabela.="</tr>";
				}
				$i++;
			}
		$tabela.="</tbody>";
	$tabela.="</table><br>";
}

$where = " idreserva = ".$_GET['idreserva'];

$controllerPAGAMENTO = new controllerPAGAMENTO('select',false,$where);
//return;
if(!empty($controllerPAGAMENTO->arrResposta))
{
	$tabela .="<table width='100%'>";
		$tabela .="<thead >";
			$tabela.="<tr class='fundo'>";
				$tabela.= utf8_encode("<th style='text-align: center;'  style='font-size:80%' colspan='5'>Pagamentos</th>");
			$tabela.="</tr>";
			$tabela.="<tr style='background-color: #DCDCDC'>";
				//$tabela.="<th  style='font-size:80%' width='10%' align='center'>Transferencia</th>";
				$tabela.="<th style='font-size:80%' width='10%' align='center'>Forma de pagamento</th>";
				$tabela.="<th style='font-size:80%' width='10%' align='center'>Data de pagamento</th>";
				$tabela.="<th style='font-size:80%' width='10%' align='center'>Tipo de pagamento</th>";
				$tabela.="<th style='font-size:80%' width='5%' align='center'>Valor</th>";
				$tabela.="<th style='font-size:80%' width='15%' align='center'>Responsavel pelo pagamento</th>";
			$tabela.="</tr>";
		$tabela.="</thead>";
		$tabela.="<tbody>";

		
		
		//dump($controllerPAGAMENTO->arrResposta);
		//return;
		
			$i = 0;
			foreach($controllerPAGAMENTO->arrResposta as $dados)
			{
			
				$transferencia = $dados['transferencia'];
			
				/*if($transferencia == 1)
					$transferencia = "Cartão débito - Visa";
				if($transferencia == 2)
					$transferencia = "Cartão débito - Master";
				if($transferencia == 3)
					$transferencia = "Depósito";
				if($transferencia == 4)
					$transferencia = "Cartão de crédito - Visa";
				if($transferencia == 5)
					$transferencia = "Cartão de crédito - Master";
				if($transferencia == 6)
					$transferencia = "Dinheiro";
				if($transferencia == 7)
					$transferencia = "Depósito";
				*/
				
				if($i %2)
				{
					$tabela.="<tr style='background-color: #DCDCDC'>";
					//$tabela.="<td style='font-size:80%' align='center'>".utf8_encode($transferencia)."</td>";
					$tabela.="<td style='font-size:80%' align='center'>".($dados['dpatensipado'])."</td>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[datapagamento] </td>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[transferencia] </td>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[valor] </td>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[resp] </td>";
					$tabela.="</tr>";
				}
				else
				{
					$tabela.="<tr>";
					//$tabela.="<td style='font-size:80%' align='center'>".utf8_encode($transferencia)."</td>";
					$tabela.="<td style='font-size:80%' align='center'>".($dados['dpatensipado'])." </td>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[datapagamento] </td>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[transferencia] </td>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[valor] </td>";
					$tabela.="<td style='font-size:80%' align='center'>$dados[resp] </td>";
					$tabela.="</tr>";
				}
				$i++;
			}
		$tabela.="</tbody>";
	$tabela.="</table>
	<br>";
}

$arr = array("idreserva"=>$_GET['idreserva']);

$controllerRESERVA = new controllerRESERVA('somaValorDiaria',$arr);
$valorTotalDiarias = $controllerRESERVA->resposta;

$controllerRESERVA = new controllerRESERVA('somaConsumoRel',$arr);
$valorConsumo = $controllerRESERVA->resposta;
if(empty($valorConsumo))
	$valorConsumo = "0,0";

$controllerPAGAMENTO = new controllerPAGAMENTO('somaPagamentoRel',$arr);
$totalPagamento = $controllerPAGAMENTO->resposta;

$controllerPAGAMENTO = new controllerPAGAMENTO('totPagamentoRel',$arr);
$valorTotPagar = $controllerPAGAMENTO->resposta;


$controllerRESERVA = new controllerRESERVA('somaDescontoRel',$arr);
$valorDesconto = $controllerRESERVA->resposta;

$controllerRESERVA = new controllerRESERVA('somaTotalRel',$arr);
$valorTotal = $controllerRESERVA->resposta;



	$tabela .="<table  width='100%'>";
		$tabela.="<tr style='background-color: #DCDCDC'>";
			$tabela.="<td  style='font-size:80%' width='10%' align='left'><strong>Diarias:</strong></td>";
			$tabela.="<td  style='font-size:80%' width='10%' align='left'>".$valorTotalDiarias."</td>";
		$tabela.="</tr>";
		$tabela.="<tr>";
			$tabela.="<td  style='font-size:80%' width='10%' align='left'><strong>Consumo e servico:</strong></td>";
			$tabela.="<td  style='font-size:80%' width='10%' align='left'>".$valorConsumo."</td>";
		$tabela.="</tr>";
		$tabela.="<tr style='background-color: #DCDCDC'>";
				$tabela.="<td  style='font-size:80%' width='10%' align='left'><strong>Pago:</strong></td>";
				$tabela.="<td  style='font-size:80%' width='10%' align='left'>".$totalPagamento."</td>";
			$tabela.="</tr>";
		$tabela.="<tr>";
			$tabela.="<td  style='font-size:80%' width='10%' align='left'><strong>Total a pagar:</strong></td>";
			$tabela.="<td  style='font-size:80%' width='10%' align='left'>".$valorTotPagar."</td>";
		$tabela.="</tr>";
		$tabela.="<tr>";
			$tabela.="<td  style='font-size:80%' width='10%' align='left'><strong>Desconto:</strong></td>";
			$tabela.="<td  style='font-size:80%' width='10%' align='left'>".$valorDesconto."</td>";
		$tabela.="</tr>";
		$tabela.="<tr style='background-color: #DCDCDC'>";
			$tabela.="<td  style='font-size:80%' width='10%' align='left'> </td>";
			$tabela.="<td  style='font-size:80%' width='10%' align='left'> </td>";
		$tabela.="</tr>";
		$tabela.="<tr >";
			$tabela.="<td  style='font-size:80%' width='10%' align='left'><strong>Total:</strong></td>";
			$tabela.="<td  style='font-size:80%' width='10%' align='left'>".$valorTotal."</td>";
		$tabela.="</tr>";
	$tabela.="</table>";

$mpdf=new mPDF();
$mpdf->WriteHTML($tabela);
$mpdf->Output();
exit;
?>
