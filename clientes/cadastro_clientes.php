<?php include "../permissao.php"; ?>
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

	<script src="../js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="js_clientes/clientes.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<link href="../css/geral.css" rel="stylesheet" type="text/css"/>	
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>	
	<link href="../css/tabelas.css" rel="stylesheet" type="text/css"/>

</head>

<script>

var grupoAcesso = "";<?php //echo $_SESSION['grupo']; ?>;
$(document).ready(function(){

	$("#formTelefone").mask("(99)9999-9999");
	if($.query.get('idcliente') && $.query.get('editar'))
	{
		updateCliente($.query.get('idcliente'));
		return;
	}
	cadastrarClientes();
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
				<div class="erros"></div>
				<a class="btnAcoesSemIco btnConsulta" href="consulta_clientes.php">Consultar Clientes</a>
				<form action="viewClientes.php" name="formInserirClientes" id="formInserirClientes" method="POST" class="formularios" enctype="multipart/form-data">
					<p class="linha">
						<label class="labelPq" for="formNomeCliente">Nome do cliente:</label>
						<input type="text" id="formNomeCliente"  name="formNomeCliente" class="inputTxt inputTextMedio" value="" />
					</p>
					<p class="linha">
						<label class="labelPq" for="formEmail">E-mail:</label>
						<input type="text" id="formEmail"  name="formEmail" class="inputTxt inputTextMedio" value="" />
					</p>
					<p class="linha">
						<label class="labelPq" for="formCNPJ">CNPJ:</label>
						<input type="text" id="formCNPJ"  name="formCNPJ" class="inputTxt inputTextMedio" value="" />
					</p>
					<p class="linha">
						<label class="labelPq" for="formTelefone">Telefone:</label>
						<input type="text" id="formTelefone"  name="formTelefone" class="inputTxt inputTextMedio" value="" />
					</p>
					<p class="linha">
						<label class="labelPq" for="formContato">Contato:</label>
						<input type="text" id="formContato"  name="formContato" class="inputTxt inputTextMedio" value="" />
					</p>
					<input type="submit" id="formCliente_submit" name="formCliente_submit" class="inputSubmit" value="Inserir"/>
					<input type="hidden" id="formIdCliente" value="">
					<span id="mensagem"></span>
				</form>
		</div>	
		<div id="rodape">
			<?php include "../rodape.php"; ?>
		</div>
	</div>
</body>
</html>
