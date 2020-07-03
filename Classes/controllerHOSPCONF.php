<?php require_once('modelHOSPCONF.php');?>
<?php
class  controllerHOSPCONF
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerHOSPCONF($action,$arrDados=false,$where="")
	{
		$this->command = new HOSPCONF();

		switch($action)
		{
			case 'select':
				if(empty($where))
					$this->arrResposta = $this->command->select();
				else
					$this->arrResposta = $this->command->select($where);
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