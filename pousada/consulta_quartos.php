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
	<link rel="stylesheet" href="../js/msg_js/css/alertify.css" />
	<link rel="stylesheet" href="../js/msg_js/css/themes/default.css" />

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
		{"label":"Nome do quarto","width":"50%"}
		,{"label":"Vagas","width":"10%"}
		,{"label":"Descrição","width":"30%"}
		,{"label":"","width":"7%"}
	];

	var objectLink  =  
	[
		{"link":"idquarto","value":"nomequarto","pagina":"consulta_reservas.php"}
	];

	var objectConfig = 
	{
			'gridDiv' : 'tabelaQuartos',
			'width': 100,
			'class' : 'tabelaPadrao',
			'border':1,
			'id':'idquarto',
			'page':false,
			'title':'Tabela de quartos',
			'colspan':5,
			'crud':true,
			'push':'cadastro_quarto.php',
			'update': true,
			'delete':"excluiQuarto",
			'visualize': "visualizarQuarto",
	 		'objectLink':objectLink
	 };

	$(document).ready(function(){
		var jq17 = jQuery.noConflict();
		getJsonSelect('selectQuartos',false,objectConfig,objectLabel,'viewPousada.php');
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
<fieldset class='moldura fieldAlertaLista'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de Quartos</strong></center></legend>
	<div id="tabelaQuartos" style="width:99%;margin:0px 0.5%;"></div>
</fieldset>
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<h4 id="myModalLabel">Informações do quarto</h4>
	</div>
	<div class="modal-body">
		<dl class="dl-horizontal">
			<dt><strong>Nome do quarto:</strong></dt>
			<dd><span id="formQuarto" name="formQuarto"></span></dd>
				<br>
			<dt><strong>Quantidade de vagas:</strong></dt>
				<dd><span id="formQtd" name="formQtd"></span></dd>
				<br>
			<dt><strong>Itens:</strong></dt>
				<dd><span id="formItens" name="formItens"></span></dd>
				<br>
			<dt><strong>Observação:</strong></dt>
				<dd><span id="formLocalizacao" name="formLocalizacao"></span></dd>
				<br>
		</dl>
	</div>
	<div class="modal-footer"></div>
</div>
</body>
</html>