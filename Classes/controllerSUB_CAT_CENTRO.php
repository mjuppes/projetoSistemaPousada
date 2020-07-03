<?php require_once('modelSUB_CAT_CENTRO.php');?>
<?php
class  controllerSUB_CAT_CENTRO
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerSUB_CAT_CENTRO($action,$arrDados=false,$where=false)
	{
		$this->command = new SUB_CAT_CENTRO();

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
		}
	}
}
?>