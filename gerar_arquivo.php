<?php
define("CONEXAO", "sqlServer");
define("SERVER_SQL_SERVER", "8XEQAN9528\SQLEXPRESS");
define("USUARIO_SQL_SERVER", "sa");
define("SENHA_SQL_SERVER", "juppes@88");
define("BASE_SQL_SERVER", "hotelsaopaulo");
define("PORTA_SQL_SERVER", "");

include('DAO/ConnectdDB.php');

?>

<html>
<head>
</head>
<body>

<?php
$Bd = new Bd(CONEXAO);
$dadosRecordSet = array();

$strSQL ="
	SELECT table_name 'tabela' FROM information_schema.tables
 order by table_name asc";

$dadosRecordSet = $Bd->execQuery($strSQL,true);
$Bd->closeConnect();
?>
<form action="gerar_arquivo.php" name="form" id="form" method="POST"  enctype="multipart/form-data">
Nome da tabela:
	<select name="tabela">
		<option value="">Selecione a tabela</option>
	<?php
		foreach($dadosRecordSet as $dados)
		{
	?>
			<option value="<?php echo $dados['tabela']; ?>"><?php echo $dados['tabela']; ?></option>
	<?php
		}
	?>
	</select><br><br>
	Caminho: <input type="text" name="path" value="C:/temp/" style="width:30%">
	<br>
	<br>
	<input type="submit" value="Gerar classes">
</form>
</body>
</html>

<?php
if(isset($_POST['tabela']) && $_POST['tabela'] == FALSE)
{
	echo "Erro, selecione uma tabela!";
	exit();
}	
else
{
	if(isset($_POST['tabela']) && !empty($_POST['tabela']))
	{
		include('Classes/gerar_metodos.php');

		$strSQL = "SELECT table_name 'Tabela', column_name 'Coluna' FROM information_schema.columns
				WHERE table_name in (select table_name from information_schema.tables
					where table_name ='".$_POST['tabela']."')";

		$geraMetodos = new geraMetodos($strSQL,$_POST['path']);
		echo "Classes geradas";
	}
}
?>
