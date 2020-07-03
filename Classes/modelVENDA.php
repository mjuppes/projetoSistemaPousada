<?php
class  VENDA
{
    var $table_name = 'VENDA';
    var $idvenda;
    var $idcategoria;
    var $idproduto;
    var $idhospede;
    var $idtipo;
    var $datavenda;
	
	function getIdvenda()
	{
		return $this->idvenda;
	}
	function setIdvenda($idvenda)
	{
		$this->idvenda = $idvenda;
	}
	
	function getIdcategoria()
	{
		return $this->idcategoria;
	}
	function setIdcategoria($idcategoria)
	{
		$this->idcategoria = $idcategoria;
	}
	
	function getIdproduto()
	{
		return $this->idproduto;
	}
	function setIdproduto($idproduto)
	{
		$this->idproduto = $idproduto;
	}
	
	function getIdhospede()
	{
		return $this->idhospede;
	}
	function setIdhospede($idhospede)
	{
		$this->idhospede = $idhospede;
	}
	
	function getIdtipo()
	{
		return $this->idtipo;
	}
	function setIdtipo($idtipo)
	{
		$this->idtipo = $idtipo;
	}
	
	function getDatavenda()
	{
		return $this->datavenda;
	}
	function setDatavenda($datavenda)
	{
		$this->datavenda = $datavenda;
	}

	function insert($arrDados,$campo=false)
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'insert');
		$Bd->closeConnect();
		return $resposta;
	}

	public function selectVendas($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select v.idvenda, h.nome as nomehospede, c.nomecategoria,p.nomeproduto,
						CONVERT(VARCHAR(10),v.datavenda,103) as datavenda,
						REPLACE(p.valor,'.',',') as valor,
						v.quantidade,
						REPLACE(v.valor_total,'.',',') as valor_total,h.idhospede
					from venda v
						join categoria c on v.idcategoria = c.idcategoria
						join produtos p on p.idproduto = v.idproduto
						join hospede h on h.idhospede = v.idhospede where v.ativo is null ";

		if($where)
			$strSQL .= $where;

		$strSQL .=" order by h.nome asc ";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	
	public function selectVendasTotal($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select 'Total de vendas: ' as descricao,REPLACE(SUM(v.quantidade * p.valor),'.',',') as valorTotal
						from venda v
							 join categoria c on v.idcategoria = c.idcategoria
							 join produtos p on p.idproduto = v.idproduto
							 join hospede h on h.idhospede = v.idhospede
					where v.ativo is null	";

		if($where)
			$strSQL .= $where;

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	
	
	}

	function selectDadosJsonVenda($idvenda)
	{
			$Bd = new Bd(CONEXAO);
			$dadosRecordSet = array();

			$strSQL = "select v.idvenda, h.nome as nomehospede, c.nomecategoria,p.nomeproduto,
						CONVERT(VARCHAR(10),v.datavenda,103) as datavenda, c.idcategoria,p.idproduto,h.idhospede,
						v.idtipo,v.quantidade
						from venda v
					inner join categoria c on v.idcategoria = c.idcategoria
					inner join produtos p on p.idproduto = v.idproduto
					inner join hospede h on h.idhospede = v.idhospede
					where idvenda = $idvenda";

			$dadosRecordSet = $Bd->execQuery($strSQL,true);

			foreach($dadosRecordSet as $dados)
			{
					$arrJson = array('idvenda'=>$dados["idvenda"],
									 'nomehospede'=>utf8_encode($dados["nomehospede"]),
									 'nomecategoria'=>$dados["nomecategoria"],
									 'nomeproduto'=>utf8_encode($dados["nomeproduto"]),
									 'datavenda'=>$dados["datavenda"],
									 'idcategoria'=>$dados["idcategoria"],
									 'idproduto'=>$dados["idproduto"],
									 'idhospede'=>$dados["idhospede"],
									 'idtipo'=>$dados["idtipo"],
									 'quantidade'=>$dados["quantidade"]);
			}

			$Bd->closeConnect();
			return json_encode($arrJson);
	}

	function update($arrDados)
	{
		$chave = 'idvenda = '.$arrDados['idvenda'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'idvenda');
		$Bd->closeConnect();
		return $resposta;
	}
	
	public function delete($idvenda)
	{
		
		$Bd = new Bd(CONEXAO);
		$chave = 'idvenda = '.$idvenda;
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave,'idvenda');
		$Bd->closeConnect();
		return $resposta;
	}
	/*
	function selectHistoricoVenda($idvenda,$where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select h.nome as nomehospede,q.nomequarto,q.localizacao,
							(case when e.nomeempresa is null then '--------------' else e.nomeempresa end) as nomeempresa
							,CONVERT(VARCHAR(10),r.datainicial,103) as datainicial
							,CONVERT(VARCHAR(10),r.datafinal,103) as datafinal
							 from venda v
							left join reserva r on r.idhospede = v.idhospede
							left join quarto q on q.idquarto = r.idquarto
							inner join hospede h on h.idhospede = v.idhospede
							left join empresa e on e.idempresa = h.idempresa
					where v.idvenda = $idvenda";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}*/

	public function selectHistoricoVenda($idhospede,$where=false)
	{
	
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "	select v.idhospede,c.nomecategoria,p.nomeproduto,v.quantidade,
							replace((p.valor * v.quantidade) , '.', ',') as	valor ,
							 CONVERT(VARCHAR(10),v.datavenda,103) datavenda
							 from  VENDA v
							 join CATEGORIA c on v.idcategoria = c.idcategoria
							 join PRODUTOS p on p.idproduto = v.idproduto
							  where v.idhospede =  $idhospede";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
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