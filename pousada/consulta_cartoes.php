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
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
</head>
<script>
	var objectLabel = 
	[
		{"label":"Bandeira","width":"30%"}
		,{"label":"Tipo","width":"10%"}
		,{"label":"Dia de Recebimento","width":"20%"}
		,{"label":"Percentual","width":"10%"}
		,{"label":"Baixa Automática","width":"10%"}
		,{"label":"Parcelas","width":"10%"}
		,{"label":"","width":"5%"}
	];

	var objectConfig = 
	{
		'gridDiv' : 'tabelaCartoes',
		'width': 500,
		'class' : 'tabelaPadrao',
		'border':1,
		'id':'id_cartao',
		'colspan':5,
		'crud':true,
		'push':'cadastro_cartoes.php',
		'update': true
	};

	$(document).ready(function(){
		var jq17 = jQuery.noConflict();
		getJsonSelect('selectCartoesTable',false,objectConfig,objectLabel,false,10);
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
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de Cartões</strong></center></legend>
	<div id="tabelaCartoes" style="width:99%;margin:0px 0.5%;"></div>
</fieldset> 
</body>
</html>