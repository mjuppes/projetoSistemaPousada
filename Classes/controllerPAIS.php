<?php require_once('modelPAIS.php');?>
<?php
class  controllerPAIS
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerPAIS($action,$arrDados=false)
	{
		$this->command = new PAIS();

		switch($action)
		{
			case 'select':
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