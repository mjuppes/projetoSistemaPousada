<?php
class  UNIDADE
{
    var $table_name = 'UNIDADE';
    var $id_unidade;
    var $unidade;
    var $valor;
    var $descricao;
	
	function getId_unidade()
	{
		return $this->id_unidade;
	}
	function setId_unidade($id_unidade)
	{
		$this->id_unidade = $id_unidade;
	}

	
	function getUnidade()
	{
		return $this->unidade;
	}
	function setUnidade($unidade)
	{
		$this->unidade = $unidade;
	}

	
	function getValor()
	{
		return $this->valor;
	}
	function setValor($valor)
	{
		$this->valor = $valor;
	}

	
	function getDescricao()
	{
		return $this->descricao;
	}
	function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_unidade ,unidade,descricao from UNIDADE where ativo is null';		
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($id_unidade)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_unidade ,unidade,quantidade,descricao from UNIDADE where id_unidade='.$id_unidade;
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_unidade'=>$dados['id_unidade']
								,'unidade'=>$dados['unidade']
								,'quantidade'=>$dados['quantidade']
								,'descricao'=>$dados['descricao']);
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
		$chave = 'id_unidade = '.$arrDados['id_unidade'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_unidade');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_unidade = '.$arrDados['id_unidade'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
