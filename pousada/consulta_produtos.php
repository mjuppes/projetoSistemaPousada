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

	<script src="../js/msg_js/alertify.js"></script>
	
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.bgiframe.min.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/thickbox-compressed.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/jquery.autocomplete.js"></script>
	<link  href="../js/jquery-autocomplete/jquery.autocomplete.css" rel="stylesheet" type="text/css">

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>	

	<link rel="stylesheet" href="../js/msg_js/css/alertify.css" />
	<link rel="stylesheet" href="../js/msg_js/css/themes/default.css" />
	
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
</head>
<script>
	var objectLabel =
	[
		{"label":"","width":"5%"}
		,{"label":"Produto","width":"15%"}
		,{"label":"Fornecedor","width":"15%"}
		,{"label":"Categoria","width":"15%"}
		,{"label":"Quantidade","width":"15%"}
		,{"label":"Valor","width":"10%"}
		,{"label":"Total","width":"10%"}
		,{"label":"Cadastrado em","width":"10%"}
		,{"label":"","width":"10%"}
	];

	var arrLink = [{"icon":"editar.png","function":"atualizarValor","title":"Atualizar valor"}];
	var objectHideTable = [{"value":"estoque"}];
	var objectConfig = 
	{
		'gridDiv' : 'tabelaProdutos',
		 'width': 500,
		 'class' : 'tabelaPadrao',
		 'border':1,
		 'id':'idproduto',
		 'colspan':4,
		 'crud':true,
		 'print':'imprimirProdutos',
		 'push': 'cadastro_produto.php',
		 'arrLink': arrLink,
		 'checkbox': true	,
		 'checkTitle': 'Excluir',
		 'checkImg': 'excluir.png',
		 'objectHideTable':objectHideTable,
		 'checkFunction':'excluiProduto',
		 'visualize':"visualizarProduto"
	};

	$(document).ready(function(){
		var jq17 = jQuery.noConflict();

		montaCombo("formSelectFornecedor","selectFornecedor");
		montaCombo('formSelectCategoria','selectCategoria');
		montaCombo('formSelectOrdem','selectProdutoOrdem');

		getJsonSelect('selectProdutosTable',false,objectConfig,objectLabel,'viewPousada.php',10);
		$("#formProdutoStr").autocomplete("complete_produto.php",{width:310,selectFirst:false});
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
<form action="viewPousada.php" name="formProduto" id="formProduto" method="POST" class="form-horizontal" enctype="multipart/form-data">
	<fieldset  class='moldura fieldAlertaLista'>
		<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Pesquisa de Produtos</strong></center></legend>

	<div class="control-group">
		<label class="control-label" for="formProdutoStr"><strong>Nome do produto:<strong></label>
		<div class="controls">
			<input type="text" class="input-large" name="formProdutoStr" id="formProdutoStr" style="width:31%;">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="formSelectFornecedor"><strong>Fornecedor:<strong></label>
			<div class="controls">
				<select id="formSelectFornecedor" style="width:32%;" name="formSelectFornecedor">
				</select>
			</div>
	</div>

	<div class="control-group">  
		<label class="control-label" for="formSelectCategoria"><strong>Categoria:</strong></label>
		<div class="controls">  
			<select id="formSelectCategoria" style="width:32%;" name="formSelectCategoria"></select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="formSelectOrdem"><strong>Odenar por:<strong></label>
		<div class="controls">
			<select id="formSelectOrdem" style="width:32%;" name="formSelectOrdem">
			</select>
		</div>
	</div>
	<div class="form-actions">
		<button type="button" onclick="buscarRegistrosTabelaProduto()" class="btn" title="Buscar">
					<img src="../icones/busca.png" width="25px" height="20px">
		<strong>Buscar</strong></button>
	</div>
</fieldset>
</form>
<fieldset class='moldura fieldAlertaLista'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de Produtos</strong></center></legend>
	<div id="tabelaProdutos" style="width:99%;margin:0px 0.5%;"></div>
</fieldset>
<input type="hidden" id="formIdProduto" value="">
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<h4 id="myModalLabel">Informações do Produto</h4>
	</div>
	<div class="modal-body">
		<dl class="dl-horizontal">
			<dt><strong>Produto:</strong></dt>
				<dd><span id="formProdutoNome" name="formProdutoNome"></span></dd>
				<br>
			<dt><strong>Fornecedor:</strong></dt>
				<dd><span id="formFornecedor" name="formFornecedor"></span></dd>
				<br>
			<dt><strong>Categoria:</strong></dt>
				<dd><span id="formCategoria" name="formCategoria"></span></dd>
				<br>
			<dt><strong>Valor:</strong></dt>
				<dd><span id="formValor" name="formValor"></span></dd>
				<br>
			<dt><strong>Unidade:</strong></dt>
				<dd><span id="formUnidade" name="formUnidade"></span></dd>
				<br>
			<dt><strong>Data da Compra:</strong></dt>
				<dd><span id="formDtaCompra" name="formDtaCompra"></span></dd>
				<br>
			<dt><strong>Data da Validade:</strong></dt>
				<dd><span id="formDtaValidade" name="formDtaValidade"></span></dd>
				<br>
			<dt><strong>Data de Cadastro:</strong></dt>
				<dd><span id="formDtaCadastro" name="formDtaCadastro"></span></dd>
				<br>
			<dt><strong>Produto de insumo?</strong></dt>
				<dd><span id="formProdInsumo" name="formProdInsumo"></span></dd>
				<br>
			<dt><strong>Produto de estoque?</strong></dt>
				<dd><span id="formProdEstoque" name="formProdEstoque"></span></dd>
				<br>
		</dl>
	</div>
	<div class="modal-footer"></div>
</div>


<div id="myModalValor" style='margin-left:-30%;width:60%'  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header" >
		<h4 id="myModalLabel" ></h4>
	</div>
	<div class="modal-body">
		<div class="divDialogElements">
			<form action="viewPousada.php" name="inserirValor" id="inserirValor" method="POST" class="form-horizontal" enctype="multipart/form-data">
			  <fieldset class='moldura fieldAlerta'>
				<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Atualizar Valor</strong></center></legend>
				<div class="control-group">
					<label class="control-label" for="formValorProd"><strong>Novo Valor:</strong></label>  
					<div class="controls">  
						<input type="text" style="width:30%;" class="input-large" name="formValorProd" id="formValorProd">
					</div>
				</div>
				</fieldset> 
			</form>

		</div>
	</div>
	<div class="modal-footer form-background">
		<a class="btn btn-primary" onclick="atualizarValorProduto();" href="#">Atualizar</a>
		<a class="btn" onclick="closeDialogProd();" href="#">Cancelar</a>
	</div>
	<div class="modal-footer"></div>
</div>

</body>
</html>