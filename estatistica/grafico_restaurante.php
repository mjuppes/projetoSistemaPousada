<?php include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>
	<script src="../js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.maskedinput-1.2.2.min.js" type="text/javascript" charset="utf-8"></script>
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

	var jq17 = jQuery.noConflict();
	$("#formDtInicial").mask("99/99");
	$("#formDtFinal").mask("99/99");

	var objectLabel = eval([{"label":"","width":30},{"label":"Pratos","width":100}]);

	var objectRecordTab  =  eval([{"recordset":"nomeprato"}]);

	var objectConfig = eval({'gridDiv' : 'tabelaPratos',
							 'width': 130,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'page':false,
							 'title':'Tabela de Pratos',
							 'colspan':2,
							 'id':'idprato',
							 'recordset':true,
							 'objectRecordTab':objectRecordTab,
							 'checkbox':true});

	montaCombo('formSelectAno','selectAno');
	getJsonSelect('selectPratos',false,objectConfig,objectLabel,'viewGrafico.php');
});
</script>
<body>
<div>
<?php include "../topo.php"; ?>	
</div>
<div class="erros"></div>
<!--
<form action="viewPratos.php" name="formInserirMesa" id="formInserirMesa" method="POST" class="form-horizontal" enctype="multipart/form-data">
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
				<label class="control-label" for="formDtInicial"><strong>Data inicial:</strong></label>
				<div class="controls">
					<input type="text" class="input-medium"  id="formDtInicial" name="formDtInicial" id="formDtInicial">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formDtFinal"><strong>Data final:</strong></label>  
				<div class="controls">  
					<input type="text" class="input-medium" id="formDtFinal" name="formDtFinal" id="formDtFinal">
				</div>
			</div>
			<div class="form-actions">  
				<button type="button" class="btn btn-primary" onclick="gerarGrafico();" id="formFiltroProduto_submit" name="formFiltroProduto_submit">Gráfico</button>  
			</div>
        </fieldset> 
</form>-->
<div id="tabelaPratos"></div>
<div id="container" class="graficoGeral" style="width: 95%;" ></div>
</body>
</html>
