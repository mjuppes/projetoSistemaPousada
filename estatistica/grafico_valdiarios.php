<?php //include "../permissao.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>

	<script src="../js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.maskedinput-1.2.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="utf-8"></script>

	<script type="text/javascript" src="../js/highcharts.js"></script>
	<script type="text/javascript" src="../js/modules/exporting.js"></script>
	<script src="../js/jquery.ui.plugingrid.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="js_grafico/grafico.js" type="text/javascript" charset="utf-8"></script>

	<link href="../css/geral.css" rel="stylesheet" type="text/css"/>	
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>	
	<link href="../css/tabelas.css" rel="stylesheet" type="text/css"/>
	<link href="../css/graficos.css" rel="stylesheet" type="text/css"/>
</head>

<script>
var grupoAcesso = ""; <?php //echo $_SESSION['grupo'] ?>;


$(document).ready(function(){
	teste();
});
</script>

	<?php
		$titulo_pagina = $info_form;
	?>
<body>
	<div id="tudo">
		<div id="cabecalho">
			<?php include "../topo.php"; ?>	
		</div>
		<div id="conteudo">
			<div class="voltar"><a href="javascript:history.go(-1);">Voltar</a></div>
			<form action="" name="formProdutos" id="formProdutos" method="POST" class="formularios" enctype="multipart/form-data">
			</form>
			<div id="listarProdutos">
				<div id="container" class="graficoGeral" style="width: 795px; height: 500px; margin-left:-28px" ></div>
			</div>
		</div>
		<div id="rodape">
			<?php include "../rodape.php"; ?>
		</div>
	</div>
</body>
</html>
