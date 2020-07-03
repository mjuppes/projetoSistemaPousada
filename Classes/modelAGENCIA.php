<?php
class  AGENCIA
{
    var $table_name = 'AGENCIA';
    var $idagencia;
    var $nomeagencia;
    var $obs;
    var $contato;

	function getIdagencia()
	{
		return $this->idagencia;
	}
	function setIdagencia($idagencia)
	{
		$this->idagencia = $idagencia;
	}
	
	function getNomeagencia()
	{
		return $this->nomeagencia;
	}
	function setNomeagencia($nomeagencia)
	{
		$this->nomeagencia = $nomeagencia;
	}
	
	function getObs()
	{
		return $this->obs;
	}
	function setObs($obs)
	{
		$this->obs = $obs;
	}
	
	function getContato()
	{
		return $this->contato;
	}
	function setContato($contato)
	{
		$this->contato = $contato;
	}

	function insert($arrDados,$campo=false)
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'insert');
		$Bd->closeConnect();
		return $resposta;
	}

	function select($arr,$where=false,$whereFiltro = false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select idagencia,nomeagencia,contato,obs  FROM AGENCIA";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	function update($arrDados)
	{
		$str = 'idagencia = '.$arrDados["idagencia"];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$str,'idagencia');
		$Bd->closeConnect();
		return $resposta;
	}

	function selectDadosJson($idagencia)
	{
			$Bd = new Bd(CONEXAO);
			$dadosRecordSet = array();
			$strSQL = "select idagencia,nomeagencia,obs,contato  FROM AGENCIA  where idagencia = $idagencia";

			$dadosRecordSet = $Bd->execQuery($strSQL,true);

			foreach($dadosRecordSet as $dados)
			{
					$arrJson = array('idagencia'=>$dados["idagencia"],
									 'nomeagencia'=>utf8_encode($dados["nomeagencia"]),
									 'obs'=>utf8_encode($dados["obs"]),
									 'contato'=>utf8_encode($dados["contato"]));
			}

			$Bd->closeConnect();
			return json_encode($arrJson);
	}

	function delete($idagencia)
	{
		$Bd = new Bd(CONEXAO);
		$str = 'idagencia = '.$idagencia;
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$str,'idagencia');
		$Bd->closeConnect();
		return $resposta;
	}
}
?>