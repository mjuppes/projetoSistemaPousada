<?php
class  RESERVA
{
    var $table_name = 'RESERVA';
    var $idreserva;
    var $idquarto;
    var $idhospede;
    var $datainicial;
    var $datafinal;
	
	function getIdreserva()
	{
		return $this->idreserva;
	}
	function setIdreserva($idreserva)
	{
		$this->idreserva = $idreserva;
	}
	
	function getIdquarto()
	{
		return $this->idquarto;
	}
	function setIdquarto($idquarto)
	{
		$this->idquarto = $idquarto;
	}
	
	function getIdhospede()
	{
		return $this->idhospede;
	}
	function setIdhospede($idhospede)
	{
		$this->idhospede = $idhospede;
	}
	
	function getDatainicial()
	{
		return $this->datainicial;
	}
	function setDatainicial($datainicial)
	{
		$this->datainicial = $datainicial;
	}
	
	function getDatafinal()
	{
		return $this->datafinal;
	}
	function setDatafinal($datafinal)
	{
		$this->datafinal = $datafinal;
	}
	
	function lastIdreserva()
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->lastRecordSet("idreserva",$this->table_name);
		$Bd->closeConnect();
		return $resposta;
	}

	function insert($arrDados,$campo=false)
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'insert');
		$Bd->closeConnect();
		return $resposta;
	}

	function selectReserva($arr,$where=false,$whereFiltro = false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "	SELECT 
						r.idreserva,
						q.nomequarto,
						COUNT(rh.id_reserva) as num_hospedes,
						CONVERT(VARCHAR(10), r.datainicial, 103) AS datainicial,
						CONVERT(VARCHAR(10), r.datafinal, 103) AS datafinal,
						(CASE
							WHEN r.opcao = 'S' THEN 'Solteiro'
							WHEN r.opcao = 'C' THEN 'Casal'
							WHEN r.opcao = 'O' THEN 'Outros'
						END) AS opcao
					FROM RESERVA r
						join RESERVA_HOSPEDE rh ON rh.id_reserva = r.idreserva
						JOIN QUARTO q ON q.idquarto = r.idquarto
					WHERE r.idreserva NOT IN
								(SELECT idreserva
								 FROM cancelamento)
					";

		if(!empty($where))
			$strSQL .= "  $where";

		if(!empty($arr))
			$strSQL .= "  q.idquarto = ".$arr['idquarto'];

		$strSQL .= " group by r.idreserva, q.nomequarto,r.datainicial,r.datafinal,r.opcao ";
		$strSQL .=" order by r.datainicial,r.datafinal desc";
		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	function selectGraficoQuarto($where=false)
	{
	
		
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "	
		select * from (select h.idquarto,q.nomequarto,count(h.idhospede) as qtd,
							month(h.datainicial) as mesIni ,
							month(h.datafinal) as mesFin,
							year (h.datafinal) as ano
							from HISTORICO h
							inner join QUARTO q on q.idquarto = h.idquarto
							where h.idreserva not in (select idreserva from CANCELAMENTO)
					group by  h.idquarto,q.nomequarto,month(h.datainicial),month(h.datafinal),year(h.datafinal)
union all
select r.idquarto,q.nomequarto,count(r.idhospede) as qtd,
							month(r.datainicial) as mesIni ,
							month(r.datafinal) as mesFin,
							year (r.datafinal) as ano
							from reserva r
							inner join QUARTO q on q.idquarto = r.idquarto
							where r.idreserva not in (select idreserva from CANCELAMENTO)
					group by  r.idquarto,q.nomequarto,month(r.datainicial),month(r.datafinal),year(r.datafinal)) t
					$where
					order by t.idquarto asc";

		/*
			$strSQL = "	select * from (select h.idquarto,q.nomequarto,count(h.idhospede) as qtd,
								month(h.datainicial) as mesIni ,
								month(h.datafinal) as mesFin 
								from HISTORICO h
								inner join QUARTO q on q.idquarto = h.idquarto
						group by  h.idquarto,q.nomequarto,month(h.datainicial),month(h.datafinal)
						union all
						select r.idquarto,q.nomequarto,count(r.idhospede) as qtd,
								month(r.datainicial) as mesIni ,
								month(r.datafinal) as mesFin 
								from reserva r
								inner join QUARTO q on q.idquarto = r.idquarto
						group by  r.idquarto,q.nomequarto,month(r.datainicial),month(r.datafinal)) t
						order by t.idquarto desc ";
		*/

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

/*
	function selectReserva($arr,$where=false,$whereFiltro = false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select q.nomequarto,t.qtd, (case when t.qtd = 0 then 'Indisponivel' else 'Disponivel' end) as disponibilidade from (
						select r.idquarto,((select qtdvaga from quarto where idquarto = r.idquarto) - count(idhospede)) as qtd    from reserva r
					group by idquarto) t inner join quarto q 
					on t.idquarto = q.idquarto
					union all
					select nomequarto, qtdvaga as qtd, (case when disponibilidade = 1 then 'Disponivel' end) as disponibilidade
					from quarto where idquarto  not in (select idquarto from reserva group by idquarto)";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}
*/

/*
	public function selectReservaHospede($arr,$where=false,$whereFiltro = false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select r.idreserva,q.nomequarto, h.nome as nomehospede, CONVERT(VARCHAR(10),r.datainicial,103) as datainicial,
							CONVERT(VARCHAR(10),r.datafinal,103) as datafinal,(case when opcao = 'S' then 'Solteiro' else 'Casal' end) as opcao
						from reserva r
						inner join quarto q on r.idquarto = q.idquarto
						inner join hospede h on r.idhospede = h.idhospede";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}
*/
	function selectDadosJsonReserva($idreserva)
	{
			$Bd = new Bd(CONEXAO);
			$dadosRecordSet = array();

			$strSQL = "select pq.idpreco,r.observacao,r.idreserva,q.nomequarto,q.idquarto,
			
			 CONVERT(VARCHAR(10),r.datainicial,103) as datainicial,
							CONVERT(VARCHAR(10),r.datafinal,103) as datafinal,r.opcao,
							(CASE
								WHEN r.opcao = 'C' THEN 'Casal'
								WHEN r.opcao = 'S' THEN 'Solteiro'
								WHEN r.opcao = '0' THEN 'Outros'
							END) AS opcaoQ, r.idpagamento,tipopagamento
						from reserva r
						inner join quarto q on r.idquarto = q.idquarto
						
						join PRECOQUARTO pq on  pq.idpreco = r.idpreco
						where r.idreserva = $idreserva";

			$dadosRecordSet = $Bd->execQuery($strSQL,true);

			foreach($dadosRecordSet as $dados)
			{
					$arrJson = array('idreserva'=>$dados["idreserva"],
									'nomequarto'=>utf8_encode($dados["nomequarto"]),
									'nomehospede'=>utf8_encode($dados["nomehospede"]),
									'datainicial'=>$dados["datainicial"],
									'observacao'=>$dados["observacao"],
									'datafinal'=>$dados["datafinal"],
									'idquarto'=>$dados["idquarto"],
									'idhospede'=>$dados["idhospede"],
									'opcao'=>$dados["opcao"],
									'opcaoQ'=>$dados["opcaoQ"],
									'idpreco'=>$dados["idpreco"],
									'tipo_pagamento'=>$dados["tipopagamento"],
									'idpagamento'=>$dados["idpagamento"]);
			}
			$Bd->closeConnect();
			return json_encode($arrJson);
	}

	function update($arrDados)
	{
		$str = 'idreserva = '.$arrDados["idreserva"];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$str,'idreserva');
		$Bd->closeConnect();
		return $resposta;
	}

	function delete($arrDados)
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->execProcedure("SP_HISTORICO",$arrDados["idreserva"]);
		$Bd->closeConnect();
		return $resposta;
	}

	public function selectHistorico($arr,$where=false,$whereFiltro = false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select q.nomequarto, hp.nome,CONVERT(VARCHAR(10),h.datainicial,103) as datainicial
					,CONVERT(VARCHAR(10),h.datafinal,103) as datafinal,
					(case when h.opcao  = 'C' then 'Casal' else 'Solteiro' end) as opcao,
					(case when e.nomeempresa is null then 'Pesso Física' else e.nomeempresa end) as nomeempresa
					  from historico h
					inner join hospede hp on h.idhospede = hp.idhospede
					inner join quarto q on q.idquarto = h.idquarto
					left join empresa e on e.idempresa = hp.idempresa
					where h.idreserva not in (select idreserva from CANCELAMENTO)
					order by  h.idhistorico desc";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	public function verificaPeriodo($idquarto,$dataIni,$dataFim)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select * from reserva where idquarto = $idquarto
			and (datainicial BETWEEN '$dataIni' AND '$dataFim' or datafinal BETWEEN '$dataIni' AND '$dataFim')
			where idreserva not in (select idreserva from cancelamento)		";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if(empty($dadosRecordSet))
			$resposta = "0";
		else
			$resposta = "1";

		$Bd->closeConnect();
		return $resposta;
	}

	public function selectVendasReserva($idhospede)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select v.idvenda,h.nome as nomehospede,c.nomecategoria, p.nomeproduto,p.valor,
							CONVERT(VARCHAR(10),v.datavenda,103) as datavenda
						from reserva r
							inner join hospede h on r.idhospede = h.idhospede
							inner join venda v on r.idhospede = v.idhospede
							inner join produtos p on p.idproduto = v.idproduto
							inner join categoria c on c.idcategoria = p.idcategoria
				where r.idhospede = $idhospede order by datavenda asc";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	
	public function selectHistoricoReserva($idhospede,$where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		

		$strSQL = "
				 select t.nomequarto,
						CONVERT(VARCHAR(10),t.datainicial,103)datainicial,
						CONVERT(VARCHAR(10),t.datafinal,103)datafinal,
						t.opcao,
						t.tipopagamento,
						replace(t.preco , '.', ',') as totreserv,
						(t.qtddias * t.preco ) as calcreserv,
						
						
						(select (case when SUM(valordesconto) is null then 0 else SUM(valordesconto) end) 
						from DESCONTO WHERE idreserva = t.idreserva) as somadesconto,

						(case when t.valordesconto is null then 
						((t.qtddias * t.preco )+(select (case when SUM(p.valor) IS null then 0 else SUM(p.valor * v.quantidade) end) from VENDA v
				join PRODUTOS p on v.idproduto = p.idproduto
				 where v.idhospede = t.idhospede
				  and v.datavenda 
				 BETWEEN t.datainicial and t.datafinal
				 )) - (case when  t.totpagamento is null then 0 else t.totpagamento end)
				 else
				((t.qtddias * t.preco 
						 +(select (case when SUM(p.valor) IS null then 0 else SUM(p.valor * v.quantidade) end) from VENDA v
				join PRODUTOS p on v.idproduto = p.idproduto
				 where v.idhospede = t.idhospede
				  and v.datavenda BETWEEN t.datainicial and t.datafinal
				 )) - ( t.totpagamento+t.valordesconto)) end) valort,
				 
				 (case when t.totpagamento is null then 0 else   t.totpagamento end) totpago,
				 
				(replace( t.qtddias * t.preco +
						(select (case when SUM(p.valor) IS null then 0 else SUM(p.valor * v.quantidade) end) from VENDA v
				join PRODUTOS p on v.idproduto = p.idproduto
				 where v.idhospede = t.idhospede
				  and v.datavenda 
				 BETWEEN t.datainicial and t.datafinal
				 ), '.', ',')  ) as totalfatura,

						t.idreserva,
						t.idhospede,

				(case when (select COUNT(*) from HISTORICO where idreserva = t.idreserva) = 0 then t.desconto else 'N' end ) 
				as desconto

						from (

							select q.nomequarto,
							(case when r.opcao = 'C' then 'Casal' else 'Solteiro' end) as opcao,
							(case when r.tipopagamento = 'F' then 'Pessoa física' else 'Pessoa jurídica 'end)tipopagamento,
							 DATEDIFF(d,r.datainicial,r.datafinal) AS qtddias, 
							 (select valor from PRECOQUARTO where idpreco = r.idpreco) as preco,
							 (select SUM(valor) from PAGAMENTO where idreserva = r.idreserva and ativo is null) as totpagamento,
							 (select SUM(valordesconto) as valor from DESCONTO where idreserva = r.idreserva) as valordesconto,
							  r.idquarto,r.idhospede,r.datainicial,r.datafinal,
							  r.idpreco,r.idpagamento,r.idreserva,r.desconto from  RESERVA r
							  left join QUARTO q on q.idquarto = r.idquarto
							  left join PRECOQUARTO pc on pc.idpreco = r.idpreco
							  left join PAGAMENTO p on p.idreserva = r.idreserva
							  union all
							  select q.nomequarto,
							(case when h.opcao = 'C' then 'Casal' else 'Solteiro' end) as opcao,
							(case when h.tipopagamento = 'F' then 'Pessoa física' else 'Pessoa jurídica 'end)tipopagamento,
							 DATEDIFF(d,h.datainicial,h.datafinal) AS qtddias, 
							 (select valor from PRECOQUARTO where idpreco = h.idpreco) as preco,
							(select SUM(valor) from PAGAMENTO where idreserva = h.idreserva) as totpagamento,
							 (select SUM(valordesconto) as valor from DESCONTO where idreserva = h.idreserva) as valordesconto,
							  h.idquarto,h.idhospede,h.datainicial,h.datafinal,
							  h.idpreco,h.idpagamento,h.idreserva,h.desconto  from  HISTORICO h
							  left join QUARTO q on q.idquarto = h.idquarto
							  left join PRECOQUARTO pc on pc.idpreco = h.idpreco
							  left join PAGAMENTO p on p.idreserva = h.idreserva
						) t
						where t.idhospede = $idhospede $where
				and t.idreserva not in (select idreserva from cancelamento)
					group by				  
							t.nomequarto,
		  t.opcao,
		 t.tipopagamento,
		  t.qtddias, 
		 t.preco,
		  t.totpagamento,
		  t.valordesconto,
		  t.idquarto,t.idhospede,t.datainicial,t.datafinal,
		  t.idpreco,t.idpagamento,t.idreserva,t.desconto order by t.datainicial desc, t.datafinal desc  ";

		  /*$strSQL = "
				 select t.nomequarto,
						CONVERT(VARCHAR(10),t.datainicial,103)datainicial,
						CONVERT(VARCHAR(10),t.datafinal,103)datafinal,
						t.opcao,t.tipopagamento,
						replace(t.preco , '.', ',') as totreserv,
						(t.qtddias * t.preco ) as calcreserv,
						
						(replace( t.qtddias * t.preco +
						
						(select (case when SUM(p.valor) IS null then 0 else SUM(p.valor * v.quantidade) end) from VENDA v
				join PRODUTOS p on v.idproduto = p.idproduto
				 where v.idhospede = t.idhospede
				  and v.datavenda 
				 BETWEEN t.datainicial and t.datafinal
				 ), '.', ',')  ) valort,
				 
						(case when t.valordesconto is null then 
						((t.qtddias * t.preco )+(select (case when SUM(p.valor) IS null then 0 else SUM(p.valor * v.quantidade) end) from VENDA v
				join PRODUTOS p on v.idproduto = p.idproduto
				 where v.idhospede = t.idhospede
				  and v.datavenda 
				 BETWEEN t.datainicial and t.datafinal
				 
				 )) - (case when  t.totpagamento is null then 0 else t.totpagamento end)
						 else ((t.qtddias * t.preco 
						 +(select (case when SUM(p.valor) IS null then 0 else SUM(p.valor * v.quantidade) end) from VENDA v
				join PRODUTOS p on v.idproduto = p.idproduto
				 where v.idhospede = t.idhospede
				  and v.datavenda BETWEEN t.datainicial and t.datafinal
				 )) - ( t.totpagamento+t.valordesconto)) end) valort,
				 
						(case when t.totpagamento is null then 0 else   t.totpagamento end) totpago,
						t.idreserva,t.idhospede

						from (

							select q.nomequarto,
							(case when r.opcao = 'C' then 'Casal' else 'Solteiro' end) as opcao,
							(case when r.tipopagamento = 'F' then 'Pessoa física' else 'Pessoa jurídica 'end)tipopagamento,
							 DATEDIFF(d,r.datainicial,r.datafinal) AS qtddias, 
							 (select valor from PRECOQUARTO where idpreco = r.idpreco) as preco,
							 (select SUM(valor) from PAGAMENTO where idreserva = r.idreserva) as totpagamento,
							 (select SUM(valordesconto) as valor from DESCONTO where idreserva = r.idreserva) as valordesconto,
							  r.idquarto,r.idhospede,r.datainicial,r.datafinal,
							  r.idpreco,r.idpagamento,r.idreserva,r.desconto from  RESERVA r
							  left join QUARTO q on q.idquarto = r.idquarto
							  left join PRECOQUARTO pc on pc.idpreco = r.idpreco
							  left join PAGAMENTO p on p.idreserva = r.idreserva
							  union all
							  select q.nomequarto,
							(case when h.opcao = 'C' then 'Casal' else 'Solteiro' end) as opcao,
							(case when h.tipopagamento = 'F' then 'Pessoa física' else 'Pessoa jurídica 'end)tipopagamento,
							 DATEDIFF(d,h.datainicial,h.datafinal) AS qtddias, 
							 (select valor from PRECOQUARTO where idpreco = h.idpreco) as preco,
							(select SUM(valor) from PAGAMENTO where idreserva = h.idreserva) as totpagamento,
							 (select SUM(valordesconto) as valor from DESCONTO where idreserva = h.idreserva) as valordesconto,
							  h.idquarto,h.idhospede,h.datainicial,h.datafinal,
							  h.idpreco,h.idpagamento,h.idreserva,h.desconto  from  HISTORICO h
							  left join QUARTO q on q.idquarto = h.idquarto
							  left join PRECOQUARTO pc on pc.idpreco = h.idpreco
							  left join PAGAMENTO p on p.idreserva = h.idreserva
						) t
						where t.idhospede = $idhospede $where
				and t.idreserva not in (select idreserva from cancelamento)
					group by				  
							t.nomequarto,
		  t.opcao,
		 t.tipopagamento,
		  t.qtddias, 
		 t.preco,
		  t.totpagamento,
		  t.valordesconto,
		  t.idquarto,t.idhospede,t.datainicial,t.datafinal,
		  t.idpreco,t.idpagamento,t.idreserva,t.desconto order by t.datainicial desc, t.datafinal desc  ";

*/
		  
		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectHistoricoHospede($idvenda,$where=false)
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
	}

	public function selectReservaAndamento()
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select r.idreserva, (select count(*) from reserva where idquarto = r.idquarto) as qtd,q.idquarto,r.idquarto,nomequarto,	CONVERT(VARCHAR(10),r.datafinal,111) as datafinal1,
						CONVERT(VARCHAR(10),r.datainicial,103) as datainicial,CONVERT(VARCHAR(10),r.datafinal,103) as datafinal2
						from reserva r inner join quarto q on r.idquarto = q.idquarto order by  r.datainicial,r.datafinal desc";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectVendaPorHospede($where)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "	select c.nomecategoria,p.nomeproduto,replace(p.valor , '.', ',') as	valor,(case when v.idtipo = 1 then 'Pessoa fisica' else 'Pessoa juridica' end) as tipovenda from RESERVA r
					join HOSPEDE h on r.idhospede = h.idhospede
					join VENDA v on v.idhospede = h.idhospede
					join CATEGORIA c on c.idcategoria = v.idcategoria
					join PRODUTOS p on p.idproduto = v.idproduto
					 where  $where  and v.datavenda between r.datainicial and r.datafinal
					group by c.nomecategoria,p.nomeproduto,p.valor,v.idtipo
					union all
					select 'Valor geral ','', replace(sum(p.valor) , '.', ',') as	valor,'' from RESERVA r
					join HOSPEDE h on r.idhospede = h.idhospede
					join VENDA v on v.idhospede = h.idhospede
					join PRODUTOS p on p.idproduto = v.idproduto
					 where  $where and v.datavenda between r.datainicial and r.datafinal";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}


	function descontaReserva($arrDados)
	{
		$str = 'idreserva = '.$arrDados["idreserva"];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$str,'idreserva');
		$Bd->closeConnect();
		return $resposta;
	}
	
	
	public function verificaDesconto($idreserva)
	{
		$Bd = new Bd(CONEXAO);

		$strSQL = "select (case when desconto = 'S' then 'true' else 'false' end) as resposta
				from RESERVA where
				idreserva = $idreserva";

		$resposta = $Bd->getOneRecordSet($strSQL,"resposta");
		$Bd->closeConnect();
		return $resposta;
	}

	public function selectConsumoVenda($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "  select c.nomecategoria,p.nomeproduto,
					v.quantidade as qtd ,sum(p.valor * v.quantidade) as	valor, (convert(varchar(100),v.datavenda,103)) as datavenda, h.nome
					from RESERVA r
						join HOSPEDE h on r.idhospede = h.idhospede
						join VENDA v on v.idhospede = h.idhospede
						join CATEGORIA c on c.idcategoria = v.idcategoria
						join PRODUTOS p on p.idproduto = v.idproduto
				 where  $where  and v.datavenda between r.datainicial and r.datafinal
		group by c.nomecategoria,p.nomeproduto,p.valor,v.idtipo,v.datavenda,h.nome,v.quantidade";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	public function somaValorDiaria($idreserva)
	{
		$Bd = new Bd(CONEXAO);

		$strSQL = "	select replace((DATEDIFF(d,r.datainicial,r.datafinal) * pq.valor), '.', ',')  as valor  from RESERVA r
					join PRECOQUARTO pq on r.idpreco = pq.idpreco
		 where idreserva = $idreserva";

		$resposta = $Bd->getOneRecordSet($strSQL,"valor");
		$Bd->closeConnect();
		return $resposta;
	}

	public function somaConsumoRel($idreserva)
	{
		$Bd = new Bd(CONEXAO);

		$strSQL = "		
		select 	replace(sum(p.valor* v.quantidade), '.', ',') as	consumo
						from RESERVA r
							join HOSPEDE h on r.idhospede = h.idhospede
							join VENDA v on v.idhospede = h.idhospede
							join PRODUTOS p on p.idproduto = v.idproduto
							 where 
							 v.idhospede = r.idhospede and
						r.idreserva=$idreserva and v.datavenda between r.datainicial and r.datafinal
    
		";

		$resposta = $Bd->getOneRecordSet($strSQL,"consumo");
		$Bd->closeConnect();
		return $resposta;
	}

	public function somaDescontoRel($idreserva)
	{
		$Bd = new Bd(CONEXAO);
/*
		$strSQL = "	select 
		replace((t.valor - (select SUM(valor) from PAGAMENTO where idreserva = t.idreserva)), '.', ',') as desconto
			from (
				select ((DATEDIFF(d,r.datainicial,r.datafinal) * pq.valor)) as valor, r.idreserva  from RESERVA r
				join PRECOQUARTO pq on pq.idpreco = r.idpreco
			where r.idreserva = $idreserva and desconto = 'S') t";*/
			$strSQL = "select '-'+
			CONVERT(VARCHAR(10),SUM(valordesconto),103) as desconto
				from DESCONTO where idreserva= $idreserva group by idreserva";

		$resposta = $Bd->getOneRecordSet($strSQL,"desconto");
		$Bd->closeConnect();
		return $resposta;
	}

	public function somaTotalRel($idreserva)
	{
		$Bd = new Bd(CONEXAO);
		$strSQL = "	
			select sum(t.total) as total from 
				( select COALESCE(sum(p.valor * v.quantidade) -
				 (select (case when sum(valordesconto) is null then 0 else  SUM(valordesconto) end) from DESCONTO where idreserva = r.idreserva),0) as total,
				r.idreserva from RESERVA r 
				join HOSPEDE h on r.idhospede = h.idhospede 
				left join VENDA v on v.idhospede = h.idhospede 
				left join PRODUTOS p on p.idproduto = v.idproduto 
				where v.idhospede = r.idhospede and 
				v.datavenda between r.datainicial and r.datafinal
				 group by p.valor,r.idreserva 
				 union
				  all select COALESCE(sum(p.valor * v.quantidade),0) as total, 
				  hist.idreserva from HISTORICO hist join HOSPEDE h on 
				  hist.idhospede = h.idhospede left join VENDA v on v.idhospede = h.idhospede
				   left join PRODUTOS p on p.idproduto = v.idproduto where v.idhospede = hist.idhospede 
				   and v.datavenda between hist.datainicial and hist.datafinal group by p.valor,hist.idreserva 
				   union all 
				   select (DATEDIFF(d,r.datainicial,r.datafinal) * pq.valor) as total,r.idreserva from RESERVA r 
				   join PRECOQUARTO pq on r.idpreco = pq.idpreco union all 
				   select (DATEDIFF(d,hist.datainicial,hist.datafinal) * pq.valor) as total,hist.idreserva from HISTORICO hist
				 join PRECOQUARTO pq on hist.idpreco = pq.idpreco )t where t.idreserva= $idreserva ";

		$resposta = $Bd->getOneRecordSet($strSQL,"total");
		$Bd->closeConnect();
		return $resposta;
	}

	public function selectRelatorioGeral($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "

	select
		t.idreserva,
		t.idhospede,
		t.nome,
		t.nomequarto,
		t.datainicial,t.datafinal,
		t.qtddias, 
		t.valorquarto,
		(t.qtddias * t.valorquarto) as valor_total,
		(select (case when SUM(valordesconto) is null then 0 else SUM(valordesconto) end) as valordesconto from DESCONTO where idreserva = t.idreserva) as desconto,
		(sum(t.valor)  - (select (case when SUM(valordesconto) is null then 0 else SUM(valordesconto) end) as valordesconto from DESCONTO where idreserva = t.idreserva)) as valor_pago
	from  (
	select
		h.idhospede,
		q.idquarto,
		h.nome, 
		q.nomequarto,
		DATEDIFF(d,r.datainicial,r.datafinal) AS qtddias, 
		(convert(varchar(100),r.datainicial,103)) as datainicial,
		(convert(varchar(100),r.datafinal,103)) as datafinal,
		pq.valor as valorquarto,
		r.desconto,
		r.idreserva,
		p.valor,
		r.datainicial as datainicial_2
	from RESERVA r 
		join HOSPEDE h on  h.idhospede = r.idhospede
		join QUARTO q on q.idquarto = r.idquarto
		join PRECOQUARTO pq on pq.idpreco = r.idpreco
		join PAGAMENTO p on p.idreserva = r.idreserva
		
		


	) t";

	if(!empty($where))
		$strSQL .= " where $where ";

	$strSQL .= "
	group by 
		t.idhospede,
		t.nome,
		t.nomequarto,
		t.datainicial,
		t.datafinal,
		t.qtddias, 
		t.idreserva,
		t.valorquarto
	union all
	select
		t.idreserva,
		t.idhospede,
		t.nome,
		t.nomequarto,
		t.datainicial,t.datafinal,
		t.qtddias,
		t.valorquarto,
		(t.qtddias * t.valorquarto) as valor_total,
		(select (case when SUM(valordesconto) is null then 0 else SUM(valordesconto) end) as valordesconto from DESCONTO where idreserva = t.idreserva) as desconto,
		(sum(t.valor)  - (select (case when SUM(valordesconto) is null then 0 else SUM(valordesconto) end) as valordesconto from DESCONTO where idreserva = t.idreserva)) as valor_pago
		
	from  (
	select
		h.idhospede,
		q.idquarto,
		h.nome, 
		q.nomequarto,
		DATEDIFF(d,ht.datainicial,ht.datafinal) AS qtddias, 
		(convert(varchar(100),ht.datainicial,103)) as datainicial,
		(convert(varchar(100),ht.datafinal,103)) as datafinal,
		pq.valor as valorquarto,
		ht.desconto,
		ht.idreserva,
		p.valor,
		ht.datainicial as datainicial_2
	from HISTORICO ht
		join HOSPEDE h on  h.idhospede = ht.idhospede
		join QUARTO q on q.idquarto = ht.idquarto
		join PRECOQUARTO pq on pq.idpreco = ht.idpreco
		join PAGAMENTO p on p.idreserva = ht.idreserva

	) t ";

	if(!empty($where))
		$strSQL .= " where $where ";

	$strSQL.="
	group by
		t.idreserva,
		t.idhospede,
		t.idquarto,
		t.nome,
		t.nomequarto,
		t.qtddias,
		t.datainicial,
		t.datafinal,
		t.valorquarto		
	";

		// $strSQL .= " order by t.nome asc	";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}


	public function selectRelatorioGeralTotal($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		if(!empty($where))
			$where = ' where '.$where;
		
	$strSQL = "
	select SUM(t2.valor_total) as valor_total, SUM(t2.desconto) as desconto, SUM(t2.valor_pago) as valor_pago from (
			select
				(t.qtddias * t.valorquarto) as valor_total,
				(select (case when SUM(valordesconto) is null then 0 else SUM(valordesconto) end) as valordesconto
		 from DESCONTO where idreserva = t.idreserva) as desconto,
				(sum(t.valor)  - (select (case when SUM(valordesconto) is null then 0 else SUM(valordesconto) end)
		 as valordesconto from DESCONTO where idreserva = t.idreserva)) as valor_pago
			from  (
			select
				DATEDIFF(d,r.datainicial,r.datafinal) AS qtddias, 
				pq.valor as valorquarto,
				r.desconto,
				r.idreserva,
				p.valor,
				r.datainicial
				
			from RESERVA r 
				join HOSPEDE h on  h.idhospede = r.idhospede
				join QUARTO q on q.idquarto = r.idquarto
				join PRECOQUARTO pq on pq.idpreco = r.idpreco
				join PAGAMENTO p on p.idreserva = r.idreserva
				 $where
			) t
			group by 
				t.qtddias, 
				t.idreserva,
				t.valorquarto
			union all
			select
				(t.qtddias * t.valorquarto) as valor_total,
				(select (case when SUM(valordesconto) is null then 0 else SUM(valordesconto) end) as valordesconto
		 from DESCONTO where idreserva = t.idreserva) as desconto,
				(sum(t.valor)  - (select (case when SUM(valordesconto) is null then 0 else SUM(valordesconto) end)
		 as valordesconto from DESCONTO where idreserva = t.idreserva)) as valor_pago
				
			from  (
			select
				DATEDIFF(d,r.datainicial,r.datafinal) AS qtddias, 
				pq.valor as valorquarto,
				r.desconto,
				r.idreserva,
				p.valor,
				r.datainicial
			from HISTORICO r
				join HOSPEDE h on  h.idhospede = r.idhospede
				join QUARTO q on q.idquarto = r.idquarto
				join PRECOQUARTO pq on pq.idpreco = r.idpreco
				join PAGAMENTO p on p.idreserva = r.idreserva
			 $where
			) t 
			group by
				t.idreserva,
				t.qtddias,
				t.valorquarto		) t2 
		";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectGraficoFatAnual($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "  
			select * from (
				select month(r.datainicial) as mes,sum(pq.valor) as valor from RESERVA r
				join PRECOQUARTO pq on pq.idpreco = r.idpreco
				 where r.idreserva not in (select idreserva from CANCELAMENTO)
					$where
				group by month(r.datainicial)				
				union all 
				select month(r.datainicial) as mes,sum(pq.valor) as valor from HISTORICO r
				join PRECOQUARTO pq on pq.idpreco = r.idpreco
				 where r.idreserva not in (select idreserva from CANCELAMENTO)
					$where 
				group by month(r.datainicial)				
			) t order by t.mes asc";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);
	
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