<?php
class  PAIS
{
    var $table_name = 'PAIS';
    var $idpais;
    var $nomepais;
	
	function getIdpais()
	{
		return $this->idpais;
	}
	function setIdpais($idpais)
	{
		$this->idpais = $idpais;
	}

	
	function getNomepais()
	{
		return $this->nomepais;
	}
	function setNomepais($nomepais)
	{
		$this->nomepais = $nomepais;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  idpais ,nomepais from PAIS';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  idpais ,nomepais from PAIS';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('idpais'=>$dados['idpais']
								,'nomepais'=>$dados['nomepais']);
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
		$chave = 'idpais = '.$arrDados['idpais'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'idpais');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'idpais = '.$arrDados['idpais'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
