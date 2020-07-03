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
	
	if($.query.get('idpesquisa') && $.query.get('adicionar'))
	{
		addPergunta($.query.get('idpesquisa'))
		return;
	}
	if($.query.get('idpesquisa') && $.query.get('editar'))
	{
		updatePesquisa($.query.get('idpesquisa'));
		return;
	}
	cadastrarPesquisa();
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
<div id="divPesquisa">
	<form action="viewPesquisa.php" name="formPesquisa" id="formPesquisa" method="POST" class="form-horizontal" enctype="multipart/form-data">
			<fieldset class='moldura fieldAlerta'>
				<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Pesquisa</strong></center></legend>
				<div id="lista" class="lista_info">
					<button type="button" style="padding: 5x 10px;" class="btn btn-menu" title="Listar" onclick='location="consulta_pesquisa.php"'><img src="../icones/listar.png" width="40px" height="50px"><br>Listar</button>
				</div>

				<div class="control-group">  
					<label class="control-label" for="formNomePesquisa"><strong>Nome da pesquisa:</strong></label>
					<div class="controls">  
						<input type="text" class="input-xlarge" name="formNomePesquisa" id="formNomePesquisa">
							<button id='btnParametro'
							onclick=window.location='cadastro_pesquisa.php?idpesquisa=<?php echo $_GET['idpesquisa']; ?>&adicionar=true'
							style='display:none'  type='button' class='btn' title='Adicionar'><img src='http://177.70.26.45/beaverpousada/icones/adicionar.png' width='20px' height='20px'>&nbsp;<strong>Adicionar Parametro</strong></button>
					</div>
					
					
					
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-primary" id="formPesquisa_submit" name="formPesquisa_submit">Cadastrar</button>
				</div>
			</fieldset> 
	</form>
</div>
<input type="hidden" id="formIdPesquisa" value="">
<div id="divParametros" style="display:none">
	<form name="formParametros" id="formParametros" method="POST" class="form-horizontal" enctype="multipart/form-data">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="NomePesquisa"><strong>Pesquisa:</strong></label>
					<div class="controls">
						<span id="NomePesquisa" name="NomePesquisa"></span>
					</div>
				</div>
				<div class="control-group">  
					<label class="control-label" for="formNomeParametro"><strong>Parametro:</strong></label>
					<div class="controls">  
						<input type="text" class="input-xlarge" name="formNomeParametro[]" id="formNomeParametro[]">
						<button id='push' type='button' onclick="adicionarParametros()" class='btn' title='Adicionar parametro'><img src='http://localhost/beaverpousada/icones/adicionar.png' width='20px' height='20px'></button>
					</div>
				</div>
				<div id="buttonParametros"></div>
				<div class="form-actions">
					<button type="button" onclick="getParametros()" class="btn btn-primary" id="formParametros_submit" name="formParametros_submit">Cadastrar</button>  
				</div>
				<input type="hidden" id="formIdPesquisa" value="">
			</fieldset> 
	</form>
</div>
</body>
</html>
