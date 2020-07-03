<?php require_once('modelEMPRESA.php');?>
<?php
class  controllerEMPRESA
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerEMPRESA($action,$arrDados=false,$where=false)
	{
		$this->command = new EMPRESA();

		switch($action)
		{
			case 'lastIdempresa':
				$this->resposta = $this->command->lastIdempresa();
			break;
			case 'selectEmpresa':
				if(!empty($where))
					$this->arrResposta = $this->command->selectEmpresa($where);
				else
					$this->arrResposta = $this->command->selectEmpresa();
			break;
			case 'selectDadosJson':
				$this->resposta = $this->command->selectDadosJson($arrDados['idempresa']);
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