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
	var objectLabel =
	[
		{"label":"Estabelecimento","width":"20%"}
		,{"label":"Atendente","width":"10%"}
		,{"label":"Data","width":"15%"}
		,{"label":"Sistema","width":"10%"}
		,{"label":"Nome","width":"15%"}
		,{"label":"Status","width":"10%"}
		,{"label":"Usuário","width":"15%"}
		,{"label":" ","width":"20%"}
	];

	var objectConfig = 
	{
		'gridDiv' : 'tabelaPesquisaContato',
		'width': 100,
		'class' : 'tabelaPadrao',
		'border':1,
		'id':'id_pesquisa',
		'page':false,
		'colspan':6,
		'crud':true,
		'push':'cadastro_pesquisa.php',
		'update': true
	};

	$(document).ready(function(){
		var jq17 = jQuery.noConflict();

		montaCombo('formSelectEstado','selectEstado');
		$('#formSelectCidade').attr('disabled',true);
		$("#formSelectEstado").bind("change",function()
		{
			if($("#formSelectEstado").val() == "")
			{
				$("#formSelectCidade").html("<option>Selecione uma cidade</option>");
				$("#formSelectCidade").attr('disabled',true);
				return;
			}

			montaCombo('formSelectCidade','selectCidade',$("#formSelectEstado").val());
			$("#formSelectCidade").attr('disabled',false);
		});
		getJsonSelect('selectPesquisaContatoTable',false,objectConfig,objectLabel);
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
<form  name="formInserirCidade" id="formInserirCidade" method="POST" class="form-horizontal" enctype="multipart/form-data">
	<fieldset  class='moldura fieldAlertaLista'>
		<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Filtro</strong></center></legend>
		<div class="control-group">
			<label class="control-label" for="formSelectEstado"><strong>Estado:<strong></label>
			<div class="controls">
				<select id="formSelectEstado" style="width:50%;" name="formSelectEstado">
					<option value="">-- Selecione --</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formSelectCidade"><strong>Cidade:<strong></label>
			<div class="controls">
				<select id="formSelectCidade" disabled style="width:50%;" name="formSelectCidade">
					<option value="">-- Selecione --</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"  disabledfor="formSelectSoftware" disabled><strong>Possui Software?<strong></label>
			<div class="controls">
				<select id="formSelectSoftware" style="width:32%;" name="formSelectSoftware" onchange="habilitaPesquisa();">
					<option value="">- Informar -</option>
					<option value="S">Sim</option>
					<option value="N">Não</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"  disabledfor="formSelectSituacao" disabled><strong>Situação:<strong></label>
			<div class="controls">
				<select id="formSelectSituacao" style="width:32%;" name="formSelectSituacao">
					<option value="">- Informar -</option>
					<option value="R">Retornar Ligação</option>
					<option value="F">Pesquisa Fizalizada</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label"  disabledfor="formSelectPrioridade" disabled><strong>Prioridade do retorno:<strong></label>
			<div class="controls">
				<select id="formSelectPrioridade" style="width:32%;" name="formSelectPrioridade">
					<option value="">- Informar -</option>
					<option value="1">Sim</option>
					<option value="2">Não</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formDtaIni"><strong>Data Inicial:</strong></label>
			<div class="controls">
				<input type="text" class="input-xlarge" style="width:20%;" name="formDtaIni" id="formDtaIni">
				<img style="cursor:pointer" title='CalendÃ¡rio' onclick= "displayCalendar(document.getElementById('formDtaIni'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formDtaFinal"><strong>Data Final:</strong></label>
			<div class="controls">
				<input type="text" class="input-xlarge" style="width:20%;" name="formDtaFinal" id="formDtaFinal">
				<img style="cursor:pointer" title='CalendÃ¡rio' onclick= "displayCalendar(document.getElementById('formDtaFinal'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
			</div>
		</div>
		<div class="form-actions">
			<button type="button" onclick="buscarTabelaPesquisaContato()" class="btn" title="Buscar">
			<img src="../icones/busca.png" width="25px" height="20px">
			<strong>Buscar</strong></button>
		</div>
	</fieldset> 
</form>
<fieldset class='moldura fieldAlertaLista'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de Pesquisas</strong></center></legend>
	<div id="tabelaPesquisaContato" style="width:99%;margin:0px 0.5%;"></div>
</fieldset> 
</body>
</html>