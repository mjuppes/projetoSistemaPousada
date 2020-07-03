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

	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.bgiframe.min.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/thickbox-compressed.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/jquery.autocomplete.js"></script>

	<link rel="stylesheet" type="text/css" href="../js/jquery-autocomplete/jquery.autocomplete.css"/>
	<link rel="stylesheet" type="text/css" href="../js/jquery-autocomplete/lib/thickbox.css"/>

	<script src="../js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="js_clientes/clientes.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<link href="../css/geral.css" rel="stylesheet" type="text/css"/>	
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>	
	<link href="../css/tabelas.css" rel="stylesheet" type="text/css"/>

</head>

<script>
	var grupoAcesso = ""; <?php //echo $_SESSION['grupo'] ?>;

	$(document).ready(function(){
		montaCombo('viewClientes.php','formSelectClientes','selectComboCliente',false,false,false);
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
			<form action="" name="formHistoricoCliente" id="formHistoricoCliente" method="POST" class="formularios" enctype="multipart/form-data">
				<fieldset>
					<legend><strong>Pesquisa de Histórico</strong></legend>
					<br/>
					<p class="linha">
						<label class="labelPq" for="formSelectClientes">Clientes:</label>
						<select id="formSelectClientes" name="formSelectClientes" class="selectMed" onclick="buscaHistorico(this.value)">
						<option value="">Selecione um cliente</option>
						</select>
					</p>
				</fieldset>
			</form>
			<div id="listarHistorico">
				<table border="1" id="tabelaProposta" width="770" class="tabelaPadrao">
					<thead>
						<tr>
							<th  colspan='8' align='center'>Propostas</th>
						</tr>
						<tr>
							<th width="200" align="center">Cliente</th>
							<th width="110" align="center">Projeto</th>
							<th width="100" align="center">Modelo</th>
							<th width="100" align="center">Data</th>
							<th width="130" align="center">Cod. Produto</th>
							<th width="40" align="center">Preço</th>
							<th width="35" align="center">Efetuada</th>
							<th width="60" align="center" class='colAcoes1'></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<div id="listarHistorico">
				<table border="1" id="tabelaPropoServ" width="735" class="tabelaPadrao">
					<thead>
						<tr>
							<th  colspan='8' align='center'>Propostas de serviços</th>
						</tr>
						<tr>
							<th width="200" align="center">Cliente</th>
							<th width="110" align="center">Serviço</th>
							<th width="100" align="center">Técnico</th>
							<th width="100" align="center">Validade</th>
							<th width="130" align="center">Data da proposta</th>
							<th width="40" align="center">Preço</th>
							<th width="60" align="center" class='colAcoes1'></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
		<div id="rodape">
			<?php include "../rodape.php"; ?>
		</div>
	</div>
</body>
</html>
