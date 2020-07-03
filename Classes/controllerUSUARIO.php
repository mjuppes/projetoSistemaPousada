<?php require_once('modelUSUARIO.php');?>
<?php
class  controllerUSUARIO
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerUSUARIO($action,$arrDados=false,$where=false)
	{
		switch($action)
		{
			case 'insert':
				$this->command = new USUARIO();
				$this->resposta = $this->command->insert($arrDados);
			break;
			case 'selectUsuario':
				$this->command = new USUARIO();
				if(isset($arrDados['filtro']) && $arrDados['filtro'] == TRUE)
				{
					$this->arrResposta = $this->command->selectUsuario(false,false,$where);
				}
				else
				{
					if(empty($arrDados))
					   $this->arrResposta = $this->command->selectUsuario(false);
					else
 					   $this->arrResposta = $this->command->selectUsuario($arrDados);
				}
			break;
			case 'selectPermissao':
				$this->command = new USUARIO();
				if(isset($arrDados['filtro']) && $arrDados['filtro'] == TRUE)
				{
					$this->arrResposta = $this->command->selectPermissao(false,false,$where);
				}
				else
				{
					if(empty($arrDados))
   					   $this->arrResposta = $this->command->selectPermissao(false);
					else
					   $this->arrResposta = $this->command->selectPermissao($arrDados);
				}
			break;
			case 'selectMontaPainelAcoes':
				$this->command = new USUARIO();
				$this->arrResposta = $this->command->selectMontaPainelAcoes($where);
			break;
			case 'selectMontaPainelAcoesModulo':
				$this->command = new USUARIO();
				$this->arrResposta = $this->command->selectMontaPainelAcoesModulo($where);
			break;
			case 'update':
				$this->command = new USUARIO();
				$this->resposta = $this->command->update($arrDados);
			break;
		}
	}
}
?>
