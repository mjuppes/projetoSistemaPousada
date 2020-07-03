<?php require_once('modelCONTATOS.php');?>
<?php
class  controllerCONTATOS
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerCONTATOS($action,$arrDados=false,$where=false)
	{
		$this->command = new CONTATOS();

		switch($action)
		{
			case 'select':
				if(empty($where))
					$this->arrResposta = $this->command->select();
				else
					$this->arrResposta = $this->command->select($where);
			break;
			case 'selectDadosJson':
				$this->resposta = $this->command->selectDadosJson($arrDados['id_contato']);
			break;
			case 'insert':
				$this->resposta = $this->command->insert($arrDados);
			break;
			case 'insert_last_id':
				$this->resposta = $this->command->insert_last_id($arrDados);
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