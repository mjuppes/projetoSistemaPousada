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
	<script src="../js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	
	<script src="../js/msg_js/alertify.js"></script>
	<link rel="stylesheet" href="../js/msg_js/css/alertify.css" />
	<link rel="stylesheet" href="../js/msg_js/css/themes/default.css" />

	<script src="../js/select-autocomplete/dist/bundle.min.js"></script>

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	
	<script src="../js/dhtmlgoodies_calendar.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<link href="../css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css"/>
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<script>

function dataAtualFormatada()
{
    var data = new Date();

    var dia = data.getDate();

    if(dia.toString().length == 1)
		dia = "0"+dia;

    var mes = data.getMonth()+1;

    if(mes.toString().length == 1)
		mes = "0"+mes;

    var ano = data.getFullYear();

    return dia+"/"+mes+"/"+ano;
}

function daysInMonth(month,year)
{
	var m = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

	if (month != 2) 
		return m[month - 1];
	if (year % 4 != 0) 
		return m[1];
	if (year % 100 == 0 && year%400 != 0) return m[1];

	return m[1] + 1;
}


$(document).ready(function(){
	var jq17 = jQuery.noConflict();

	$("#formReserva_submit").click( function(){
		cadastrarReservaHospede();
		}
	);

	if($.query.get('idreserva') && $.query.get('editar'))
		carregaJsonHospedes($.query.get('idreserva'));
	else
		carregaJsonHospedes(false);
	
	var data1 = dataAtualFormatada();

	var data = new Date();

	$('#form_submit').attr('disabled',true);
	
	$('#formValor').priceFormat({
		prefix: '',
		centsSeparator: ',',
		thousandsSeparator: '.'
	});

	$("#formDtInicial").mask("99/99/9999");
	$("#formDtFinal").mask("99/99/9999");

	$("#formDtInicial").val(data1);

	if($.query.get('idreserva') && $.query.get('editar'))
	{
		updateReservaHospede($.query.get('idreserva'));
		return;
	}

	$("#formSelectTipoPagamento" ).change(function() {
		if($(this).val() == 1)
			$("#divCartao").show();
		else
			$("#divCartao").hide();
	});

	if(!$.query.get('idhospede'))
		montaCombo('formSelectHospede','selectHospede');
	else
		montaCombo('formSelectHospede','selectHospede',$.query.get('idhospede'));
	
	if($.query.get('idquarto'))
	{
		montaCombo('formSelectQuarto','selectQuartoCombo',$.query.get('idquarto'));
		$('#formSelectValor').attr('disabled',false);
		montaCombo('formSelectValor','selectValorQuarto',$.query.get('idquarto'));
		$('#formValor').attr('disabled',false);
		$('#form_submit').attr('disabled',false);
	}
	else
		montaCombo('formSelectQuarto','selectQuartoCombo');

	montaCombo('formSelectOpcaoQuarto','selectOpcaoQuarto');
	montaCombo('formSelectTipoPagamento','selectTipoPagemento');

	$('#formCapacidade').attr('disabled',true);

	if($.query.get('formDtInicial'))
		$('#formDtInicial').val($.query.get('formDtInicial'))

	/*
		$("#form_submit_hospede").click(function() 
		{
			window.location = 'cadastro_hospede.php?formIdLastHosp=true&formDtInicial='+$('#formDtInicial').val();
		});
	*/

});
</script>
 <style>
      body {
        font-family: "Roboto", sans-serif;
      }

      .select-wrapper {
        margin: auto;
        max-width: 600px;
        width: calc(100% - 40px);
      }

      .select-pure__select {
        align-items: center;
        background: #f9f9f8;
        border-radius: 4px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        box-sizing: border-box;
        color: #363b3e;
        cursor: pointer;
        display: flex;
        font-size: 16px;
        font-weight: 500;
        justify-content: left;
        min-height: 44px;
        padding: 5px 10px;
        position: relative;
        transition: 0.2s;
        width: 50%;
      }

      .select-pure__options {
        border-radius: 4px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        box-sizing: border-box;
        color: #363b3e;
        display: none;
        left: 0;
        max-height: 221px;
        overflow-y: scroll;
        position: absolute;
        top: 50px;
        width: 100%;
        z-index: 5;
      }

      .select-pure__select--opened .select-pure__options {
        display: block;
      }

      .select-pure__option {
        background: #fff;
        border-bottom: 1px solid #e4e4e4;
        box-sizing: border-box;
        height: 44px;
        line-height: 25px;
        padding: 10px;
      }

      .select-pure__option--selected {
        color: #e4e4e4;
        cursor: initial;
        pointer-events: none;
      }

      .select-pure__option--hidden {
        display: none;
      }

      .select-pure__selected-label {
        background: #5e6264;
        border-radius: 4px;
        color: #fff;
        cursor: initial;
        display: inline-block;
        margin: 5px 10px 5px 0;
        padding: 3px 7px;
      }

      .select-pure__selected-label:last-of-type {
        margin-right: 0;
      }

      .select-pure__selected-label i {
        cursor: pointer;
        display: inline-block;
        margin-left: 7px;
      }

      .select-pure__selected-label i:hover {
        color: #e4e4e4;
      }

      .select-pure__autocomplete {
        background: #f9f9f8;
        border-bottom: 1px solid #e4e4e4;
        border-left: none;
        border-right: none;
        border-top: none;
        box-sizing: border-box;
        font-size: 16px;
        outline: none;
        padding: 10px;
        width: 100%;
		height: 40px;
      }
    </style>
<body>
<div>
<?php include "../topo.php"; ?>	
</div>
<div style="margin-left:10px;" >
  <input type="image" src="../icones/volta.png" name="image" width="40" height="40" onclick="javascript:history.go(-1);"> <strong>Voltar</strong>
</div>
<br>
<div class="erros"></div>
<form action="viewPousada.php" name="formInserirReserva" id="formInserirReserva" method="POST" class="form-horizontal" enctype="multipart/form-data">
 <fieldset class='moldura fieldAlerta'>
 	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Reserva</strong></center></legend>
	  	<div id="divImprimir">
				<form class="form-horizontal" enctype="multipart/form-data">
					<div class="control-group">
						<div class="controls">  
							<button id='push' type='button' onclick="imprimirFormularioReserva()" class='btn' title='Imprimir'><img src='../icones/print.png' width=25px height=25px>&nbsp;&nbsp;<strong>Imprimir</strong></button>
						</div>
					</div>
				</form>
		</div>

		<div class="control-group" id="divAutoComplete">
			<label class="control-label" for="formSelectHospede"><strong>Hóspede:<strong></label>
			<div class="controls">
				<span id="autocomplete-select-hospede" class="autocomplete-select" style="width:70%"></span>
			</div>
			
			<!--
			<button class="btn" id="form_submit_hospede" name="form_submit_hospede" title="Novo Hóspede" type="button" >
				<img width="20px" height="20px" src="http://177.70.26.45/beaverpousada/icones/adicionar.png">
				<strong>Novo Hóspede</strong>
			</button>
			-->
		</div>
		<div class="control-group">
			<div class="controls">
				<select multiple id="formSelectHospSelecionado"  style="width:50%;" name="formSelectHospSelecionado">
				</select>
				<a href="#" id="idLinkRemove" style="display:none" onclick="removeOptionReserva('formSelectHospSelecionado');">Remover</a>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formSelectQuarto"><strong>Quarto:<strong></label>
				<div class="controls">
					<select id="formSelectQuarto" style="width:50%;" name="formSelectQuarto" onchange="carregaValor(this.value);">
						<option value="">-- Selecione --</option>
					</select>
				</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formSelectValor"><strong>Valor aplicado:<strong></label>
				<div class="controls">
					<select id="formSelectValor" style="width:20%;" name="formSelectValor" disabled >
						<option value="">-- Selecione --</option>
					</select>
					
				</div>
		</div>
		
		<div class="control-group">
				<div class="controls">
					<input type="text" class="input-large" name="formValor" id="formValor" value="" disabled>
					<button class="btn" id="form_submit" name="form_submit" title="Adicionar" type="button" onclick="adicionarValorQuarto();">
						<img width="20px" height="20px" src="http://177.70.26.45/beaverpousada/icones/adicionar_old.png">
						<strong>Outro Valor</strong>
					</button>
				</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="formDtaReserva"><strong>Período de reserva:</strong></label>
			<div class="controls">  
				<input type="text" class="input-large" name="formDtInicial" id="formDtInicial">
				<img style="cursor:pointer" title='Calendário' onclick= "displayCalendar(document.getElementById('formDtInicial'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
				até
				<input type="text" class="input-large" name="formDtFinal" id="formDtFinal" onblur="verificaData('formDtInicial','formDtFinal');">
				<img style="cursor:pointer" title='Calendário' onclick= "displayCalendar(document.getElementById('formDtFinal'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formOpcao"><strong>Pagamento:</strong></label>
			<div class="controls">  
				<input type="radio" id="opcao[]" name="opcao" value="F" checked> Hóspede
				<input type="radio" id="opcao[]" name="opcao" value="J"> Empresa
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="formSelectOpcaoQuarto"><strong>Opção de quarto<strong></label>
				<div class="controls">
					<select id="formSelectOpcaoQuarto" style="width:20%;" name="formSelectOpcaoQuarto">
					</select>
				</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formObservacao"><strong>Observações:</strong></label>  
			<div class="controls">  
				<textarea class="input-xlarge" name="formObservacao" id="formObservacao" rows="3"></textarea>  
			</div>
		</div>
	  <div class="form-actions form-background">
		<button type="button" class="btn btn-primary" id="formReserva_submit" name="formReserva_submit">Cadastrar</button>  
	  </div>
	  <input type="hidden" id="formIdReserva" value="">
    </fieldset> 
</form>
</body>
</html>
