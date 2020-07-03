<?php
class  CATEGORIA
{
    var $table_name = 'CATEGORIA';
    var $idcategoria;
    var $nomecategoria;
    var $id = 'idcategoria';
	
	function getIdcategoria()
	{
		return $this->idcategoria;
	}
	function setIdcategoria($idcategoria)
	{
		$this->idcategoria = $idcategoria;
	}
	
	function getNomecategoria()
	{
		return $this->nomecategoria;
	}
	function setNomecategoria($nomecategoria)
	{
		$this->nomecategoria = $nomecategoria;
	}

	public function select($arr=false,$where=false,$whereFiltro=false)
	{
	
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		
		
		$strSQL = "select idcategoria,nomecategoria from CATEGORIA ";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
 		else
			$resposta = false;

		$Bd->closeConnect();

		return $dadosRecordSet;
	}

	public function selectDadosJson($idcategoria)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select idcategoria,nomecategoria from CATEGORIA where idcategoria = $idcategoria";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		foreach($dadosRecordSet as $dados)
		{
			$arrJson = array('idcategoria'=>$dados['idcategoria']
							,'nomecategoria'=>$dados['nomecategoria']);
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
		$chave = 'idcategoria = '.$arrDados['idcategoria'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'idcategoria');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$Bd = new Bd(CONEXAO);
		$chave = 'idcategoria = '.$arrDados['idcategoria'];
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave,'idcategoria');
		$Bd->closeConnect();
		return $resposta;
	}

}
?>