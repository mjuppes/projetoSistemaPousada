<?php require_once('modelCATEGORIA.php');?>
<?php
class  controllerCATEGORIA
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerCATEGORIA($action,$arrDados=false,$whereFiltro=false)
	{

  		$this->command = new CATEGORIA();

		switch($action)
		{
			case 'select':
				$this->arrResposta = $this->command->select();
			break;
			case 'selectDadosJson':
				$this->resposta = $this->command->selectDadosJson($arrDados['idcategoria']);
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
}?>