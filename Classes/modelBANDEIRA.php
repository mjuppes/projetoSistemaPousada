<?php
class  BANDEIRA
{
    var $table_name = 'BANDEIRA';
    var $id_bandeira;
    var $bandeira;
	
	function getId_bandeira()
	{
		return $this->id_bandeira;
	}
	function setId_bandeira($id_bandeira)
	{
		$this->id_bandeira = $id_bandeira;
	}

	
	function getBandeira()
	{
		return $this->bandeira;
	}
	function setBandeira($bandeira)
	{
		$this->bandeira = $bandeira;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_bandeira ,bandeira from BANDEIRA';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_bandeira ,bandeira from BANDEIRA';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_bandeira'=>$dados['id_bandeira']
								,'bandeira'=>$dados['bandeira']
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
		$chave = 'id_bandeira = '.$arrDados['id_bandeira'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_bandeira');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_bandeira = '.$arrDados['id_bandeira'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
