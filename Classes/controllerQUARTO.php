<?php require_once('modelQUARTO.php');?>
<?php
class  controllerQUARTO
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerQUARTO($action,$arrDados=false,$where=false)
	{
		$this->command = new QUARTO();

		switch($action)
		{
			case 'selectQuartos':
				if(empty($where))
					$this->arrResposta = $this->command->selectQuartos();
				else
					$this->arrResposta = $this->command->selectQuartos($where);
			break;
			case 'insert':
				$this->resposta = $this->command->insert($arrDados);
			break;
			case 'update':
				$this->resposta = $this->command->update($arrDados);
			break;
			case 'selectDadosJsonQuarto':
				$this->resposta = $this->command->selectDadosJsonQuarto($arrDados['idquarto']);
			break;
			case 'delete':
				$this->resposta = $this->command->delete($arrDados['idquarto']);
			break;
			case 'verificaVaga':
				$this->resposta = $this->command->verificaVaga($arrDados['idreserva'],$arrDados['idquarto'],$arrDados["datainicial"],$arrDados["datafinal"]);
			break;
			case 'verificaVagaRetNum':
				$this->resposta = $this->command->verificaVagaRetNum($arrDados['idquarto'],$arrDados["datainicial"],$arrDados["datafinal"]);
			break;
			default:
				echo "Controlador não encontrado!";
			break;
		}
	}
}
?>