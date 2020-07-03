<?php
class  PAGAMENTO
{
    var $table_name = 'PAGAMENTO';
    var $idpagamento;
    var $valor;
    var $idreserva;
	
	function getIdpagamento()
	{
		return $this->idpagamento;
	}
	function setIdpagamento($idpagamento)
	{
		$this->idpagamento = $idpagamento;
	}

	
	function getValor()
	{
		return $this->valor;
	}
	function setValor($valor)
	{
		$this->valor = $valor;
	}

	
	function getIdreserva()
	{
		return $this->idreserva;
	}
	function setIdreserva($idreserva)
	{
		$this->idreserva = $idreserva;
	}

	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		
		if(!empty($where))
		{
			
			
			
			$strSQL = "			
						SELECT t.idpagamento,
       (CASE
            WHEN t.transferencia = 1 THEN 'Antecipado'
            WHEN t.transferencia = 2 THEN 'Caixa'
            WHEN t.transferencia = 3 THEN 'Faturamento'
            WHEN t.transferencia = 4 THEN 'Faturamento Parcelado'
        END) AS transferencia ,  (CASE
                                       WHEN t.tipo_pagamento = 1 THEN 'Dinheiro'
                                       WHEN t.tipo_pagamento = 2 THEN 'Cartão'
                                       WHEN t.tipo_pagamento = 3 THEN 'Cheque'
                                       WHEN t.tipo_pagamento = 4 THEN 'Deposito'
                                   END) AS tipo_pagamento,
                                  t.datapagamento,
                                  t.valor,
                                  t.idreserva,
                                  (CASE
                                       WHEN t.resp = 'J' THEN 'Pessoa juridica'
                                       ELSE 'Pessoa fisica'
                                   END) AS resp
FROM
  (
  
  SELECT idpagamento,
          transferencia,
          tipo_pagamento,
          CONVERT(VARCHAR(10),datapagamento,103) AS datapagamento,
          replace(valor, '.', ',') AS valor,
          idreserva,
		 ativo,

     (SELECT tipopagamento
      FROM reserva
      WHERE idreserva = p.idreserva
        UNION ALL
        SELECT tipopagamento
        FROM HISTORICO WHERE idreserva = p.idreserva ) resp
   FROM PAGAMENTO p 
   ) t  where $where  and t.ativo is null";
		}
		else
		{
			$strSQL = "
						SELECT t.idpagamento,
       (CASE
            WHEN t.transferencia = 1 THEN 'Antecipado'
            WHEN t.transferencia = 2 THEN 'Caixa'
            WHEN t.transferencia = 3 THEN 'Faturamento'
            WHEN t.transferencia = 4 THEN 'Faturamento Parcelado'
        END) AS transferencia ,  (CASE
                                       WHEN t.tipo_pagamento = 1 THEN 'Dinheiro'
                                       WHEN t.tipo_pagamento = 2 THEN 'Cartão'
                                       WHEN t.tipo_pagamento = 3 THEN 'Cheque'
                                       WHEN t.tipo_pagamento = 4 THEN 'Deposito'
                                   END) AS tipo_pagamento,
                                  t.datapagamento,
                                  t.valor,
                                  t.idreserva,
                                  (CASE
                                       WHEN t.resp = 'J' THEN 'Pessoa juridica'
                                       ELSE 'Pessoa fisica'
                                   END) AS resp
FROM
  (
  
  SELECT idpagamento,
          transferencia,
          tipo_pagamento,
          CONVERT(VARCHAR(10),datapagamento,103) AS datapagamento,
          replace(valor, '.', ',') AS valor,
          idreserva,
		ativo,
     (SELECT tipopagamento
      FROM reserva
      WHERE idreserva = p.idreserva
        UNION ALL
        SELECT tipopagamento
        FROM HISTORICO WHERE idreserva = p.idreserva ) resp
   FROM PAGAMENTO p ) t ";
		}

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idpagamento)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = " select  idpagamento ,	replace(valor , '.', ',') as	valor,idreserva,
						transferencia,dpatensipado,	CONVERT(VARCHAR(10),datapagamento,103) datapagamento
						from PAGAMENTO where idpagamento = $idpagamento";
						
						

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('idpagamento'=>$dados['idpagamento']
								,'valor'=>$dados['valor']
								,'idreserva'=>$dados['idreserva']
								,'transferencia'=>$dados['transferencia']
								,'dpatensipado'=>$dados['dpatensipado']
								,'datapagamento'=>$dados['datapagamento']);
		}
		$Bd->closeConnect();
		return json_encode($arrJson);
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
		$chave = 'idpagamento = '.$arrDados['idpagamento'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'idpagamento');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($idpagamento)
	{
		$chave = 'idpagamento = '.$idpagamento;
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
	
	
	public function selectTotal($where)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = "select 'Total' as texto, (select sum(valor) from PAGAMENTO where $where and ativo is null)  as total";
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	public function verificaPendencia($idreserva)
	{
		$Bd = new Bd(CONEXAO);

		$strSQL = "select 
						(case when  t2.valorRestante > 0 then 'true' else 'false' end) as resposta
						 from (
						select 
						(case when t.valorP is null then ((t.qtddias*t.valor) - 0)
						 else ((t.qtddias*t.valor) - t.valorP)  end) as valorRestante
						 from (
						select DATEDIFF(d,r.datainicial,r.datafinal) AS qtddias, r.idquarto,
						(select  valor from PRECOQUARTO where idpreco =  r.idpreco) as valor,
						(select SUM(valor) as valor from PAGAMENTO where idreserva = r.idreserva) as valorP
						 from RESERVA r
						  where r.idreserva =  $idreserva) t
				) t2";

		$resposta = $Bd->getOneRecordSet($strSQL,"resposta");
		$Bd->closeConnect();
		return $resposta;
	}

	public function somaPagamentoRel($idreserva)
	{
		$Bd = new Bd(CONEXAO);
		$strSQL = "	select '-'+CONVERT(VARCHAR(10),SUM(valor),103) as valor from PAGAMENTO where idreserva= $idreserva ";
/*		$strSQL = "		
				select (t.total + (select COALESCE(sum(valor),0) as pago from PAGAMENTO where idreserva = $idreserva)) as pago from (
					select	COALESCE(sum(p.valor),0) as	total,r.idreserva
						  from RESERVA r
										join HOSPEDE h on r.idhospede = h.idhospede
										join VENDA v on v.idhospede = h.idhospede
										join PRODUTOS p on p.idproduto = v.idproduto
										 where 
										 v.idhospede = r.idhospede 
										   and v.datavenda between r.datainicial and r.datafinal
										  group by p.valor,r.idreserva
					union all	
					select COALESCE(sum(p.valor),0) as	total, hist.idreserva
						  from HISTORICO hist
										join HOSPEDE h on hist.idhospede = h.idhospede
										join VENDA v on v.idhospede = h.idhospede
										join PRODUTOS p on p.idproduto = v.idproduto
										 where 
										 v.idhospede = hist.idhospede and
										  v.datavenda between hist.datainicial and hist.datafinal
										  group by p.valor,hist.idreserva
					)t where t.idreserva= $idreserva				
		
		";
*/

		$resposta = $Bd->getOneRecordSet($strSQL,"valor");
		$Bd->closeConnect();
		return $resposta;
	}
	

	public function totPagamentoRel($idreserva)
	{
		$Bd = new Bd(CONEXAO);
	
			$strSQL = "	
		   select 
		   (((t.valor * t.qtddias-(t.desconto))+(case when t.totvenda IS null  THEN 0 else t.totvenda end)) - (case when t.pago IS null  THEN 0 else t.pago end)
		   )as  total
			from ( 
		   select pc.valor,
		   DATEDIFF(d,r.datainicial,r.datafinal) AS qtddias,
			  (select SUM(valor) from pagamento where idreserva =  r.idreserva)  pago,
			  (select SUM(valordesconto) from desconto where idreserva =  r.idreserva)  desconto,
			  (select sum(p.valor * v.quantidade) from VENDA v
			join PRODUTOS p on v.idproduto = p.idproduto
			 where datavenda BETWEEN r.datainicial and r.datafinal and idhospede = r.idhospede) AS totvenda
			from RESERVA r 
			JOIN QUARTO q on q.idquarto = r.idquarto
			join PRECOQUARTO pc on pc.idpreco = r.idpreco
			where r.idreserva= $idreserva
			) t
				";

		$resposta = $Bd->getOneRecordSet($strSQL,"total");
		$Bd->closeConnect();
		return $resposta;
	}

	public function selectTableRelatorioDiscriminado($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

	

		$strSQL = "
			select
					h.idhospede,
					h.nome,sum(p.valor) as valor,
				(case
					  when p.transferencia = 1 then 'Antecipado'
					  when p.transferencia = 2 then 'Caixa'
					  when p.transferencia = 3 then 'Faturamento'
					  when p.transferencia = 4 then 'Faturamento Parcelado'
					 
					end) as tranferencia,
				(case
				  when p.dpatensipado = 1 then 'Cartão Débito - Visa' 
				  when p.dpatensipado = 2 then 'Cartão Débito - Master' 
				  when p.dpatensipado = 4 then 'Cartão Crédito - Visa' 
				  when p.dpatensipado = 5 then 'Cartão Crédito - Master' 
				   when p.dpatensipado = 6 then 'Dinheiro'
				    when p.dpatensipado = 7 then 'Deposito'
				end) as dpatensipado
				
			from PAGAMENTO p
			 left join RESERVA r on r.idreserva = p.idreserva
			 left join HISTORICO hist on hist.idreserva = p.idreserva
			 left join HOSPEDE h on h.idhospede = hist.idhospede";
			 
			if(!empty($where))
				$strSQL .= " where ". $where." ";

		$strSQL .= "
			 group by h.idhospede,h.nome,p.transferencia,p.dpatensipado
			 order by h.nome desc";


 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	public function selectTableRelatorioDiscriminadoTotal($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "
				select
					
					sum(p.valor) as valor,
				(case
					  when p.transferencia = 1 then 'Antecipado'
					  when p.transferencia = 2 then 'Caixa'
					  when p.transferencia = 3 then 'Faturamento'
					  when p.transferencia = 4 then 'Faturamento Parcelado'
					end) as tranferencia,
				(case
				  when p.dpatensipado = 1 then 'Cartão Débito - Visa' 
				  when p.dpatensipado = 2 then 'Cartão Débito - Master' 
				  when p.dpatensipado = 4 then 'Cartão Crédito - Visa' 
				  when p.dpatensipado = 5 then 'Cartão Crédito - Master' 
				   when p.dpatensipado = 6 then 'Dinheiro'
				    when p.dpatensipado = 7 then 'Deposito'
				end) as dpatensipado
				
			from PAGAMENTO p
			 left join RESERVA r on r.idreserva = p.idreserva
			 left join HISTORICO hist on hist.idreserva = p.idreserva
			 left join HOSPEDE h on h.idhospede = hist.idhospede";

		if(!empty($where))
				$strSQL .= " where ". $where." ";

		$strSQL .= " group by p.transferencia,p.dpatensipado ";

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	function insert_last_id($arrDados,$campo=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$dadosRecordSet = $Bd->executarSql($arrDados,$this->table_name,'insert_last_id');
		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	public function selectTipoPagamento($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

	

		$strSQL = "
		select p.valor, 
				(case 
					when p.tipo_pagamento = 1 then 'Dinheiro'
					when p.tipo_pagamento = 2 
						then ('Cart�o ' + (case when c.tipo = 'D' then 'D�bito' else 'Cr�dito' end)+' '+b.bandeira)
					when p.tipo_pagamento = 3 then 'Cheque n�mero : '+ch.numero+', Banco: <strong>'+bc.banco+'</strong>, Data: '+CONVERT(VARCHAR(10),ch.data_vencimento,103)
					when p.tipo_pagamento = 4 then 'Dep�sito; Banco: <strong>'+bc2.banco+'</strong>, Ag�ncia: <strong>'+dc.agencia+'</strong>, Conta: <strong>'+dc.conta+'</strong>, Tipo: <strong>'+  (case when dc.tipo_conta = 'D' then 'Conta Corrente' else 'Poupan�a' end)+'</strong>'
				end) tipo_pagamento
				from PAGAMENTO p
				left join CARTAO c on c.id_cartao = p.id_cartao
				left join bandeira b on b.id_bandeira = c.id_bandeira
				left join CHEQUE ch on ch.id_pagamento = p.idpagamento
				left join BANCOS bc on bc.id_banco = ch.id_banco
				left join DEPOSITO_CONTA dc on dc.id_pagamento = p.idpagamento
				left join BANCOS bc2 on bc2.id_banco = dc.id_banco
				 where $where
			";

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}

}
?>
