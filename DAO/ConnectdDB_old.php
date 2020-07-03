<?php
/**
* @Classe DAO (Camada de persistência de dados)
* @Criado em 15/08/2011
*
* @Class que contem chamadas para o model correspondente
*
* @author Marcio (mjuppes@gmail.com)
* @version 1.0.0
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
			case 'postgreSql'://Implementar postgreSql no futuro...
				echo 'Banco em fase de implementação';
				return;
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

		$this->link = pg_connect("host=".$this->servername." port=".$this->porta ."dbname=".$this->dbase." user=".$this->usuario." password=".$this->senha);
		if(!$this->link) 
		{
			echo("Não foi possível estabelecer conexão com o PostGreSql."); 
			return false;
		}

		$db = pg_select($this->dbase, $this->link, '$_POST'); // Selecao do Banco de Dados
		if(!$db)
		{	
			echo ("Não foi possível estabelecer conexão com o banco de dados.");
			return false;
		}
		else
		{
			return true;
		}
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
				while($row = pg_fetch_assoc($result))
				{
					array_push($objRS,$row);
				}
				break;
			default:
				echo 'Tipo de aplicação não existente!';
				break;
		}
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
				$objRS = pg_query($strSQL,$this->link);
				$marcador_final= microtime(1);
				$tempo_execucao = $marcador_final - $marcador_inicial;
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
			
			if($flagmenu)
				return $this->getRecordSet($objRS,$rows,false,$flagmenu);
			else
				return $this->getRecordSet($objRS,$rows);
		}
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
			case 'insert':
				$campo = Array();
				$valor = Array();

				foreach ($arr as $arrC => $value)
				{
					$value = str_replace("'", "''", $value);

					array_push($campo,$arrC);
					if(is_int($value))
						array_push($valor,$value);
					else
						array_push($valor,"'".$value."'");
				}

				$campo = implode(",", $campo);
				$valor = implode(",", $valor);
				$strSQL = "insert into ".$tableName." (".$campo.") values (".$valor.")";
				$_SESSION['sql'] = $strSQL;

				if($this->execQuery($strSQL,false))
				{
					return true;
				}
				else
				{
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
						{
							array_push($valores,$arrC."=NULL");
						}
						else
						{
							array_push($valores,$arrC."='".$value."'");
						}
					}
				}

				$valores = implode(",", $valores);
				if($where != '')
				{
					$strSQL = "update  ".$tableName." set ".$valores." where ".$where;
				}
				else
				{
					$strSQL = "update ".$tableName." set  ".$valores." ";
				}

				$_SESSION['sql'] = $strSQL;

				if($this->execQuery($strSQL,false))
				{
					return true;
				}
				else
				{
					return false;
				}
				break;
			case 'delete_':
				if($where != '')
				{
					$strSQL = "update  ".$tableName." set deletado = 'S' where  ".$where;
				}
				else
				{
					$strSQL = "update  ".$tableName." set deletado = 'S'";
				}

				$_SESSION['sql'] = $strSQL;

				if($this->execQuery($strSQL,false))
				{
					return true;
				}
				else
				{
					return false;
				}
				break;
			case 'delete':
				if(empty($where))
				{
					$strSQL = "delete from ".$tableName;
				}
				else
				{
					$strSQL = "delete from ".$tableName." where  ".$where;
				}

				$_SESSION['sql'] = $strSQL;

				if($this->execQuery($strSQL,false))
				{
					return true;
				}
				else
				{
					return false;
				}
				break;
		}
	}

	/**
 	* @Descrição: método retorna o numero do ultimo  id de registro inserido
	* @return retorna variável com o ultimo id
	* @author Marcio (mjuppes@gmail.com)
	*/

	public function lastRecordSet($campo,$table)
	{
		$strSQL = "select max(".$campo.") as ".$campo." from ".$table;
		return $this->getOneRecordSet($strSQL,$campo);
	}

	/**
 	* @Descrição: método que adiciona dias em uma data
	* @return retorna os dias somados
	* @author Marcio (mjuppes@gmail.com)
	*/

	public function addDaysDate($dias,$data)
	{
		$strSQL = "SELECT CONVERT(VARCHAR(10),DATEADD ( DAY ,".$dias.", '".$data."'),103) as data";
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
				break;
			default:
		}
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
				break;
		}
		$_SESSION['sql'] = $strSQL;
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
				break;
		}
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
}
?>