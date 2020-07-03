<?php include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
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
$(document).ready(function(){
	var jq17 = jQuery.noConflict();

	if($.query.get("id_fornecedor") && $.query.get("editar"))
	{
		updateFornecedor($.query.get("id_fornecedor"));
		return;
	}
	cadastrarFornecedor();
	montaCombo("formSelectTipoForn","selectComboTipoFornecedor");
	montaCombo('formSelectDepBanco','selectBancoCombo',false);
});
</script>
<body>
<div class="inner">
<div>
<?php include "../topo.php"; ?>	
</div>
<div style="margin-left:10px;" >
  <input type="image" src="../icones/volta.png" name="image" width="40" height="40" onclick="javascript:history.go(-1);"> <strong>Voltar</strong>
</div>
<br>
<div class="erros"></div>
	<form action="viewPousada.php" name="formInserirFornecedor" id="formInserirFornecedor"	method="POST" class="form-horizontal" enctype="multipart/form-data">
		<fieldset class='moldura fieldAlerta'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Fornecedor</strong></center></legend>
			<div class="control-group">
				<label class="control-label" for="formFornecedor"><strong>Fornecedor:</strong></label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="formFornecedor" id="formFornecedor" style="width:48%;">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectTipoForn"><strong>Tipo/Categoria:<strong></label>
				<div class="controls">
					<select id="formSelectTipoForn" style="width:50%;" name="formSelectTipoForn">
					</select>
				</div>
			</div>
			
			<div class="control-group" >
				<label class="control-label" for="formSelectDepBanco"><strong>Banco:</strong></label>
				<div class="controls">
					<select id="formSelectDepBanco" name="formSelectDepBanco" style="width:50%;">
					</select>
				</div>
			</div>
			<div class="control-group" >
				<label class="control-label" for="formAgencia"><strong>Agência:</strong></label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="formAgencia" id="formAgencia">
				</div>
			</div>
			<div class="control-group" >
				<label class="control-label" for="formConta"><strong>Conta:</strong></label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="formConta" id="formConta">
				</div>
			</div>
			<div class="control-group" >
				<label class="control-label" for="formSelectTipoConta"><strong>Tipo:</strong></label>
				<div class="controls">
					<select id="formSelectTipoConta" name="formSelectTipoConta" style="width:50%;">
						<option value="">-- Tipo --</option>
						<option value="C">Corrente</option>
						<option value="P">Poupança</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formCpfCnpj"><strong>CPF/CNPJ:</strong></label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="formCpfCnpj" id="formCpfCnpj">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formEndereco"><strong>Endereço:</strong></label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="formEndereco" id="formEndereco">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formTelefone"><strong>Telefone:</strong></label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="formTelefone" id="formTelefone">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formObeservacao"><strong>Observações:</strong></label>  
				<div class="controls">  
					<textarea class="input-xlarge" name="formObeservacao" id="formObeservacao" rows="3"></textarea>  
				</div>
			</div>
			<input type="hidden" id="formIdFornecedor" value="">
			<div class="form-actions form-background">
				<button type="submit" class="btn btn-primary" id="formFornecedor_submit" name="formFornecedor_submit">Cadastrar</button>  
			</div>
		</fieldset>
	</form>
	</div>
</body>
</html>
