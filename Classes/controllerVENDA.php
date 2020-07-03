<?php require_once('modelVENDA.php');?>
<?php
class  controllerVENDA
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerVENDA($action,$arrDados=false,$where=false)
	{
		$this->command = new VENDA();

		switch($action)
		{
			case 'insert':
				$this->resposta = $this->command->insert($arrDados);
				break;
			case 'selectVendas':
				if(empty($where))
					$this->arrResposta = $this->command->selectVendas();
				else
					$this->arrResposta = $this->command->selectVendas($where);
			break;
			case 'selectDadosVenda':
				$this->resposta = $this->command->selectDadosJsonVenda($arrDados['idvenda']);
			break;
			case 'update':
				$this->resposta = $this->command->update($arrDados);
			break;
			case 'delete':
				$this->resposta = $this->command->delete($arrDados['idvenda']);
			break;
			case 'selectHistoricoHospede':
				$this->arrResposta = $this->command->selectHistoricoHospede($arrDados['idvenda']);
			break;
			case 'selectHistoricoVenda':
			if(!empty($where))
					$this->arrResposta = $this->command->selectHistoricoVenda($arrDados['idhospede'],$where);
				else
					$this->arrResposta = $this->command->selectHistoricoVenda($arrDados['idhospede']);
			break;
			case 'selectVendasTotal':
				if(!empty($where))
					$this->arrResposta = $this->command->selectVendasTotal($where);
				else
					$this->arrResposta = $this->command->selectVendasTotal();
				break;
			case 'insert_massive':
				$this->resposta = $this->command->insert_massive($arrDados);
			break;
		}
	}
}
?>