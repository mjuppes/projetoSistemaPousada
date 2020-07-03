<?php
class  CENTRO_CUSTO
{
    var $table_name = 'CENTRO_CUSTO';
    var $id_centro_custo;
    var $id_cat_centro;
    var $valor;
    var $descricao;
    var $data;
    var $data_cadastro;
    var $ativo;
	
	function getId_centro_custo()
	{
		return $this->id_centro_custo;
	}
	function setId_centro_custo($id_centro_custo)
	{
		$this->id_centro_custo = $id_centro_custo;
	}

	
	function getId_cat_centro()
	{
		return $this->id_cat_centro;
	}
	function setId_cat_centro($id_cat_centro)
	{
		$this->id_cat_centro = $id_cat_centro;
	}

	
	function getValor()
	{
		return $this->valor;
	}
	function setValor($valor)
	{
		$this->valor = $valor;
	}

	
	function getDescricao()
	{
		return $this->descricao;
	}
	function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}

	
	function getdata()
	{
		return $this->data;
	}
	function setdata($data)
	{
		$this->data = $data;
	}

	
	function getData_cadastro()
	{
		return $this->data_cadastro;
	}
	function setData_cadastro($data_cadastro)
	{
		$this->data_cadastro = $data_cadastro;
	}

	
	function getAtivo()
	{
		return $this->ativo;
	}
	function setAtivo($ativo)
	{
		$this->ativo = $ativo;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "
				select
						c.id_centro_custo,
						ct.categoria_centro,
						sc.sub_cat_centro,
						'R$ '+CONVERT(VARCHAR(10),c.valor,103) as valor,
						CONVERT(VARCHAR(10),c.data,103) as data,
						(CONVERT(VARCHAR(29),c.data_cadastro,103) +' '+CONVERT(VARCHAR(29),c.data_cadastro,108)) as data_cadastro
				from CENTRO_CUSTO c 
					join SUB_CAT_CENTRO sc on sc.id_sub_cat_centro = c.id_sub_cat_centro
					join CAT_CENTRO ct on ct.id_cat_centro = sc.id_cat_centro
				where c.ativo is null ";

		if(!empty($where))
			$strSQL.= $where;
		
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($id_centro_custo)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = "
		select
			 cat.categoria_centro, sb.sub_cat_centro,c.valor,c.descricao,
			 CONVERT(VARCHAR(10),c.data,103) as data,
			 CONVERT(VARCHAR(10),c.data_cadastro,103) as data_cadastro,
			 (case
			  when c.tipo_pagamento = 1 then 'Dinheiro'
			  when c.tipo_pagamento = 2 then 'Cartão'
			  when c.tipo_pagamento = 4 then 'Depósito'
			 end) as tipo_pagamento,
			 c.tipo_pagamento as tp,
			 (case when  b.bandeira is null then '' else b.bandeira end) as bandeira,
			(case when  f.nome is null then '' else  f.nome end) as fornecedor,
			(case when bc.banco is null then '' else bc.banco end) banco,
			(case when dc.agencia is null then '' else dc.agencia end) as agencia,
			(case when dc.conta is null then '' else dc.conta end) conta,
			(case 
				when dc.tipo_conta = 'C' then 'Conta Corrente' 
				when dc.tipo_conta = 'P' then 'Conta Poupança' 
				when dc.tipo_conta is null then '' 
			end) as tipo_conta,
			c.descricao
		from
			CENTRO_CUSTO c
					join SUB_CAT_CENTRO sb on sb.id_sub_cat_centro = c.id_sub_cat_centro
					join CAT_CENTRO cat on cat.id_cat_centro = sb.id_cat_centro
					left join CARTAO ct on ct.id_cartao = c.id_cartao
					left join BANDEIRA b on b.id_bandeira = ct.id_bandeira
					left join FORNECEDOR f on f.id_fornecedor = c.id_fornecedor
					left join DEPOSITO_CONTA dc on dc.id_centro_custo = c.id_centro_custo
					left join BANCOS bc on bc.id_banco = dc.id_banco
		where c.id_centro_custo = $id_centro_custo";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('categoria_centro'=>utf8_encode($dados['categoria_centro'])
								,'sub_cat_centro'=>utf8_encode($dados['sub_cat_centro'])
								,'valor'=>$dados['valor']
								,'descricao'=>$dados['descricao']
								,'data'=>$dados['data']
								,'data_cadastro'=>$dados['data_cadastro']
								,'tipo_pagamento'=>$dados['tipo_pagamento']
								,'tp'=>$dados['tp']
								,'bandeira'=>$dados['bandeira']
								,'fornecedor'=>$dados['fornecedor']
								,'banco'=>$dados['banco']
								,'agencia'=>$dados['agencia']
								,'conta'=>$dados['conta']
								,'tipo_conta'=>$dados['tipo_conta']);
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
		$chave = 'id_centro_custo  in('.$arrDados['id_centro_custo'].')';
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_centro_custo');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_centro_custo = '.$arrDados['id_centro_custo'];
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
