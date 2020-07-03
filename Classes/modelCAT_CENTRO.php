<?php
class  CAT_CENTRO
{
    var $table_name = 'CAT_CENTRO';
    var $id_cat_centro;
    var $categoria_centro;
	
	function getId_cat_centro()
	{
		return $this->id_cat_centro;
	}
	function setId_cat_centro($id_cat_centro)
	{
		$this->id_cat_centro = $id_cat_centro;
	}

	
	function getCategoria_centro()
	{
		return $this->categoria_centro;
	}
	function setCategoria_centro($categoria_centro)
	{
		$this->categoria_centro = $categoria_centro;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_cat_centro ,categoria_centro from CAT_CENTRO';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_cat_centro ,categoria_centro from CAT_CENTRO';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_cat_centro'=>$dados['id_cat_centro']
								,'categoria_centro'=>$dados['categoria_centro']
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
		$chave = 'id_cat_centro = '.$arrDados['id_cat_centro'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_cat_centro');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_cat_centro = '.$arrDados['id_cat_centro'];
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
