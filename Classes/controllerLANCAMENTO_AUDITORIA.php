<?php require_once('modelLANCAMENTO_AUDITORIA.php');?>
<?php
class  controllerLANCAMENTO_AUDITORIA
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerLANCAMENTO_AUDITORIA($action,$arrDados=false,$where=false)
	{
		$this->command = new LANCAMENTO_AUDITORIA();

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
			case 'insert_last_id':
				$this->arrResposta = $this->command->insert_last_id($arrDados);
			break;
		}
	}
}
?>