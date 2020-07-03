<?php
class  PRODUTOS
{
    var $table_name = 'PRODUTOS';
    var $idproduto;
    var $nomeproduto;
    var $valor;
    var $idcategoria;
    var $id = 'idproduto';
	
	function getIdproduto()
	{
		return $this->idproduto;
	}
	function setIdproduto($idproduto)
	{
		$this->idproduto = $idproduto;
	}
	
	function getNomeproduto()
	{
		return $this->nomeproduto;
	}
	function setNomeproduto($nomeproduto)
	{
		$this->nomeproduto = $nomeproduto;
	}
	
	function getValor()
	{
		return $this->valor;
	}
	function setValor($valor)
	{
		$this->valor = $valor;
	}
	
	function getIdcategoria()
	{
		return $this->idcategoria;
	}
	function setIdcategoria($idcategoria)
	{
		$this->idcategoria = $idcategoria;
	}


	public function select($arr,$where=false,$whereFiltro=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		if(!empty($where))
			$strSQL = "SELECT  p.idproduto,p.nomeproduto,f.nome as nome_fornecedor,
							c.nomecategoria,p.quantidade,REPLACE(p.valor,'.',',') as valor,
							REPLACE((p.quantidade * p.valor),'.',',') as total,
							(CONVERT(VARCHAR(29),p.data_cadastro,103) +' '+CONVERT(VARCHAR(29),p.data_cadastro,108)) as data_cadastro,
							p.estoque
				FROM PRODUTOS p
				inner join categoria c on p.idcategoria = c.idcategoria
				join fornecedor f on f.id_fornecedor = p.id_fornecedor
				where p.ativo is null  $where";
		else
			$strSQL = "SELECT  p.idproduto,p.nomeproduto,f.nome as nome_fornecedor,
						c.nomecategoria,p.quantidade,REPLACE(p.valor,'.',',') as valor,
						REPLACE((p.quantidade * p.valor),'.',',') as total,
						(CONVERT(VARCHAR(29),p.data_cadastro,103) +' '+CONVERT(VARCHAR(29),p.data_cadastro,108)) as data_cadastro,
						p.estoque
				FROM PRODUTOS p
					inner join categoria c on p.idcategoria = c.idcategoria
					join fornecedor f on f.id_fornecedor = p.id_fornecedor
					where p.ativo is null";

		$dadosRecordSet = $Bd->execQuery($strSQL,true,true);

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	public function selectDadosJson($idproduto)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select p.idproduto,
					p.id_fornecedor,
					f.nome as nome_fornecedor,
					p.quantidade,
					p.codigo,
					p.id_unidade as id_sigla,
					CONVERT(VARCHAR(10),p.data_compra,103) as data_compra,
					CONVERT(VARCHAR(10),p.data_validade,103) as data_validade,
					CONVERT(VARCHAR(10),p.data_cadastro,103) as data_cadastro,
					p.nomeproduto,REPLACE(p.valor,'.',',') as valor,
					p.idcategoria,c.nomecategoria,
					p.estoque,p.insumo from PRODUTOS p
				inner join categoria c on p.idcategoria = c.idcategoria
				join fornecedor f on f.id_fornecedor = p.id_fornecedor

				where p.idproduto = $idproduto";

				// echo $strSQL;
				// return;
		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		foreach($dadosRecordSet as $dados)
		{
			$arrJson = array('idproduto'=>$dados['idproduto']
							,'nomeproduto'=>utf8_encode($dados['nomeproduto'])
							,'codigo'=>$dados['codigo']
							,'valor'=>$dados['valor']
							,'data_compra'=>$dados['data_compra']
							,'data_validade'=>$dados['data_validade']
							,'data_cadastro'=>$dados['data_cadastro']
							,'idcategoria'=>$dados['idcategoria']
							,'id_fornecedor'=>$dados['id_fornecedor']
							,'nomecategoria'=>$dados['nomecategoria']
							,'quantidade'=>$dados['quantidade']
							,'nome_fornecedor'=>$dados['nome_fornecedor']
							,'estoque'=>$dados['estoque']
							,'insumo'=>$dados['insumo']
							,'id_sigla'=>$dados['id_sigla']);
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
		$chave = 'idproduto in ('.$arrDados['idproduto'].')';
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'idproduto');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$Bd = new Bd(CONEXAO);
		$chave = 'idproduto = '.$arrDados['idproduto'];
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave,'idproduto');
		
		$Bd->closeConnect();
		return $resposta;
	}
	
	public function selectProdutoEstoque($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		if($where)
			$strSQL = "
					select p.idproduto,p.codigo,p.nomeproduto,unidade from PRODUTOS p 
						join UNIDADE u on u.id_unidade = p.id_unidade where estoque = 'S' $where";
		else
			$strSQL = "select p.idproduto,p.codigo,p.nomeproduto,unidade from PRODUTOS p 
						join UNIDADE u on u.id_unidade = p.id_unidade where estoque = 'S' ";
		

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	
	}

	public function selectProdutosInsumo($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select idproduto,codigo,nomeproduto,

		('R$ '+REPLACE( CONVERT(VARCHAR(10),valor),'.',',')) as valor
		from PRODUTOS where estoque = 'S' and insumo = 'S' ";
		
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
	
	public function selectProdutosAuditoria($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select idproduto,codigo,nomeproduto,
		('R$ '+REPLACE( CONVERT(VARCHAR(10),valor),'.',',')) as valor
		from PRODUTOS where estoque = 'S' ";
		
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

	function insert_last_id($arrDados,$campo=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$dadosRecordSet = $Bd->executarSql($arrDados,$this->table_name,'insert_last_id');
		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	public function selectEstoqueAtual($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		if($where)
			$strSQL = "
				 select p.idproduto, p.codigo,c.nomecategoria,p.nomeproduto,p.quantidade,u.unidade,p.estoque_min,p.estoque_max,
				 p.custo_medio,p.valor,(p.quantidade * p.valor) as total
				  from PRODUTOS p 
					join CATEGORIA c on c.idcategoria = p.idcategoria
					join UNIDADE u on u.id_unidade = p.id_unidade
				 where p.estoque = 'S' $where";
		else
			$strSQL = "
				select p.idproduto,p.codigo,c.nomecategoria,p.nomeproduto,p.quantidade,u.unidade,p.estoque_min,p.estoque_max,
					 p.custo_medio,p.valor,(p.quantidade * p.valor) as total
					  from PRODUTOS p 
						join CATEGORIA c on c.idcategoria = p.idcategoria
						join UNIDADE u on u.id_unidade = p.id_unidade
					 where p.estoque = 'S'";
		

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	
	}
	
}
?>