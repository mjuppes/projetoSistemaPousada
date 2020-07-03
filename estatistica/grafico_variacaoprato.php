<?php include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>

	<script src="../js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="utf-8"></script>

	<script type="text/javascript" src="../js/highcharts.js"></script>
	<script type="text/javascript" src="../js/modules/exporting.js"></script>
	<script src="../js/jquery.ui.plugingrid.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="js_grafico/grafico.js" type="text/javascript" charset="utf-8"></script>


	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
</head>
<script>
	$(document).ready(function(){
		montaCombo('formSelectAno','selectAno');
		montaCombo('formSelectMes','selectMes');
		montaCombo('formSelectPratos','selectPratosCombo');
	});
</script>
<body>
<div>
<?php include "../topo.php"; ?>
</div>
<form class="form-horizontal" name="formProdutos" id="formProdutos" >
	<fieldset>
		<div class="control-group">
			<label class="control-label" for="formSelectAno"><strong>Ano<strong></label>
			<div class="controls">
				<select id="formSelectAno" style="width:21%;" name="formSelectAno"  >
					<option value="">-------</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formSelectMes"><strong>Mês<strong></label>
			<div class="controls">
				<select id="formSelectMes" style="width:21%;" name="formSelectMes"  >
					<option value="">-------</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formSelectPratos"><strong>Selecione um prato<strong></label>
			<div class="controls">
				<select id="formSelectPratos" style="width:21%;" name="formSelectPratos"  >
					<option value="">Selecione um prato</option>
				</select>
			</div>
		</div>
		<div class="form-actions">  
			<button type="button" class="btn btn-primary" onclick="gerarChartVariacaoPrato();"  id="formFiltroProduto_submit" name="formFiltroProduto_submit">Gráfico</button>  
		</div>
   </fieldset>
</form>
<div id="container" class="graficoGeral" style="width: 100%;" ></div>
</body>
</html>