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

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
</head>
<script>
$(document).ready(function(){
	var jq17 = jQuery.noConflict();

	if($.query.get('idchamado') && $.query.get('editar'))
	{
		updateChamado($.query.get('idchamado'));
		return;
	}
	cadastrarChamado();
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
<div class="erros"></div>
<form action="viewChamado.php" name="formInserirChamado" id="formInserirChamado" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset class='moldura fieldAlerta' >
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Chamado</strong></center></legend>
			<div class="control-group">  
				<label class="control-label" for="formTitulo"><strong>T�tulo:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge" name="formTitulo" id="formTitulo">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formDescricao"><strong>Descri��o do chamado:</strong></label>  
				<div class="controls">
					<textarea class="input-xlarge" name="formDescricao" id="formDescricao" cols="50" rows="10"></textarea>  
				</div>
			</div>
			<div id="divChamado" style="display:none">
				<div class="control-group">
					<label class="control-label" for="formSelectStatus"><strong>Status:<strong></label>
						<div class="controls">
							<select id="formSelectStatus" style="width:18%;" name="formSelectStatus">
							</select>
						</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formRetorno"><strong>Retorno</strong></label>  
					<div class="controls">
						<textarea class="input-xlarge" name="formRetorno" id="formRetorno" cols="50" rows="10"></textarea>  
					</div>
				</div>
			</div>
			<div class="form-actions form-background">
				<button type="submit" class="btn btn-primary" id="formChamado_submit" name="formChamado_submit">Cadastrar</button>  
			</div>
			<input type="hidden" id="formIdChamado" value="">
        </fieldset> 
</form>
</body>
</html>
