<?php include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>
	<script src="../js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="utf-8"></script>

	<script src="../js/msg_js/alertify.js"></script>
	<script src="../js/jquery.maskedinput-1.2.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/additional-methods.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.form.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.ui.plugingrid.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="../js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	
	
	<link rel="stylesheet" href="../js/msg_js/css/alertify.css" />
	<link rel="stylesheet" href="../js/msg_js/css/themes/default.css" />
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
</head>
<script>
var objectLabel = eval([{"label":"Nome da categoria","width":"95%"},{"label":"","width":"5%"}]);

var objectConfig = eval({'gridDiv' : 'tabelaCategoria',
						 'width': 400,
						 'class' : 'tabelaPadrao',
						 'border':1,
						 'id':'idcategoria',
						 'page':false,
						 'title':'Tabela de categorias',
						 'colspan':5,
						 'crud':true,
						 'update': 'cadastro_categoria.php',
						 'delete':"excluiCategoria"});

$(document).ready(function(){
	var jq17 = jQuery.noConflict();
	getJsonSelect('selectTableCategoria',false,objectConfig,objectLabel,'viewPousada.php');

	if($.query.get('idcategoria') && $.query.get('editar'))
	{
		updateCategoria($.query.get('idcategoria'));
		return;
	}
	cadastrarCategoria();
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
<form action="viewPousada.php" name="formInserirCategoria" id="formInserirCategoria" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset class='moldura fieldAlerta'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Categoria</strong></center></legend>
			<div class="control-group">  
				<label class="control-label" for="formCategoria"><strong>Categoria:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge" name="formCategoria" id="formCategoria">
				</div>
			</div>
			<div class="form-actions form-background">
				<button type="submit" class="btn btn-primary" id="formCategoria_submit" name="formCategoria_submit">Cadastrar</button>
			</div>
			<input type="hidden" id="formIdCategoria" value="">
        </fieldset> 
</form>
<div id="tabelaCategoria" style="width:99%;margin:0px 0.5%;"></div>
</body>
</html>
