<?php session_start(); ?>
<?php include('../CONFIG/config.php');?>
<?php include('../'.DIR_DAO);?>

<?php
$q=strtolower(utf8_decode($_GET["q"]));

$Bd = new Bd(CONEXAO);

$dadosRecord = array();

$sql = "
select distinct h.nome from reserva r
 inner join HOSPEDE h on r.idhospede = h.idhospede where h.nome like '%$q%'";


$dadosRecord = $Bd->execQuery($sql,true);

if(empty($dadosRecord))
	echo "Nenhum registro encontrado!";
else
{

	foreach($dadosRecord as $dados)
	{
		  echo utf8_encode($dados['nome'])."\n";
	}
}
$Bd->closeConnect();
?>