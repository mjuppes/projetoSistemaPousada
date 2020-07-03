<?php require_once('modelPRODUTOS.php');?>
<?php
class  controllerPRODUTOS
{
    var $command;
    var $resposta;
    var $arrResposta = array();
	
	public function controllerPRODUTOS($action,$arrDados=false,$where=false)
	{
  		$this->command = new PRODUTOS();

		switch($action)
		{
			case 'select':
				if(!empty($where))
					$this->arrResposta = $this->command->select(false,$where);
				else
					$this->arrResposta = $this->command->select(false);
			break;
			case 'selectDadosJson':
				$this->resposta = $this->command->selectDadosJson($arrDados['idproduto']);
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
			case 'selectProdutoEstoque':
				if(!empty($where))
					$this->arrResposta = $this->command->selectProdutoEstoque($where);
				else
					$this->arrResposta = $this->command->selectProdutoEstoque();
			break;
			case 'selectProdutosInsumo':
				if(!empty($where))
					$this->arrResposta = $this->command->selectProdutosInsumo($where);
				else
					$this->arrResposta = $this->command->selectProdutosInsumo();
			break;
			case 'selectProdutosAuditoria':
				if(!empty($where))
					$this->arrResposta = $this->command->selectProdutosInsumo($where);
				else
					$this->arrResposta = $this->command->selectProdutosInsumo();
			break;
			case 'insert_last_id':
				$this->arrResposta = $this->command->insert_last_id($arrDados);
			break;
			case 'selectEstoqueAtual':
				if(!empty($where))
					$this->arrResposta = $this->command->selectEstoqueAtual(false,$where);
				else
					$this->arrResposta = $this->command->selectEstoqueAtual(false);
			break;

		}
	}
}?>