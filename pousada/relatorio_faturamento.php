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

</head>
<script>

var objectLink  =  [{"link":"idhospede","value":"nome","pagina":"historico_hospedes.php"}];

var objectLabel_1 = [
					{"label":"Hóspede","width":'25%'}
					,{"label":"Quarto","width":'10%'}
					,{"label":"Data Inicial","width":'10%'},
					,{"label":"Data Final","width":'10%'}
					,{"label":"Quant. Dias","width":'10%'}
					,{"label":"Val. Quarto","width":'10%'}
					,{"label":"Total","width":'5%'}
					,{"label":"Desconto","width":'5%'}
					,{"label":"Val. Pago","width":'10%'}
					,{"label":" ","width":'15%'}];

var objectConfig_1 = {'gridDiv' : 'tabelaRelatorioGeral',
					 'width': 400,
					 'class' : 'tabelaPadrao',
					 'border':1,
					 'crud':true,
					'visualize':"visulalizarPagamento",
					 //'print': "relGeral",
					 'id':'idreserva',
					 'colspan':10,
					 'objectLink':objectLink};

var objectLabel_2 = [{"label":"Valor Total","width":'20%'}
					,{"label":"Descontos","width":'20%'}
					,{"label":"Valor Pago","width":'10%'}];

var objectConfig_2 = {'gridDiv' : 'tabelaRelatorioGeralTotal',
					'width': 400,
					'class' : 'tabelaPadrao',
					'border':1,
					'colspan':3};



$(document).ready(function(){
	var jq17 = jQuery.noConflict();

		$("#formDtInicial").mask("99/99/9999");
		$("#formDtFinal").mask("99/99/9999");

		getJsonSelect('selectTableRelatorioGeral',false,objectConfig_1,objectLabel_1,'viewPousada.php',false);
		getJsonSelect('selectTableRelatorioGeralTotal',false,objectConfig_2,objectLabel_2,'viewPousada.php',false);

		$("#formBuscar_submit").click(function(){
			var objPar ="";

			if($("#formSelectHospede").val())
				objPar +="formSelectHospede="+$("#formSelectHospede").val()+"&";
				
			if($("#formSelectQuarto").val())
				objPar +="formSelectQuarto="+$("#formSelectQuarto").val()+"&";

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

			getJsonSelect('selectTableRelatorioGeral',false,objectConfig_1,objectLabel_1,'viewPousada.php',false,false,objPar);
			getJsonSelect('selectTableRelatorioGeralTotal',false,objectConfig_2,objectLabel_2,'viewPousada.php',false,false,objPar);
			
		});
	montaCombo('formSelectQuarto','selectQuartoCombo');
	montaCombo('formSelectHospede','selectHospede');
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
		<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Pesquisa de Faturamento Geral</strong></center></legend>

	<div class="control-group">
		<label class="control-label" for="formSelectHospede"><strong>Hóspede<strong></label>
		<div class="controls">
			<select id="formSelectHospede" style="width:32%;" name="formSelectHospede">
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="formSelectQuarto"><strong>Quarto<strong></label>
		<div class="controls">
			<select id="formSelectQuarto" style="width:32%;" name="formSelectQuarto">
				<option value="">Selecione um quarto</option>
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
<br>
<fieldset class='moldura fieldAlertaLista'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Relatório Geral</strong></center></legend>
		<div id="tabelaRelatorioGeral" style="width:99%;margin:0px 0.5%;height: 200px;overflow: scroll;"></div>
		<br>
		<div id="tabelaRelatorioGeralTotal" style="width:99%;margin:0px 0.5%;"></div>
</fieldset>
<div style="width:100%">
	<div id="myModalPagamento" style='margin-left:-30%;width:60%'  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header" >
			<h4 id="myModalLabel" ></h4>
		</div>
		<div class="modal-body">
			<div id="tabelaPagamento" style="width:98%;margin:0px 1%;"></div>
		</div>
		<div class="modal-footer"></div>
	</div>
</div>
</body>
</html>
