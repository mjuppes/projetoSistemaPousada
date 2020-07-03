<?php require_once('modelHOSPEDE.php');?>
<?php
class  controllerHOSPEDE
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	var $teste;
	
	
	public function controllerHOSPEDE($action,$arrDados=false,$where=false)
	{
		$this->command = new HOSPEDE();

		switch($action)
		{
			case 'insert':
				$this->resposta = $this->command->insert($arrDados);
				break;
			case 'insert_last_id':
				$this->arrResposta = $this->command->insert_last_id($arrDados);
				break;
			case 'update':
				$this->resposta = $this->command->update($arrDados);
				break;
			case 'delete':
				$this->resposta = $this->command->delete($arrDados);
				break;
			case 'lastIdhospede':
				$this->resposta = $this->command->lastIdhospede();
				break;
			case 'selectHospede':
				if(!empty($where))
					$this->arrResposta = $this->command->selectHospede($where);
				else
					$this->arrResposta = $this->command->selectHospede();
				break;
			case 'selectHospedeGeral':
				if(!empty($where))
					$this->arrResposta = $this->command->selectHospedeGeral($where);
				else
					$this->arrResposta = $this->command->selectHospedeGeral();
				break;
			case 'selectDadosJson':
				$this->resposta = $this->command->selectDadosJson($arrDados['idhospede']);
				break;
			case 'selectQtdTipoHospAgencia':
				if(!empty($where))
					$this->arrResposta = $this->command->selectQtdTipoHospAgencia($where);
				else
					$this->arrResposta = $this->command->selectQtdTipoHospAgencia();
				break;
			case 'graficoNumeroHospede':
				if(!empty($where))
					$this->arrResposta = $this->command->graficoNumeroHospede($where);
				else
					$this->arrResposta = $this->command->graficoNumeroHospede();
				break;	
			case 'selectHistoricoHospede':
			if(!empty($where))
					$this->arrResposta = $this->command->selectHistoricoHospede($arrDados['idhospede'],$where);
				else
					$this->arrResposta = $this->command->selectHistoricoHospede($arrDados['idhospede']);
				break;
			case 'selectRelHospede':
				if(!empty($where))
					$this->arrResposta = $this->command->selectRelHospede($arrDados['idhospede'],$where);
				else
					$this->arrResposta = $this->command->selectRelHospede($arrDados['idhospede']);
				break;
			case 'selectHospedeTable':
				if(!empty($where))
					$this->arrResposta = $this->command->selectHospedeTable($where);
				else
					$this->arrResposta = $this->command->selectHospedeTable($where);
				break;
			case 'insert_massive':
				$this->resposta = $this->command->insert_massive($arrDados);
				break;
				
		}
	}
}
?>