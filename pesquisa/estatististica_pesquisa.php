<?php include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>

	<script src="../js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="utf-8"></script>

	<script type="text/javascript" src="../js/highcharts_old.js"></script>
	<script type="text/javascript" src="../js/modules/exporting.js"></script>
	<script src="js_pesquisa/pesquisa.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	
	
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">

</head>
    <script type="text/javascript">

  $(document).ready(function(){
		var jq17 = jQuery.noConflict();
		montaCombo('formSelectPergunta','selectPergunta',$.query.get('idpesquisa'));
		gerarGraficoPesquisa($.query.get('idpesquisa'));
		tabelaFormatoGrafico();
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
	<div id="container" class="graficoGeral" style="width: 98%;position:;background-color:rgba( 173, 216, 230   ,0.1)"></div>
</body>
</html>