<?php
class  LANCAMENTO_INSUMO
{
    var $table_name = 'LANCAMENTO_INSUMO';
    var $id_lanca_insumo;
    var $idproduto;
    var $quantidade;
    var $descricao;
    var $historico;
	
	function getId_lanca_insumo()
	{
		return $this->id_lanca_insumo;
	}
	function setId_lanca_insumo($id_lanca_insumo)
	{
		$this->id_lanca_insumo = $id_lanca_insumo;
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


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = "select id_lanca_insumo,p.nomeproduto,
							(CONVERT(VARCHAR(29),l.data_cadastro,103) +' '+CONVERT(VARCHAR(29),l.data_cadastro,108)) as data_cadastro,
						(case when l.historico = '1'
							then 'Consumo Interno'
							else 'Cancelamento de Consumo Interno' end) as historico
					,l.quantidade,
					(case when l.descricao is null then '' else l.descricao end) as descricao
				from LANCAMENTO_INSUMO l 
		join PRODUTOS p on p.idproduto = l.idproduto where l.ativo is null ";
		
		if(!empty($where))
			$strSQL.=$where;

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_lanca_insumo ,idproduto,quantidade,descricao,historico from LANCAMENTO_INSUMO';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_lanca_insumo'=>$dados['id_lanca_insumo']
								,'idproduto'=>$dados['idproduto']
								,'quantidade'=>$dados['quantidade']
								,'descricao'=>$dados['descricao']
								,'historico'=>$dados['historico']
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
		$chave = 'id_lanca_insumo = '.$arrDados['id_lanca_insumo'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_lanca_insumo');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_lanca_insumo = '.$arrDados['id_lanca_insumo'];
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
