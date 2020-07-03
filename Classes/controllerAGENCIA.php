<?php  require_once('modelAGENCIA.php');?>
<?php
class  controllerAGENCIA
{
    var $command;
    var $resposta;
    var $arrResposta = array();

	public function controllerAGENCIA($action,$arrDados=false)
	{
		$this->command = new AGENCIA();

		switch($action)
		{
			case 'select':
				if(isset($arrDados['filtro']) && $arrDados['filtro'] == TRUE)
				{
					$this->arrResposta = $this->command->select(false,false,$where);
				}
				else
				{
					if(empty($arrDados))
						$this->arrResposta = $this->command->select(false);
					else
						$this->arrResposta = $this->command->select($arrDados);
				}
			break;
			case 'insert':
				$this->resposta = $this->command->insert($arrDados);
			break;
			case 'update':
				$this->resposta = $this->command->update($arrDados);
			break;
			case 'selectDadosJson':
				$this->resposta = $this->command->selectDadosJson($arrDados['idagencia']);
			break;
			case 'delete':
				$this->resposta = $this->command->delete($arrDados['idagencia']);
			break;
			default:
				echo "Controlador não encontrado!";
			break;
		}
	}
}
?>