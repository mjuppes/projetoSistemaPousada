<?php
class  PESQUISA_CONTATO
{
    var $table_name = 'PESQUISA_CONTATO';
    var $id_pesquisa;
    var $id_contato;
    var $nome;
    var $cargo;
    var $estrelas;
    var $num_quartos;
    var $num_colaboradores;
    var $taxa_ocupacao;
    var $observacao_taxa;
    var $sistema;
    var $nome_sistema;
    var $tipo_sistema;
    var $tempo_uso;
    var $custo;
    var $satisfeito;
    var $observacao_satisfeito;
    var $observacao_falta;
    var $suporte;
    var $observacao_suporte;
    var $possui_erros;
    var $observacao_erros;
    var $numero_usuarios;
    var $observacao_controle;
    var $motor_vendas;
    var $nfe;
    var $observacao_motor_nfe;
    var $observacao_c_atual;
    var $observacao_sistema;
    var $observacao_gerais;
    var $situacao_pesquisa;
    var $operacao;
	
	function getId_pesquisa()
	{
		return $this->id_pesquisa;
	}
	function setId_pesquisa($id_pesquisa)
	{
		$this->id_pesquisa = $id_pesquisa;
	}

	
	function getId_contato()
	{
		return $this->id_contato;
	}
	function setId_contato($id_contato)
	{
		$this->id_contato = $id_contato;
	}

	
	function getNome()
	{
		return $this->nome;
	}
	function setNome($nome)
	{
		$this->nome = $nome;
	}

	
	function getCargo()
	{
		return $this->cargo;
	}
	function setCargo($cargo)
	{
		$this->cargo = $cargo;
	}

	
	function getEstrelas()
	{
		return $this->estrelas;
	}
	function setEstrelas($estrelas)
	{
		$this->estrelas = $estrelas;
	}

	
	function getNum_quartos()
	{
		return $this->num_quartos;
	}
	function setNum_quartos($num_quartos)
	{
		$this->num_quartos = $num_quartos;
	}

	
	function getNum_colaboradores()
	{
		return $this->num_colaboradores;
	}
	function setNum_colaboradores($num_colaboradores)
	{
		$this->num_colaboradores = $num_colaboradores;
	}

	
	function getTaxa_ocupacao()
	{
		return $this->taxa_ocupacao;
	}
	function setTaxa_ocupacao($taxa_ocupacao)
	{
		$this->taxa_ocupacao = $taxa_ocupacao;
	}

	
	function getObservacao_taxa()
	{
		return $this->observacao_taxa;
	}
	function setObservacao_taxa($observacao_taxa)
	{
		$this->observacao_taxa = $observacao_taxa;
	}

	
	function getSistema()
	{
		return $this->sistema;
	}
	function setSistema($sistema)
	{
		$this->sistema = $sistema;
	}

	
	function getNome_sistema()
	{
		return $this->nome_sistema;
	}
	function setNome_sistema($nome_sistema)
	{
		$this->nome_sistema = $nome_sistema;
	}

	
	function getTipo_sistema()
	{
		return $this->tipo_sistema;
	}
	function setTipo_sistema($tipo_sistema)
	{
		$this->tipo_sistema = $tipo_sistema;
	}

	
	function getTempo_uso()
	{
		return $this->tempo_uso;
	}
	function setTempo_uso($tempo_uso)
	{
		$this->tempo_uso = $tempo_uso;
	}

	
	function getCusto()
	{
		return $this->custo;
	}
	function setCusto($custo)
	{
		$this->custo = $custo;
	}

	
	function getSatisfeito()
	{
		return $this->satisfeito;
	}
	function setSatisfeito($satisfeito)
	{
		$this->satisfeito = $satisfeito;
	}

	
	function getObservacao_satisfeito()
	{
		return $this->observacao_satisfeito;
	}
	function setObservacao_satisfeito($observacao_satisfeito)
	{
		$this->observacao_satisfeito = $observacao_satisfeito;
	}

	
	function getObservacao_falta()
	{
		return $this->observacao_falta;
	}
	function setObservacao_falta($observacao_falta)
	{
		$this->observacao_falta = $observacao_falta;
	}

	
	function getSuporte()
	{
		return $this->suporte;
	}
	function setSuporte($suporte)
	{
		$this->suporte = $suporte;
	}

	
	function getObservacao_suporte()
	{
		return $this->observacao_suporte;
	}
	function setObservacao_suporte($observacao_suporte)
	{
		$this->observacao_suporte = $observacao_suporte;
	}

	
	function getPossui_erros()
	{
		return $this->possui_erros;
	}
	function setPossui_erros($possui_erros)
	{
		$this->possui_erros = $possui_erros;
	}

	
	function getObservacao_erros()
	{
		return $this->observacao_erros;
	}
	function setObservacao_erros($observacao_erros)
	{
		$this->observacao_erros = $observacao_erros;
	}

	
	function getNumero_usuarios()
	{
		return $this->numero_usuarios;
	}
	function setNumero_usuarios($numero_usuarios)
	{
		$this->numero_usuarios = $numero_usuarios;
	}

	
	function getObservacao_controle()
	{
		return $this->observacao_controle;
	}
	function setObservacao_controle($observacao_controle)
	{
		$this->observacao_controle = $observacao_controle;
	}

	
	function getMotor_vendas()
	{
		return $this->motor_vendas;
	}
	function setMotor_vendas($motor_vendas)
	{
		$this->motor_vendas = $motor_vendas;
	}

	
	function getNfe()
	{
		return $this->nfe;
	}
	function setNfe($nfe)
	{
		$this->nfe = $nfe;
	}

	
	function getObservacao_motor_nfe()
	{
		return $this->observacao_motor_nfe;
	}
	function setObservacao_motor_nfe($observacao_motor_nfe)
	{
		$this->observacao_motor_nfe = $observacao_motor_nfe;
	}

	
	function getObservacao_c_atual()
	{
		return $this->observacao_c_atual;
	}
	function setObservacao_c_atual($observacao_c_atual)
	{
		$this->observacao_c_atual = $observacao_c_atual;
	}

	
	function getObservacao_sistema()
	{
		return $this->observacao_sistema;
	}
	function setObservacao_sistema($observacao_sistema)
	{
		$this->observacao_sistema = $observacao_sistema;
	}

	
	function getObservacao_gerais()
	{
		return $this->observacao_gerais;
	}
	function setObservacao_gerais($observacao_gerais)
	{
		$this->observacao_gerais = $observacao_gerais;
	}

	
	function getSituacao_pesquisa()
	{
		return $this->situacao_pesquisa;
	}
	function setSituacao_pesquisa($situacao_pesquisa)
	{
		$this->situacao_pesquisa = $situacao_pesquisa;
	}

	
	function getOperacao()
	{
		return $this->operacao;
	}
	function setOperacao($operacao)
	{
		$this->operacao = $operacao;
	}


	public function select($where=false)
	{

		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL = "
		select	pc.id_pesquisa, c.nome as contato,
				pc.nome as atendente,
				(CONVERT(VARCHAR(29),pc.data_cadastro,103) +' '+CONVERT(VARCHAR(29),pc.data_cadastro,108)) as data_cadastro,
				(case 
					when pc.sistema = 'S' then 'Sim'
					when pc.sistema = 'N' then 'Não'
					else ' '

				end) as sistema, 
				(case when nome_sistema is null then ' ' else nome_sistema end) as nome_sistema,
				(case when situacao_pesquisa = 'F' then 'Finalizada' else 'Retornar Ligação' end) as situacao_pesquisa,
				u.usuario
				from PESQUISA_CONTATO pc 
				join CONTATOS c on c.id_contato = pc.id_contato
				join USUARIO u on u.idusuario = pc.id_usuario	";

		if(!empty($where))
			$strSQL .= " where ".$where;

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);
		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	
	public function selectDadosJson($id_pesquisa)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$strSQL = " select
							id_pesquisa ,pc.id_contato,pc.nome,c.telefone,cargo,
							pc.estrelas,num_quartos,num_colaboradores,
							taxa_ocupacao,observacao_taxa,sistema,nome_sistema,
							tipo_sistema,tempo_uso,custo,satisfeito,observacao_satisfeito,
							observacao_falta,suporte,observacao_suporte,possui_erros,
							observacao_erros,numero_usuarios,observacao_controle,
							motor_vendas,nfe,observacao_motor_nfe,observacao_c_atual,observacao_sistema,
							observacao_gerais,situacao_pesquisa,operacao,prioridade
						from PESQUISA_CONTATO pc join CONTATOS c on c.id_contato = pc.id_contato
					where id_pesquisa = ".$id_pesquisa;

 		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		foreach($dadosRecordSet as $dados)
		{
				$arrJson = array('id_pesquisa'=>$dados['id_pesquisa']
								,'id_contato'=>$dados['id_contato']
								,'telefone'=>$dados['telefone']
								,'nome'=>$dados['nome']
								,'cargo'=>$dados['cargo']
								,'estrelas'=>$dados['estrelas']
								,'num_quartos'=>$dados['num_quartos']
								,'num_colaboradores'=>$dados['num_colaboradores']
								,'taxa_ocupacao'=>$dados['taxa_ocupacao']
								,'observacao_taxa'=>$dados['observacao_taxa']
								,'sistema'=>$dados['sistema']
								,'nome_sistema'=>$dados['nome_sistema']
								,'tipo_sistema'=>$dados['tipo_sistema']
								,'tempo_uso'=>$dados['tempo_uso']
								,'custo'=>$dados['custo']
								,'satisfeito'=>$dados['satisfeito']
								,'observacao_satisfeito'=>$dados['observacao_satisfeito']
								,'observacao_falta'=>$dados['observacao_falta']
								,'suporte'=>$dados['suporte']
								,'observacao_suporte'=>$dados['observacao_suporte']
								,'possui_erros'=>$dados['possui_erros']
								,'observacao_erros'=>$dados['observacao_erros']
								,'numero_usuarios'=>$dados['numero_usuarios']
								,'observacao_controle'=>$dados['observacao_controle']
								,'motor_vendas'=>$dados['motor_vendas']
								,'nfe'=>$dados['nfe']
								,'observacao_motor_nfe'=>$dados['observacao_motor_nfe']
								,'observacao_c_atual'=>$dados['observacao_c_atual']
								,'observacao_sistema'=>$dados['observacao_sistema']
								,'observacao_gerais'=>$dados['observacao_gerais']
								,'situacao_pesquisa'=>$dados['situacao_pesquisa']
								,'operacao'=>$dados['operacao']
								,'prioridade'=>$dados['prioridade']);
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
	public function insert_last_id($arrDados,$campo=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		$dadosRecordSet = $Bd->executarSql($arrDados,$this->table_name,'insert_last_id');
		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	public function update($arrDados)
	{
		$chave = 'id_pesquisa = '.$arrDados['id_pesquisa'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$chave,'id_pesquisa');
		$Bd->closeConnect();
		return $resposta;
	}

	public function delete($arrDados)
	{
		$chave = 'id_pesquisa = '.$arrDados['id_pesquisa'];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'delete',$chave);
		$Bd->closeConnect();
		return $resposta;
	}
}
?>
