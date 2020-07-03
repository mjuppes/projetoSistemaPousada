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
	
	
	<script src="../js/dhtmlgoodies_calendar.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<link href="../css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css"/>
	<!--<link href="../css/bordasombreada.css" rel="stylesheet" type="text/css"/>-->
</head>
<script>
	var objectLabel = eval([{"label":"Transferência","width":'15%'}
							,{"label":"Depósito antecipado","width":'25%'}
							,{"label":"Data efetuada","width":'25%'}
							,{"label":"Valor do pagamento","width":'15%'}
							,{"label":"Responsável pelo pagamento","width":'15%'}
							,{"label":"","width":'10%'}]);

	var objectHideTable = eval([{"value":"idreserva"}]);

	var objectConfig = eval({'gridDiv' : 'tabelaPagamento',
							 'width': 700,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'id':'idpagamento',
							 'title':'Tabela de pagamentos',
							 'colspan':5,
							 'crud':true,
							 'update': 'cadastro_pagamento.php',
							 'delete':"excluiPagamento",
							 'objectHideTable':objectHideTable});

	var objectLabel_2 = eval([{"label":"","width":'80%'}
							,{"label":"Valor total","width":'20%'}]);


	var objectConfig_2= eval({'gridDiv' : 'tabelaTotalPagamentos',
							 'width': 700,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'colspan':2});

	var objectLabel_3 = eval([{"label":"Valor","width":'95%'}
							,{"label":" ","width":'5%'}]);

	var objectConfig_3= eval({'gridDiv' : 'tabelaTotalDesconto',
							 'width': 700,
							 'class' : 'tabelaPadrao',
							 'id':'iddesconto',
							 'border':1,
							 'crud':true,
							 'delete':"excluiDesconto",
							 'colspan':2});

	$(document).ready(function(){
		var jq17 = jQuery.noConflict();
		getJsonSelect('selectPagamentos',$.query.get('idreserva'),objectConfig,objectLabel,'viewPousada.php');
		getJsonSelect('selectTotalPagamentos',$.query.get('idreserva'),objectConfig_2,objectLabel_2,'viewPousada.php');
		getJsonSelect('selectDescontos',$.query.get('idreserva'),objectConfig_3,objectLabel_3,'viewPousada.php');
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
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de pagamentos</strong></center></legend>
		<div id="tabelaPagamento" style="width:99%;margin:0px 0.5%;"></div>
		<div id="tabelaTotalDesconto" style="width:99%;margin:0px 0.5%;"></div>
		<div id="tabelaTotalPagamentos" style="width:99%;margin:0px 0.5%;"></div>
	</fieldset>
</body>
</html>