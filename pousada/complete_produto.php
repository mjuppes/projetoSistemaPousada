<?php session_start(); ?>
<?php include('../CONFIG/config.php');?>
<?php include('../'.DIR_DAO);?>

<?php
$q=strtolower(utf8_decode($_GET["q"]));

$Bd = new Bd(CONEXAO);

$dadosRecord = array();

$sql = "select distinct nomeproduto from produtos where nomeproduto like '%$q%'";

$dadosRecord = $Bd->execQuery($sql,true);

if(empty($dadosRecord))
	echo "Nehum registro encontrado!";
else
{
	foreach($dadosRecord as $dados)
	{
		  echo utf8_encode($dados['nomeproduto'])."\n";
	}
}
$Bd->closeConnect();

