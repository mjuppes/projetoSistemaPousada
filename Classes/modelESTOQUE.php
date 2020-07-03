<?php
class  ESTOQUE
{
    var $table_name = 'ESTOQUE';
    var $idestoque;
    var $idproduto;
    var $dataentrada;
    var $datasaida;
    var $quantidade;
	
	function getIdestoque()
	{
		return $this->idestoque;
	}
	function setIdestoque($idestoque)
	{
		$this->idestoque = $idestoque;
	}

	
	function getIdproduto()
	{
		return $this->idproduto;
	}
	function setIdproduto($idproduto)
	{
		$this->idproduto = $idproduto;
	}

	
	function getDataentrada()
	{
		return $this->dataentrada;
	}
	function setDataentrada($dataentrada)
	{
		$this->dataentrada = $dataentrada;
	}

	
	function getDatasaida()
	{
		return $this->datasaida;
	}
	function setDatasaida($datasaida)
	{
		$this->datasaida = $datasaida;
	}

	
	function getQuantidade()
	{
		return $this->quantidade;
	}
	function setQuantidade($quantidade)
	{
		$this->quantidade = $quantidade;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = " 
		
		select  e.idestoque ,p.nomeproduto,
e.quantidade,
CONVERT(VARCHAR(10),(select max(data) from MOVESTOQUE where idproduto = p.idproduto),103) as datam,
(select top 1 unidade  from MOVESTOQUE where idproduto = p.idproduto order by idmovestoque desc) as unidade
 from ESTOQUE e 
JOIN PRODUTOS p on p.idproduto = e.idproduto
		
		";
		
		
echo $strSQL;
return;		
		
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idestoque)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = " select  idestoque ,idproduto,dataentrada,datasaida,quantidade from ESTOQUE where idestoque = $idestoque ";
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('idestoque'=>$dados['idestoque']
								,'idproduto'=>$dados['idproduto']
								,'dataentrada'=>$dados['dataentrada']
								,'datasaida'=>$dados['datasaida']
								,'quantidade'=>$dados['quantidade']);
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
		if(isset($arrDados['idproduto']))
			$chave = 'idproduto = '.$arrDados['idproduto'];
		else
			$chave = 'idestoque = '.$arrDados['idestoque'];

		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'idestoque');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'idestoque = '.$arrDados['idestoque'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}

	public function verificarEstoque($idproduto)
	{
		$Bd = new Bd(CONEXAO);
		//$strSQL = " select quantidade from ESTOQUE where idproduto = $idproduto";
		$strSQL = " 
			select  estoque from ESTOQUE e 
			inner join  PRODUTOS p on  e.idproduto = p.idproduto
			where e.idproduto = $idproduto";



		$resposta = $Bd->getOneRecordSet($strSQL,'estoque');
		$Bd->closeConnect();
		return $resposta;
	
	}
	
	public function verificarEstoqueQtd($idproduto)
	{
		$Bd = new Bd(CONEXAO);
		$strSQL = " select quantidade from ESTOQUE where idproduto = $idproduto";
		$resposta = $Bd->getOneRecordSet($strSQL,'quantidade');
		$Bd->closeConnect();
		return $resposta;
	
	}

}
?>
