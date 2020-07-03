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
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
	
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.bgiframe.min.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/thickbox-compressed.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/jquery.autocomplete.js"></script>
	<link  href="../js/jquery-autocomplete/jquery.autocomplete.css" rel="stylesheet" type="text/css">
	
	
	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/dhtmlgoodies_calendar.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<link href="../css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css"/>
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	
</head>
<script>
	var objectLabel = eval([{"label":"Nome do quarto","width":167}
							,{"label":"Hóspede","width":167}
							,{"label":"Data Inicial","width":167}
							,{"label":"Data Final","width":167}
							,{"label":"Opção de quarto","width":167}
							,{"label":"Empresa","width":167}]);

	var objectConfig = eval({'gridDiv' : 'tabelaReserva',
							 'width': 100,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'id':'idreserva',
							'page':true,
							 'print': "relHistorico",
							 'title':'Histórico de reservas',
							 'colspan':6});

	var objectLabel_1 = eval([{"label":"Nome do quarto","width":"14%"}
							,{"label":"Hóspede","width":"20%"}
							,{"label":"Motivo","width":"14%"}
							,{"label":"Data Inicial","width":"10%"}
							,{"label":"Data Final","width":"10%"}
							,{"label":"Opção de quarto","width":"14%"}
							,{"label":"Empresa","width":"14%"}
							,{"label":"Observação","width":"14%"}]);

	var objectConfig_1 = eval({'gridDiv' : 'tabelaCancelamento',
							 'width': 100,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'id':'idreserva',
							 'title':'Histórico de Cancelamento',
							 'colspan':8});

	$(document).ready(function(){
		var jq17 = jQuery.noConflict();
		$("#formNomeHospede").autocomplete("complete.php",{width:310,selectFirst:false});
		$("#formDtInicial").mask("99/99/9999");
		$("#formDtFinal").mask("99/99/9999");
		montaCombo('formSelectQuarto','selectQuartosCombo');

		montaCombo('formSelectQuartoCancelamento','selectQuartosCombo');
		$("#formNomeCancelamento").autocomplete("complete.php",{width:310,selectFirst:false});

		getJsonSelect('selectHistorico',false,objectConfig,objectLabel,'viewPousada.php',10);
		getJsonSelect('selectCancelamento',false,objectConfig_1,objectLabel_1,'viewPousada.php');
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
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1"  style='border-radius: 8px;' data-toggle="tab">Reservas anteriores</a></li>
		<li><a href="#tab2" style='border-radius: 8px;' data-toggle="tab">Reservas canceladas</a></li>
	</ul>
<div class="tab-content">
	<div class="tab-pane active" id="tab1">
		<p>
			<!--
				<form action="" name="form" id="form" method="POST" class="form-horizontal" enctype="multipart/form-data">
					<div class="control-group">
						<label class="control-label" for="formNomeHospede"><strong>Nome do hóspede:<strong></label>
						<div class="controls">
							<input type="text" style="width:25%" class="input-large" name="formNomeHospede" id="formNomeHospede">
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
							<input type="text" class="input-large" name="formDtInicial" id="formDtInicial">
							<img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formDtInicial'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="formDtFinal"><strong>Data final:</strong></label>
						<div class="controls">  
							<input type="text" class="input-large" name="formDtFinal" id="formDtFinal">
							<img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formDtFinal'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
						</div>
					</div>
					<div class="form-actions">
						<button type="button" onclick="buscarRegistrosTabelaHistorico()" class="btn" title="Buscar">
							<img src="../icones/busca.png" width="25px" height="20px">
						<strong>Buscar</strong></button>
					</div>
				</form>
			-->
			<div id="tabelaReserva"  style="width:99%;margin:0px 0.5%;"></div><br>
		</p>
    </div>
		<div class="tab-pane" id="tab2">
		<p>
			<form action="" name="form" id="form" method="POST" class="form-horizontal" enctype="multipart/form-data">
				<div class="control-group">
					<label class="control-label" for="formNomeCancelamento"><strong>Nome do hóspede:<strong></label>
					<div class="controls">
						<input type="text" style="width:25%" class="input-large" name="formNomeCancelamento" id="formNomeCancelamento">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formSelectQuartoCancelamento"><strong>Quarto:<strong></label>
					<div class="controls">
						<select id="formSelectQuartoCancelamento" style="width:20%;" name="formSelectQuartoCancelamento"></select>
					</div>
				</div>
				<div class="form-actions">
					<button type="button" onclick="buscarRegistrosTabelaCancelamento()" class="btn" title="Buscar">
						<img src="../icones/busca.png" width="25px" height="20px">
					<strong>Buscar</strong></button>
				</div>
			</form>
			<div id="tabelaCancelamento"  style="width:99%;margin:0px 0.5%;"></div>
		</p>
		</div>
	</div>
	</div>
</div>
</body>
</html>