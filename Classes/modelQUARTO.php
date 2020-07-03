<?php
class  QUARTO
{
    var $table_name = 'QUARTO';
    var $idquarto;
    var $nomequarto;
    var $disponibilidade;
    var $localizacao;
	
	function getIdquarto()
	{
		return $this->idquarto;
	}
	function setIdquarto($idquarto)
	{
		$this->idquarto = $idquarto;
	}
	
	function getNomequarto()
	{
		return $this->nomequarto;
	}
	function setNomequarto($nomequarto)
	{
		$this->nomequarto = $nomequarto;
	}
	
	function getDisponibilidade()
	{
		return $this->disponibilidade;
	}
	function setDisponibilidade($disponibilidade)
	{
		$this->disponibilidade = $disponibilidade;
	}
	
	function getLocalizacao()
	{
		return $this->localizacao;
	}
	function setLocalizacao($localizacao)
	{
		$this->localizacao = $localizacao;
	}

	function insert($arrDados,$campo=false)
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'insert');
		$Bd->closeConnect();
		return $resposta;
	}

	function selectQuartos($where='')
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select idquarto,nomequarto, qtdvaga,localizacao
						from quarto $where";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	function update($arrDados)
	{
		$str = 'idquarto = '.$arrDados["idquarto"];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$str,'idquarto');
		$Bd->closeConnect();
		return $resposta;
	}

	function selectDadosJsonQuarto($idquarto)
	{
			$Bd = new Bd(CONEXAO);
			$dadosRecordSet = array();

			$strSQL = "select idquarto,qtdvaga,nomequarto,
							disponibilidade,localizacao,itens,status,
							CONVERT(VARCHAR(10),datainicial,103) as datainicial,
							CONVERT(VARCHAR(10),datafinal,103) as datafinal
							from quarto where idquarto = $idquarto";

			$dadosRecordSet = $Bd->execQuery($strSQL,true);

			foreach($dadosRecordSet as $dados)
			{
					$arrJson = array('idquarto'=>$dados["idquarto"],
									 'nomequarto'=>$dados["nomequarto"],
									 'disponibilidade'=>$dados["disponibilidade"],
									 'localizacao'=>utf8_encode($dados["localizacao"]),
									 'qtdvaga'=>$dados["qtdvaga"],
									 'status'=>$dados["status"],
									 'datainicial'=>$dados["datainicial"],
									 'datafinal'=>$dados["datafinal"],
									 'itens'=>$dados["itens"]);
			}

			$Bd->closeConnect();
			return json_encode($arrJson);
	}

	function delete($idquarto)
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->execProcedure("SP_EXCLUIQUARTO",$idquarto);
		$Bd->closeConnect();
		return $resposta;
	}
	
	function verificaVaga($idreserva,$idquarto,$dataIni,$dataFim)
	{
		$Bd = new Bd(CONEXAO);
		$strSQL = "select (qtdvaga - (select count(idquarto) from reserva 
				where idquarto = q.idquarto and idreserva not in (select idreserva from CANCELAMENTO)
				and (datainicial BETWEEN '$dataIni' AND '$dataFim' or datafinal BETWEEN '$dataIni' AND '$dataFim')
				 and idreserva <> $idreserva
				)) as num 	
				from quarto q where idquarto = $idquarto ";

		$resposta = $Bd->getOneRecordSet($strSQL,"num");
		$Bd->closeConnect();		
		if($resposta == "0")
			return false;
		else 
			return true;
	}

	function verificaVagaRetNum($idquarto,$dataIni,$dataFim)
	{
		$Bd = new Bd(CONEXAO);
		$strSQL = "select (qtdvaga - (select count(idquarto) from reserva 
				where idquarto = q.idquarto 
				and (datainicial BETWEEN '$dataIni' AND '$dataFim' or datafinal BETWEEN '$dataIni' AND '$dataFim'))) as num 	
				from quarto q where idquarto = $idquarto";

		$resposta = $Bd->getOneRecordSet($strSQL,"num");
		$Bd->closeConnect();		

		return $resposta;
	}
}
?>