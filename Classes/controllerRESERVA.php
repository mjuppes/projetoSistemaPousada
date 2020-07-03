<?php require_once('modelRESERVA.php');?>
<?php
class  controllerRESERVA
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerRESERVA($action,$arrDados=false,$where=false)
	{
		$this->command = new RESERVA();

		switch($action)
		{
			case 'lastIdreserva':
				$this->resposta = $this->command->lastIdreserva();
			break;
			case 'insert':
				$this->resposta = $this->command->insert($arrDados);
				break;
			case 'update':
				$this->resposta = $this->command->update($arrDados);
				break;
			case 'delete':
				$this->resposta = $this->command->delete($arrDados);
				break;
			case 'selectReserva':
				$this->arrResposta = $this->command->selectReserva($arrDados,$where);
				break;
			case 'selectReservaHospede':
				$this->arrResposta = $this->command->selectReservaHospede($arrDados);
				break;
			case 'selectDadosJsonReserva':
				$this->resposta = $this->command->selectDadosJsonReserva($arrDados['idreserva']);
				break;
			case 'selectHistorico':
				$this->arrResposta = $this->command->selectHistorico($arrDados);
				break;
			case 'verificaPeriodo':
				$this->resposta = $this->command->verificaPeriodo($arrDados["idquarto"],$arrDados["datainicial"],$arrDados["datafinal"]);
				break;
			case 'selectVendasReserva':
				$this->arrResposta = $this->command->selectVendasReserva($arrDados["idhospede"]);
				break;
			case 'selectGraficoQuarto':
				if(isset($arrDados['filtro']) && $arrDados['filtro'] == true)
					$this->arrResposta = $this->command->selectGraficoQuarto($where);
				else
					$this->arrResposta = $this->command->selectGraficoQuarto();
				break;
			case 'selectHistoricoReserva':
				if(!empty($where))
					$this->arrResposta = $this->command->selectHistoricoReserva($arrDados['idhospede'],$where);
				else
					$this->arrResposta = $this->command->selectHistoricoReserva($arrDados['idhospede']);
				break;
			case 'selectReservaAndamento':
				$this->arrResposta = $this->command->selectReservaAndamento();
				break;
			case 'selectVendaPorHospede':
				if($where)
					$this->arrResposta = $this->command->selectVendaPorHospede($where);
				else
					$this->arrResposta = $this->command->selectVendaPorHospede();
				break;
			case 'descontaReserva':
				$this->resposta = $this->command->descontaReserva($arrDados);
				break;
			case 'verificaDesconto':
				$this->resposta = $this->command->verificaDesconto($arrDados['idreserva']);
			break;
			case 'selectConsumoVenda':
				if($where)
					$this->arrResposta = $this->command->selectConsumoVenda($where);
				else
					$this->arrResposta = $this->command->selectConsumoVenda();
				break;
			break;
			case 'somaValorDiaria':
				$this->resposta = $this->command->somaValorDiaria($arrDados['idreserva']);
			break;
			case 'somaConsumoRel':
				$this->resposta = $this->command->somaConsumoRel($arrDados['idreserva']);
			break;
			case 'somaDescontoRel':
				$this->resposta = $this->command->somaDescontoRel($arrDados['idreserva']);
			break;
			case 'somaTotalRel':
				$this->resposta = $this->command->somaTotalRel($arrDados['idreserva']);
			break;
			case 'selectRelatorioGeral':
				if(empty($where))
					$this->arrResposta = $this->command->selectRelatorioGeral();
				else
					$this->arrResposta = $this->command->selectRelatorioGeral($where);
			break;
			case 'selectRelatorioGeralTotal':
				if(empty($where))
					$this->arrResposta = $this->command->selectRelatorioGeralTotal();
				else
					$this->arrResposta = $this->command->selectRelatorioGeralTotal($where);
			break;
			case 'selectGraficoFatAnual':
				if(empty($where))
					$this->arrResposta = $this->command->selectGraficoFatAnual();
				else
					$this->arrResposta = $this->command->selectGraficoFatAnual($where);
			break;
			case 'insert_massive':
				$this->resposta = $this->command->insert_massive($arrDados);
			break;
			case 'insert_last_id':
				$this->arrResposta = $this->command->insert_last_id($arrDados);
			break;
		}
	}
}
?>