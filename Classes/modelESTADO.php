<?php
class  ESTADO
{
    var $table_name = 'ESTADO';
    var $idestado;
    var $nomeestado;
	
	function getIdestado()
	{
		return $this->idestado;
	}
	function setIdestado($idestado)
	{
		$this->idestado = $idestado;
	}
	
	function getNomeestado()
	{
		return $this->nomeestado;
	}
	function setNomeestado($nomeestado)
	{
		$this->nomeestado = $nomeestado;
	}

	public function selectEstado($where)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		if(!empty($where))
			$strSQL = "SELECT  idestado,nomeestado FROM ESTADO $where";
		else
			$strSQL = "SELECT  idestado,nomeestado FROM ESTADO";


		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	function insert($arrDados,$campo=false)
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'insert');
		$Bd->closeConnect();
		return $resposta;
	}

	function update($arrDados)
	{
		$str = 'idestado = '.$arrDados["idestado"];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$str,'idestado');
		$Bd->closeConnect();
		return $resposta;
	}

	function selectDadosJsonEstado($idestado)
	{
			$Bd = new Bd(CONEXAO);
			$dadosRecordSet = array();

			$strSQL = "select idestado, nomeestado from estado where idestado =  $idestado";

			$dadosRecordSet = $Bd->execQuery($strSQL,true);

			foreach($dadosRecordSet as $dados)
			{
					$arrJson = array('idestado'=>$dados["idestado"],
									 'nomeestado'=>utf8_encode($dados["nomeestado"]));
			}

			$Bd->closeConnect();
			return json_encode($arrJson);
	}

	function delete($idestado)
	{
		$Bd = new Bd(CONEXAO);
		$str = 'idestado = '.$idestado;
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$str,'idestado');
		$Bd->closeConnect();
		return $resposta;
	}
	
}
?>