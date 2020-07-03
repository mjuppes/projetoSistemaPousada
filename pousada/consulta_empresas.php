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
	<!--<link href="../css/bordasombreada.css" rel="stylesheet" type="text/css"/>-->
</head>
<script>
	var objectLabel = eval([{"label":"Nome da empresa","width":"35%"}
							,{"label":"CNPJ","width":"20%"}
							,{"label":"Telefone","width":"20%"}
							,{"label":"","width":"4%"}]);

	var objectConfig = eval({'gridDiv' : 'tabelaEmpresa',
							 'width': 500,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'id':'idempresa',
							 'page':true,
							 'colspan':5,
							 'crud':true,
							 'push':'cadastro_empresa.php',
							 'update': true ,
							 'visualize': "visualizarEmpresa"});

	$(document).ready(function(){
		var jq17 = jQuery.noConflict();
		$("#formNomeEmpresa").autocomplete("complete_empresa.php",{width:310,selectFirst:false});
		getJsonSelect('selectEmpresaTable',false,objectConfig,objectLabel,false,10);
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
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Pesquisa de Empresas</strong></center></legend>
			<div class="control-group">
				<label class="control-label" for="formNomeEmpresa"><strong>Nome da empresa:</strong></label>  
				<div class="controls">  
					<input type="text" class="input-large" style="width:21%;"name="formNomeEmpresa" id="formNomeEmpresa">
				</div>
			</div>
			<div class="form-actions">
				<button type="button" onclick="buscarRegistrosTabelaEmpresa()" class="btn" title="Buscar">
				<img src="../icones/busca.png" width="25px" height="20px">
				<strong>Buscar</strong></button>
			</div>
        </fieldset> 
</form>
<fieldset class='moldura fieldAlertaLista'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de Empresas</strong></center></legend>
	<div id="tabelaEmpresa" style="width:99%;margin:0px 0.5%;"></div>
</fieldset> 
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<h4 id="myModalLabel">Informações da Empresa</h4>
	</div>
	<div class="modal-body">
		<dl class="dl-horizontal">
			<dt><strong>Nome da empresa:</strong></dt>
				<dd><span id="formEmpresa" name="formEmpresa"></span></dd>
				<br>
			<dt><strong>CNPJ:</strong></dt>
				<dd><span id="formCnpj" name="formCnpj"></span></dd>
				<br>
			<dt><strong>Inscrição estadual:</strong></dt>
				<dd><span id="formIE" name="formIE"></span></dd>
				<br>
			<dt><strong>Telefone:</strong></dt>
				<dd><span id="formTelefone" name="formTelefone"></span></dd>
				<br>
			<dt><strong>Fax:</strong></dt>
				<dd><span id="formFax" name="formFax"></span></dd>
				<br>
			<dt><strong>Endereço:</strong></dt>
				<dd><span id="formEndereco" name="formEndereco"></span></dd>
				<br>
		</dl>
	</div>
	<div class="modal-footer"></div>
</div>
</body>
</html>