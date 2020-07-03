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

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
</head>
<script>
$(document).ready(function(){
	 var jq17 = jQuery.noConflict();
	montaCombo('formSelectEstado','selectEstado');
	$('#formSelectCidade').attr('disabled',true);
	$("#formSelectEstado").bind("change",function()
	{
		if($("#formSelectEstado").val() == "")
		{
			$("#formSelectCidade").html("<option>Selecione uma cidade</option>");
			$("#formSelectCidade").attr('disabled',true);
			return;
		}

		montaCombo('formSelectCidade','selectCidade',$("#formSelectEstado").val());
		$("#formSelectCidade").attr('disabled',false);
	});
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
<div class="erros" id="erros"></div>
<form action="viewPousada.php" name="formInserirContato" id="formInserirContato" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset class='moldura fieldAlerta'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Contato</strong></center></legend>
			<div class="control-group">  
				<label class="control-label" for="formNome"><strong>Nome:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge" style="width:50%;"  name="formNome" id="formNome">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectEstado"><strong>Estado:<strong></label>
				<div class="controls">
					<select id="formSelectEstado" style="width:50%;" name="formSelectEstado">
						<option value="">-- Selecione --</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectCidade"><strong>Cidade:<strong></label>
				<div class="controls">
					<select id="formSelectCidade" style="width:50%;" name="formSelectCidade">
						<option value="">-- Selecione --</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formTelefone"><strong>Telefone:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge"  style="width:50%;" class="input-large" name="formTelefone" id="formTelefone">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formCep"><strong>Cep:</strong></label>  
				<div class="controls">  
					<input type="text" class="input-xlarge" style="width:50%;" class="input-large" name="formCep" id="formCep" onblur="verificaCEP(this,'formEndereco','formBairro')">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formEndereco"><strong>Endereço:</strong></label>  
				<div class="controls">  
					<input type="text" class="input-xlarge" style="width:50%;" class="input-large" name="formEndereco" id="formEndereco">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formBairro"><strong>Bairro:</strong></label>  
				<div class="controls">
					<input type="text" class="input-xlarge" style="width:50%;" class="input-large" name="formBairro" id="formBairro">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label"  disabledfor="formSelectEstrelas" disabled><strong>Estrelas:<strong></label>
				<div class="controls">
					<select id="formSelectEstrelas" style="width:32%;" name="formSelectEstrelas">
						<option value="">- Nenhuma -</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label"  disabledfor="formSelectFonte" disabled><strong>Fonte:<strong></label>
				<div class="controls">
					<select id="formSelectFonte" style="width:32%;" name="formSelectFonte" onchange="habilitaFonte();">
						<option value="">- Selecione -</option>
						<option value="1">Trivago</option>
						<option value="2">Booking</option>
						<option value="3">Google</option>
						<option value="4">Hoteis.com</option>
						<option value="5">Outros</option>
					</select>
				</div>
			</div>
			<div class="control-group" id="divOutraFonte" style="display:none">
				<label class="control-label" for="formFonteNome"><strong>Outra:</strong></label>  
				<div class="controls">
					<input type="text" class="input-xlarge" style="width:50%;" class="input-large" name="formFonteNome" id="formFonteNome">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formObservacao"><strong>Observações:</strong></label>  
				<div class="controls">  
					<textarea class="input-xlarge" style="width:50%;" name="formObservacao" id="formObservacao" rows="3"></textarea>  
				</div>
			</div>
			<div class="form-actions form-background">
				<button type="button" class="btn btn-primary" id="formContatos_submit" name="formContatos_submit" onclick="cadastrarContato();">Cadastrar</button>  
			</div>
			<input type="hidden" id="formIdEmpresa" value="">
        </fieldset> 
</form>
</body>
</html>
