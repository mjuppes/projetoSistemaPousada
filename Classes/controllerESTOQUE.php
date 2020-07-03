<?php require_once('modelESTOQUE.php');?>
<?php
class  controllerESTOQUE
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerESTOQUE($action,$arrDados=false)
	{
		$this->command = new ESTOQUE();

		switch($action)
		{
			case 'select':
				$this->arrResposta = $this->command->select();
			break;
			case 'selectDadosJson':
				$this->resposta = $this->command->selectDadosJson($arrDados["idestoque"]);
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
			case 'verificarEstoque':
				$this->resposta = $this->command->verificarEstoque($arrDados['idproduto']);
			break;
			case 'verificarEstoqueQtd':
				$this->resposta = $this->command->verificarEstoqueQtd($arrDados['idproduto']);
			break;
		}
	}
}
?>