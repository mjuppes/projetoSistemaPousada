<?php require_once('modelPAGAMENTO.php');?>
<?php
class  controllerPAGAMENTO
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerPAGAMENTO($action,$arrDados=false,$where=false)
	{
		$this->command = new PAGAMENTO();

		switch($action)
		{
			case 'select':
				if($where)
					$this->arrResposta = $this->command->select($where);
				else
					$this->arrResposta = $this->command->select();
			break;
			case 'selectDadosJson':
				$this->resposta = $this->command->selectDadosJson($arrDados['idpagamento']);
			break;
			case 'insert':
				$this->resposta = $this->command->insert($arrDados);
			break;
			case 'update':
				$this->resposta = $this->command->update($arrDados);
			break;
			case 'delete':
				$this->resposta = $this->command->delete($arrDados['idpagamento']);
			break;
			case 'selectTotal':
				if($where)
					$this->arrResposta = $this->command->selectTotal($where);
				else
					$this->arrResposta = $this->command->selectTotal();
			break;
			case 'verificaPendencia':
				$this->resposta = $this->command->verificaPendencia($arrDados['idreserva']);
			break;
			case 'somaPagamentoRel':
				$this->resposta = $this->command->somaPagamentoRel($arrDados['idreserva']);
			break;
			case 'totPagamentoRel':
				$this->resposta = $this->command->totPagamentoRel($arrDados['idreserva']);
			break;
			case 'selectTableRelatorioDiscriminado':
				if($where)
					$this->arrResposta = $this->command->selectTableRelatorioDiscriminado($where);
				else
					$this->arrResposta = $this->command->selectTableRelatorioDiscriminado();
			break;
			case 'selectTableRelatorioDiscriminadoTotal':
				if($where)
					$this->arrResposta = $this->command->selectTableRelatorioDiscriminadoTotal($where);
				else
					$this->arrResposta = $this->command->selectTableRelatorioDiscriminadoTotal();
			break;
			case 'insert_last_id':
				$this->arrResposta = $this->command->insert_last_id($arrDados);
			break;
			case 'selectTipoPagamento':
				if($where)
					$this->arrResposta = $this->command->selectTipoPagamento($where);
				else
					$this->arrResposta = $this->command->selectTipoPagamento();
			break;
		}
	}
}
?>