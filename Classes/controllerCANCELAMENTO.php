<?php require_once('modelCANCELAMENTO.php');?>
<?php
class  controllerCANCELAMENTO
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerCANCELAMENTO($action,$arrDados=false,$where=false)
	{
		$this->command = new CANCELAMENTO();

		switch($action)
		{
			case 'select':
			if(!empty($where))
				$this->arrResposta = $this->command->select($where);
			else
				$this->arrResposta = $this->command->select();
			break;
			case 'selectDadosJson':
				$this->resposta = $this->command->selectDadosJson($arrDados);
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