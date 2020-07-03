<?php
class  PERGUNTA
{
    var $table_name = 'PERGUNTA';
    var $idpergunta;
    var $pergunta;
	
	function getIdpergunta()
	{
		return $this->idpergunta;
	}
	function setIdpergunta($idpergunta)
	{
		$this->idpergunta = $idpergunta;
	}

	
	function getPergunta()
	{
		return $this->pergunta;
	}
	function setPergunta($pergunta)
	{
		$this->pergunta = $pergunta;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = " select  pe.nomepesquisa,p.idpergunta ,p.pergunta from PERGUNTA p
			join Pesquisa pe on p.idpesquisa = pe.idpesquisa 
		$where";
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idpergunta)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = " select  idpergunta ,pergunta from PERGUNTA where idpergunta = $idpergunta";
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('idpergunta'=>$dados['idpergunta']
								,'pergunta'=>$dados['pergunta']);
		}
		$Bd->closeConnect();
		return json_encode($arrJson);
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
		$chave = 'idpergunta = '.$arrDados['idpergunta'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'idpergunta');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = "idpergunta = ".$arrDados['idpergunta'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
