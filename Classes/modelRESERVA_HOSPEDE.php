<?php
class  RESERVA_HOSPEDE
{
    var $table_name = 'RESERVA_HOSPEDE';
    var $id_reserv_hospede;
    var $id_reserva;
    var $id_hospede;
	
	function getId_reserv_hospede()
	{
		return $this->id_reserv_hospede;
	}
	function setId_reserv_hospede($id_reserv_hospede)
	{
		$this->id_reserv_hospede = $id_reserv_hospede;
	}

	
	function getId_reserva()
	{
		return $this->id_reserva;
	}
	function setId_reserva($id_reserva)
	{
		$this->id_reserva = $id_reserva;
	}

	
	function getId_hospede()
	{
		return $this->id_hospede;
	}
	function setId_hospede($id_hospede)
	{
		$this->id_hospede = $id_hospede;
	}

	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = '
			select  
						id_reserv_hospede,
						rh.id_hospede,
						h.nome 
			from RESERVA_HOSPEDE rh 
					join HOSPEDE h on h.idhospede = rh.id_hospede
		';

		if(!empty($where))
			$strSQL .= " $where";

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_reserv_hospede ,id_reserva,id_hospede from RESERVA_HOSPEDE';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_reserv_hospede'=>$dados['id_reserv_hospede']
								,'id_reserva'=>$dados['id_reserva']
								,'id_hospede'=>$dados['id_hospede']
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
		if(isset($arrDados['id_reserv_hospede']))
			$chave = 'id_reserv_hospede = '.$arrDados['id_reserv_hospede'];
		else
		{
			$chave = ' id_reserva = '.$arrDados['id_reserva'].' and id_hospede in ('.$arrDados['id_hospede'].')';
			unset($arrDados['id_reserva']);
			unset($arrDados['id_hospede']);
		}

		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_reserv_hospede');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_reserv_hospede = '.$arrDados['id_reserv_hospede'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
	
	public function insert_massive($arrDados)
	{
		$Bd = new Bd(CONEXAO);
 		$resposta = $Bd->insert_massive($arrDados,$this->table_name);

		$Bd->closeConnect();
		return $resposta;
	}
}
?>
