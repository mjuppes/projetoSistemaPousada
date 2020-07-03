<?php
class  FORNECEDOR
{
    var $table_name = 'FORNECEDOR';
    var $id_fornecedor;
    var $nome;
    var $endereco;
    var $telefone;
    var $observacao;
	
	function getId_fornecedor()
	{
		return $this->id_fornecedor;
	}
	function setId_fornecedor($id_fornecedor)
	{
		$this->id_fornecedor = $id_fornecedor;
	}

	
	function getNome()
	{
		return $this->nome;
	}
	function setNome($nome)
	{
		$this->nome = $nome;
	}

	
	function getEndereco()
	{
		return $this->endereco;
	}
	function setEndereco($endereco)
	{
		$this->endereco = $endereco;
	}

	
	function getTelefone()
	{
		return $this->telefone;
	}
	function setTelefone($telefone)
	{
		$this->telefone = $telefone;
	}

	
	function getObservacao()
	{
		return $this->observacao;
	}
	function setObservacao($observacao)
	{
		$this->observacao = $observacao;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = '
				select  
				f.id_fornecedor ,f.nome,tf.tipo_fornecedor,
		f.cpfcnpj,f.endereco,
		f.telefone,f.observacao 
		from FORNECEDOR f join TIPO_FORNECEDOR tf on tf.id_tipo_fornecedor = f.id_tipo_fornecedor
		where f.ativo is null';

		if($where)
			$strSQL .= $where;

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($id_fornecedor)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = " select 
						id_fornecedor,
						nome,	banco,
					agencia,	conta,
				(case when tipo_conta = 'C' then 'Conta Corrente' else 'Conta Poupança' end) as tipo_conta,
		cpfcnpj,endereco,telefone,observacao,f.id_tipo_fornecedor
		from FORNECEDOR f
		join TIPO_FORNECEDOR tf on tf.id_tipo_fornecedor = f.id_tipo_fornecedor
		join BANCOS b on b.id_banco = f.id_banco
		where id_fornecedor = ".$id_fornecedor;

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_fornecedor'=>$dados['id_fornecedor']
								,'nome'=>$dados['nome']
								,'banco'=>$dados['banco']
								,'agencia'=>$dados['agencia']
								,'conta'=>$dados['conta']
								,'tipo_conta'=>$dados['tipo_conta']
								,'cpfcnpj'=>$dados['cpfcnpj']
								,'id_tipo_fornecedor'=>$dados['id_tipo_fornecedor']
								,'endereco'=>$dados['endereco']
								,'telefone'=>$dados['telefone']
								,'observacao'=>$dados['observacao']);
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
		$chave = 'id_fornecedor = '.$arrDados['id_fornecedor'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_fornecedor');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_fornecedor = '.$arrDados['id_fornecedor'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
