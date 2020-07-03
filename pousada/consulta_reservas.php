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
	var objectLabel = 
	[
		{"label":"Quarto","width":'25%'}
		,{"label":"Nº de Hóspedes","width":'25%'}
		,{"label":"Data Inicial","width":'15%'}
		,{"label":"Data Final","width":'15%'}
		,{"label":"Opção de quarto","width":'15%'}
		,{"label":" ","width":'10%'}
	];

	var objectConfig = 
	{
		'gridDiv' : 'tabelaReservas',
		 'width': 700,
		 'class' : 'tabelaPadrao',
		 'border':1,
		 'id':'idreserva',
		 'page':true,
		 'colspan':5,
		 'crud':true,
		 'update': 'cadastro_reserva.php',
		 //'chekout':"excluiReserva",//Implementar checkOut
		 'printDetails': 'mostrarHospedes'
	};

	$(document).ready(function(){
		var jq17 = jQuery.noConflict();
		$("#formDtInicial").mask("99/99/9999");
		$("#formDtFinal").mask("99/99/9999");
		$("#formNome").autocomplete("complete_reserva.php",{width:310,selectFirst:false});
		montaCombo('formSelectQuarto','selectQuartosCombo');
		if($.query.get('idquarto'))
		{
			montaCombo('formSelectQuarto','selectQuartosCombo',$.query.get('idquarto'));
			getJsonSelect('selectReserva',$.query.get('idquarto'),objectConfig,objectLabel,'viewPousada.php',10);
		}
		else
			getJsonSelect('selectReserva',false,objectConfig,objectLabel,'viewPousada.php',10);
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
<form  name="formInserirCidade" id="formInserirCidade" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset  class='moldura fieldAlertaLista'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Pesquisa de Reservas</strong></center></legend>
		
			<div class="control-group">
				<label class="control-label" for="formNome"><strong>Nome</strong></label>  
				<div class="controls">  
					<input type="text" class="input-large" style="width:21%;"name="formNome" id="formNome">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectQuarto"><strong>Quarto:<strong></label>
				<div class="controls">
					<select id="formSelectQuarto" style="width:20%;" name="formSelectQuarto"></select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formDtInicial"><strong>Data inicial:</strong></label>
				<div class="controls">
					<input type="text" class="input-medium"  id="formDtInicial" name="formDtInicial" id="formDtInicial">
					<img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formDtInicial'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg' width='35px' height='20px'>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formDtFinal"><strong>Data final:</strong></label>  
				<div class="controls">  
					<input type="text" class="input-medium" id="formDtFinal" name="formDtFinal" id="formDtFinal">
					<img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formDtFinal'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg' width='35px' height='20px'>
				</div>
			</div>
			<div class="form-actions form-background">
				<button type="button" onclick="buscarRegistrosTabelaReserva()" class="btn" title="Buscar">
				<img src="../icones/busca.png" width="25px" height="20px">
				<strong>Buscar</strong></button>
			</div>
        </fieldset> 
</form>
<fieldset class='moldura fieldAlertaLista'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de Reservas</strong></center></legend>
	<div id="tabelaReservas" style="width:99%;margin:0px 0.5%;"></div>
</fieldset> 
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<h4 id="myModalLabel">Informações da locação</h4>
	</div>
	<div class="modal-body">
		<dl class="dl-horizontal">
			<dt>Nome do quarto:</dt>
				<dd><span id="formQuarto" name="formQuarto"></span></dd>
				<br>
			<dt>Nome do hóspede:</dt>
				<dd><span id="formHospede" name="formHospede"></span></dd>
				<br>
			<dt>Data inicial:</dt>
				<dd><span id="formDtaInicial" name="formDtaInicial"></span></dd>
				<br>
			<dt>Data final:</dt>
				<dd><span id="formDtaFinal" name="formDtaFinal"></span></dd>
				<br>
			<dt>Tipo de aluguel:</dt>
				<dd><span id="formOpcao" name="formOpcao"></span></dd>
		</dl>
	</div>
	<div class="modal-footer"></div>
</div>
</body>
</html>