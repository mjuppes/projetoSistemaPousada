<?php
class  CARTAO
{
    var $table_name = 'CARTAO';
    var $id_cartao;
    var $id_bandeira;
    var $tipo;
    var $dia_recebimento;
    var $percentual;
    var $baixa_automatica;
	
	function getId_cartao()
	{
		return $this->id_cartao;
	}
	function setId_cartao($id_cartao)
	{
		$this->id_cartao = $id_cartao;
	}

	
	function getId_bandeira()
	{
		return $this->id_bandeira;
	}
	function setId_bandeira($id_bandeira)
	{
		$this->id_bandeira = $id_bandeira;
	}

	
	function getTipo()
	{
		return $this->tipo;
	}
	function setTipo($tipo)
	{
		$this->tipo = $tipo;
	}

	
	function getDia_recebimento()
	{
		return $this->dia_recebimento;
	}
	function setDia_recebimento($dia_recebimento)
	{
		$this->dia_recebimento = $dia_recebimento;
	}

	
	function getPercentual()
	{
		return $this->percentual;
	}
	function setPercentual($percentual)
	{
		$this->percentual = $percentual;
	}

	
	function getBaixa_automatica()
	{
		return $this->baixa_automatica;
	}
	function setBaixa_automatica($baixa_automatica)
	{
		$this->baixa_automatica = $baixa_automatica;
	}


	public function select($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = " select
						c.id_cartao,
						b.bandeira,
						(case when c.tipo = 'D' then 'Débito' else 'Crédito' end) tipo,
						c.dia_recebimento,(CONVERT(VARCHAR(10),c.percentual)+'%') percentual,
						(case when c.baixa_automatica = 't' then 'Baixa Automática' else '' end) baixa_automatica,
						(case when parcelas is null then '' else parcelas end) parcelas
						from CARTAO c
						join BANDEIRA b ON b.id_bandeira = c.id_bandeira";

		if($where)
			$strSQL .= " where ".$where;

		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  id_cartao ,id_bandeira,tipo,dia_recebimento,percentual,baixa_automatica from CARTAO';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_cartao'=>$dados['id_cartao']
								,'id_bandeira'=>$dados['id_bandeira']
								,'tipo'=>$dados['tipo']
								,'dia_recebimento'=>$dados['dia_recebimento']
								,'percentual'=>$dados['percentual']
								,'baixa_automatica'=>$dados['baixa_automatica']
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
		$chave = 'id_cartao = '.$arrDados['id_cartao'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_cartao');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_cartao = '.$arrDados['id_cartao'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
