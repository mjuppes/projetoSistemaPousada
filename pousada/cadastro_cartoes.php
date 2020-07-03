<?php //include "../permissao.php"; ?>

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
	/*
		if($.query.get('idchamado') && $.query.get('editar'))
		{
			updateCartao($.query.get('idchamado'));
			return;
		}
		
	*/
	
	$("#formCartao_submit").click(function() {
		cadastrarCartao();
	});
	montaCombo('formSelectBandeira','selectBandeira');
});
</script>
<body>
<div>
<?php include "../topo.php"; ?>	
</div>
<div style="margin-left:10px;">
  <input type="image" src="../icones/volta.png" name="image" width="40" height="40" onclick="javascript:history.go(-1);"> <strong>Voltar</strong>
</div>
<br>
<div id="erros" class="erros"></div>
<form action="viewPousada.php" name="formInserirCartao" id="formInserirCartao" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset class='moldura fieldAlerta' >
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Cartão</strong></center></legend>
		<div class="control-group">
			<label class="control-label" for="formSelectBandeira"><strong>Bandeira:<strong></label>
				<div class="controls">
					<select id="formSelectBandeira" name="formSelectBandeira" style="width:50%">
					</select>
				</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formOpcao"><strong>Tipo de Lançamento:</strong></label>
			<div class="controls">  
				<input type="radio" id="opcao[]" onclick="habilitarCampoParcelas('D')" name="opcao" value="D" checked> Débito
				<input type="radio" id="opcao[]" onclick="habilitarCampoParcelas('C')" name="opcao" value="C"> Crédito
			</div>
		</div>
		<div class="control-group" id="divParcelas" style="display:none">
			<label class="control-label" for="formParcelas"><strong>Parcelas:</strong></label>
			<div class="controls">
				<input type="text" class="input-xlarge" name="formParcelas" id="formParcelas">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formDiaRecebimento"><strong>Dia de Recebimento:</strong></label>
			<div class="controls">
				<input type="text" class="input-xlarge" name="formDiaRecebimento" id="formDiaRecebimento">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formPercentual"><strong>Percentual:</strong></label>
			<div class="controls">
				<input type="text" class="input-xlarge" name="formPercentual" id="formPercentual">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formBaixaAutomatica"><strong>Baixa Automática:</strong></label>
			<div class="controls">
				<input type="checkbox"  name="formBaixaAutomatica" id="formBaixaAutomatica">
			</div>
		</div>

		<div class="form-actions form-background">
			<button type="button" class="btn btn-primary" id="formCartao_submit" name="formCartao_submit">Cadastrar</button>  
		</div>
		<input type="hidden" id="formIdChamado" value="">
    </fieldset> 
</form>
</body>
</html>
