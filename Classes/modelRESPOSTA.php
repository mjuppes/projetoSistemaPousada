<?php
class  RESPOSTA
{
    var $table_name = 'RESPOSTA';
    var $idresposta;
    var $idpesquisa;
    var $idpergunta;
    var $resposta;
	
	function getIdresposta()
	{
		return $this->idresposta;
	}
	function setIdresposta($idresposta)
	{
		$this->idresposta = $idresposta;
	}

	
	function getIdpesquisa()
	{
		return $this->idpesquisa;
	}
	function setIdpesquisa($idpesquisa)
	{
		$this->idpesquisa = $idpesquisa;
	}

	
	function getIdpergunta()
	{
		return $this->idpergunta;
	}
	function setIdpergunta($idpergunta)
	{
		$this->idpergunta = $idpergunta;
	}

	
	function getResposta()
	{
		return $this->resposta;
	}
	function setResposta($resposta)
	{
		$this->resposta = $resposta;
	}

	public function select($where=false,$arr=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		
		
		if(isset($arr['idpesquisa']))
		{
		$strSQL = "select count(r.resposta) as num,
						(select top 1 parametro from PARAMETRO where idpesquisa = r.idpesquisa
						and valor = r.resposta)as parametro from resposta r 
						$where
						group by r.idpesquisa,r.resposta";
		}
		else
		{
			$strSQL = "select count(r.resposta) as num,
						(select top 1 parametro from PARAMETRO where idpesquisa = r.idpesquisa
						and valor = r.resposta)as parametro,p.pergunta from resposta r 
						join pergunta p on p.idpergunta = r.idpergunta
						$where
						group by r.idpesquisa,r.resposta,p.pergunta";
		}
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  idresposta ,idpesquisa,idpergunta,resposta from RESPOSTA';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('idresposta'=>$dados['idresposta']
								,'idpesquisa'=>$dados['idpesquisa']
								,'idpergunta'=>$dados['idpergunta']
								,'resposta'=>$dados['resposta']
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
		$chave = 'idresposta = '.$arrDados['idresposta'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'idresposta');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		if(isset($arrDados['idpergunta']))
			$chave = "idpergunta = ".$arrDados['idpergunta'];
		else
			$chave = "idresposta = ".$arrDados['idresposta'];

		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);

		$Bd->closeConnect();
		return $resposta;
	}
}
?>
