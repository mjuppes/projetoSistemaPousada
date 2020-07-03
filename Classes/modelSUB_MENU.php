<?php
class  SUB_MENU
{
    var $table_name = 'SUB_MENU';
    var $id_sub_menu;
    var $label;
    var $idordem;
    var $icone;
    var $iditens;
	
	function getId_sub_menu()
	{
		return $this->id_sub_menu;
	}
	function setId_sub_menu($id_sub_menu)
	{
		$this->id_sub_menu = $id_sub_menu;
	}

	
	function getLabel()
	{
		return $this->label;
	}
	function setLabel($label)
	{
		$this->label = $label;
	}

	
	function getIdordem()
	{
		return $this->idordem;
	}
	function setIdordem($idordem)
	{
		$this->idordem = $idordem;
	}

	
	function getIcone()
	{
		return $this->icone;
	}
	function setIcone($icone)
	{
		$this->icone = $icone;
	}

	
	function getIditens()
	{
		return $this->iditens;
	}
	function setIditens($iditens)
	{
		$this->iditens = $iditens;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_sub_menu ,LINK, label LABELMENU,
		idordem,icone ICONE,iditens,titulo as TITLE from SUB_MENU '.$where;
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_sub_menu ,label,idordem,icone,iditens from SUB_MENU';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_sub_menu'=>$dados['id_sub_menu']
								,'label'=>$dados['label']
								,'idordem'=>$dados['idordem']
								,'icone'=>$dados['icone']
								,'iditens'=>$dados['iditens']
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
		$chave = 'id_sub_menu = '.$arrDados['id_sub_menu'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_sub_menu');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_sub_menu = '.$arrDados['id_sub_menu'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
