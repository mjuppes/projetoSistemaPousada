<?php session_start(); ?>
<?php
define("DIR_ACTIONS", "action/");
define("DIR_EMAIL", "ClasseEmail/");
define("SERVER_SQL_SERVER", "8XEQAN9528\SQLEXPRESS");
define("USUARIO_SQL_SERVER", "sa");
define("SENHA_SQL_SERVER", "juppes@88");
define("BASE_SQL_SERVER", "suporte");
define('GUSER', 'mjuppes@gmail.com');
define('GPWD', 'mjuppes88');


include('../'.DIR_EMAIL.'class.phpmailer.php');
include('../'.DIR_ACTIONS.'genericFunction.php');


$link = mssql_connect(SERVER_SQL_SERVER,USUARIO_SQL_SERVER,SENHA_SQL_SERVER);
$db = mssql_select_db(BASE_SQL_SERVER, $link); //Selecao do Banco de Dados

switch($_POST['controller'])
{
	case 'cadastroChamado':
		$data = date("d/m/Y H:i:s");
		$strSQL = "INSERT INTO CHAMADO (titulo,descricao,idacesso,base,data,status) values ('$_POST[formTitulo]','$_POST[formDescricao]','".$_SESSION['idacesso']."','".$_SESSION['BASE']."','".$data."','1')";
		$objRS = mssql_query($strSQL,$link);

		if($objRS)
		{
			$msg = "<strong>Cliente</strong>".$_SESSION['BASE']."<br><strong>Titulo</strong>:".$_POST['formTitulo']."<br><strong>Descrição</strong>".$_POST['formDescricao'];
			if(smtpmailer('mjuppes@gmail.com', 'mjuppes@gmail.com', 'Marcio', 'Chamado aberto',$msg))
				echo "1";	
			else
				echo "erro!";
		}
		else
			echo "erro!";
	break;
	case 'selectChamadosTable':
		$strSQL = "select c.idchamado, c.titulo,c.descricao,ac.usuario,c.data,
				(case when status = '1' then 'Aberto' else 'Fechado' end) as status
		from CHAMADO c
					join acesso.dbo.acesso  ac on ac.idacesso = c.idacesso
					where c.base = '".trim($_SESSION["BASE"])."'";

		$objRS = mssql_query($strSQL,$link);
		$arrDados = array();

		while($row = mssql_fetch_assoc($objRS))
		{
			array_push($arrDados,$row);
		}

		$strJSON = json_encode('{"rows":'.json_encode($arrDados)."}");
		echo($strJSON);
	break;
	case 'deleteChamado':
		$strSQL = "delete from CHAMADO where idchamado = ".$_POST['idchamado'];
		$objRS = mssql_query($strSQL,$link);
		if($objRS)
			echo "1";
		else
			echo "erro!";
	break;
	case 'selectDadosChamado':
		$strSQL = "select c.idchamado, c.titulo,c.descricao,ac.usuario,c.data,
				c.status
		from CHAMADO c
					join acesso.dbo.acesso  ac on ac.idacesso = c.idacesso
					where c.base = '".trim($_SESSION["BASE"])."' and c.idchamado = ".$_POST['idchamado'];

		$objRS = mssql_query($strSQL,$link);
		$arrDados = array();

		while($row = mssql_fetch_assoc($objRS))
		{
			array_push($arrDados,$row);
		}
	
		foreach($arrDados as $dados)
		{
				$arrJson = array('idchamado'=>$dados['idchamado']
								,'titulo'=>$dados['titulo']
								,'descricao'=>$dados['descricao']
								,'status'=>$dados['status']);
		}
		
		echo json_encode($arrJson);
	break;
	case 'selectStatus':
		$arrStatus = array("Ativo"=>"1","Encerrado"=>"2");
		echo selectCombo("-- Selecione --",$arrStatus,false,$_POST['id']);
	break;
}
?>