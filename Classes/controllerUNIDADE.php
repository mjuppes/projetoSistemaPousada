<?php require_once('modelUNIDADE.php');?>
<?php
class  controllerUNIDADE
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerUNIDADE($action,$arrDados=false,$where=false)
	{
		$this->command = new UNIDADE();

		switch($action)
		{
			case 'select':
				if(empty($where))
					$this->arrResposta = $this->command->select();
				else			
					$this->arrResposta = $this->command->select($where);
			break;
			case 'selectDadosJson':
				$this->resposta = $this->command->selectDadosJson($arrDados['id_unidade']);
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