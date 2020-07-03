<?php require_once('modelCHAMADO.php');?>
<?php
class  controllerCHAMADO
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerCHAMADO($action,$arrDados=false)
	{
		$this->command = new CHAMADO();

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