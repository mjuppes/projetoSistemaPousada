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
	<link rel="stylesheet" href="../js/msg_js/css/alertify.css" />
	<link rel="stylesheet" href="../js/msg_js/css/themes/default.css" />

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
		{"label":"","width":"5%"}
		,{"label":"Sub-Categoria","width":"20%"}
		,{"label":"Categoria","width":"20%"}
		,{"label":"Valor","width":"10%"}
		,{"label":"Data de Pagamento","width":"20%"}
		,{"label":"Data de Cadastro","width":"20%"}
		,{"label":"","width":"10%"}
	];

	var objectConfig = 
	{
		'gridDiv' : 'tabelaCentroCusto',
		'width': 500,
		'class' : 'tabelaPadrao',
		'border':1,
		'id':'id_centro_custo',
		'colspan':6,
		'crud':true,
		'push':'centro_custo.php',
		'print':'imprimirListaCentroCusto',
		'checkbox': true,
		'checkTitle': 'Confirmar Pagamento',
		'checkImg': 'pagar.png',
		'checkFunction':'confirmarPagamentoCP',
		'visualize':"visualizarCP"
	};

	$(document).ready(function(){
		var jq17 = jQuery.noConflict();

		$("#formDtInicial").mask("99/99/9999");
		$("#formDtFinal").mask("99/99/9999");

		$("#formSelectCategoria").change(function()
		{
			if($("#formSelectCategoria").val())
			{
				$('#formSelectSubCategoria').attr('disabled',false);
				montaCombo('formSelectSubCategoria','selectSubCentroCombo',$("#formSelectCategoria").val());
			}
			else
			{
				$("#formSelectSubCategoria").html("<option value=''>-- Selecione --</option>");
				$('#formSelectSubCategoria').attr('disabled',true);
			}
		});
		
		
		montaCombo('formSelectCategoria','selectCatCentro');
		getJsonSelect('selectCentroCustoTable',false,objectConfig,objectLabel,false,10);
		
		$("#push").attr('style','width:30%');

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

<form  name="formInserirCidade" id="formInserirCidade" method="POST" class="form-horizontal" enctype="multipart/form-data">
	<fieldset  class='moldura fieldAlertaLista'>
		<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Pesquisa Contas a Pagar</strong></center></legend>
		<div class="control-group">
			<label class="control-label" for="formSelectCategoria"><strong>Categoria:<strong></label>
			<div class="controls">
				<select id="formSelectCategoria" style="width:32%;" name="formSelectCategoria">
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formSelectSubCategoria"><strong>Sub-Categoria:<strong></label>
			<div class="controls">
				<select id="formSelectSubCategoria" disabled style="width:32%;" name="formSelectSubCategoria">
					<option value=''>-- Selecione --</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formSelectSit"><strong>Situação:<strong></label>
			<div class="controls">
				<select id="formSelectSit" style="width:32%;" name="formSelectSit">
					<option value='1'>Pendente</option>
					<option value='2'>Pago</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formDtInicial">
				<strong>Data Inicial:</strong>
			</label>
			<div class="controls">  
				<input type="text" class="input-large" name="formDtInicial" id="formDtInicial">
				<img style="cursor:pointer" title='Calendário' onclick= "displayCalendar(document.getElementById('formDtInicial'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formDtFinal">
				<strong>Data Final:</strong>
			</label>
			<div class="controls"> 
				<input type="text" class="input-large" name="formDtFinal" id="formDtFinal" onblur="verificaData('formDtInicial','formDtFinal');">
				<img style="cursor:pointer" title='Calendário' onclick= "displayCalendar(document.getElementById('formDtFinal'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
			</div>
		</div>

		<div class="form-actions">
			<button type="button" onclick="buscarTabelaContasPagar()" class="btn" title="Buscar">
			<img src="../icones/busca.png" width="25px" height="20px">
			<strong>Buscar</strong></button>
		</div>
	</fieldset> 
</form>

<fieldset class='moldura fieldAlertaLista'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de Contas a Pagar</strong></center></legend>
	<div id="tabelaCentroCusto" style="width:99%;margin:0px 0.5%;"></div>
</fieldset>


<div style="width:100%">
	<div id="myModalInfoCP" style='margin-left:-40%;width:80%;'  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header" >
			<h4 id="myModalLabel" ></h4>
		</div>
		<div class="modal-body">
			<form action="viewPousada.php" name="formCatCentroCusto" id="formCatCentroCusto" method="POST" class="form-horizontal" enctype="multipart/form-data">
				<fieldset class='moldura fieldAlerta' style="width:98%">
					<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Informações Contas a Pagar</strong></center></legend>
					<div class="control-group">
						<label class="control-label" for="formCategoria"><strong>Categoria:</strong></label>
						<div class="controls">  
							<input type="text" disabled class="input-xlarge" style="width:48%;" name="formCategoria" id="formCategoria">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="formSubCategoria"><strong>Sub-Categoria:</strong></label>
						<div class="controls">  
							<input type="text" disabled class="input-xlarge" style="width:48%;" name="formSubCategoria" id="formSubCategoria">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="formValor"><strong>Valor:</strong></label>
						<div class="controls">  
							<input type="text" disabled class="input-xlarge" style="width:48%;" name="formValor" id="formValor">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="formDataPagamento"><strong>Data do Pagamento:</strong></label>
						<div class="controls">  
							<input type="text" disabled class="input-xlarge" style="width:48%;" name="formDataPagamento" id="formDataPagamento">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="formDataCadastro"><strong>Data do Cadastro:</strong></label>
						<div class="controls">  
							<input type="text" disabled class="input-xlarge" style="width:48%;" name="formDataCadastro" id="formDataCadastro">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="formTipoPagamento"><strong>Tipo Pagamento:</strong></label>
						<div class="controls">  
							<input type="text" disabled class="input-xlarge" style="width:48%;" name="formTipoPagamento" id="formTipoPagamento">
						</div>
					</div>
					<!-- Cartão -->
					<div id="divTipoCartCP" style="display:none">
						<div class="control-group">
							<label class="control-label" for="formBandeiraC"><strong>Cartão:</strong></label>
							<div class="controls">  
								<input type="text" disabled class="input-xlarge" style="width:48%;" name="formBandeiraC" id="formBandeiraC">
							</div>
						</div>
					</div>
					<!-- -->
					<!-- Depósito -->
					<div id="divTipoDepositoCP" style="display:none">
						<div class="control-group">
							<label class="control-label" for="formBanco"><strong>Banco:</strong></label>
							<div class="controls">  
								<input type="text" disabled class="input-xlarge" style="width:48%;" name="formBanco" id="formBanco">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="formAgencia"><strong>Agência:</strong></label>
							<div class="controls">  
								<input type="text" disabled class="input-xlarge" style="width:48%;" name="formAgencia" id="formAgencia">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="formConta"><strong>Conta:</strong></label>
							<div class="controls">  
								<input type="text" disabled class="input-xlarge" style="width:48%;" name="formConta" id="formConta">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="formTipoConta"><strong>Tipo Conta:</strong></label>
							<div class="controls">  
								<input type="text" disabled class="input-xlarge" style="width:48%;" name="formTipoConta" id="formTipoConta">
							</div>
						</div>
					</div>
					<!-- -->
					<div class="control-group">
						<label class="control-label" for="formDescricao"><strong>Descrição:</strong></label>  
						<div class="controls">  
							<textarea   disabled style="width:50%;" class="input-xlarge" name="formDescricao" id="formDescricao" rows="3"></textarea>  
						</div>
					</div>
					<br>
				</fieldset> 
			</form>
		</div>
		<div class="modal-footer"></div>
	</div>
</div>

</body>
</html>