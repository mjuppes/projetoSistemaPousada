<?php
class  EMPRESA
{
    var $table_name = 'EMPRESA';
    var $idempresa;
    var $nomeempresa;
    var $cnpj;
	
	function getIdempresa()
	{
		return $this->idempresa;
	}
	function setIdempresa($idempresa)
	{
		$this->idempresa = $idempresa;
	}
	
	function getNomeempresa()
	{
		return $this->nomeempresa;
	}
	function setNomeempresa($nomeempresa)
	{
		$this->nomeempresa = $nomeempresa;
	}
	
	function getCnpj()
	{
		return $this->cnpj;
	}
	function setCnpj($cnpj)
	{
		$this->cnpj = $cnpj;
	}
	
	function getTelefone()
	{
		return $this->telefone;
	}
	function setTelefone($telefone)
	{
		$this->telefone = $telefone;
	}
	
	function getFax()
	{
		return $this->fax;
	}
	function setFax($fax)
	{
		$this->fax = $fax;
	}
	
	function getEndereco()
	{
		return $this->endereco;
	}
	function setEndereco($endereco)
	{
		$this->endereco = $endereco;
	}

	function lastIdempresa()
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->lastRecordSet("idempresa",$this->table_name);
		$Bd->closeConnect();
		return $resposta;
	}

	function selectEmpresa($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		if(!$where)
			$strSQL = "select idempresa,nomeempresa,cnpj,(case telefone when null then  '---------' else telefone end) as telefone
						from EMPRESA order by nomeempresa asc";
		
		else
			$strSQL = "select idempresa,nomeempresa,cnpj,(case telefone when null then  '---------' else telefone end) as telefone
					from EMPRESA where $where order by nomeempresa asc";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idempresa)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select idempresa,nomeempresa,cnpj,telefone,
		(case fax when null then  '---------' else fax end) as fax
		,endereco,inscricaoest from EMPRESA where idempresa = $idempresa";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		foreach($dadosRecordSet as $dados)
		{
			$arrJson = array('idempresa'=>$dados['idempresa']
							,'nomeempresa'=>$dados['nomeempresa']
							,'cnpj'=>$dados['cnpj']
							,'telefone'=>$dados['telefone']
							,'fax'=>$dados['fax']
							,'endereco'=>$dados['endereco']
							,'inscricaoest'=>$dados['inscricaoest']);
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
		$chave = 'idempresa = '.$arrDados['idempresa'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'idempresa');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$Bd = new Bd(CONEXAO);
		$chave = 'idempresa = '.$arrDados['idempresa'];
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave,'idempresa');
		$Bd->closeConnect();
		return $resposta;
	}

}
?>