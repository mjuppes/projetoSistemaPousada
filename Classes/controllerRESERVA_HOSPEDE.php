<?php require_once('modelRESERVA_HOSPEDE.php');?>
<?php
class  controllerRESERVA_HOSPEDE
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerRESERVA_HOSPEDE($action,$arrDados=false,$where=false)
	{
		$this->command = new RESERVA_HOSPEDE();

		switch($action)
		{
			case 'select':
				if(empty($where))
					$this->arrResposta = $this->command->select();
				else
					$this->arrResposta = $this->command->select($where);
			break;
			case 'selectDadosJson':
				$this->resposta = $this->command->selectDadosJson($arrDados['']);
			break;
			case 'insert':
				$this->resposta = $this->command->insert($arrDados);
			break;
			case 'insert_last_id':
				$this->resposta = $this->command->insert_last_id($arrDados);
			break;
			case 'update':
				$this->resposta = $this->command->update($arrDados);
			break;
			case 'delete':
				$this->resposta = $this->command->delete($arrDados);
			break;
			case 'insert_massive':
				$this->resposta = $this->command->insert_massive($arrDados);
			break;
		}
	}
}
?>