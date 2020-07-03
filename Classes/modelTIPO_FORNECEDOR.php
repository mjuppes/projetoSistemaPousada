<?php
class  TIPO_FORNECEDOR
{
    var $table_name = 'TIPO_FORNECEDOR';
    var $id_tipo_fornecedor;
    var $tipo_fornecedor;
    var $descricao;
    var $ativo;
	
	function getId_tipo_fornecedor()
	{
		return $this->id_tipo_fornecedor;
	}
	function setId_tipo_fornecedor($id_tipo_fornecedor)
	{
		$this->id_tipo_fornecedor = $id_tipo_fornecedor;
	}

	
	function gettipo_fornecedor()
	{
		return $this->tipo_fornecedor;
	}
	function settipo_fornecedor($tipo_fornecedor)
	{
		$this->tipo_fornecedor = $tipo_fornecedor;
	}

	
	function getDescricao()
	{
		return $this->descricao;
	}
	function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}

	
	function getAtivo()
	{
		return $this->ativo;
	}
	function setAtivo($ativo)
	{
		$this->ativo = $ativo;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = " select  id_tipo_fornecedor ,tipo_fornecedor,
					descricao from TIPO_FORNECEDOR where ativo is null";
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_tipo_fornecedor ,tipo_fornecedor,descricao,ativo from TIPO_FORNECEDOR';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_tipo_fornecedor'=>$dados['id_tipo_fornecedor']
								,'tipo_fornecedor'=>$dados['tipo_fornecedor']
								,'descricao'=>$dados['descricao']
								,'ativo'=>$dados['ativo']);
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
		$chave = 'id_tipo_fornecedor = '.$arrDados['id_tipo_fornecedor'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_tipo_fornecedor');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_tipo_fornecedor = '.$arrDados['id_tipo_fornecedor'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();	
		return $resposta;
	}
}
?>
