<?php include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>
	<script src="../js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.ui.plugingrid.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script type="text/javascript" src="../js/highcharts_old.js"></script>
	<script type="text/javascript" src="../js/modules/exporting.js"></script>
	<script src="js_estatistica/estatistica.js" type="text/javascript" charset="so-8859-1"></script>

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	
</head>
<script>
var objectLabel = eval([{"label":"Número de hóspede sem indicação","width":100},{"label":"Número de hóspedes por indicação","width":100}]);

var objectConfig = eval({'gridDiv' : 'tabelaNumeroHospede',
						 'width': 400,
						 'class' : 'tabelaPadrao',
						 'border':1,
						 'colspan':2});

$(document).ready(function(){
	var jq17 = jQuery.noConflict();
	getJsonSelect('selectNumeroHospede',false,objectConfig,objectLabel,'viewGrafico.php',false);
	gerarChartNumeroHospede();
	montaCombo('formSelectAno','selectAno');
	montaCombo('formSelectMes','selectMes');
	montaCombo('formSelectAgencia','selectAgencia');
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
<form  name="form" id="form" method="POST" class="form-horizontal" enctype="multipart/form-data">
	<fieldset class='moldura fieldAlerta'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Estatística de Indicação</strong></center></legend>
		<div class="control-group">
			<label class="control-label" for="formSelectAno"><strong>Ano:<strong></label>
			<div class="controls">
				<select id="formSelectAno" style="width:21%;" name="formSelectAno"  >
					<option value="">-------</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formSelectMes"><strong>Mês:<strong></label>
			<div class="controls">
				<select id="formSelectMes" style="width:21%;" name="formSelectMes"  >
					<option value="">-------</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formSelectAgencia"><strong>Agência:<strong></label>
			<div class="controls">
				<select id="formSelectAgencia" style="width:21%;" name="formSelectAgencia"  >
					<option value="">-------</option>
				</select>
			</div>
		</div>
		<div class="form-actions">
			<button type="button" onclick="gerarChartNumeroHospede()" class="btn" title="Carregar">
						<img src="../icones/Refresh.png" width="20px" height="50px">
			<strong>Carregar</strong></button>
		</div>
   </fieldset>
</form>
<div style="margin-top:0%">
<div id="tabelaNumeroHospede"  style="width:550px;margin-left:2%;margin-top:2%"></div>
<br>
<div id="container" class="graficoGeral" style="width: 98%;position:relative;"></div>
</div>
</body>
</html>