<?php

session_start();

$SQL_menu = query("SELECT id, titulo, img_referencia, link, diretorio, target, disponivel FROM menu WHERE oculto = 0 AND tipo = 1 AND permissao LIKE '%[$_SESSION[grupo]]%' ORDER BY ordenacao");

?>

<ul id="itens_menu">
<?php
while ($menu = fetch_array($SQL_menu)){
	
	$referencia = "?referencia=".base64_encode($menu['id']);
	$href_i     = "<a href='$menu[diretorio]$menu[link]$referencia' target='$menu[target]'>";
	$href_f     = "</a>";
	$style      = "";
	
	if ($menu['target'] == "_blank"){
		$onClick = "";
	} else {
		$onClick = "onClick=javascript:window.location.href='$menu[diretorio]$menu[link]$referencia'";
	}
	
	if ($menu['disponivel'] == "1"){
		$onClick = "onClick=javascript:alert('Módulo&#32;não&#32;disponível.');";
		$href_i  = "";
		$href_f  = "";
		$style   = "style='color:#FF0000;'";
	} else {
		$onClick = "";
	}

	echo
	"
	<li class='botao' $onClick>$href_i<div class='botao_imagem'><img src='img/icones/$menu[img_referencia]'/></div> <div class='botao_texto'><p $style>$menu[titulo]<p></div>$href_f</li>
	";
}
?>
</ul>
