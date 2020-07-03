<?php
class  PESQUISA
{
    var $table_name = 'PESQUISA';
    var $idpesquisa;
    var $nomepesquisa;
	
	function getIdpesquisa()
	{
		return $this->idpesquisa;
	}
	function setIdpesquisa($idpesquisa)
	{
		$this->idpesquisa = $idpesquisa;
	}

	
	function getNomepesquisa()
	{
		return $this->nomepesquisa;
	}
	function setNomepesquisa($nomepesquisa)
	{
		$this->nomepesquisa = $nomepesquisa;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = " select  idpesquisa ,nomepesquisa from PESQUISA";
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idpesquisa)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = " select  idpesquisa ,nomepesquisa from PESQUISA where idpesquisa = $idpesquisa";
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array("idpesquisa"=>$dados['idpesquisa']
								,"nomepesquisa"=>$dados['nomepesquisa']);
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
		$chave = "idpesquisa = ".$arrDados['idpesquisa'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'idpesquisa');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->execProcedure("SP_EXCLUIPESQUISA",$arrDados['idpesquisa']);
		$Bd->closeConnect();
		return $resposta;
	}

	function lastIdPesquisa()
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->lastRecordSet("idpesquisa",$this->table_name);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
