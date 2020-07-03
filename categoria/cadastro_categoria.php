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

	<script src="../js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="js_categoria/categoria.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<link href="../css/geral.css" rel="stylesheet" type="text/css"/>	
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>	
	<link href="../css/tabelas.css" rel="stylesheet" type="text/css"/>

</head>

<script>

var grupoAcesso = "";<?php //echo $_SESSION['grupo']; ?>;
$(document).ready(function(){
	if($.query.get('idcategoria') && $.query.get('editar'))
	{
		updateCategoria($.query.get('idcategoria'));
		montaTabela('selectCategorias',false,'tabelaCategorias');
		return;
	}
	cadastrarCategoria();
	montaCombo('viewCategoria.php','formSelectServicos','selectServicos',false,false,false);
	montaCombo('viewCategoria.php','formSelectFornecedor','selectFornecedor',false,false,false);
	montaTabela('selectCategorias',false,'tabelaCategorias');
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

				<form action="viewCategoria.php" name="formInserirCategoria" id="formInserirCategoria" method="POST" class="formularios" enctype="multipart/form-data">
					<p class="linha">
						<label class="labelPq" for="formSelectServicos">Serviços:</label>
						<select id="formSelectServicos" name="formSelectServicos" class="selectMed">
						<option value="">Selecione um serviço</option>
						</select>
					</p>
					<p class="linha">
						<label class="labelPq" for="formSelectFornecedor">Fornecedor:</label>
						<select id="formSelectFornecedor" name="formSelectFornecedor" class="selectMed">
						<option value="">Selecione um fornecedor</option>
						</select>
					</p>
					<p class="linha">
						<label class="labelPq" for="formCategoria">Cat. produtos:</label>
						<input type="text" id="formCategoria"  name="formCategoria" class="inputTxt inputTextMedio" value="" />
					</p>
					<input type="submit" id="formCategoria_submit" name="formCategoria_submit" class="inputSubmit" value="Inserir"/>
					<input type="hidden" id="formIdCategoria" value="">
				</form>
				<div style="margin-top:10px;">
					<table border="1" id="tabelaCategorias" width="670" class="tabelaPadrao">
						<thead>
							<tr>
								<th width="100" align="center">Serviço</th>
								<th width="200" align="center">Forncedor</th>
								<th width="300" align="center">Categorias</th>
								<th width="70" align="center"></th>
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
