<?php session_start(); 
include('../CONFIG/config.php');
include('../'.DIR_DAO);
include('../'.DIR_MPDF.'mpdf.php');
include('../'.DIR_ACTIONS.'genericFunction.php');
include('../'.DIR_CLASSES.'controllerRESERVA.php');

	$where = "";


	if(!empty($where))
		$controllerRESERVA = new controllerRESERVA('selectRelatorioGeral',false,$where);
	else
		$controllerRESERVA = new controllerRESERVA('selectRelatorioGeral');

	for($i=0; $i<count($controllerRESERVA->arrResposta); $i++)
	{
		$controllerRESERVA->arrResposta[$i]['nome'] = utf8_encode($controllerRESERVA->arrResposta[$i]['nome']);
		$controllerRESERVA->arrResposta[$i]['nomequarto'] = utf8_encode($controllerRESERVA->arrResposta[$i]['nomequarto']);
	}
	

	$tabela = "";
	$tabela.="<style>
				table
				{
					border-collapse:collapse;
				}
				table, td, th
				{
					border:1px solid black;
				}
				.fundo
				{
					background-color:#DCDCDC
				}

				img
				{
					opacity:0.4;
					filter:alpha(opacity=40); /* For IE8 and earlier */
				}
			   </style>";

	$tabela .="<table id='curso' width='100%'>";
		$tabela .="<thead >";
			$tabela.="<tr class='fundo'>";
				$tabela.= utf8_encode("<th style='text-align: center;' colspan='10'>Relatorio de hóspedes</th>");
			$tabela.="</tr>";
			$tabela.="<tr>";
				$tabela.="<th width='30%' align='center'>Nome</th>";
				$tabela.="<th width='10%' align='center'>Quantidade de dias</th>";
				$tabela.="<th width='14%' align='center'>Valor da diaria</th>";
				$tabela.="<th width='14%' align='center'>Total de diarias</th>";
				$tabela.="<th width='16%' align='center'>Consumo</th>";
				$tabela.="<th width='12%' align='center'>Desconto</th>";
				$tabela.="<th width='12%' align='center'>Total</th>";
				$tabela.="<th width='12%' align='center'>Quarto</th>";
				$tabela.="<th width='12%' align='center'>Data inicial</th>";
				$tabela.="<th width='12%' align='center'>Data final</th>";
				$tabela.="</tr>";
		$tabela.="</thead>";
		$tabela.="<tbody>";

		$i = 0;
		foreach($controllerRESERVA->arrResposta as $dados)
		{
			if($i %2)
			{
				$tabela.="<tr style='background-color: #DCDCDC'>";
					$tabela.="<td align='center'>$dados[nome]</td>";
					$tabela.="<td align='center'>$dados[qtdDias]</td>";
					$tabela.="<td align='center'>$dados[valordiaria]</td>";
					$tabela.="<td align='center'>$dados[valordiarias]</td>";
					$tabela.="<td align='center'>$dados[valorconsumo]</td>";
					$tabela.="<td align='center'>$dados[desconto]</td>";
					$tabela.="<td align='center'>$dados[valgeral]</td>";
					$tabela.="<td align='center'>$dados[nomequarto]</td>";
					$tabela.="<td align='center'>$dados[datainicial]</td>";
					$tabela.="<td align='center'>$dados[datafinal]</td>";
				$tabela.="</tr>";
			}
			else
			{
				$tabela.="<tr>";
					$tabela.="<td align='center'>$dados[nome]</td>";
					$tabela.="<td align='center'>$dados[qtdDias]</td>";
					$tabela.="<td align='center'>$dados[valordiaria]</td>";
					$tabela.="<td align='center'>$dados[valordiarias]</td>";
					$tabela.="<td align='center'>$dados[valorconsumo]</td>";
					$tabela.="<td align='center'>$dados[desconto]</td>";
					$tabela.="<td align='center'>$dados[valgeral]</td>";
					$tabela.="<td align='center'>$dados[nomequarto]</td>";
					$tabela.="<td align='center'>$dados[datainicial]</td>";
					$tabela.="<td align='center'>$dados[datafinal]</td>";
				$tabela.="</tr>";
			}
			$i++;
		}
		$tabela.="</tbody>";
	$tabela.="</table>";

$mpdf=new mPDF();
$mpdf->WriteHTML($tabela);
$mpdf->Output();
exit;
?>