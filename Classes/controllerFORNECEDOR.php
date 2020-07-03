<?php require_once('modelFORNECEDOR.php');?>
<?php
class  controllerFORNECEDOR
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerFORNECEDOR($action,$arrDados=false,$where=false)
	{
		$this->command = new FORNECEDOR();

		switch($action)
		{
			case 'select':
				if(empty($where))
					$this->arrResposta = $this->command->select();
				else
					$this->arrResposta = $this->command->select($where);
			break;
			case 'selectDadosJson':
				$this->resposta = $this->command->selectDadosJson($arrDados['id_fornecedor']);
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