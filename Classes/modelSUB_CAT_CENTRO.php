<?php
class  SUB_CAT_CENTRO
{
    var $table_name = 'SUB_CAT_CENTRO';
    var $id_sub_cat_centro;
    var $sub_cat_centro;
    var $descricao;
    var $id_cat_centro;
	
	function getId_sub_cat_centro()
	{
		return $this->id_sub_cat_centro;
	}
	function setId_sub_cat_centro($id_sub_cat_centro)
	{
		$this->id_sub_cat_centro = $id_sub_cat_centro;
	}

	
	function getSub_cat_centro()
	{
		return $this->sub_cat_centro;
	}
	function setSub_cat_centro($sub_cat_centro)
	{
		$this->sub_cat_centro = $sub_cat_centro;
	}

	
	function getDescricao()
	{
		return $this->descricao;
	}
	function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}

	
	function getId_cat_centro()
	{
		return $this->id_cat_centro;
	}
	function setId_cat_centro($id_cat_centro)
	{
		$this->id_cat_centro = $id_cat_centro;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = "
				select  id_sub_cat_centro,
						sub_cat_centro,
						(case when descricao is null then '' else descricao end) as descricao
						from SUB_CAT_CENTRO 
						where ativo is null";

		if(isset($where))
			$strSQL .=" and $where";

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_sub_cat_centro ,sub_cat_centro,descricao,id_cat_centro from SUB_CAT_CENTRO';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_sub_cat_centro'=>$dados['id_sub_cat_centro']
								,'sub_cat_centro'=>$dados['sub_cat_centro']
								,'descricao'=>$dados['descricao']
								,'id_cat_centro'=>$dados['id_cat_centro']
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
		$chave = 'id_sub_cat_centro = '.$arrDados['id_sub_cat_centro'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_sub_cat_centro');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_sub_cat_centro = '.$arrDados['id_sub_cat_centro'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
