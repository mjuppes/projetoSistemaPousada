<?php include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>
	<script src="../js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="utf-8"></script>

	<script src="../js/jquery.maskedinput-1.2.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/additional-methods.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.form.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.ui.plugingrid.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="../js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/msg_js/alertify.js"></script>
	<link rel="stylesheet" href="../js/msg_js/css/alertify.css" />
	<link rel="stylesheet" href="../js/msg_js/css/themes/default.css" />

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
</head>
<script>
var objectLabel = [{"label":"Nome da cidade","width":950},{"label":"","width":50}];

var objectConfig = 
{
	'gridDiv' : 'tabelaCidades',
	'width': 400,
	'class' : 'tabelaPadrao',
	'border':1,
	'id':'idcidade',
	'page':true,
	'title':'Tabela de cidades',
	'colspan':5,
	'crud':true,
	'update': 'cadastro_cidade.php',
	'delete':"excluiCidade"
};

$(document).ready(function(){
	var jq17 = jQuery.noConflict();
	getJsonSelect('selectTableCidade',false,objectConfig,objectLabel,'viewPousada.php',10);

	if($.query.get('idcidade') && $.query.get('editar'))
	{
		updateCidade($.query.get('idcidade'));
		return;
	}
	
	montaCombo('formSelectPais','selectPais');
	//montaCombo('formSelectEstado','selectEstado');
	cadastrarCidade();
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
<div class="erros"></div>
<form action="viewPousada.php" name="formInserirCidade" id="formInserirCidade" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset class='moldura fieldAlerta'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Cidade</strong></center></legend>
		<div class="control-group">
				<label class="control-label" for="formSelectPais"><strong>Pais:<strong></label>
				<div class="controls">
					<select id="formSelectPais" style="width:20%;" name="formSelectPais" onchange="buscaEstado(this.value);"></select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectEstado"><strong>Estado:<strong></label>
				<div class="controls">
					<select id="formSelectEstado" style="width:20%;" name="formSelectEstado" disabled>
					<option value="">-- Selecione --</option>
					</select>
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formNomeCidade"><strong>Cidade:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge" name="formNomeCidade" id="formNomeCidade">
				</div>
			</div>
			<div class="form-actions form-background">
				<button type="submit" class="btn btn-primary" id="formCidade_submit" name="formCidade_submit">Cadastrar</button>
			</div>
			<input type="hidden" id="formIdCidade" value="">
        </fieldset> 
</form>
<br>
<div id="tabelaCidades" style="width:99%;margin:0px 0.5%;"></div>
</body>
</html>
