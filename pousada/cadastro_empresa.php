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

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
</head>
<script>
$(document).ready(function(){
	var jq17 = jQuery.noConflict();
	$("#formTelefone").mask("(99) 9999-99999");
	$("#formFax").mask("(99) 9999-99999");

	if($.query.get('idempresa') && $.query.get('editar'))
	{
		updateEmpresa($.query.get('idempresa'));
		return;
	}
	cadastrarEmpresa();
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
<form action="viewPousada.php" name="formInserirEmpresa" id="formInserirEmpresa" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset class='moldura fieldAlerta'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Empresa</strong></center></legend>
			<div class="control-group">  
				<label class="control-label" for="formEmpresa"><strong>Nome da empresa:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge" name="formEmpresa" id="formEmpresa">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formCnpj"><strong>CNPJ:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge" class="input-large" name="formCnpj" id="formCnpj">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formIE"><strong>Inscrição estadual:</strong></label>  
				<div class="controls">  
					<input type="text" class="input-xlarge" class="input-large" name="formIE" id="formIE">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formTelefone"><strong>Telefone:</strong></label>  
				<div class="controls">
					<input type="text" class="input-xlarge" class="input-large" name="formTelefone" id="formTelefone">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formFax"><strong>Telefone(Fax):</strong></label>  
				<div class="controls">
					<input type="text" class="input-xlarge" class="input-large" name="formFax" id="formFax">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formEndereco"><strong>Endereço:</strong></label>  
				<div class="controls">
					<input type="text" class="input-xlarge" class="input-large" name="formEndereco" id="formEndereco">
				</div>
			</div>
			<div class="form-actions form-background">
				<button type="submit" class="btn btn-primary" id="formEmpresa_submit" name="formEmpresa_submit">Cadastrar</button>  
			</div>
			<input type="hidden" id="formIdEmpresa" value="">
        </fieldset> 
</form>
</body>
</html>
