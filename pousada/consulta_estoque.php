<?php include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>

	<script src="../js/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="utf-8"></script>

	<script src="../js/jquery.maskedinput-1.2.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/additional-methods.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.form.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.ui.plugingrid.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="../js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/msg_js/alertify.js"></script>

	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.bgiframe.min.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/thickbox-compressed.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/jquery.autocomplete.js"></script>
	<link  href="../js/jquery-autocomplete/jquery.autocomplete.css" rel="stylesheet" type="text/css">

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>

	<link rel="stylesheet" href="../js/msg_js/css/alertify.css" />
	<link rel="stylesheet" href="../js/msg_js/css/themes/default.css" />
	
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
	<!--<link href="../css/bordasombreada.css" rel="stylesheet" type="text/css"/>-->
</head>
<script>
	
	$(document).ready(function(){
		var jq17 = jQuery.noConflict();
		montaCombo('formSelectProduto','selectProdutosEstoque',false);
		//getJsonSelect('selectEstoqueTable',false,objectConfig,objectLabel);
	});
</script>
<body>
<div>
<?php include "../topo.php"; ?>
</div>
<div style="margin-left:10px;" >
  <input type="image" src="../icones/volta.png" name="image" width="40" height="40" onclick="javascript:history.go(-1);"> <strong>Voltar</strong>
</div>
<br>
<form action="viewPousada.php" name="formEstoque" id="formEstoque" method="POST" class="form-horizontal" enctype="multipart/form-data">
   	<fieldset  class='moldura fieldAlertaLista'>
		<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Pesquisa de Estoque</strong></center></legend>
		<div class="control-group">
			<label class="control-label" for="formSelectProduto"><strong>Produto:<strong></label>
			<div class="controls">
				<select id="formSelectProduto"  style="width:50%;" name="formSelectProduto">
					<option>Selecione um produto</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formSelectTipo"><strong>Tipo de Pesquisa:<strong></label>
			<div class="controls">
				<select id="formSelectTipo"  style="width:50%;" name="formSelectTipo">
					<option value="">-- Selecione --</option>
					<option value='1'>Saldo Atual</option>
					<option value='2'>Movimentação</option>
				</select>
			</div>
		</div>
		<div class="form-actions">
			<button type="button" onclick="buscarRegistrosTabelaEstoque()" class="btn" title="Buscar">
					<img src="../icones/busca.png" width="25px" height="20px">
		<strong>Buscar</strong></button>
	</div>
    </fieldset>
</form>
<fieldset class='moldura fieldAlertaLista'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de Estoque</strong></center></legend>
	<div id="tabelaEstoque" style="width:99%;margin:0px 0.5%;"></div>
</fieldset>

</body>
</html>