<?php require_once('modelPESQUISA.php');?>
<?php
class  controllerPESQUISA
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerPESQUISA($action,$arrDados=false)
	{
		$this->command = new PESQUISA();

		switch($action)
		{
			case 'select':
				$this->arrResposta = $this->command->select();
			break;
			case 'selectDadosJson':
				$this->resposta = $this->command->selectDadosJson($arrDados['idpesquisa']);
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
			case 'lastIdPesquisa':
				$this->resposta = $this->command->lastIdPesquisa();
			break;
		}
	}
}
?>