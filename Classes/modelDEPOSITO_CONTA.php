<?php
class  DEPOSITO_CONTA
{
    var $table_name = 'DEPOSITO_CONTA';
    var $id_dep_conta;
    var $id_banco;
    var $agencia;
    var $conta;
    var $tipo_conta;
	
	function getId_dep_conta()
	{
		return $this->id_dep_conta;
	}
	function setId_dep_conta($id_dep_conta)
	{
		$this->id_dep_conta = $id_dep_conta;
	}

	
	function getId_banco()
	{
		return $this->id_banco;
	}
	function setId_banco($id_banco)
	{
		$this->id_banco = $id_banco;
	}

	
	function getAgencia()
	{
		return $this->agencia;
	}
	function setAgencia($agencia)
	{
		$this->agencia = $agencia;
	}

	
	function getConta()
	{
		return $this->conta;
	}
	function setConta($conta)
	{
		$this->conta = $conta;
	}

	
	function getTipo_conta()
	{
		return $this->tipo_conta;
	}
	function setTipo_conta($tipo_conta)
	{
		$this->tipo_conta = $tipo_conta;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_dep_conta ,id_banco,agencia,conta,tipo_conta from DEPOSITO_CONTA';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_dep_conta ,id_banco,agencia,conta,tipo_conta from DEPOSITO_CONTA';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_dep_conta'=>$dados['id_dep_conta']
								,'id_banco'=>$dados['id_banco']
								,'agencia'=>$dados['agencia']
								,'conta'=>$dados['conta']
								,'tipo_conta'=>$dados['tipo_conta']
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
		$chave = 'id_dep_conta = '.$arrDados['id_dep_conta'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_dep_conta');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_dep_conta = '.$arrDados['id_dep_conta'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
