<?php
class  MOV_ESTOQUE
{
    var $table_name = 'MOV_ESTOQUE';
    var $id_mov_estoque;
    var $id_produto;
    var $data_movimentacao;
	
	function getId_mov_estoque()
	{
		return $this->id_mov_estoque;
	}
	function setId_mov_estoque($id_mov_estoque)
	{
		$this->id_mov_estoque = $id_mov_estoque;
	}

	
	function getId_produto()
	{
		return $this->id_produto;
	}
	function setId_produto($id_produto)
	{
		$this->id_produto = $id_produto;
	}

	
	function getData_movimentacao()
	{
		return $this->data_movimentacao;
	}
	function setData_movimentacao($data_movimentacao)
	{
		$this->data_movimentacao = $data_movimentacao;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = "
					
			select me.id_mov_estoque,
			p.nomeproduto,
			(CONVERT(VARCHAR(29),me.data_movimentacao,103) +' '+CONVERT(VARCHAR(29),me.data_movimentacao,108)) as data_movimentacao,
			 (case
				  when tipo_mov = 'E' then 'Entrada de produto'
				  when tipo_mov = 'S' then 'Saida de produto'
				  when tipo_mov = 'A' then 'Atualização de preço'
			  end) as tipo_mov,
			  (case 
					when tipo_tab = 'P' then 'Por Cadastro'
					when tipo_tab = 'I' then 'Por Insumo'
					when tipo_tab = 'E' then 'Por Estoque'
					when tipo_tab = 'A' then 'Por Auditoria'
				end) as tipo_tab,
				me.quantidade,
				valor_atual,
				(me.quantidade * valor_atual) as valor_total_compra,
				(case when me.observacao is null then '' else me.observacao end ) observacao
			 from 
			 MOV_ESTOQUE me
			 join PRODUTOS p on p.idproduto = me.id_produto 
		";

		if($where)
			$strSQL .= " where ".$where;

		$strSQL .= " order by data_movimentacao asc";

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_mov_estoque ,id_produto,data_movimentacao from MOV_ESTOQUE';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_mov_estoque'=>$dados['id_mov_estoque']
								,'id_produto'=>$dados['id_produto']
								,'data_movimentacao'=>$dados['data_movimentacao']
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
		$chave = 'id_mov_estoque = '.$arrDados['id_mov_estoque'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_mov_estoque');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_mov_estoque = '.$arrDados['id_mov_estoque'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
