<?php
/**
* @Classe DAO (Camada de persistência de dados)
* @Criado em 15/08/2011
*
* @Class que contem chamadas para o model correspondente
*
* @author Marcio (mjuppes@gmail.com)
* @version 2.0.0
*
*/
class Bd
{
	var $servername = "";
	var $usuario = "";
	var $senha = "";
	var $dbase = "";
	var $link = "";
	var $banco = "";
	var $porta = "";

	/**
	* @Descrição: Construtor que recebe um parâmetro
	* para setar o banco que será usado o objetivo
	* é saber qual bando se comunicar implementar outros bancos no futuro se possível
	* @author Marcio (mjuppes@gmail.com)
	*/
	public function Bd($banco='')
	{
		switch($banco)
		{
			case 'sqlServer':
				$this->banco = $banco;
				$this->conSqlServer();
				break;
			case 'mySql':
				$this->banco = $banco;
				$this->conMySql();
				break;
			case 'postgreSql':
				$this->banco = $banco;
				$this->conPostGreSql();
				break;
			default:
				echo 'Banco inexistente!';
				break;
		}
	}

	/**
	* @Descrição: Conecta ao banco PostGreSql
	* usando macros como parâmetros seta a variável 
	* $link global em todo o arquivo
	* @author Marcio (mjuppes@gmail.com)
	*/
	private function conPostGreSql()
	{
		$this->servername = SERVER_POSTGRESQL_SERVER;
		$this->usuario 	  = USUARIO_POSTGRESQL_SERVER;
		$this->senha 	  = SENHA_POSTGRESQL_SERVER;
		$this->dbase 	  = BASE_POSTGRESQL_SERVER;
		$this->porta 	  = PORTA_POSTGRESQL_SERVER;

		$this->link = pg_connect("host=".$this->servername." port=".$this->porta ." dbname=".$this->dbase." user=".$this->usuario." password=".$this->senha);

		if(!$this->link) 
		{
			echo("Não foi possível estabelecer conexão com o PostGreSql."); 
			return false;
		}

		if(!$this->link)
		{
			echo ("Não foi possível estabelecer conexão com o banco de dados.");
			return false;
		}
		else
			return true;

	}

	/**
	* @Descrição: Conecta ao banco Mysql
	* usando macros como parâmetros seta a variável 
	* $link global em todo o arquivo
	* @author Marcio (mjuppes@gmail.com)
	*/
	private function conMySql()
	{
		$this->servername = SERVER_MYSQL;
		$this->usuario 	  = USUARIO_MYSQL;
		$this->senha 	  = SENHA_MYSQL;
		$this->dbase 	  = BASE_MYSQL;
		$this->porta 	  = PORTA_MYSQL;

		$this->link = mysql_connect($this->servername, $this->usuario, $this->senha);

		if(!$this->link) 
		{
			echo("Não foi possível estabelecer conexão com o Mysql."); 
			return false;
		}

		$db = mysql_select_db($this->dbase, $this->link); // Selecao do Banco de Dados
		if(!$db)
		{
			echo ("Não foi possível estabelecer conexão com o banco de dados.");
			return false;
		}
		else
			return true;
	}
	
	/**
	* @Descrição: Conecta ao banco SqlServer
	* usando macros como parâmetros seta a variável 
	* $link global em todo o arquivo
	* @author Marcio (mjuppes@gmail.com)
	*/
	private function conSqlServer()
	{
		$this->servername = SERVER_SQL_SERVER;
		$this->usuario    = USUARIO_SQL_SERVER;
		$this->senha      = SENHA_SQL_SERVER;
		$this->dbase      = BASE_SQL_SERVER;
		$this->porta 	  = PORTA_SQL_SERVER;

		$this->link = mssql_connect($this->servername, $this->usuario, $this->senha);

		if(!$this->link)
		{
			echo("Não foi possível estabelecer conexão com o SQL Server."); 
			return false;
		}
		
		
//echo $this->dbase;
//return;
		$db = mssql_select_db($this->dbase, $this->link);

		if(!$db)
		{
			echo ("Não foi possível estabelecer conexão com o banco de dados.");
			return false;
		}

		return true;
	}

	/**
	* @Descrição: Recebe a consulta e associa o array com 
	* os dados que estão vindo do select verifica o banco pela variavel $banco 
	* tem como parâmetro o $result que é a minha string sql 
	* verifica o numero de linhas que foram afetadas
	* @author Marcio (mjuppes@gmail.com)
	*/

	public function getRecordSet($result='',$rows='',$page='',$flagmenu=false)
	{

		$objRS = array();
		switch($this->banco)
		{
			case 'sqlServer':
				if(isset($_SESSION['numPage']) && !empty($_SESSION['numPage']) && !$flagmenu)
				{
					$QtdRegTotal = $rows;
					$_REQUEST["Pagina"] = $_SESSION['numPage'];
					$QtdPorPagina   = $_SESSION['numRows'];
					$PaginaAtual    = ( $_REQUEST["Pagina"] == "") ? 1 : $_REQUEST["Pagina"];
					$QtdPaginas     = ceil( $QtdRegTotal / $QtdPorPagina );

					if($PaginaAtual == 1 )
						$Linha = 0; 
					else
						$Linha = ( $PaginaAtual - 1 ) * $QtdPorPagina;

					mssql_data_seek($result, $Linha);

					$numRows = mssql_num_rows($result);
					if($numRows == 0)
					{
						echo 'Nenhum registro foi encontrado!';
						return false;
					}

					$i=0;
					while(($row = mssql_fetch_assoc( $result ) ) && $i < $QtdPorPagina)
					{
						array_push($objRS,$row);
						$i++;
					}
					
					mssql_free_result($result);	
					$_SESSION['numPage'] ="";
					return $objRS;
				}
				else
				{
					$numRows = mssql_num_rows($result);
					if($numRows == 0)
					{
						echo 'Nenhum registro foi encontrado!';
						return false;
					}
					while($row = mssql_fetch_assoc($result))
					{
						array_push($objRS,$row);
					}

					mssql_free_result($result);
					
				}
			break;
			case 'mySql':
				$numRows = mysql_num_rows($result);

				if($numRows == 0)
				{
					echo 'Nenhum registro foi encontrado!';
					return false;
				}

				while($row = mysql_fetch_assoc($result))
				{
					array_push($objRS,$row);
				}
				mysql_free_result($result);
			break;
			case 'postgreSql':
				if(isset($_SESSION['numPage']) && !empty($_SESSION['numPage']))
				{
					$QtdRegTotal = $rows;
					$_REQUEST["Pagina"] = $_SESSION['numPage'];
					$QtdPorPagina   = $_SESSION['numRows'];
					$PaginaAtual    = ($_REQUEST["Pagina"] == "") ? 1 : $_REQUEST["Pagina"];
					$numRows = pg_num_rows($result);

					if(empty($QtdPorPagina))
						$QtdPorPagina = $numRows;

					$QtdPaginas     = ceil( $QtdRegTotal / $QtdPorPagina );

					if($PaginaAtual == 1 )
						$Linha = 0; 
					else
						$Linha = ($PaginaAtual - 1 ) * $QtdPorPagina;

					pg_result_seek($result, $Linha);
					

					if($numRows == 0)
					{
						echo 'Nenhum registro foi encontrado!';
						return false;
					}

					$i=0;
					while(($row = pg_fetch_assoc( $result ) ) && $i < $QtdPorPagina)
					{
						array_push($objRS,$row);
						$i++;
					}

					pg_free_result($result);	
					$_SESSION['numPage'] = "";
					return $objRS;
				}
				else
				{
					$numRows = pg_num_rows($result);

					if($numRows == 0)
						return false;

					while($row = pg_fetch_assoc($result))
					{
						array_push($objRS,$row);
					}

					pg_free_result($result);
				}
			break;
			default:
				echo 'Tipo de aplicação não existente!';
			break;
		}

		//$this->logSql("Executou função getRecordSet: ".$this->banco);
		return $objRS;
	}

	/**
 	* @Descrição: Executa a query  e o segundo parâmetro
	* informa se precisa ser retornado um array caso true,
	* ou só é necessário executar a query
	* faz o cálculo do tempo de execução da query
	* armazena na variável de sessão
	* método usado em todo o sistema
	* @return retorna true ou false ou um array
	* caso o parâmetro $record seja setado como true
	* @author Marcio (mjuppes@gmail.com)
	*/

	public function execQuery($strSQL="",$record=false,$flagmenu=false)
	{
		switch($this->banco)
		{
			case 'sqlServer':
				$marcador_inicial = microtime(1);
				$objRS = @mssql_query($strSQL,$this->link);
				$marcador_final= microtime(1);
				$tempo_execucao = $marcador_final - $marcador_inicial;
				$rows = mssql_rows_affected($this->link);
				break;
			case 'mySql':
				$marcador_inicial = microtime(1);
				$objRS = mysql_query($strSQL,$this->link);
				$marcador_final= microtime(1);
				$tempo_execucao = $marcador_final - $marcador_inicial;
				$rows = mysql_rows_affected($this->link);
			break;
			case 'postgreSql':
				$marcador_inicial = microtime(1);
				$objRS = pg_query($this->link,$strSQL);
				$marcador_final= microtime(1);
				$tempo_execucao = $marcador_final - $marcador_inicial;
				$rows = pg_affected_rows($objRS);
			break;
			default:
				break;
		}

		$_SESSION['tempo_execucao'] = $tempo_execucao;
		
		if($rows == 0)
			return false;

		if(!$objRS)
		{
			$_SESSION['sql'] = $strSQL;
			echo utf8_encode('Não consigo executar a query: <br>Sql: ' . $strSQL);
			return false;
		}

		if($record)
		{
			$_SESSION['sql'] = $strSQL;
			$this->logSql("Executou função execQuery: ".$strSQL);
			
			if($flagmenu)
				return $this->getRecordSet($objRS,$rows,false,$flagmenu);
			else
				return $this->getRecordSet($objRS,$rows);
		}

		$this->logSql("Executou função execQuery: ".$strSQL);
		return $objRS;
	}

	/**
 	* @Descrição: método recebe cinco parâmetros 
	* 1 - array como associado nome e valor
	* 2 - nome da tabela onde vai ser feito o comando
	* 3 - tipo de comando se é insert, update, delete ou delete_full
	* 4 - a condição
	* 5 - a chave caso o tipo seja update e a chave não pode ser atualizada
	* dentro do métod existe uma variável de sessão para armazenar a sql 
	* @return retorna true ou false caso tenha acontecido algum erro
	* @author Marcio (mjuppes@gmail.com)
	*/

	public function executarSql($arr='',$tableName='',$tipo='',$where='',$chave='')
	{
		switch($tipo)
		{
			case 'insert_last_id':
				$campo = Array();
				$valor = Array();

				foreach ($arr as $arrC => $value)
				{
					$value = str_replace("'", "''", $value);

					array_push($campo,$arrC);
					
					if($value == 'DATE_NOW')
					{
						array_push($valor,'SYSDATETIME()');
					}
					else
					{
						if(is_int($value))
							array_push($valor,$value);
						else
							array_push($valor,"'".$value."'");
					}
				}

				$campo = implode(",", $campo);
				$valor = implode(",", $valor);

				if($this->banco == "postgreSql")
					$strSQL = 'insert into "'.$tableName.'" ('.$campo.') values ('.$valor.')';
				else
				{
					$strSQL  = "insert into ".$tableName." (".$campo.") values (".$valor.")";
					$strSQL .= "SELECT IDENT_CURRENT('".$tableName."') as last_id";
				}
					

				$_SESSION['sql'] = $strSQL;
				$result = @mssql_query($strSQL,$this->link);
				
				$objRS = array();
				while($row = mssql_fetch_assoc($result))
				{
						array_push($objRS,$row);
				}
				mssql_free_result($result);
				
				return $objRS;
				break;
			case 'insert':
				$campo = Array();
				$valor = Array();

				foreach ($arr as $arrC => $value)
				{
					$value = str_replace("'", "''", $value);

					array_push($campo,$arrC);
					
					
					if($value == 'DATE_NOW')
					{
						array_push($valor,'SYSDATETIME()');
					}
					else
					{
						if(is_int($value))
							array_push($valor,$value);
						else
							array_push($valor,"'".$value."'");
					}
				}

				$campo = implode(",", $campo);
				$valor = implode(",", $valor);

				if($this->banco == "postgreSql")
					$strSQL = 'insert into "'.$tableName.'" ('.$campo.') values ('.$valor.')';
				else
					$strSQL = "insert into ".$tableName." (".$campo.") values (".$valor.")";

				$_SESSION['sql'] = $strSQL;

				if($this->execQuery($strSQL,false))
				{
					$this->logSql("Executou função executarSql: ".$strSQL);
					return true;
				}
				else
				{
					$this->logSql("Erro no comando: ".$strSQL);
					return false;
				}
				break;
			case 'update':
				$valores = Array();

				foreach($arr as $arrC => $value)
				{
					$value = str_replace("'", "''", $value);

					if($arrC != $chave)
					{
						if(empty($value))
							array_push($valores,$arrC."=NULL");
						else
							array_push($valores,$arrC."='".trim($value)."'");
					}
				}

				$valores = implode(",", $valores);

				if($where != '')
				{
					if($this->banco == "postgreSql")
						$strSQL = 'update  "'.$tableName.'" set '.$valores.' where '.$where;
					else
						$strSQL = "update  ".$tableName." set ".$valores." where ".$where;
				}
				else
				{
					if($this->banco == "postgreSql")
						$strSQL = 'update  "'.$tableName.'" set '.$valores;
					else
						$strSQL = "update ".$tableName." set  ".$valores." ";
				}

				$_SESSION['sql'] = $strSQL;

				if($this->execQuery($strSQL,false))
				{
					$this->logSql("Executou função executarSql: ".$strSQL);
					return true;
				}
				else
				{
					$this->logSql("Erro no comando: ".$strSQL);
					return false;
				}
				break;
			case 'delete_':
				if($where != '')
					$strSQL = "update  ".$tableName." set deletado = 'S' where  ".$where;
				else
					$strSQL = "update  ".$tableName." set deletado = 'S'";

				$_SESSION['sql'] = $strSQL;

				if($this->execQuery($strSQL,false))
				{
					$this->logSql("Executou função executarSql: ".$strSQL);
					return true;
				}
				else
				{
					$this->logSql("Erro no comando: ".$strSQL);
					return false;
				}
				break;
			case 'delete':
				if(empty($where))
				{
					if($this->banco == "postgreSql")
						$strSQL = 'delete from "'.$tableName.'"';
					else
						$strSQL = "delete from ".$tableName;
				}
				else
				{
					if($this->banco == "postgreSql")
						$strSQL = 'delete from "'.$tableName.'" where  '.$where;
					else
						$strSQL = "delete from ".$tableName." where  ".$where;
				}

				$_SESSION['sql'] = $strSQL;

				if($this->execQuery($strSQL,false))
				{
					$this->logSql("Executou função executarSql: ".$strSQL);
					return true;
				}
				else
				{
					$this->logSql("Erro no comando: ".$strSQL);
					return false;
				}
				break;
		}
	}

	/**
 	* @Descrição: método recebe dois parâmetros 
	* 1 - array como associado indice,nome e valor
	* 2 - nome da tabela onde vai ser feito o comando
	* método cria para insert de grande quantidade de dados
	* @return retorna true ou false caso tenha acontecido algum erro
	* @author Marcio (mjuppes@gmail.com)
	* data: 17/11/2015 12:05
	*/

	public function insert_massive($arr='',$tableName='')
	{
		$campos = Array();
		$flag = false;
		$strSQL = "";
		$part_1 = "";
		$part_2 = "";

		foreach($arr as $key => $value)
		{
				foreach($value as $key2 => $value2)
				{
						if(!in_array($key2,$campos))
						{
							array_push($campos,$key2);

							if(empty($part_1))
								$part_1 .= "('".$value2."'";
							else
								$part_1 .= ",'".$value2."'";
						}
						else
						{
							if($flag == false)
								$part_2 .= ",('".$value2."'";
							else
							{
								if(empty($part_2))
									$part_2 .= ",('".$value2."'";
								else
									$part_2 .= ",'".$value2."'";
							}

							$flag = true;
						}
				}

				if(!empty($part_2))
				{
					if($flag == true)
						$part_2 .= ")";

					$flag = false;
				}
		}

		$part_1 .= ")";
		$values = $part_1.$part_2;

		$campos = implode(",", $campos);

		if($this->banco == "postgreSql")
			$strSQL .= 'insert into "'.$tableName.'" ('.$campos.') values '.$values;
		else
			$strSQL .= 'insert into '.$tableName.' ('.$campos.') values '.$values;

		$_SESSION['sql'] = $strSQL;
		if($this->execQuery($strSQL,false))
			return true;
		else
			return false;
	}

	/**
 	* @Descrição: método retorna o numero do ultimo  id de registro inserido
	* @return retorna variável com o ultimo id
	* @author Marcio (mjuppes@gmail.com)
	*/

	public function lastRecordSet($campo,$table)
	{
		$strSQL = "select max(".$campo.") as ".$campo." from ".$table;
		$this->logSql("Executou função lastRecordSet: ".$strSQL);
		return $this->getOneRecordSet($strSQL,$campo);
	}

	/**
 	* @Descrição: método que adiciona dias em uma data
	* @return retorna os dias somados
	* @author Marcio (mjuppes@gmail.com)
	*/

	public function addDaysDate($dias,$data)
	{
		$strSQL = "SELECT CONVERT(VARCHAR(10),DATEADD (DAY ,".$dias.", '".$data."'),103) as data";
		$this->logSql("Executou função getRecordNumRows: ".$strSQL);
		return $this->getOneRecordSet($strSQL,'data');
	}

	/**
 	* @Descrição: método retorna o numero de linhas da consulta
	* @return retorna variável com o número de linhas
	* @author Marcio (mjuppes@gmail.com)
	*/
	public function getRecordNumRows($strSQL='')
	{
		switch($this->banco)
		{
			case 'sqlServer':
					$objRS = mssql_query($strSQL,$this->link);
					$numRows = mssql_num_rows($objRS);
				break;
			case 'mySql':
					$objRS = mysql_query($strSQL,$this->link);
					$numRows = mysql_num_rows($result);
				break;
			case 'postgreSql':
					$objRS = pg_query($this->link,$strSQL);
					$numRows = pg_num_rows($result);
				break;
			default:
		}
		
		$this->logSql("Executou função getRecordNumRows: ".$strSQL);
		return $numRows;
	}

	/**
 	* @Descrição: método executa a procedure correspondete
	* segundo parâmetro é opcional caso a procedure tenha que receber algum 
	* parâmetro
	* @return true ou false caso tenha acontecido algum problema
	* @author Marcio (mjuppes@gmail.com)
	*/
	public function execProcedure($procedure='',$idprocedure='')
	{
		$strSQL = "EXEC ".$procedure." ".$idprocedure;
		$_SESSION['sql'] = $strSQL;
		$this->logSql("Executou função execProcedure: ".$strSQL);
		$objRS = $this->execQuery($strSQL,false);

		if($objRS)
			return "1";
		else
			return "2";
	}

	public function execProcedureArray($procedure='',$arrIdprocedure=false,$exec=false)
	{
		$strIdProcedure = "";

		foreach($arrIdprocedure as $key => $value)
		{
			if(empty($strIdProcedure))
				$strIdProcedure .= " ".$value;
			else
				$strIdProcedure .= " , ".$value;
		}

		$strSQL = "EXEC ".$procedure." ".$strIdProcedure;
		$_SESSION['sql'] = $strSQL;
		$this->logSql("Executou função execProcedureArray: ".$strSQL);
		$objRS = $this->execQuery($strSQL,$exec);
		return $objRS;
	}

	/**
 	* @Descrição: método retorna uma recordset
	* @return retorna o campo que setado
	* @author Marcio (mjuppes@gmail.com)
	*/
	public function getOneRecordSet($strSQL='',$campo='')
	{
		switch($this->banco)
		{
			case 'sqlServer':
					$objRS = mssql_query($strSQL,$this->link);
					$row = mssql_fetch_array($objRS);
				break;
			case 'mySql':
					$objRS = mysql_query($strSQL,$this->link);
					$row = mysql_fetch_array($objRS);
				break;
			case 'postgreSql':
					$objRS = pg_query($this->link,$strSQL);
					$row = pg_fetch_array($objRS, 0,PGSQL_ASSOC);
				break;
		}

		$_SESSION['sql'] = $strSQL;
		$this->logSql("Executou função getOneRecordSet: ".$strSQL);
		return $row[$campo];
	}

	/**
 	* @Descrição: método fecha a minha conecxão
	* com o banco de dados
	* @return sem retorno
	* @author Marcio (mjuppes@gmail.com)
	*/
	public function closeConnect()
	{
		switch($this->banco)
		{
			case 'sqlServer':
				mssql_close($this->link);
			break;
			case 'mySql':
				mysql_close($this->link);
			break;
			case 'postgreSql':
				pg_close($this->link);
			break;
		}

		$this->logSql("Fechou link com Banco: ".$this->banco);
	}

	public function execQueryObject($strSQL="",$arrVariaveis=false)
	{
		$retArray = array();

		switch($this->banco)
		{
			case 'sqlServer':
					$objRS = mssql_query($strSQL,$this->link);
					while($row = mssql_fetch_object($objRS))
					{
							if($arrVariaveis)
							{
								foreach($arrVariaveis as $value)
								{
									$row->{$value} = utf8_encode($row->{$value});
								}
							}
							$retArray[] = $row;
					}
			break;
			case 'mySql':
					$objRS = mysql_query($strSQL,$this->link);
					while($row = mysql_fetch_object($objRS))
					{
							if($arrVariaveis)
							{
								foreach($arrVariaveis as $value)
								{
									$row->{$value} = utf8_encode($row->{$value});
								}
							}
							$retArray[] = $row;
					}
			break;
			case 'postgreSql':
			break;
		}

		$_SESSION['sql'] = $strSQL;
		return $retArray;
	}

	public function logSql($msgSql)
	{
		/*$data = date("d/m/Y H:i:s");
		$fp = fopen('c:\temp\logSql-'.date("d-m-Y").'.conf', "a");

		$string = "";

		if(isset($_SESSION['username']))
			$string = " \r\n usuário logado como ". $_SESSION['username']." -> $msgSql -> $data \r";

		$escreve = fwrite($fp,$string);
		fclose($fp);*/
		return;
	}
}
?>