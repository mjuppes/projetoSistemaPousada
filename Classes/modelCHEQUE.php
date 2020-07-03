<?php
class  CHEQUE
{
    var $table_name = 'CHEQUE';
    var $id_cheque;
    var $numero;
    var $id_banco;
    var $data_vencimento;
	
	function getId_cheque()
	{
		return $this->id_cheque;
	}
	function setId_cheque($id_cheque)
	{
		$this->id_cheque = $id_cheque;
	}

	
	function getNumero()
	{
		return $this->numero;
	}
	function setNumero($numero)
	{
		$this->numero = $numero;
	}

	
	function getId_banco()
	{
		return $this->id_banco;
	}
	function setId_banco($id_banco)
	{
		$this->id_banco = $id_banco;
	}

	
	function getData_vencimento()
	{
		return $this->data_vencimento;
	}
	function setData_vencimento($data_vencimento)
	{
		$this->data_vencimento = $data_vencimento;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_cheque ,numero,id_banco,data_vencimento from CHEQUE';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_cheque ,numero,id_banco,data_vencimento from CHEQUE';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_cheque'=>$dados['id_cheque']
								,'numero'=>$dados['numero']
								,'id_banco'=>$dados['id_banco']
								,'data_vencimento'=>$dados['data_vencimento']
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
		$chave = 'id_cheque = '.$arrDados['id_cheque'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_cheque');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_cheque = '.$arrDados['id_cheque'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}

	public function insert_massive($arrDados)
	{
		$Bd = new Bd(CONEXAO);
 		$resposta = $Bd->insert_massive($arrDados,$this->table_name);
		$Bd->closeConnect();
		return $resposta;
	}

}
?>
