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
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>	

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
</head>
<script>
	var objectLabel =
	[
		{"label":"Nome da agência","width":"25%"}
		,{"label":"Contato","width":"25%"}
		,{"label":"Observação","width":"45%"}
		,{"label":"","width":"30%"}
	];

	var objectConfig = 
	{
		'gridDiv' : 'tabelaAgencia',
		'width': 210,
		'class' : 'tabelaPadrao',
		'border':1,
		'id':'idagencia',
		'page':true,
		'title':'Tabela de agências',
		'colspan':5,
		'crud':true,
		'push': 'cadastro_agencia.php',
		'update': true,
		'delete':"excluiAgencia"
	};

	$(document).ready(function(){
		var jq17 = jQuery.noConflict();
		if($.query.get('idagencia'))
			getJsonSelect('selectAgencia',$.query.get('idagencia'),objectConfig,objectLabel,'viewPousada.php',10);
		else
			getJsonSelect('selectAgencia',false,objectConfig,objectLabel,'viewPousada.php',10);
	});
</script>
<body>
<div>
<?php include "../topo.php"; ?>
</div>
<div style="margin-left:10px;">
  <input type="image" src="../icones/volta.png" name="image" width="40" height="40" onclick="javascript:history.go(-1);"> <strong>Voltar</strong>
</div>
<br>
<fieldset class='moldura fieldAlertaLista'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de Agências</strong></center></legend>
	<div id="tabelaAgencia" style="width:99%;margin:0px 0.5%;"></div>
</fieldset>
</body>
</html>