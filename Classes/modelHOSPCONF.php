<?php
class  HOSPCONF
{
    var $table_name = 'HOSPCONF';
    var $idhospconf;
    var $idhospede;
    var $idreserva;
    var $obs;
	
	function getIdhospconf()
	{
		return $this->idhospconf;
	}
	function setIdhospconf($idhospconf)
	{
		$this->idhospconf = $idhospconf;
	}

	
	function getIdhospede()
	{
		return $this->idhospede;
	}
	function setIdhospede($idhospede)
	{
		$this->idhospede = $idhospede;
	}

	
	function getIdreserva()
	{
		return $this->idreserva;
	}
	function setIdreserva($idreserva)
	{
		$this->idreserva = $idreserva;
	}

	
	function getObs()
	{
		return $this->obs;
	}
	function setObs($obs)
	{
		$this->obs = $obs;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = "
				select h.idhospede,h.nome from HOSPCONF hc
				join HOSPEDE h on h.idhospede = hc.idhospede
				 join RESERVA r on hc.idreserva = r.idreserva
				where r.idreserva not in (select idreserva from cancelamento) ".$where;

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  idhospconf ,idhospede,idreserva,obs from HOSPCONF';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('idhospconf'=>$dados['idhospconf']
								,'idhospede'=>$dados['idhospede']
								,'idreserva'=>$dados['idreserva']
								,'obs'=>$dados['obs']);
		}
		$Bd->closeConnect();
		return $dadosRecordSet;
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
	
		if(isset($arrDados['idhospconf']))
			$chave = 'idhospconf = '.$arrDados['idhospconf'];
		if(isset($arrDados['idreserva']))
			$chave = 'idreserva = '.$arrDados['idreserva'];

		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'idhospconf');

		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'idhospconf = '.$arrDados['idhospconf'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
