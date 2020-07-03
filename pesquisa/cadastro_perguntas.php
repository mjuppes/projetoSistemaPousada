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

	<script src="js_pesquisa/pesquisa.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
</head>
<script>
$(document).ready(function(){
	var jq17 = jQuery.noConflict();
	buscarNome($.query.get('idpesquisa'));
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
<form name="formParametros" id="formParametros" method="POST" class="form-horizontal" enctype="multipart/form-data">
		<fieldset>
			<div class="control-group">
				<label class="control-label" for="NomePesquisa"><strong>Pesquisa:</strong></label>
				<div class="controls">
					<span id="NomePesquisa" name="NomePesquisa"></span>
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formNomePesquisa"><strong>Pergunta:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge" name="formPegunta[]" id="formPegunta[]">
					<button type='button' onclick="adicionarPerguntas()" class='btn' title='Adicionar perguntas'><img src='/beaverpousada/icones/adicionar.png' width='20px' height='20px'></button>
				</div>
			</div>
			<div id="buttonPerguntas"></div>
			<div class="form-actions">
				<button type="button" onclick="getPerguntas()" class="btn btn-primary" id="formParametros_submit" name="formParametros_submit">Cadastrar</button>  
			</div>
			<input type="hidden" id="formIdPesquisa" value="<?php echo $_GET['idpesquisa']; ?>">
		</fieldset> 
</form>
</body>
</html>
