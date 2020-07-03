<?php
class  LANCAMENTO_AUDITORIA
{
    var $table_name = 'LANCAMENTO_AUDITORIA';
    var $id_lanca_auditoria;
    var $idproduto;
    var $quantidade;
    var $descricao;
    var $historico;
    var $data_cadastro;
    var $ativo;
	
	function getId_lanca_auditoria()
	{
		return $this->id_lanca_auditoria;
	}
	function setId_lanca_auditoria($id_lanca_auditoria)
	{
		$this->id_lanca_auditoria = $id_lanca_auditoria;
	}

	
	function getIdproduto()
	{
		return $this->idproduto;
	}
	function setIdproduto($idproduto)
	{
		$this->idproduto = $idproduto;
	}

	
	function getQuantidade()
	{
		return $this->quantidade;
	}
	function setQuantidade($quantidade)
	{
		$this->quantidade = $quantidade;
	}

	
	function getDescricao()
	{
		return $this->descricao;
	}
	function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}

	
	function getHistorico()
	{
		return $this->historico;
	}
	function setHistorico($historico)
	{
		$this->historico = $historico;
	}

	
	function getData_cadastro()
	{
		return $this->data_cadastro;
	}
	function setData_cadastro($data_cadastro)
	{
		$this->data_cadastro = $data_cadastro;
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
		
		$strSQL = "select id_lanca_auditoria,p.nomeproduto,
							(CONVERT(VARCHAR(29),l.data_cadastro,103) +' '+CONVERT(VARCHAR(29),l.data_cadastro,108)) as data_cadastro,
						(case when l.historico = '1'
							then 'Saída pela Auditoria'
							else 'Entrada pela Auditoria' end) as historico
					,l.quantidade,
					(case when l.descricao is null then '' else l.descricao end) as descricao
				from LANCAMENTO_AUDITORIA l 
		join PRODUTOS p on p.idproduto = l.idproduto where l.ativo is null ";

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_lanca_auditoria ,idproduto,quantidade,descricao,historico,data_cadastro,ativo from LANCAMENTO_AUDITORIA';
		
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_lanca_auditoria'=>$dados['id_lanca_auditoria']
								,'idproduto'=>$dados['idproduto']
								,'quantidade'=>$dados['quantidade']
								,'descricao'=>$dados['descricao']
								,'historico'=>$dados['historico']
								,'data_cadastro'=>$dados['data_cadastro']
								,'ativo'=>$dados['ativo']
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
		$chave = 'id_lanca_auditoria = '.$arrDados['id_lanca_auditoria'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_lanca_auditoria');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_lanca_auditoria = '.$arrDados['id_lanca_auditoria'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}

	function insert_last_id($arrDados,$campo=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$dadosRecordSet = $Bd->executarSql($arrDados,$this->table_name,'insert_last_id');
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
}
?>
