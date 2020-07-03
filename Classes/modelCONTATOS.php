<?php
class  CONTATOS
{
    var $table_name = 'CONTATOS';
    var $id_contato;
    var $nome;
    var $id_estado;
    var $id_cidade;
    var $telefone;
    var $cep;
    var $endereco;
    var $bairro;
    var $estrelas;
    var $fonte;
    var $fonte_nome;
    var $observacao;
    var $data_cadastro;
	
	function getId_contato()
	{
		return $this->id_contato;
	}
	function setId_contato($id_contato)
	{
		$this->id_contato = $id_contato;
	}

	
	function getNome()
	{
		return $this->nome;
	}
	function setNome($nome)
	{
		$this->nome = $nome;
	}

	
	function getId_estado()
	{
		return $this->id_estado;
	}
	function setId_estado($id_estado)
	{
		$this->id_estado = $id_estado;
	}

	
	function getId_cidade()
	{
		return $this->id_cidade;
	}
	function setId_cidade($id_cidade)
	{
		$this->id_cidade = $id_cidade;
	}

	
	function getTelefone()
	{
		return $this->telefone;
	}
	function setTelefone($telefone)
	{
		$this->telefone = $telefone;
	}

	
	function getCep()
	{
		return $this->cep;
	}
	function setCep($cep)
	{
		$this->cep = $cep;
	}

	
	function getEndereco()
	{
		return $this->endereco;
	}
	function setEndereco($endereco)
	{
		$this->endereco = $endereco;
	}

	
	function getBairro()
	{
		return $this->bairro;
	}
	function setBairro($bairro)
	{
		$this->bairro = $bairro;
	}

	
	function getEstrelas()
	{
		return $this->estrelas;
	}
	function setEstrelas($estrelas)
	{
		$this->estrelas = $estrelas;
	}

	
	function getFonte()
	{
		return $this->fonte;
	}
	function setFonte($fonte)
	{
		$this->fonte = $fonte;
	}

	
	function getFonte_nome()
	{
		return $this->fonte_nome;
	}
	function setFonte_nome($fonte_nome)
	{
		$this->fonte_nome = $fonte_nome;
	}

	
	function getObservacao()
	{
		return $this->observacao;
	}
	function setObservacao($observacao)
	{
		$this->observacao = $observacao;
	}

	
	function getData_cadastro()
	{
		return $this->data_cadastro;
	}
	function setData_cadastro($data_cadastro)
	{
		$this->data_cadastro = $data_cadastro;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = " select
						id_contato ,
						(nome+' - '+ bairro) as nome,e.nomeestado,cid.nomecidade,
						telefone,cep,endereco,
						bairro,estrelas,fonte,fonte_nome,
						observacao,data_cadastro
				 from CONTATOS c 
					 join ESTADO e on e.idestado = c.id_estado
					 join CIDADE cid on cid.idcidade = c.id_cidade";
		
		if(!empty($where))
			$strSQL .= " where ".$where;

		$strSQL .= " order by bairro asc";

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($id_contato)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = " select 
						id_contato ,nome,id_estado,id_cidade,telefone,
						cep,endereco,bairro,estrelas,fonte,fonte_nome,
						observacao,data_cadastro from CONTATOS
						where
					id_contato = ".$id_contato;

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_contato'=>$dados['id_contato']
								,'nome'=>$dados['nome']
								,'id_estado'=>$dados['id_estado']
								,'id_cidade'=>$dados['id_cidade']
								,'telefone'=>$dados['telefone']
								,'cep'=>$dados['cep']
								,'endereco'=>$dados['endereco']
								,'bairro'=>$dados['bairro']
								,'estrelas'=>$dados['estrelas']
								,'fonte'=>$dados['fonte']
								,'fonte_nome'=>$dados['fonte_nome']
								,'observacao'=>$dados['observacao']
								,'data_cadastro'=>$dados['data_cadastro']);
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
	public function insert_last_id($arrDados,$campo=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$dadosRecordSet = $Bd->executarSql($arrDados,$this->table_name,'insert_last_id');
		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	public function update($arrDados)
	{
		$chave = 'id_contato = '.$arrDados['id_contato'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_contato');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_contato = '.$arrDados['id_contato'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
