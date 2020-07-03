<?php include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title></title>
	<script src="../js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.ui.plugingrid.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script type="text/javascript" src="../js/highcharts.js"></script>
	<script type="text/javascript" src="../js/modules/exporting.js"></script>
	<script src="js_estatistica/estatistica.js" type="text/javascript" charset="iso-8859-1"></script>
	
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="../css/bordasombreada.css" rel="stylesheet" type="text/css"/>
</head>
<script>

var objectLabel = eval([{"label":"Agências","width":'25%'},{"label":"Quantidades de indicações","width":'25%'}]);

var objectConfig = eval({'gridDiv' : 'tabelaAgencias',
						 'width': '50%',
						 'class' : 'tabelaPadrao',
						 'border':1,
						 'colspan':2});

$(document).ready(function(){
	var jq17 = jQuery.noConflict();
	getJsonSelect('selectAgenciasQtd',false,objectConfig,objectLabel,'viewGrafico.php',10);
	montaCombo('formSelectMes','selectMes');
	gerarChartTipoHospAgencia();
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
<form name="form" id="form" method="POST" class="form-horizontal" enctype="multipart/form-data">
		<fieldset>
			<div class="control-group">
				<label class="control-label" for="formSelectMes"><strong>Mês<strong></label>
				<div class="controls">
					<select id="formSelectMes" style="width:21%;" name="formSelectMes" onchange="gerarChartTipoHospAgencia()">
						<option value="">-------</option>
					</select>
				</div>
			</div>
		</fieldset> 
</form>
<div style="margin-top:0%">
<div id="tabelaAgencias"  style="width:550px;margin-left:2%;margin-top:2%"></div>
<br>
<div id="container" class="graficoGeral" style="width: 98%;position:;background-color:rgba( 173, 216, 230   ,0.1)"></div>
</div>
</body>
</html>