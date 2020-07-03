<?php include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>

	<script src="../js/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="utf-8"></script>

	<script src="../js/jquery.maskedinput-1.2.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script type="text/javascript" src="../js/jsapi.js"></script>
	<script src="js_pesquisa/pesquisa.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">

</head>
    <script type="text/javascript">
	
	 google.load("visualization", "1", {packages:["corechart"]});

	function drawChartPie(arrayForGviz)
	{
		$("#piechart_3d").fadeOut();
		arrayForGviz =  eval("["+arrayForGviz.toString()+"]");
		var data = google.visualization.arrayToDataTable(arrayForGviz);

		var options = {
			is3D: true,
			'backgroundColor': 'transparent'
		};
		
		var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
		$("#piechart_3d").fadeIn();
		chart.draw(data, options);
		
	}
	
	
	function drawChartBar(arrayForGviz)
	{
		
		arrayForGviz =  eval("["+arrayForGviz.toString()+"]");
		var data = google.visualization.arrayToDataTable(arrayForGviz);

		var options = {
			is3D: true,
			'backgroundColor': 'transparent',
			colors:[{color:'#67C5DC', darker:'#680000'}, {color:'cyan', darker:'deepskyblue'}]
		};
		
		var chart = new google.visualization.ColumnChart(document.getElementById('piechart_3d'));
		$("#piechart_3d").fadeIn();
        chart.draw(data, options);
		
	}
	  

  $(document).ready(function(){
		var jq17 = jQuery.noConflict();
		montaCombo('formSelectPergunta','selectPergunta',$.query.get('idpesquisa'));
		tabelaFormatoGrafico();
		gerarGraficoPesquisa($.query.get('idpesquisa'));
	});
	
    </script>
<body>
<div>
<?php include "../topo.php"; ?>
</div>
<div style="margin-left:10px;" >
  <input type="image" src="../icones/volta.png" name="image" width="40" height="40" onclick="javascript:history.go(-1);"> <strong>Voltar</strong>
</div>
<form  name="form" id="form" method="POST" class="form-horizontal" enctype="multipart/form-data">
	<fieldset>
		<div class="control-group">
			<label class="control-label" for="formSelectPergunta"><strong>Perguntas:<strong></label>
			<div class="controls">
				<select id="formSelectPergunta" style="width:21%;" name="formSelectPergunta" onchange="gerarChartPergunta()" >
					<option value="">-------</option>
				</select>
			</div>
		</div>
   </fieldset>
</form>
<div id="tabelaTipoGrafico"  style="width:17%;margin-left:2%;margin-top:2%;"></div>
<br>
    <div id="piechart_3d" style="width: 60%; margin:50px 25%;height: 500px;"></div>
</body>
</html>