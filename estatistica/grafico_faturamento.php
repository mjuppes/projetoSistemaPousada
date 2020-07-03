<?php include "../permissao.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>

	<script src="../js/jquery-1.4.4.min.js" type="text/javascript" charset="so-8859-1"></script>
	<script src="../js/jquery.maskedinput-1.2.2.min.js" type="text/javascript" charset="so-8859-1"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="so-8859-1"></script>
	
	<script type="text/javascript" src="../js/highcharts.js"></script>
	<script type="text/javascript" src="../js/modules/exporting.js"></script>
	<script src="js_estatistica/estatistica.js" type="text/javascript" charset="so-8859-1"></script>

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	
	
</head>
<script>
	$(document).ready(function(){
		montaCombo('formSelectAno','selectAno');
		montaCombo('formSelectGraficos','selectGraficosCombo');
		//gerarChartFaturamento();
	});
</script>
<body>
<div>
<?php include "../topo.php"; ?>
<script src="../js/jquery.blockUI.js"></script>
</div>
<div style="margin-left:10px;" >
  <input type="image" src="../icones/volta.png" name="image" width="40" height="40" onclick="javascript:history.go(-1);"> <strong>Voltar</strong>
</div>
<br>
<form  name="" id="" method="POST" class="form-horizontal" enctype="multipart/form-data">
		<fieldset>
			<div class="control-group">
				<label class="control-label" for="formSelectAno"><strong>Ano:<strong></label>
				<div class="controls">
					<select id="formSelectAno" style="width:21%;" name="formSelectAno" onchange="gerarTipoChart()">
						<option value="">-------</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectGraficos"><strong>Gráfico:<strong></label>
				<div class="controls">
					<select id="formSelectGraficos" style="width:21%;" name="formSelectGraficos" onchange="gerarTipoChart()" >
						<option value="">-------</option>
					</select>
				</div>
			</div>
			
		</fieldset> 
</form>


<br>
<div id="container" class="graficoGeral" style="width:95%;margin:0px 0.5%;"></div>
</body>
</html>