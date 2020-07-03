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

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	
	<script src="../js/dhtmlgoodies_calendar.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<link href="../css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css"/>

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

	$("#form_submit_hospede").click(function() 
	{
		window.location = 'cadastro_hospede.php?formIdLastHosp=true&formDtInicial='+$('#formDtInicial').val();
	});

	cadastrarReservaHospede();
});
</script>
<style>
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
		<div id="lista" class="lista_info">
			<button type="button" style="padding: 5x 10px;" class="btn btn-menu" title="Listar" onclick='location="consulta_reservas.php"'><img src="../icones/listar.png" width="40px" height="50px"><br>Listar</button>
		</div>
	  	<div id="divImprimir">
				<form class="form-horizontal" enctype="multipart/form-data">
					<div class="control-group">
						<div class="controls">  
							<button id='push' type='button' onclick="imprimirFormularioReserva()" class='btn' title='Imprimir'><img src='../icones/print.png' width=25px height=25px>&nbsp;&nbsp;<strong>Imprimir</strong></button>
						</div>
					</div>
				</form>
		</div>


		<div class="control-group">
			<label class="control-label" for="formSelectHospede"><strong>Hóspede:<strong></label>
				<div class="controls">
					<select id="formSelectHospede" style="width:50%;" name="formSelectHospede">
					</select>
		
					<button class="btn" id="form_submit_hospede" name="form_submit_hospede" title="Novo Hóspede" type="button" >
						<img width="20px" height="20px" src="http://177.70.26.45/beaverpousada/icones/adicionar.png">
						<strong>Novo Hóspede</strong>
					</button>
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
			<label class="control-label" for="formValor"><strong>Novo valor:<strong></label>
				<div class="controls">
					<input type="text" class="input-large" name="formValor" id="formValor" disabled>
					<button class="btn" id="form_submit" name="form_submit" title="Adicionar" type="button" onclick="adicionarValorQuarto();">
						<img width="20px" height="20px" src="http://177.70.26.45/beaverpousada/icones/adicionar.png">
						<strong>Adicionar</strong>
					</button>
				</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formDtaReserva"><strong>Período de reserva:</strong></label>
			<div class="controls">  
				<input type="text" class="input-large" name="formDtInicial" id="formDtInicial">
				<img style="cursor:pointer" title='Calendário' onclick= "displayCalendar(document.getElementById('formDtInicial'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
				há
				<input type="text" class="input-large" name="formDtFinal" id="formDtFinal" onblur="verificaData('formDtInicial','formDtFinal');">
				<img style="cursor:pointer" title='Calendário' onclick= "displayCalendar(document.getElementById('formDtFinal'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formSelectTipoPagamento"><strong>Tipo de pagamento:<strong></label>
				<div class="controls">
					<select id="formSelectTipoPagamento" style="width:20%;" name="formSelectTipoPagamento">
						<option>Tipo de pagamento</option>
					</select>
				</div>
		</div>
		<div class="control-group" id="divCartao" style="display:none">
			<label class="control-label" for="formCartao"><strong>Número do cartão:</strong></label>
			<div class="controls">
				<input type="text" class="input-xlarge" name="formCartao" id="formCartao">
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
		<button type="submit" class="btn btn-primary" id="formReserva_submit" name="formReserva_submit">Cadastrar</button>  
	  </div>
	  <input type="hidden" id="formIdReserva" value="">
    </fieldset> 
</form>
</body>
</html>
