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

	
	<script src="js_pousada/calendario.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
</head>
<style>

table, th, td,tr {
	border: 1px solid black;
}
th {
	height: 50px;
}
td {
	height: 70px;
}

</style>
<script>
	$(document).ready(function(){
		var jq17 = jQuery.noConflict();
		calendario2();
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
<fieldset class='moldura fieldAlertaLista'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Agenda Mensal</strong></center></legend>
	<div id="calendario" style="width:99%;margin:0px 0.5%;"></div>
</fieldset> 
<div style="width:100%">
<div id="myModal"  style="left:35%;margin-right:60%;width:70%;" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<h4 id="myModalLabel">Cadastrar Compromisso...</h4>
	</div>
	<div class="modal-body">

	<form action="viewPousada.php" name="formInserirLancaInsumo" id="formInserirLancaInsumo" method="POST" class="form-horizontal" enctype="multipart/form-data">
			<div class="control-group">  
				<label class="control-label" for="formTitulo"><strong>Título:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge" name="formTitulo" id="formTitulo">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formDescricao"><strong>Descrição:</strong></label>  
				<div class="controls">
					<textarea class="input-xlarge" name="formDescricao" id="formDescricao" cols="50" rows="10"></textarea>  
				</div>
			</div>
		<div class="form-actions form-background">
			<button type="button" onclick=""  class="btn btn-primary" id="formProduto_submit" name="formProduto_submit">Cadastrar</button>  
		</div>
	</form>
</div>
</div>

</body>
</html>