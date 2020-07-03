<?php
class  HOSPEDE
{
    var $table_name = 'HOSPEDE';
    var $idhospede;
    var $nome;
    var $sexo;
    var $datareserva;
    var $cpf;
    var $rg;
    var $idestado;
    var $idcidade;
    var $idempresa;
    var $email;
    var $datahoje;
	
	function getIdhospede()
	{
		return $this->idhospede;
	}
	function setIdhospede($idhospede)
	{
		$this->idhospede = $idhospede;
	}
	
	function getNome()
	{
		return $this->nome;
	}
	function setNome($nome)
	{
		$this->nome = $nome;
	}
	
	function getSexo()
	{
		return $this->sexo;
	}
	function setSexo($sexo)
	{
		$this->sexo = $sexo;
	}
	
	function getDatareserva()
	{
		return $this->datareserva;
	}
	function setDatareserva($datareserva)
	{
		$this->datareserva = $datareserva;
	}
	
	function getCpf()
	{
		return $this->cpf;
	}
	function setCpf($cpf)
	{
		$this->cpf = $cpf;
	}
	
	function getRg()
	{
		return $this->rg;
	}
	function setRg($rg)
	{
		$this->rg = $rg;
	}
	
	function getIdestado()
	{
		return $this->idestado;
	}
	function setIdestado($idestado)
	{
		$this->idestado = $idestado;
	}
	
	function getIdcidade()
	{
		return $this->idcidade;
	}
	function setIdcidade($idcidade)
	{
		$this->idcidade = $idcidade;
	}
	
	function getIdempresa()
	{
		return $this->idempresa;
	}
	function setIdempresa($idempresa)
	{
		$this->idempresa = $idempresa;
	}
	
	function getEmail()
	{
		return $this->email;
	}
	function setEmail($email)
	{
		$this->email = $email;
	}
	
	function getDatahoje()
	{
		return $this->datahoje;
	}
	function setDatahoje($datahoje)
	{
		$this->datahoje = $datahoje;
	}

	function insert($arrDados,$campo=false)
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'insert');
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

	function lastIdhospede()
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->lastRecordSet("idhospede",$this->table_name);
		$Bd->closeConnect();
		return $resposta;
	}

	
	function selectHospede($where='')
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		/*
			@Implementação para aparecer todos os hóspedes 25/04/2014 10:25
			$strSQL = "select idhospede,nome,sexo,datareserva,cpf,rg,idestado,idcidade,
								idempresa,email,datahoje from HOSPEDE
							where idhospede  not in(select idhospede from reserva group by idhospede)
							and ativo is null
							order by nome asc";
		*/

		$strSQL = "select idhospede,nome,sexo,datareserva,cpf,rg,idestado,idcidade,
							idempresa,email,datahoje from HOSPEDE
						where ativo is null $where
						order by nome asc";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	function selectHospedeGeral($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "	select  h.idhospede, h.nome, (case when sexo = 'M' then 'Masculino' else 'Feminino' end) as sexo,
						(case when emp.nomeempresa is null then 'Pessoa Fisica' else emp.nomeempresa end) nomeempresa,
						e.nomeestado,c.nomecidade, CONVERT(VARCHAR(10),h.datahoje,103) datahoje from hospede h
						inner join estado e on e.idestado = h.idestado
						inner join cidade c on c.idcidade = h.idcidade
						left join empresa emp on emp.idempresa = h.idempresa ";

		if(!empty($where))
			$strSQL .= "  where h.ativo is null and ".$where;
			
		$strSQL .= " order by  h.nome asc";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	public function selectDadosJson($idhospede)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = " select
						(case idmotivo
						   when  1 then 'Turismo' 
						   when  2 then 'Trabalho'
						   when  3 then 'Congresso'
						   when  4 then 'Outro'
						   else  'Outro' end) as motivo ,
						c.idcidade,
						ag.nomeagencia,
						h.cep,h.idpais,
						CONVERT(VARCHAR(10),h.datanascimento,103) as datanascimento,
						h.bairro,h.idmotivo,
						CONVERT(VARCHAR(10),h.datachegada,103) datachegada,
						e.idestado,h.idhospede, h.nome, 
						(case when sexo = 'M' then 'Masculino' else 'Feminino' end) as sexo,
						e.nomeestado,c.nomecidade, CONVERT(VARCHAR(10),h.datahoje,103) datahoje,h.rne,
						h.email,h.cpf,h.rg,h.opcao,h.sexo as catSexo, h.idempresa,h.passaporte,h.telefone,h.endereco,emp.nomeempresa,
						h.idagencia 
						from hospede h
						inner join estado e on e.idestado = h.idestado
						inner join cidade c on c.idcidade = h.idcidade
						left join empresa emp on emp.idempresa = h.idempresa
						left join agencia ag on ag.idagencia = h.idagencia
						where h.idhospede = $idhospede";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = 	array('idhospede'=>$dados["idhospede"],
								'nome'=>utf8_encode($dados["nome"]),
								'sexo'=>$dados["sexo"],
								'nomeestado'=>utf8_encode($dados["nomeestado"]),
								'nomecidade'=>utf8_encode($dados["nomecidade"]),
								'nomeagencia'=>utf8_encode($dados["nomeagencia"]),
								'datahoje'=>$dados["datahoje"],
								'email'=>$dados["email"],
								'cpf'=>$dados["cpf"],
								'rg'=>$dados["rg"],
								'datanascimento'=>$dados['datanascimento'],
								'opcao'=>$dados["opcao"],
								'idcidade'=>$dados["idcidade"],
								'idpais'=>$dados["idpais"],
								'idestado'=>$dados["idestado"],
								'catSexo'=>$dados["catSexo"],
								'passaporte'=>$dados["passaporte"],
								'telefone'=>$dados["telefone"],
								'endereco'=>$dados["endereco"],
								'rne'=>$dados["rne"],
								'nomeempresa'=>$dados["nomeempresa"],
								'idempresa'=>$dados["idempresa"],
								'idagencia'=>$dados["idagencia"],
								'bairro'=>$dados["bairro"],
								'idmotivo'=>trim($dados["idmotivo"]),
								'motivo'=>$dados["motivo"],
								'cep'=>$dados["cep"],
								'datachegada'=>$dados["datachegada"]);
		}
		$Bd->closeConnect();
		return json_encode($arrJson);
	}

	public function update($arrDados)
	{
		$str = 'idhospede = '.$arrDados["idhospede"];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$str,'idhospede');
		$Bd->closeConnect();
		return $resposta;
	}

	function selectQtdTipoHospAgencia($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "select a.nomeagencia, COUNT(*) as qtd  from HOSPEDE h
							inner join AGENCIA a on h.idagencia = a.idagencia
							where h.idagencia is not null  $where group by   a.nomeagencia";
	
		$dadosRecordSet = $Bd->execQuery($strSQL,true,false);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	function graficoNumeroHospede($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		if(!empty($where))
		{
			$strSQL = "select * from (select (select COUNT(*) from HOSPEDE where $where and idagencia is null) as qtd1,
					(select COUNT(*) from HOSPEDE where $where and idagencia is not null) as qtd2) t group by t.qtd1,t.qtd2 ";
		}
		else
		{
			$strSQL = "select * from (select (select COUNT(*) from HOSPEDE where idagencia is null) as qtd1,
					(select COUNT(*) from HOSPEDE where idagencia is not null) as qtd2) t group by t.qtd1,t.qtd2 ";
		}

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	public function selectHistoricoHospede($idhospede,$where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "	select  h.idhospede, h.nome, (case when sexo = 'M' then 'Masculino' else 'Feminino' end) as sexo,
							(case when emp.nomeempresa is null then 'Pessoa Fisica' else emp.nomeempresa end) nomeempresa,
							e.nomeestado,c.nomecidade,h.bairro,h.endereco,
							CONVERT(VARCHAR(10),h.datanascimento,103) datanascimento
								from hospede h
						inner join estado e on e.idestado = h.idestado
						inner join cidade c on c.idcidade = h.idcidade
						left join empresa emp on emp.idempresa = h.idempresa
						where h.idhospede = $idhospede";

		//echo $strSQL;
		//return;

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	public function selectRelHospede($idhospede,$where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "	 select h.nome,
					 (case when h.cpf is null or h.cpf = '' then 'SEM CPF' else h.cpf end) as cpf ,
					 (case when h.rg is null or h.rg = '' then 'SEM RG' else h.rg end) as rg,
					 (case when e.nomeempresa is null or e.nomeempresa = '' then 'SEM EMPRESA' else e.nomeempresa end ) as nomempresa,
					 (case when e.cnpj is null or e.cnpj = '' then 'SEM CNPJ' else e.cnpj end) as cnpj,
					 (case when est.nomeestado is null or est.nomeestado = '' then 'SEM ESTADO' else est.nomeestado end) as nomeestado,
					 (case when c.nomecidade is null or c.nomecidade = '' then 'SEM CIDADE' else c.nomecidade end) as nomecidade,
					 (case when h.datanascimento is null or h.datanascimento = '' then 'SEM DATA DE NASCIMENTO' else 
					 convert(varchar(100),h.datanascimento,103) end) as datanascimento,h.telefone
					  from HOSPEDE h 
					  left join EMPRESA e on e.idempresa = h.idempresa
					  left join ESTADO est on est.idestado = h.idestado
					  left join CIDADE c on c.idcidade = h.idcidade
					  where idhospede = $idhospede";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
			$resposta = true;
		else
			$resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	function selectHospedeTable($where='')
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		if(empty($where))
			$strSQL = "	select idhospede,nome from HOSPEDE order by nome asc";
		else
			$strSQL = "	select idhospede,nome from HOSPEDE where $where ";


		
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

}
?>