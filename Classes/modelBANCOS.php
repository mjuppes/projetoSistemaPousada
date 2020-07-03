<?php
class  BANCOS
{
    var $table_name = 'BANCOS';
    var $id_banco;
    var $banco;
    var $cod_banco;
	
	function getId_banco()
	{
		return $this->id_banco;
	}
	function setId_banco($id_banco)
	{
		$this->id_banco = $id_banco;
	}

	
	function getBanco()
	{
		return $this->banco;
	}
	function setBanco($banco)
	{
		$this->banco = $banco;
	}

	
	function getCod_banco()
	{
		return $this->cod_banco;
	}
	function setCod_banco($cod_banco)
	{
		$this->cod_banco = $cod_banco;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_banco ,banco,cod_banco from BANCOS';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_banco ,banco,cod_banco from BANCOS';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_banco'=>$dados['id_banco']
								,'banco'=>$dados['banco']
								,'cod_banco'=>$dados['cod_banco']
);
		}
		$Bd->closeConnect();
		return json_encode($arrJson);	}

	public function insert($arrDados)
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'insert');
		$Bd->closeConnect();
		return $resposta;
	}

	public function update($arrDados)
	{
		$chave = 'id_banco = '.$arrDados['id_banco'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_banco');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_banco = '.$arrDados['id_banco'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
