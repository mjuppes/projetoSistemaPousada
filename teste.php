<?php include "permissao.php"; ?>
<?php include('CONFIG/config.php');?>
<?php include(DIR_DAO);?>

<?php

// $strSh = sha1('admFelix');
		// $strSenha = md5($strSh);
// echo $strSenha;
// return;
$sql = "select * from quarto where idquarto = $_GET[idquarto]";
$Bd = new Bd(CONEXAO);
$dadosRecord = $Bd->execQuery($sql,true);
$Bd->closeConnect();

foreach($dadosRecord as $dados)
{

		$arrItens =  explode("|",$dados['itens']);
		$strItens = "";

		foreach($arrItens as $key => $value)
		{
			switch($value)
			{
				case '1': $item = "TV";
					break;
				case '2': $item = "Ventilador";
					break;
				case '3': $item = "Frigobar";
					break;
				case '4': $item = "Spliter";
					break;
				case '5': $item = "Aquecedor";
					break;
				case '6': $item = "Fogão";
					break;
				default: $item = "";
			}

			if(empty($strItens))
				$strItens .= $item;
			else
				$strItens .= ",".$item;
		}

		$nome_quarto  = $dados['nomequarto'];
		$qtd_vagas  = $dados['qtdvaga'];
		$observacao = trim($dados['localizacao']);
}

$str_msg  = "<strong>Quarto:</strong>&nbsp&nbsp".$nome_quarto."<br><br>";
$str_msg .= "<strong>Quantidade de vagas:</strong>&nbsp&nbsp".$qtd_vagas."<br><br>";

if(!empty($strItens))
	$str_msg .= "<strong>Itens:</strong>&nbsp&nbsp".$strItens."<br><br>";

if(!empty($observacao))
	$str_msg .= "<strong>Observações:</strong>&nbsp&nbsp".utf8_encode($observacao)."<br><br>";


echo $str_msg;
return;
echo "<pre>";
	print_r($dadosRecord);
echo "</pre>";
return;

foreach($dadosRecord as $dados)
{
 	  $str .=  "\n<center>".utf8_encode($dados['nome'])."<center>\n";
}
$Bd->closeConnect();
echo $_GET['nomequarto']." - ".$_GET['idquarto'];//." - ".$_GET["datainicial"]." - ".$_GET["datafinal"];
?>