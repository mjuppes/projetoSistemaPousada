<?php
class  CIDADE
{
    var $table_name = 'CIDADE';
    var $idcidade;
    var $nomecidade;
    var $idestado;
	
	function getIdcidade()
	{
		return $this->idcidade;
	}
	function setIdcidade($idcidade)
	{
		$this->idcidade = $idcidade;
	}
	
	function getNomecidade()
	{
		return $this->nomecidade;
	}
	function setNomecidade($nomecidade)
	{
		$this->nomecidade = $nomecidade;
	}
	
	function getIdestado()
	{
		return $this->idestado;
	}
	function setIdestado($idestado)
	{
		$this->idestado = $idestado;
	}

	public function selectCidade($where=false)
	{
		
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		if(!empty($where))
			$strSQL = "SELECT  idcidade,nomecidade FROM CIDADE $where";
		else
			$strSQL = "SELECT  idcidade,nomecidade FROM CIDADE";

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
		$str = 'idcidade = '.$arrDados["idcidade"];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$str,'idcidade');
		$Bd->closeConnect();
		return $resposta;
	}

	function selectDadosJsonCidade($idcidade)
	{
			$Bd = new Bd(CONEXAO);
			$dadosRecordSet = array();

			$strSQL = "select idcidade,idestado,nomecidade from cidade where idcidade =  $idcidade";

			$dadosRecordSet = $Bd->execQuery($strSQL,true);

			foreach($dadosRecordSet as $dados)
			{
					$arrJson = array('idcidade'=>$dados["idcidade"],
									'idestado'=>$dados["idestado"],
									'nomecidade'=>$dados["nomecidade"]);
			}

			$Bd->closeConnect();
			return json_encode($arrJson);
	}

	function delete($idcidade)
	{
		$Bd = new Bd(CONEXAO);
		$str = 'idcidade = '.$idcidade;
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$str,'idcidade');
		$Bd->closeConnect();
		return $resposta;
	}
	
	
	
}
?>