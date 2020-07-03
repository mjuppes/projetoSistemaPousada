<?php
class  CHAMADO
{
    var $table_name = 'CHAMADO';
    var $idchamado;
    var $titulo;
    var $descricao;
    var $idusuario;
	
	function getIdchamado()
	{
		return $this->idchamado;
	}
	function setIdchamado($idchamado)
	{
		$this->idchamado = $idchamado;
	}

	
	function getTitulo()
	{
		return $this->titulo;
	}
	function setTitulo($titulo)
	{
		$this->titulo = $titulo;
	}

	
	function getDescricao()
	{
		return $this->descricao;
	}
	function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}

	
	function getIdusuario()
	{
		return $this->idusuario;
	}
	function setIdusuario($idusuario)
	{
		$this->idusuario = $idusuario;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  idchamado ,titulo,descricao,idusuario from CHAMADO';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  idchamado ,titulo,descricao,idusuario from CHAMADO';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('idchamado'=>$dados['idchamado']
								,'titulo'=>$dados['titulo']
								,'descricao'=>$dados['descricao']
								,'idusuario'=>$dados['idusuario']
);
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
		$chave = 'idchamado = '.$arrDados['idchamado'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'idchamado');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'idchamado = '.$arrDados['idchamado'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
