<?php require_once('modelCENTRO_CUSTO.php');?>
<?php
class  controllerCENTRO_CUSTO
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerCENTRO_CUSTO($action,$arrDados=false,$where=false)
	{
		$this->command = new CENTRO_CUSTO();

		switch($action)
		{
			case 'select':
				if(empty($where))
					$this->arrResposta = $this->command->select();
				else
					$this->arrResposta = $this->command->select($where);
			break;
			case 'selectDadosJson':
				$this->resposta = $this->command->selectDadosJson($arrDados['id_centro_custo']);
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
			case 'insert_last_id':
				$this->arrResposta = $this->command->insert_last_id($arrDados);
			break;
		}
	}
}
?>