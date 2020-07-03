<?php
class  CANCELAMENTO
{
    var $table_name = 'CANCELAMENTO';
    var $idcancelamento;
    var $motivo;
    var $observacao;
    var $idreserva;
	
	function getIdcancelamento()
	{
		return $this->idcancelamento;
	}
	function setIdcancelamento($idcancelamento)
	{
		$this->idcancelamento = $idcancelamento;
	}

	
	function getMotivo()
	{
		return $this->motivo;
	}
	function setMotivo($motivo)
	{
		$this->motivo = $motivo;
	}

	
	function getObservacao()
	{
		return $this->observacao;
	}
	function setObservacao($observacao)
	{
		$this->observacao = $observacao;
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
		$strSQL = "select q.nomequarto, h.nome as nomehospede,(case when c.motivo = 1 then 'Não comparecimento' else 'Outro' end) as motivo,
					(CONVERT(char(10),r.datafinal,103)) as datainicial, 
					(CONVERT(char(10),r.datafinal,103)) as datafinal,
					(case when r.opcao = 'S' then 'Solteiro' else 'Casal' end) as opcao,
					(case when h.idempresa is null then 'Pessoa Física' else 'Pessoa Jurídica' end) as tipopessoa,
					 c.observacao
					 from cancelamento c
					join RESERVA r on r.idreserva = c.idreserva
					join HOSPEDE h on h.idhospede = r.idhospede
					join QUARTO q on q.idquarto = r.idquarto $where";

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($idTabela)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = ' select  idcancelamento ,motivo,observacao,idreserva from CANCELAMENTO';
 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('idcancelamento'=>$dados['idcancelamento']
								,'motivo'=>$dados['motivo']
								,'observacao'=>$dados['observacao']
								,'idreserva'=>$dados['idreserva']);
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
		$chave = 'idcancelamento = '.$arrDados['idcancelamento'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'idcancelamento');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'idcancelamento = '.$arrDados['idcancelamento'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
