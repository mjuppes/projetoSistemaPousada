<?php require_once('modelBANCOS.php');?>
<?php
class  controllerBANCOS
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerBANCOS($action,$arrDados=false,$where=false)
	{
		$this->command = new BANCOS();

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