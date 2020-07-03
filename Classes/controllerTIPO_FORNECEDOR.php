<?php require_once('modelTIPO_FORNECEDOR.php');?>
<?php
class  controllerTIPO_FORNECEDOR
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerTIPO_FORNECEDOR($action,$arrDados=false,$where=false)
	{
		$this->command = new TIPO_FORNECEDOR();

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