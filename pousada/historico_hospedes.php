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
var objectLabel_1 = 
[
	{"label":"Nome do hóspede","width":"17%"}
	,{"label":"Sexo","width":"8%"}
	,{"label":"Empresa","width":"12%"}
	,{"label":"Estado","width":"12%"}
	,{"label":"Cidade","width":"12%"}
	,{"label":"Bairro","width":"12%"}
	,{"label":"Endereço","width":"12%"}
	,{"label":"Data de nascimento","width":"12%"}
	,{"label":"","width":"5%"}
];

var objectConfig_1 = 
{
	'gridDiv' : 'tabelaHospede',
	 'width': 1000,
	 'class' : 'tabelaPadrao',
	 'border':1,
	 'print': "relHistoricoHp",
	 'id':'idhospede',
	 'colspan':11,
	 'crud':true,
	 'update':'cadastro_hospede.php',
	 'paddingLeft':'2%'
};

var objectLabel_2 = 
[
	{"label":"Quarto","width":"15%"}
	,{"label":"Data Inicial","width":"5%"}
	,{"label":"Data Final","width":"5%"}
	,{"label":"Opção","width":"5%"}
	,{"label":"Tipo de pagamento","width":"12%"}
	,{"label":"Valor diário","width":"10%"}
	,{"label":"Total das diárias","width":"8%"}
	,{"label":"Desconto","width":"8%"}
	,{"label":"A pagar","width":"8%"}
	,{"label":"Total pago","width":"8%"}
	,{"label":"Total da fatura","width":"8%"}
	,{"label":"","width":"7%"}
];

var objectLink  =  
[
	{"link":"idreserva|idhospede","value":"nomequarto","pagina":"../relatorio/relVendaHospede.php"}
];

var objectHideTable = 
[
	{"value":"idhospede"},
	{"value":"desconto"}
];

var objectConfig_2 	= 
{
	'gridDiv' : 'tabelaReservas',
	'width': 1000,
	'class' : 'tabelaPadrao',
	'border':1,
	'id':'idreserva',
	'pagamento':'addHidenPagamento',
	//'lista':'consulta_pagamento.php',
	'colspan':9,
	'efect':false,
	'crud':true,
	'paddingLeft':'8%',
	'objectLink':objectLink,
	'objectHideTable':objectHideTable,
	'printDetails': 'mostrarPagamentos',
	'discount':'descontoReserva'
};

var objectLabel_3 = 
[
	{"label":"Categoria","width":"25%"}
	,{"label":"Produto","width":"25%"}
	,{"label":"Quantidade","width":"15%"}
	,{"label":"Valor","width":"25%"}
	,{"label":"Data da venda","width":"25%"}
];

var objectConfig_3 = 
{
	'gridDiv' : 'tabelaVendas',
	'width': 800,
	'class' : 'tabelaPadrao',
	'border':1,
	'id':'idhospede',
	'paddingLeft':'0%',
	'title':'Histórico de vendas',
	'colspan':4,
	'crud':false
};

function addCheque()
{
	var html  = '';

	html  = '';
	html += '<br><br><br>';
	html += '<div style="width:100%;position:relative;">';
	html += '		<div  class="classCheque">';
	html += '			<input type="text"  title="Data" style="width:90%" class="input-xlarge" name="formDataCheque[]" id="formDataCheque[]">';
			html += '		</div>';
					html += '<div  class="classCheque">';
						html += '<input type="text"  title="Numero" style="width:90%" class="input-xlarge" name="formNumeroCheque[]" id="formNumeroCheque[]">';
					html += '</div>';
					html += '<div   class="classCheque">';
						html += '<input type="text"  title="Valor" style="width:90%" class="input-xlarge" name="formValorCheque[]" id="formValorCheque[]">';
					html += '</div>';
				html += '</div>';
			html += '</div>';
	$("#cont_cheque").append(html);

	var valor   = 0;
	var valor_2 = 0;

	$("input[type=text][name='formValorCheque[]']").each(function(i)
	{
		if($(this).val())
		{
			valor = $(this).val().replace(',','.');
			valor = parseFloat(valor).toFixed(2);

			if(valor_2 == 0)
				valor_2 = valor;
			else
				valor_2 = (parseFloat(valor_2)+parseFloat(valor));
		}

		$(this).priceFormat({
					prefix: '',
					centsSeparator: ',',
					thousandsSeparator: '.'
		});

	});

	$("input[type=text][name='formDataCheque[]']").each(function(i)
	{
		var ind = ($("input[type=text][name='formDataCheque[]']").length - 1);
		if(i == ind)
			$(this).mask("99/99/9999");
	});

	$("#formTotalCheque").val("R$ "+valor_2.toString().replace('.',','));
}

$(document).ready(function(){
	var jq17 = jQuery.noConflict();
	
	$('#formValorPagamento').priceFormat({
		prefix: '',
		centsSeparator: ',',
		thousandsSeparator: '.'
	});

	$('#formValor').priceFormat({
		prefix: '',
		centsSeparator: ',',
		thousandsSeparator: '.'
	});

	$('#formPagamento').priceFormat({prefix: '',centsSeparator: ',',thousandsSeparator: '.'});
	$("#formData").mask("99/99/9999");

	montaCombo('formSelectTransferencia','selectTransferencia');
	montaCombo('formSelecDpAntecipado','selectDpAntecipado');

	getJsonSelect('selectHistoricoHospede',$.query.get('idhospede'),objectConfig_1,objectLabel_1);
	getJsonSelect('selectHistoricoReserva',$.query.get('idhospede'),objectConfig_2,objectLabel_2);

});
</script>
<body>
<div>
<?php include "../topo.php"; ?>
</div>
<style>

.classCheque {
	float:left;
	position:relative;
	padding: 5x 10px;
	margin-left:10px;
}

</style>
<div style="margin-left:10px;" >
  <input type="image" src="../icones/volta.png" name="image" width="40" height="40" onclick="javascript:history.go(-1);"> <strong>Voltar</strong>
</div>
<br>

<fieldset class='moldura fieldAlertaLista'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Histórico do Hóspede</strong></center></legend>
	<fieldset class='moldura fieldAlertaLista'>
		<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Informações</strong></center></legend>
		<div id="tabelaHospede" style="width:98%;margin:0px 1%;"></div>
	</fieldset>
	<br>
	<fieldset class='moldura fieldAlertaLista'>
		<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de Reservas</strong></center></legend>
		<div id="tabelaReservas" style="width:98%;margin:0px 1%;"></div>
	</fieldset>
	<br>
<!--
	<fieldset class='moldura fieldAlertaLista'>
		<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Consumo</strong></center></legend>	
		<div id="tabelaVendas" style="width:98%;margin:0px 1%;"></div>
	</fieldset>
	-->
</fieldset>

<div id="myModalDesconto" style='margin-left:-30%;width:60%'  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header" >
		<h4 id="myModalLabel" ></h4>
	</div>
	<div class="modal-body">
		<div class="divDialogElements">
			<form action="viewPousada.php" name="inserirDesconto" id="inserirDesconto" method="POST" class="form-horizontal" enctype="multipart/form-data">
			  <fieldset class='moldura fieldAlerta'>
				<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de desconto</strong></center></legend>
				<div class="control-group">
					<label class="control-label" for="formValor"><strong>Valor do desconto:</strong></label>  
					<div class="controls">  
						<input type="text" style="width:30%;" class="input-large" name="formValor" id="formValor">
					</div>
				</div>
				</fieldset> 
			</form>

		</div>
	</div>
	<div class="modal-footer form-background">
		<a class="btn" onclick="closeDialogDesconto();" href="#">Cancelar</a>
		<a class="btn btn-primary" onclick="cadastrarDesconto();" href="#">Confirmar</a>
	</div>
	<div class="modal-footer"></div>
</div>

<div id="myModal" style='margin-left: -40%; width: 80%;'  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header" >
		<h4 id="myModalLabel" ></h4>
	</div>
	<div class="modal-body" style="max-height:500px;padding:5px">
	<div class="divDialogElements">
		<form action="viewPousada.php" name="inserirPagamento" id="inserirPagamento" method="POST" class="form-horizontal" enctype="multipart/form-data">
			  <fieldset class='moldura fieldAlerta'>
				<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Pagamento</strong></center></legend>
				<div id="erros" class="erros"></div>
				<div class="control-group">
					<div class="controls">
						<button id="push" class="btn" title="Imprimir" onclick="window.location ='http://localhost/beaverPousada/relatorio/relVendaHospede.php?rel=HistoricoHp&idreserva=<?php echo $_GET['idreserva']?>&idhospede=<?php echo $_GET['idhospede']?>'" type="button">
							<img width="25px" height="25px" src="../icones/print.png">
							<strong>Imprimir</strong>
						</button>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formSelectTransferencia"><strong>Tipo de pagamento:<strong></label>
					<div class="controls">
						<select id="formSelectTransferencia" style="width:63%;" name="formSelectTransferencia">
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formSelecDpAntecipado"><strong>Forma de pagamento:<strong></label>
					<div class="controls">
						<select id="formSelecDpAntecipado" style="width:63%;" name="formSelecDpAntecipado" onchange="habilitarFormaPagamamento(this.value);">
						</select>
					</div>
				</div>
				<div class="control-group" id="divDataPagamento" style="display:none">
					<label class="control-label" for="formData"><strong>Data efetuada:</strong></label>
					<div class="controls">
						<input type="text" class="input-large" name="formData" id="formData" value="<?php echo date("d/m/Y");?>">
					</div>
				</div>
				<div class="control-group" id="divTipoCartao" style="display:none">
					<div class="controls">  
						<input type="radio" onclick="habilitaCartoes('D')" id="opcao[]" name="opcao" value="D" checked> Débito
						<input type="radio" onclick="habilitaCartoes('C')" id="opcao[]" name="opcao" value="C"> Crédito
					</div>
				</div>
				<div class="control-group" id="divCartao" style="display:none">
					<label class="control-label" for="formSelectCartao"><strong>Bandeira:</strong></label>
					<div class="controls">
						<select id="formSelectCartao" style="width:63%;" name="formSelectCartao" onchange="selectComboParcelas(this.value);">
						</select>
					</div>
				</div>
				<div class="control-group" id="divParcelas" style="display:none">
					<label class="control-label" for="formSelectParcelas"><strong>Parcelas:</strong></label>
					<div class="controls">
						<select id="formSelectParcelas" disabled style="width:63%;" name="formSelectParcelas">
							<option value="">-- Selecione --</option>
						</select>
					</div>
				</div>
				<div class="control-group" id="divValorPagamento" style="display:none">
					<label class="control-label" for="formValorPagamento"><strong>Valor do pagamento:</strong></label>
					<div class="controls">
						<input type="text" class="input-xlarge" name="formValorPagamento" id="formValorPagamento">
					</div>
				</div>
		<div id="divCheque" style="display:none;width:110%;">
			  <fieldset class='moldura fieldAlerta'>
				<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cheques</strong></center></legend>
				

				<div  class="control-group"  style="margin-left: 7%">
					<div style="width:100%;position:relative;">				
						<div style="float:left;position:relative;padding: 5x 10px;margin-left:10px;">
							<select id="formSelectBanco" name="formSelectBanco" style="width:100%;">
							</select>
						</div>
				
						<div  style="float:left;position:relative;padding: 5x 10px;margin-left:57px;">
							<input type="text" value="R$ 0,00" disabled title="Total em cheques" style="width:60%" class="input-xlarge" name="formTotalCheque" id="formTotalCheque">
						</div>
					</div>
				</div>
				
				<div  class="control-group"  style="margin-left: 7%" id="cont_cheque">
					<div style="width:100%;position:relative;">
						<div  class="classCheque">
							<input type="text"  title="Data" style="width:90%" class="input-xlarge" name="formDataCheque[]" id="formDataCheque[]">
						</div>
						<div  class="classCheque">
							<input type="text"  title="Numero" style="width:90%" class="input-xlarge" name="formNumeroCheque[]" id="formNumeroCheque[]">
						</div>
					
						<div   class="classCheque">
							<input type="text"  title="Valor" style="width:90%" class="input-xlarge" name="formValorCheque[]" id="formValorCheque[]">
						</div>
						<!--
						<div   class="classCheque">
							<button class="btn" id="form_submit_hospede" style="width:90%" name="form_submit_hospede" title="" type="button" onclick='addCheque();'>
							<img width="20px" height="20px" src="http://177.70.26.45/beaverpousada/icones/adicionar.png">
							</button>
						</div>
						-->
						<div   class="classCheque">
							<button class="btn" id="form_submit_hospede" style="width:90%" name="form_submit_hospede" title="Novo Hóspede" type="button" >
							<img width="20px" height="20px" src="http://177.70.26.45/beaverpousada/icones/adicionar.png">
							</button>
						</div>
					</div>
			</fieldset>
		</div>
		
		<div id="divDeposito" style="display:none">
			<div class="control-group" >
				<label class="control-label" for="formSelectDepBanco"><strong>Banco:</strong></label>
				<div class="controls">
					<select id="formSelectDepBanco" name="formSelectDepBanco" style="width:63%;">
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
					<select id="formSelectTipoConta" name="formSelectTipoConta" style="width:63%;">
						<option value="">-- Tipo --</option>
						<option value="C">Corrente</option>
						<option value="P">Poupança</option>
					</select>
				</div>
			</div>
		</div>
	</div>
		<div class="modal-footer form-background" >
			<button type="button" onclick="cadastrarPagamento()" class="btn btn-primary" id="formPagamento_submit" name="formPagamento_submit">Cadastrar</button>
			<a class="btn" onclick="closeDialogPagamento();" href="#">Cancelar</a>
		</div>
		<input type="hidden" id="formIdReserva" value="">
	</form>
	<div class="modal-footer"></div>
</div>

</body>
</html>