<?php  require_once('modelPRECOQUARTO.php');?>
<?php
class  controllerPRECOQUARTO
{
    var $command;
    var $resposta;
    var $arrResposta = array();

	public function controllerPRECOQUARTO($action,$arrDados=false,$where=false)
	{
		$this->command = new PRECOQUARTO();

		switch($action)
		{
			case 'select':
				if(empty($where))
					$this->arrResposta = $this->command->select();
				else
					$this->arrResposta = $this->command->select($where);
			break;
			case 'insert':
				$this->resposta = $this->command->insert($arrDados);
			break;
			case 'update':
				$this->resposta = $this->command->update($arrDados);
			break;
			case 'selectDadosJson':
				$this->resposta = $this->command->selectDadosJson($arrDados['idpreco']);
			break;
			case 'delete':
				$this->resposta = $this->command->delete($arrDados['idpreco']);
			break;
			case 'verificaValor':
				$this->arrResposta = $this->command->verificaValor($arrDados['idquarto'],$arrDados['valor']);
			break;
			default:
				echo "Controlador não encontrado!";
			break;
		}
	}
}
?>