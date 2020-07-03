<?php require_once('modelCIDADE.php');?>
<?php
class  controllerCIDADE
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerCIDADE($action,$arrDados=false,$where=false)
	{
		$this->command = new CIDADE();

		switch($action)
		{
			case 'selectCidade':
				if(!empty($where))
				{
					$this->arrResposta = $this->command->selectCidade($where);
				}
				else
					$this->arrResposta = $this->command->selectCidade(false);
			break;
			case 'insert':
				$this->resposta = $this->command->insert($arrDados);
			break;
			case 'update':
				$this->resposta = $this->command->update($arrDados);
			break;
			case 'selectDadosJsonCidade':
				$this->resposta = $this->command->selectDadosJsonCidade($arrDados['idcidade']);
			break;
			case 'delete':
				$this->resposta = $this->command->delete($arrDados['idcidade']);
			break;
		}
	}
}
?>