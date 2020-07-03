<?php require_once('modelESTADO.php');?>
<?php
class  controllerESTADO
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerESTADO($action,$arrDados=false,$where=false)
	{
		$this->command = new ESTADO();

		switch($action)
		{
			case 'selectEstado':
				if(!empty($where))
					$this->arrResposta = $this->command->selectEstado($where);
				else
					$this->arrResposta = $this->command->selectEstado(false);
			break;
			case 'insert':
				$this->resposta = $this->command->insert($arrDados);
			break;
			case 'update':
				$this->resposta = $this->command->update($arrDados);
			break;
			case 'selectDadosJsonEstado':
				$this->resposta = $this->command->selectDadosJsonEstado($arrDados['idestado']);
			break;
			case 'delete':
				$this->resposta = $this->command->delete($arrDados['idestado']);
			break;
		}
	}
}
?>