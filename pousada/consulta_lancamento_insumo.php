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

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
</head>
<script>
	var objectLabel =
	[
		{"label":"Insumo","width":"15%"}
		,{"label":"Data de Cadastro","width":"15%"}
		,{"label":"Histórico","width":"20%"}
		,{"label":"Quantidade","width":"5%"}
		,{"label":"Descrição","width":"30%"}
	];

	var objectConfig = 
	{
		'gridDiv' : 'tabelaLancamentoInsumo',
		'width': 100,
		'class' : 'tabelaPadrao',
		'border':1,
		'id':'id_lanca_insumo',
		'colspan':6,
		'push':'lancar_insumo.php'
	};

	$(document).ready(function(){
		var jq17 = jQuery.noConflict();
		getJsonSelect('selectTableLancamentoInsumo',false,objectConfig,objectLabel);
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
<form action="viewPousada.php" name="formLancamentoInsumo" id="formLancamentoInsumo" method="POST" class="form-horizontal" enctype="multipart/form-data">
   	<fieldset  class='moldura fieldAlertaLista'>
		<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Pesquisa de Consumo Interno</strong></center></legend>

	<div class="control-group">
		<label class="control-label" for="formInsumoStr"><strong>Produto:<strong></label>
		<div class="controls">
			<input type="text" class="input-large" name="formInsumoStr" id="formInsumoStr" style="width:31%;">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="formSelectHistorico"><strong>Histórico:<strong></label>
			<div class="controls">
				<select id="formSelectHistorico" style="width:32%;" name="formSelectHistorico">
					<option value="">Históricos</option>
					<option value='1'>Consumo Interno</option>
					<option value='2'>Cancelamento de Consumo Interno</option>
				</select>
			</div>
	</div>
	<div class="form-actions">
		<button type="button" onclick="buscarTabelaLancamentoInsumo()" class="btn" title="Buscar">
					<img src="../icones/busca.png" width="25px" height="20px">
		<strong>Buscar</strong></button>
	</div>
    </fieldset>
</form>
<fieldset class='moldura fieldAlertaLista'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de Consumos Internos</strong></center></legend>
	<div id="tabelaLancamentoInsumo" style="width:99%;margin:0px 0.5%;"></div>
</fieldset>
</body>
</html>