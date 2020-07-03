<?php require_once('modelSUB_MENU.php');?>
<?php
class  controllerSUB_MENU
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerSUB_MENU($action,$arrDados=false,$where=false)
	{
		$this->command = new SUB_MENU();

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