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
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.ui.plugingrid.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="../js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>

	<script src="../js/dhtmlgoodies_calendar.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<link href="../css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css"/>

</head>
<script>

var objectLink  =  eval([{"link":"idhospede","value":"nome","pagina":"historico_hospedes.php"}]);

var objectLabel_1 = eval([{"label":"Hóspede","width":'20%'}
						,{"label":"Valor","width":'10%'}
						,{"label":"Tipo de Pagamento","width":'10%'},
						,{"label":"Forma de Pagamento","width":'10%'}]);

var objectConfig_1 = eval({'gridDiv' : 'tabelaRelatorioDescriminado',
						 'width': 400,
						 'class' : 'tabelaPadrao',
						 'border':1,
						 'id':'idhospede',
						 'title':'Relatório Descriminado',
						 'colspan':10,
						 'objectLink':objectLink});

var objectLabel_2 = eval([{"label":"Total","width":'20%'}
						,{"label":"Tipo de pagamento","width":'10%'}
						,{"label":"Forma de pagamento","width":'10%'}]);

var objectConfig_2 = eval({'gridDiv' : 'tabelaRelatorioDescriminadoTotal',
							'width': 400,
							'class' : 'tabelaPadrao',
							'border':1,
							'title':'Total',
							'colspan':4});



$(document).ready(function(){
	var jq17 = jQuery.noConflict();

	$("#formDtInicial").mask("99/99/9999");
	$("#formDtFinal").mask("99/99/9999");

	getJsonSelect('selectTableRelatorioDiscriminado',false,objectConfig_1,objectLabel_1,'viewPousada.php',false);
	getJsonSelect('selectTableRelatorioDiscriminadoTotal',false,objectConfig_2,objectLabel_2,'viewPousada.php',false);

	$("#formBuscar_submit").click(function(){
		var objPar ="";

		if($("#formSelectHospede").val())
			objPar +="formSelectHospede="+$("#formSelectHospede").val()+"&";
			
		if($("#formSelectQuarto").val())
			objPar +="formSelectQuarto="+$("#formSelectQuarto").val()+"&";

		if($("#formTipoPagamento").val())
			objPar +="formTipoPagamento="+$("#formTipoPagamento").val()+"&";

		if($("#formFormaPagamento").val())
			objPar +="formFormaPagamento="+$("#formFormaPagamento").val()+"&";

		if($("#formDtInicial").val() && $("#formDtFinal").val())
			objPar += "&formDtInicial="+$("#formDtInicial").val()+"&formDtFinal="+$("#formDtFinal").val();
		else
		{
			if($("#formDtInicial").val() && !$("#formDtFinal").val())
			{
				alert('Informe a data filnal');
				return;
			}

			if(!$("#formDtInicial").val() && $("#formDtFinal").val())
			{
				alert('Informe a data inicial');
				return;
			}
		}
		
		getJsonSelect('selectTableRelatorioDiscriminado',false,objectConfig_1,objectLabel_1,'viewPousada.php',false,false,objPar);
		getJsonSelect('selectTableRelatorioDiscriminadoTotal',false,objectConfig_2,objectLabel_2,'viewPousada.php',false,false,objPar);
	});

	montaCombo('formSelectQuarto','selectQuartoCombo');
	montaCombo('formSelectHospede','selectHospede');
	montaCombo('formTipoPagamento','selectTipoPagementoCombo');
	montaCombo('formFormaPagamento','selectFormaPagamentoCombo');
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
<form action="viewPratos.php" name="formValores" id="formValores" method="POST" class="form-horizontal" enctype="multipart/form-data">
    <fieldset  class='moldura fieldAlertaLista'>
		<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Pesquisa de Faturamento</strong></center></legend>

		<div class="control-group">
				<label class="control-label" for="formSelectHospede"><strong>Hóspede<strong></label>
					<div class="controls">
						<select id="formSelectHospede" style="width:20%;" name="formSelectHospede">
						</select>
					</div>
		</div>
		<div class="control-group">
				<label class="control-label" for="formSelectQuarto"><strong>Quarto<strong></label>
					<div class="controls">
						<select id="formSelectQuarto" style="width:20%;" name="formSelectQuarto">
							<option value="">Selecione um quarto</option>
						</select>
					</div>
		</div>
		<div class="control-group">
				<label class="control-label" for="formTipoPagamento"><strong>Tipo de pagamento<strong></label>
					<div class="controls">
						<select id="formTipoPagamento" style="width:20%;" name="formTipoPagamento">
							<option value="">Selecione um tipo</option>
						</select>
					</div>
		</div>
		<div class="control-group">
				<label class="control-label" for="formFormaPagamento"><strong>Forma de pagamento<strong></label>
					<div class="controls">
						<select id="formFormaPagamento" style="width:20%;" name="formFormaPagamento">
							<option value="">Selecione um tipo</option>
						</select>
					</div>
		</div>
	<div class="control-group">
		<label class="control-label" for="formDtInicial"><strong>Data inicial:</strong></label>
		<div class="controls">
		  <input type="text" class="input-medium"  id="formDtInicial" name="formDtInicial" id="formDtInicial">
		  <img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formDtInicial'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
		</div>
	  </div>
	  <div class="control-group">
		<label class="control-label" for="formDtFinal"><strong>Data final:</strong></label>  
		<div class="controls">  
		  <input type="text" class="input-medium" id="formDtFinal" name="formDtFinal" id="formDtFinal">
  		  <img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formDtFinal'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
		</div>  
	  </div>
	  <div class="form-actions">  
		<button type="button" class="btn" title="Buscar" id="formBuscar_submit" name="formBuscar_submit">
			<img src="../icones/busca.png" width="25px" height="20px">
			<strong>Buscar</strong>
		</button>
	  </div>
    </fieldset>
</form>
<fieldset class='moldura fieldAlertaLista'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Relatório Discriminado</strong></center></legend>
		<div id="tabelaRelatorioDescriminado" style="width:99%;margin:0px 0.5%;"></div>
		<br>
		<div id="tabelaRelatorioDescriminadoTotal" style="width:99%;margin:0px 0.5%;"></div>
</fieldset>
</body>
</html>
