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
	
	<script src="../js/msg_js/alertify.js"></script>
	
	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>

	<link rel="stylesheet" href="../js/msg_js/css/alertify.css" />
	<link rel="stylesheet" href="../js/msg_js/css/themes/default.css" />
	
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>

	<script src="../js/dhtmlgoodies_calendar.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<link href="../css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css"/>
</head>
<script>
$(document).ready(function(){


	var jq17 = jQuery.noConflict();
	$('#formValor').priceFormat({
		prefix: '',
		centsSeparator: ',',
		thousandsSeparator: '.'
	});

	if($.query.get("idproduto") && $.query.get("editar"))
	{
		updateProduto($.query.get("idproduto"));
		return;
	}

	montaCombo("formSelectFornecedor","selectFornecedor");
	montaCombo("formSelectCategoria","selectCategoria");
	montaCombo("formSelectInsumo","selectProdutoInsumo");
	montaCombo("formSelectPE","selectProdutoEstoque");
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
<div id="erros" class="erros"></div>
	<form action="viewPousada.php" name="formInserirProduto" id="formInserirProduto"	method="POST" class="form-horizontal" enctype="multipart/form-data">
		<fieldset class='moldura fieldAlerta'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Produto</strong></center></legend>
			<div class="control-group">
				<label class="control-label" for="formProduto"><strong>Produto:</strong></label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="formProduto" id="formProduto">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formCodigo"><strong>Código:</strong></label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="formCodigo" id="formCodigo">
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
				<label class="control-label" for="formSelectCategoria"><strong>Categoria:<strong></label>
					<div class="controls">
						<select id="formSelectCategoria" style="width:32%;" name="formSelectCategoria">
						</select>
					</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formValor"><strong>Valor:</strong></label>
				<div class="controls">
					<input type="text" class="input-xlarge" style="width:10%;" value="0,00" name="formValor" id="formValor">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formDtaCompra"><strong>Data da Compra:</strong></label>
				<div class="controls">
					<input type="text" class="input-xlarge" style="width:20%;" name="formDtaCompra" id="formDtaCompra">
					<img style="cursor:pointer" title='CalendÃ¡rio' onclick= "displayCalendar(document.getElementById('formDtaCompra'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formDtaValidade"><strong>Data da Validade:</strong></label>
				<div class="controls">
					<input type="text" class="input-xlarge" style="width:20%;" name="formDtaValidade" id="formDtaValidade">
					<img style="cursor:pointer" title='CalendÃ¡rio' onclick= "displayCalendar(document.getElementById('formDtaValidade'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectInsumo"><strong>Insumo?<strong></label>
				<div class="controls">
					<select id="formSelectInsumo" style="width:13%;" name="formSelectInsumo">
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectPE"><strong>Estoque?<strong></label>
				<div class="controls">
					<select id="formSelectPE" style="width:13%;" name="formSelectPE" onchange="habilitarInfoEstoque()">
					</select>
				</div>
			</div>
			<div id="divInfoEstoque" style="display:none;">
				<div class="control-group">
					<label class="control-label" for="formSelectSigla" disabled><strong>Sigla de Controle:<strong></label>
					<div class="controls">
						<select id="formSelectSigla" style="width:32%;" name="formSelectSigla">
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formQuantidade"><strong>Quantidade Inicial:<strong></label>
					<div class="controls">
						<input type="text" class="input-xlarge" style="width:10%;" value="" name="formQuantidade" id="formQuantidade">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formEstMinino"><strong>Estoque Mínimo:<strong></label>
					<div class="controls">
						<input type="text" class="input-xlarge" style="width:10%;" value="" name="formEstMinino" id="formEstMinino">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formEstMaximo"><strong>Estoque Máximo:<strong></label>
					<div class="controls">
						<input type="text" class="input-xlarge" style="width:10%;" value="" name="formEstMaximo" id="formEstMaximo">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formCustoMedio"><strong>Custo Médio:<strong></label>
						<div class="controls">
							<input type="text" class="input-xlarge" style="width:10%;" value="" name="formCustoMedio" id="formCustoMedio">
						</div>
				</div>
			</div>
			<div class="form-actions form-background">
				<button type="button" class="btn btn-primary" id="formProduto_submit" onclick="cadastrarProduto();" name="formProduto_submit">Cadastrar</button>  
			</div>
			<input type="hidden" id="formIdProduto" value="">
		</fieldset>
	</form>
</body>
</html>
