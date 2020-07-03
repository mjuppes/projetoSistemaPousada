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

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>	

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
</head>
<script>
var objectLabel =
[
	{"label":"Sub-Categoria","width":'40%'},
	{"label":"Descrição","width":'50%'},
	{"label":"","width":'5%'}
];

var objectConfig =
{
	'gridDiv' : 'tabelaSubCentro',
	'width': 700,
	'id':'id_sub_cat_centro',
	'border':1,
	'colspan':5,
	'crud':true,
	'delete':"excluiSubCategoria"
};


var objectLabel_2 =
[
	{"label":"Categoria","width":'90%'},
	{"label":"","width":'5%'}
];

var objectConfig_2 =
{
	'gridDiv' : 'tabelaCatCentro',
	'width': 700,
	'id':'id_cat_centro',
	'border':1,
	'colspan':5,
	'crud':true,
	'update':"atualizarSubCategoria"
};

$(document).ready(function(){
	
	getJsonSelect('selectTableCatCentro',false,objectConfig_2,objectLabel_2,'viewPousada.php');
	var jq17 = jQuery.noConflict();

	$("#formCategoria_submit").click(function(){
		cadastrarCatCentroCusto();
	});

	$("#formSubCategoria_submit").click(function(){
		cadastrarSubCatCentroCusto();
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
<form action="viewPousada.php" name="formCatCentroCusto" id="formCatCentroCusto" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset class='moldura fieldAlerta'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastrar Categorias (Centro de Custo)</strong></center></legend>
			<div class="control-group">  
				<label class="control-label" for="formCategoria"><strong>Categoria:</strong></label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="formCategoria" id="formCategoria">
				</div>
			</div>
			<div class="form-actions form-background">
				<button type="button" class="btn btn-primary" id="formCategoria_submit" name="formCategoria_submit">Cadastrar</button>  
			</div>
        </fieldset> 
</form>
<fieldset class='moldura fieldAlerta'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de Categorias</strong></center></legend>
	<div id="tabelaCatCentro" style="width:99%;margin:0px 0.5%;"></div>
</fieldset> 

<div style="width:100%">
	<div id="myModalSubCatCentro" style='margin-left:-40%;width:80%;'  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header" >
			<h4 id="myModalLabel" ></h4>
		</div>
		<div class="modal-body">
			<form action="viewPousada.php" name="formCatCentroCusto" id="formCatCentroCusto" method="POST" class="form-horizontal" enctype="multipart/form-data">
				<fieldset class='moldura fieldAlerta' style="width:98%">
					<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Sub-Categoria</strong></center></legend>
					<div class="control-group">
						<label class="control-label" for="formSelectCatCentro"><strong>Categoria:<strong></label>
							<div class="controls">
								<select id="formSelectCatCentro" style="width:50%;" name="formSelectCatCentro">
									<option value="">-- Selecione --</option>
								</select>
							</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="formSubCategoria"><strong>Sub-Categoria:</strong></label>
						<div class="controls">  
							<input type="text" class="input-xlarge" style="width:48%;" name="formSubCategoria" id="formSubCategoria">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="formObservacao"><strong>Observações:</strong></label>  
						<div class="controls">  
							<textarea   style="width:50%;" class="input-xlarge" name="formObservacao" id="formObservacao" rows="3"></textarea>  
						</div>
					</div>
					<div class="form-actions form-background">
						<button type="button" class="btn btn-primary" id="formSubCategoria_submit" name="formSubCategoria_submit">Cadastrar</button>  
					</div>
					<br>
				</fieldset> 
			</form>
			<fieldset class='moldura fieldAlerta' style="width:98%">
					<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de Sub-Categorias</strong></center></legend>
					<div id="tabelaSubCentro" style="width:99%;margin:0px 0.5%;"></div>
			</fieldset> 
		</div>
		<div class="modal-footer"></div>
	</div>
</div>
</body>
</html>
