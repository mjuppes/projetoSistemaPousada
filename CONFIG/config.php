<?php
define("USUARIO_SQL_SERVER_LIB", "sa");
define("SENHA_SQL_SERVER_LIB", "juppes@88");
define("BASE_SQL_SERVER_LIB", "acesso");
define("SERVER_SQL_SERVER", "8XEQAN9528\SQLEXPRESS");

if(isset($_POST['formLogin_user']) && isset($_POST["formLogin_senha"]) &&  !empty($_POST['formLogin_user']) && !empty($_POST["formLogin_senha"]))
{
		$link = mssql_connect(SERVER_SQL_SERVER,USUARIO_SQL_SERVER_LIB,SENHA_SQL_SERVER_LIB);
		$db = mssql_select_db(BASE_SQL_SERVER_LIB, $link); //Selecao do Banco de Dados

		$strSh = sha1($_POST["formLogin_senha"]);
		$strSenha = md5($strSh);

		$strSQL = "select idacesso,usuario,senha,base from ACESSO where usuario = '".trim($_POST['formLogin_user'])."' and senha = '".$strSenha."'";
		$result = mssql_query($strSQL,$link);

		$objRS = array();
		while($row = mssql_fetch_assoc($result))
		{
			array_push($objRS,$row);
		}

		foreach($objRS as $dados)
		{
			$_SESSION["BASE"] 		= $dados["base"];
			$_SESSION["idacesso"] 	= $dados["idacesso"];
		}
}

define("DIR_PADRAO_METODOS", "C:/tmp/");
define("DIR_PADRAO_METODOS_BKP", "C:/tmp/");
define("CONEXAO", "sqlServer");
define("DIR_CLASSE_JSON", "Classes/Class_Json.php");
define("DIR_CLASSES", "Classes/");
define("DIR_INCLUDES", "INCLUDES/includes.php");


define("DIR_EMAIL", "ClasseEmail/");
define('GUSER', 'mjuppes@gmail.com');
define('GPWD', 'mjuppes88');


define("DIR_DAO", "DAO/ConnectdDB.php");
define("DIR_MPDF", "MPDF/");
define("DIR_MPDF2", "MPDF2/");

define("DIR_ACTIONS", "action/");
define("DIR_EXECEL", "classeExcel/");
define("DIR_GRID", "classeGrid/");

define("SERVER_SQL_SERVER", "8XEQAN9528\SQLEXPRESS");
define("USUARIO_SQL_SERVER", "sa");
define("SENHA_SQL_SERVER", "juppes@88");
define("BASE_SQL_SERVER", $_SESSION["BASE"]);
define("PORTA_SQL_SERVER", "");

define("SERVER_MYSQL", "localhost");
define("USUARIO_MYSQL", "root");
define("SENHA_MYSQL", "");
define("BASE_MYSQL", "mysql");
define("PORTA_MYSQL", "");
define("DATE_NOW", "DATE_NOW");

define("SERVER_POSTGRESQL_SERVER", "localhost");
define("USUARIO_POSTGRESQL_SERVER", "postgres");
define("SENHA_POSTGRESQL_SERVER", "1234");
define("BASE_POSTGRESQL_SERVER", "bolao");
define("PORTA_POSTGRESQL_SERVER", "5432");
?>