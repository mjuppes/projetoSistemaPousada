<?php
class  USUARIO
{
    var $table_name = 'USUARIO';
    var $idusuario;
    var $usuario;
    var $senha;
    var $idgrupo;
	
	function getIdusuario()
	{
		return $this->idusuario;
	}
	function setIdusuario($idusuario)
	{
		$this->idusuario = $idusuario;
	}
	
	function getUsuario()
	{
		return $this->usuario;
	}
	function setUsuario($usuario)
	{
		$this->usuario = $usuario;
	}
	
	function getSenha()
	{
		return $this->senha;
	}
	function setSenha($senha)
	{
		$this->senha = $senha;
	}
	
	function getIdgrupo()
	{
		return $this->idgrupo;
	}
	function setIdgrupo($idgrupo)
	{
		$this->idgrupo = $idgrupo;
	}

	function insert($arrDados,$campo=false)
	{
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'insert');
		$Bd->closeConnect();
		return $resposta;
	}

	function selectUsuario($arr,$where=false,$whereFiltro=false)
	{
	
		$Bd = new Bd(CONEXAO);

		$dadosRecordSet = array();

		$strSQL = "select u.idusuario,u.usuario,u.senha,u.idgrupo,u.senhacrip,f.nome from usuario u 
					inner join funcionario f on f.idfuncionario = u.idfuncionario
					where u.usuario = '$arr[usuario]' and u.senha = '$arr[senha]' and f.habilitado = 'S'";

		 // echo $strSQL;
		 // return;
		
		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		if($dadosRecordSet)
		   $resposta = true;
		else
   		   $resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	function selectPermissao($arr,$where=false,$whereFiltro=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();
		
		//Vou usar consulta para montar painel de ações
		/*
		$strSQL = "select 
		 mn.title as TITLE,it.LABEL as LABELMENU ,it.LINK,mn.icone as ICONE
				from usuario u
						inner join permissao p on u.idgrupo = p.idgrupo
						inner join itenmenu it on it.iditens = p.iditens
						inner join modulo m on m.idmodulo = it.idmodulo
						inner join menu mn on mn.idmenu = it.idmenu
							where u.idgrupo = $arr[idgrupo]
						group by  m.modulo,u.idgrupo, p.iditens,it.link,it.label,
						it.idmenu,mn.NOME,
						mn.icone,mn.title,mn.posicao,it.idordem
						order by mn.posicao asc	";
		
		
		$strSQL= "select distinct  mn.posicao,mn.idmenu as IDMENU,mn.nome as NOME,mn.title as TITLE,mn.icone as ICONE 
				from usuario u 
					inner join permissao p on u.idgrupo = p.idgrupo 
					inner join itenmenu it on it.iditens = p.iditens 
					--inner join modulo m on m.idmodulo = it.idmodulo 
					inner join menu mn on mn.idmenu = it.idmenu 
				where u.idgrupo = $arr[idgrupo] order by mn.posicao asc";*/
				
				$strSQL= "
				select m.idmodulo as IDMODULO,
				m.label as NOME,m.label as TITLE,m.icone as ICONE, '' AS LINK
				from MODULO m where sup is not null order by idordem ";
				

		$dadosRecordSet = $Bd->execQuery($strSQL,true,true);

		if($dadosRecordSet)
		   $resposta = true;
		else
		   $resposta = false;

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	function selectMontaPainelAcoes($where=false)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		$strSQL= " 
			select idmodulo as IDMODULO,modulo,label as TITLE,
			label as LABELMENU ,icone as ICONE,idordem from MODULO
where sup is  null
		order by idordem";
		$dadosRecordSet = $Bd->execQuery($strSQL,true,true);

		$Bd->closeConnect();
		return $dadosRecordSet;
	}

	function selectMontaPainelAcoesModulo($where)
	{
		$Bd = new Bd(CONEXAO);
		$dadosRecordSet = array();

		/*
			$strSQL= "select distinct
		 mn.title as TITLE,it.LABEL as LABELMENU ,it.LINK,it.ICONE,it.idordem
				from usuario u
						inner join permissao p on u.idgrupo = p.idgrupo
						inner join itenmenu it on it.iditens = p.iditens
						inner join modulo m on m.idmodulo = it.idmodulo
						inner join menu mn on mn.idmenu = it.idmenu
							$where
							order by it.idordem";
		*/

	$strSQL= "SELECT 
it.IDITENS,	
				m.label AS TITLE, it.label AS LABELMENU, it.LINK,it.ICONE,it.idordem,it.SUB_MENU	
				FROM
					ITENMENU AS it  JOIN
                      MODULO AS m ON m.idmodulo = it.idmodulo
				$where
							order by it.idordem
				";
				

		
		$dadosRecordSet = $Bd->execQuery($strSQL,true,true);

	

		$Bd->closeConnect();
		return $dadosRecordSet;
	}
	function update($arrDados)
	{
		$str = 'idusuario = '.$arrDados["idusuario"];
		$Bd = new Bd(CONEXAO);
		$resposta = $Bd->executarSql($arrDados,$this->table_name,'update',$str,'idusuario');
		$Bd->closeConnect();
		return $resposta;
	}
}
?>