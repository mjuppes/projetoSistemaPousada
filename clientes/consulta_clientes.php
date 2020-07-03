<?php //include "../permissao.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>

	<script src="../js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="utf-8"></script>

	<script src="../js/jquery.maskedinput-1.2.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/additional-methods.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.form.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>

	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.bgiframe.min.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/thickbox-compressed.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/jquery.autocomplete.js"></script>

	<link rel="stylesheet" type="text/css" href="../js/jquery-autocomplete/jquery.autocomplete.css"/>
	<link rel="stylesheet" type="text/css" href="../js/jquery-autocomplete/lib/thickbox.css"/>

	<script src="../js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="../js/jquery.ui.plugingrid.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="js_clientes/clientes.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<link href="../css/geral.css" rel="stylesheet" type="text/css"/>	
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>	
	<link href="../css/tabelas.css" rel="stylesheet" type="text/css"/>
</head>
<script>
	var grupoAcesso = ""; <?php //echo $_SESSION['grupo'] ?>;

	$(document).ready(function(){
		$("#formNomeCliente").autocomplete("complete.php", {
			width:310,
			selectFirst: false
		});


		getJsonSelect('selectClientes',false,objectConfig,objectLabel,'viewClientes.php',10);
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
			<form action="" name="formCliente" id="formCliente" method="POST" class="formularios" enctype="multipart/form-data">
					<fieldset>
						<legend><strong>Pesquisa de Clientes</strong></legend>
					<br />
					<p class="linha">
					<label class="labelPq" for="formNomeCliente">Cliente:</label>
						<input type="text" id="formNomeCliente" name="formNomeCliente" class="inputText inputTextMedio"  value=""/>
					</p>
					<p class="linha">
						<input type="button" id="formFiltroCliente_submit" name="formFiltroCliente_submit" class="inputFiltro" value="Buscar" onclick="buscarRegistrosTabela();"/>
					</p>
					</fieldset>
			</form>
			<a class="btnAcoesSemIco btnCadastro" href="cadastro_clientes.php">Cadastro de Clientes</a>
			<a class="acaoGerarPdf" onclick="window.open('http://localhost/erp/produtos/testepdf.php')">Gerar Relatório</a>

			<div id="listarClientes" style='position'>
				<div id="tabelaClientes"></div>
			</div>
			
		</div>
		<div id="rodape">
			<?php include "../rodape.php"; ?>
		</div>
	</div>
</body>
</html>