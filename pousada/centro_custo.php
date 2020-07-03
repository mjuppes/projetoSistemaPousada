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

	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.bgiframe.min.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/thickbox-compressed.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/jquery.autocomplete.js"></script>
	<link  href="../js/jquery-autocomplete/jquery.autocomplete.css" rel="stylesheet" type="text/css">

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>	

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
	<script src="../js/dhtmlgoodies_calendar.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<link href="../css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css"/>

</head>
<script>
var objectLabel =
[
	{"label":"Sub-Categoria","width":'40%'},
	{"label":"Descrição","width":'50%'}
];

var objectConfig =
{
	'gridDiv' : 'tabelaSubCentro',
	'width': 700,
	'id':'id_sub_cat_centro',
	'border':1,
	'colspan':5
};

$(document).ready(function(){
	var jq17 = jQuery.noConflict();
	$("#formData").mask("99/99/9999");
	$('#formValorPagamento').priceFormat({
		prefix: '',
		centsSeparator: ',',
		thousandsSeparator: '.'
	});

	$("#formSelectCategoria").change(function()
	{
		if($("#formSelectCategoria").val())
		{
			$('#formSelectSubCategoria').attr('disabled',false);
			montaCombo('formSelectSubCategoria','selectSubCentroCombo',$("#formSelectCategoria").val());
			$('#form_submit_cat').attr('disabled',false);
		}
		else
		{
			$("#formSelectSubCategoria").html("<option value=''>-- Selecione --</option>");
			$('#formSelectSubCategoria').attr('disabled',true);
			$('#form_submit_cat').attr('disabled',true);
		}
	});	
	montaCombo('formSelectCategoria','selectCatCentro');
	montaCombo('formSelecFormPagamento','selectFormaPagamento');
	montaCombo('formSelectFornecedor','selectFornecedor');
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
<form action="viewPousada.php" name="formInserirCentroCusto" id="formInserirCentroCusto" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset class='moldura fieldAlerta'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro Contas a Pagar</strong></center></legend>
			<div class="control-group">
				<label class="control-label" for="formSelectCategoria"><strong>Categoria:<strong></label>
				<div class="controls">
					<select id="formSelectCategoria" style="width:50%;" name="formSelectCategoria" onchange="">
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectSubCategoria"><strong>Sub-Categoria:<strong></label>
				<div class="controls">
					<select id="formSelectSubCategoria" style="width:50%;" name="formSelectSubCategoria" disabled>
						<option value=''>-- Selecione --</option>
					</select>
					<button class="btn" disabled id="form_submit_cat" name="form_submit_cat" title="Nova Categoria" type="button" onclick="cadastrarSubCatCentro();" >
					<img width="20px" height="20px" src="http://177.70.26.45/beaverpousada/icones/adicionar.png">
					<strong>Adicionar</strong>
					</button>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectFornecedor"><strong>Fornecedor:<strong></label>
				<div class="controls">
					<select id="formSelectFornecedor" style="width:50%;" name="formSelectFornecedor" onchange="buscaInfoContaFornecedor(this.value);">
					</select>
				</div>
			</div>
			<!-- Info Conta -->
			<div id="divInfoConta" style="display:none">
				<div class="control-group">
					<label class="control-label" for="formBanco"><strong>Banco:</strong></label>
					<div class="controls">
						<input type="text" disabled class="input-xlarge" name="formBanco" id="formBanco">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formAgencia"><strong>Agência:</strong></label>
					<div class="controls">
						<input type="text" disabled class="input-xlarge" name="formAgencia" id="formAgencia">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formConta"><strong>Conta:</strong></label>
					<div class="controls">
						<input type="text" disabled class="input-xlarge" name="formConta" id="formConta">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formTipoConta"><strong>Tipo:</strong></label>
					<div class="controls">
						<input type="text" disabled class="input-xlarge" name="formTipoConta" id="formTipoConta">
					</div>
				</div>
			</div>
			<!--  -->
			
			<div class="control-group">
				<label class="control-label" for="formSelecFormPagamento"><strong>Forma de pagamento:<strong></label>
				<div class="controls">
					<select id="formSelecFormPagamento" style="width:50%;" name="formSelecFormPagamento" onchange="habilitarFormaPagamentoCP(this.value);">
					</select>
				</div>
			</div>
			<!-- Cartão -->
			<div class="control-group" id="divTipoCartao" style="display:none">
					<div class="controls">  
						<input type="radio" onclick="habilitaCartoes('D')" id="opcao[]" name="opcao" value="D" checked> Débito
						<input type="radio" onclick="habilitaCartoes('C')" id="opcao[]" name="opcao" value="C"> Crédito
					</div>
				</div>
				<div class="control-group" id="divCartao" style="display:none">
					<label class="control-label" for="formSelectCartao"><strong>Bandeira:</strong></label>
					<div class="controls">
						<select id="formSelectCartao" style="width:50%;" name="formSelectCartao" onchange="selectComboParcelas(this.value);">
						</select>
					</div>
				</div>
				<div class="control-group" id="divParcelas" style="display:none">
					<label class="control-label" for="formSelectParcelas"><strong>Parcelas:</strong></label>
					<div class="controls">
						<select id="formSelectParcelas" disabled style="width:50%;" name="formSelectParcelas">
							<option value="">-- Selecione --</option>
						</select>
					</div>
				</div>
			<!-------->
			
			<!--- Depósito -->
				<div id="divDeposito" style="display:none">
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
				</div>
			</div>
			<!-- -->			
			<div class="control-group">
				<label class="control-label" for="formData"><strong>Data:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge" class="input-large" name="formData" id="formData">
					<img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formData'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formValorPagamento"><strong>Valor:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge" class="input-large" name="formValorPagamento" id="formValorPagamento">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formDescricao"><strong>Descrição:</strong></label>  
				<div class="controls">
					<textarea class="input-xlarge" name="formDescricao" id="formDescricao" cols="50" rows="10"></textarea>  
				</div>
			</div>
			<div class="form-actions form-background">
				<button type="button" class="btn btn-primary" id="form_submit" name="form_submit" onclick="cadastrarCentroCusto();">Cadastrar</button>
			</div>
			<input type="hidden" id="formIdCatCentro" value="">
        </fieldset> 
</form>

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
