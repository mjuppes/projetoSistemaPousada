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

	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.bgiframe.min.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/thickbox-compressed.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/jquery.autocomplete.js"></script>
	<link  href="../js/jquery-autocomplete/jquery.autocomplete.css" rel="stylesheet" type="text/css">

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
	<!--<link href="../css/bordasombreada.css" rel="stylesheet" type="text/css"/>-->
</head>
<script>
	var objectLabel = eval([{"label":"Título","width":"15%"}
							,{"label":"Descrição","width":"30%"}
							,{"label":"Usuário","width":"10%"}
							,{"label":"Data","width":"11%"}
							,{"label":"Status","width":"8%"}
							,{"label":"","width":"4%"}]);

	var objectConfig = eval({'gridDiv' : 'tabelaChamados',
							 'width': 500,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'id':'idchamado',
							 'title':'Tabela de chamados',
							 'colspan':5,
							 'crud':true,
							 <?php if($_SESSION["idacesso"] == 2) { ?>
							 'update': true,
							 <?php } ?>
							 'push':'cadastro_chamado.php',
							 'delete':"excluiChamado"});

	$(document).ready(function(){
		var jq17 = jQuery.noConflict();
		$("#formNomeEmpresa").autocomplete("complete_empresa.php",{width:310,selectFirst:false});
		getJsonSelect('selectChamadosTable',false,objectConfig,objectLabel,"viewChamado.php");
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
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de chamados</strong></center></legend>
	<div id="tabelaChamados" style="width:99%;margin:0px 0.5%;"></div>
</fieldset> 
</body>
</html>