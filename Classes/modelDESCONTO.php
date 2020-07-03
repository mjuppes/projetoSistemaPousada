<?php
class  DESCONTO
{
    var $table_name = 'DESCONTO';
    var $iddesconto;
    var $valordesconto;
    var $idreserva;
	
	function getIddesconto()
	{
		return $this->iddesconto;
	}
	function setIddesconto($iddesconto)
	{
		$this->iddesconto = $iddesconto;
	}

	
	function getValordesconto()
	{
		return $this->valordesconto;
	}
	function setValordesconto($valordesconto)
	{
		$this->valordesconto = $valordesconto;
	}

	
	function getIdreserva()
	{
		return $this->idreserva;
	}
	function setIdreserva($idreserva)
	{
		$this->idreserva = $idreserva;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		if(empty($where))
			$strSQL = ' select  iddesconto ,valordesconto from DESCONTO ';
		else
			$strSQL = " select  iddesconto ,valordesconto from DESCONTO where $where";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  iddesconto ,valordesconto,idreserva from DESCONTO';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('iddesconto'=>$dados['iddesconto']
								,'valordesconto'=>$dados['valordesconto']
								,'idreserva'=>$dados['idreserva']
);
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
		$chave = 'iddesconto = '.$arrDados['iddesconto'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'iddesconto');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'iddesconto = '.$arrDados['iddesconto'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
