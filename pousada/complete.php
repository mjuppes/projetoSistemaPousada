<?php session_start(); ?>
<?php include('../CONFIG/config.php');?>
<?php include('../'.DIR_DAO);?>

<?php

$q=strtolower(utf8_decode($_GET["q"]));

$Bd = new Bd(CONEXAO);

$dadosRecord = array();

$sql = "select distinct nome from hospede where nome like '%$q%'";


$dadosRecord = $Bd->execQuery($sql,true);

if(empty($dadosRecord))
{
	echo "Nenhum registro encontrado!";
	return false;
}

foreach($dadosRecord as $dados)
{
		echo utf8_encode($dados['nome'])."\n";
}
$Bd->closeConnect();

