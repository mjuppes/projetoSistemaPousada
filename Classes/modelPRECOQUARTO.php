<?php
class  PRECOQUARTO
{
    var $table_name = 'PRECOQUARTO';
    var $idpreco;
    var $valor;
    
	function getIdpreco()
	{
		return $this->idpreco;
	}
	function setIdpreco($idpreco)
	{
		$this->idpreco = $idpreco;
	}
	
	function getValor()
	{
		return $this->valor;
	}
	function setValor($valor)
	{
		$this->valor = $valor;
	}

	function insert($arrDados)
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'insert');
		$Bd->closeConnect();
		return $resposta;
	}

	function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select
						idpreco,
						q.nomequarto, 
						REPLACE(pc.valor,'.',',') as valor,
						pc.idquarto
					from PRECOQUARTO pc
						join QUARTO q on q.idquarto = pc.idquarto ";
						
		if(!empty($where))
			$strSQL .= $where;

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	function update($arrDados)
	{
		$str = 'idpreco = '.$arrDados["idpreco"];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$str,'');
		$Bd->closeConnect();
		return $resposta;
	}

	function selectDadosJson($idpreco)
	{
			$Bd = new Bd(CONEXAO);
			$dadosRecordSet = array();
			$strSQL = "select idpreco,valor,idquarto   FROM PRECOQUARTO  where idpreco = $idpreco";

			$dadosRecordSet = $Bd->execQuery($strSQL,true);

			foreach($dadosRecordSet as $dados)
			{
					$arrJson = array('idpreco'=>$dados["idpreco"],
									 'valor'=>utf8_encode($dados["valor"]),
									 'idquarto'=>utf8_encode($dados["idquarto"]));
			}

			$Bd->closeConnect();
			return json_encode($arrJson);
	}

	function delete($idpreco)
	{
		$Bd = new Bd(CONEXAO);
		$str = 'idpreco = '.$idpreco;
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$str,'idpreco');
		$Bd->closeConnect();
		return $resposta;
	}

	function verificaValor($idquarto,$valor)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = "select valor  FROM PRECOQUARTO  where idquarto = $idquarto and valor = '$valor'";
		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
}
?>