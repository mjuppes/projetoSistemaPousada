<?php
class  PARAMETRO
{
    var $table_name = 'PARAMETRO';
    var $idparametro;
    var $parametro;
    var $idpesquisa;
	
	function getIdparametro()
	{
		return $this->idparametro;
	}
	function setIdparametro($idparametro)
	{
		$this->idparametro = $idparametro;
	}

	
	function getParametro()
	{
		return $this->parametro;
	}
	function setParametro($parametro)
	{
		$this->parametro = $parametro;
	}

	
	function getIdpesquisa()
	{
		return $this->idpesquisa;
	}
	function setIdpesquisa($idpesquisa)
	{
		$this->idpesquisa = $idpesquisa;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = " select  p.idparametro,p.parametro,p.idpesquisa,p.valor
					from PARAMETRO p  $where  ";

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  idparametro ,parametro,idpesquisa from PARAMETRO';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('idparametro'=>$dados['idparametro']
								,'parametro'=>$dados['parametro']
								,'idpesquisa'=>$dados['idpesquisa']);
		}
		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	public function insert($arrDados)
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'insert');
		$Bd->closeConnect();
		return $resposta;
	}

	public function update($arrDados)
	{
		$chave = 'idparametro = '.$arrDados['idparametro'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'idparametro');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'idparametro = '.$arrDados['idparametro'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
