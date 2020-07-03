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

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>


	<script src="../js/dhtmlgoodies_calendar.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<link href="../css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css"/>

</head>
<script>
$(document).ready(function(){
	var jq17 = jQuery.noConflict();

	
	if($.query.get('reserva')){}
		

	$("#formDta").mask("99/99/9999");
	$("#formDtaNascimento").mask("99/99/9999");
	$("#formDtaChegada").mask("99/99/9999");

	montaCombo('formSelectAgencia','selectAgenciaCombo');
	montaCombo('formSelectMotivo','selectMotivoCombo');
	montaCombo('formSelectPais','selectPais');
	
	
	$('#formSelectEstado').attr('disabled',true);
	$('#formSelectCidade').attr('disabled',true);

	$("#formSelectEstado").bind("change",function()
	{
		if($("#formSelectEstado").val() == "")
		{
			$("#formSelectCidade").html("<option>Selecione uma cidade</option>");
			$("#formSelectCidade").attr('disabled',true);
			return;
		}

		montaCombo('formSelectCidade','selectCidade',$("#formSelectEstado").val());
		$("#formSelectCidade").attr('disabled',false);
	});

	$("#formSelectPais").bind("change",function()
	{
		$('#formSelectEstado').attr('disabled',false);
		montaCombo('formSelectEstado','selectEstado',$("#formSelectPais").val());
	});
	

	if($.query.get('idhospede') && $.query.get('editar'))
	{
		updateHospede($.query.get('idhospede'));
		return;
	}

	
	if($.query.get('formIdLastHosp'))
		$('#formIdLastHosp').val($.query.get('formIdLastHosp'));
	
	$("#formSelectCidade").attr('disabled',true);
	cadastrarHospede();

	$("#formCpf").mask("999.999.999-99");

	$("#formRg").mask("9999999999");
	$("#formDtInicial").mask("99/99/9999");
	$("#formDtFinal").mask("99/99/9999");
	$("#formDtaReserva").mask("99/99/9999");
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
	<fieldset class='moldura fieldAlerta' >
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Hóspede</strong></center></legend>
	<div id="divImprimir">
		<form class="form-horizontal" enctype="multipart/form-data">
			<div class="control-group">
				<div class="controls">  
					<button id='push' type='button' onclick="imprimirFormulario()" class='btn' title='Imprimir'><img src='../icones/print.png' width=25px height=25px>&nbsp;&nbsp;<strong>Imprimir</strong></button>
				</div>
			</div>
		</form>
	</div>
	
		<div id="divOpcao">
			<form class="form-horizontal" enctype="multipart/form-data">
				<div class="control-group">
					<label class="control-label" for="formDta"><strong>Escolha uma opção:</strong></label>
					<div class="controls">  
						<input type="radio" name="opcao" id="opcao[]" value="F" onclick="habilitarDiv(this.value)"> Pessoa Física
						<input type="radio" name="opcao" id="opcao[]" value="J" onclick="habilitarDiv(this.value)"> Pessoa Jurídica
					</div>
				</div>
			</form>
		</div>
		<div id="divPessoaJ" style="display:none">
			<form class="form-horizontal" enctype="multipart/form-data">
				<div class="control-group">
					<label class="control-label" for="formEmp"><strong>Empresa já existente?</strong></label>
					<div class="controls">  
						<input type="radio" name="opcaoE" id="opcaoE[]" value="S" onclick="habilitarDiv(this.value)">Sim
						<input type="radio" name="opcaoE" id="opcaoE[]" value="N" onclick="habilitarDiv(this.value)">Não
					</div>
				</div>
			<div class="control-group" id="divEmpresa" style="display:none">
				<form class="form-horizontal" enctype="multipart/form-data">
					<label class="control-label" for="formSelectEmpresa"><strong>Empresa:<strong></label>
					<div class="controls">
						<select id="formSelectEmpresa" style="width:50%;" name="formSelectEmpresa">
							<option value="">Empresa</option>
							<option value="1">Colombo</option>
						</select>
					</div>
				</form>
			</div>
			<div id="divCadastroEmpresa"  style="display:none">
				<form action="viewPousada.php" name="formInserirEmpresa" id="formInserirEmpresa" method="POST" class="form-horizontal" enctype="multipart/form-data">
					<div class="control-group">
						<label class="control-label" for="formEmpresa"><strong>Nome da Empresa:<strong></label>
						<div class="controls">
							<input type="text" class="input-large" name="formEmpresa" id="formEmpresa">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="formCnpj"><strong>Cnpj:<strong></label>
						<div class="controls">
							<input type="text" class="input-large" name="formCnpj" id="formCnpj">
						</div>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn btn-primary" id="formEmpresa_submit" name="formEmpresa_submit">Cadastrar</button>
					</div>
				</form>
			</div>
			</div>
		<div id="divHospede">
		<form action="viewPousada.php" name="formInserirHospede" id="formInserirHospede" method="POST" class="form-horizontal" enctype="multipart/form-data">
			<div class="control-group">  
				<label class="control-label" for="formNome"><strong>Nome:</strong></label>  
				<div class="controls">  
					<input type="text" class="input-large" name="formNome" id="formNome" style="width:48%;">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectMotivo"><strong>Motivo da viajem:<strong></label>
					<div class="controls">
						<select id="formSelectMotivo" style="width:50%;" name="formSelectMotivo"></select>
					</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formSelectAgencia"><strong>Agencia:<strong></label>
					<div class="controls">
						<select id="formSelectAgencia" style="width:50%;" name="formSelectAgencia"></select>
					</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formEndereco"><strong>Cep:</strong></label>
					<div class="controls">  
						<input type="text" class="input-large" name="formCep" id="formCep" onblur="verificaCEP(this,'formEndereco','formBairro')">
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formEndereco"><strong>Endereço:</strong></label>
					<div class="controls">  
						<input type="text" class="input-large" name="formEndereco" id="formEndereco">
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formBairro"><strong>Bairro:</strong></label>  
				<div class="controls">
					<input type="text" class="input-large" name="formBairro" id="formBairro">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectPais"><strong>País:<strong></label>
				<div class="controls">
					<select id="formSelectPais" style="width:50%;" name="formSelectPais">
						<option value="">País</option>
						<option value="1">Brasil</option>
						<option value="1">--------</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectEstado"><strong>Estado:<strong></label>
				<div class="controls">
					<select id="formSelectEstado" style="width:50%;" name="formSelectEstado">
						<option value="">-- Selecione --</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectCidade"><strong>Cidade:<strong></label>
				<div class="controls">
					<select id="formSelectCidade" style="width:50%;" name="formSelectCidade">
						<option value="">-- Selecione --</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectSexo"><strong>Sexo:<strong></label>
				<div class="controls">
					<select id="formSelectSexo" style="width:50%;" name="formSelectSexo">
						<option value="">Sexo</option>
						<option value="M">Masculino</option>
						<option value="F">Feminino</option>
					</select>
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formDtaNascimento"><strong>Data de nascimento:</strong></label>
				<div class="controls">  
					<input type="text" class="input-large" name="formDtaNascimento" id="formDtaNascimento">
			
					<img style="cursor:pointer" title='Calendário' onclick= "displayCalendar(document.getElementById('formDtaNascimento'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
					
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formCpf"><strong>Cpf:</strong></label>
				<div class="controls">  
					<input type="text" class="input-large" name="formCpf" id="formCpf">
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formRNE"><strong>RNE:</strong></label>
				<div class="controls">  
					<input type="text" class="input-large" name="formRNE" id="formRNE">
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formRg"><strong>Rg:</strong></label>
				<div class="controls">
					<input type="text" class="input-large" name="formRg" id="formRg">
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formEmail"><strong>E-mail:</strong></label>
				<div class="controls">  
					<input type="text" class="input-large" name="formEmail" id="formEmail">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formPassaporte"><strong>Passaporte:</strong></label>
				<div class="controls">  
					<input type="text" class="input-large" name="formPassaporte" id="formPassaporte">
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formTelefone"><strong>Telefone 1:</strong></label>
				<div class="controls">  
					<input type="text" class="input-large" name="formTelefone" id="formTelefone">
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formTelefone2"><strong>Telefone 2:</strong></label>
				<div class="controls">  
					<input type="text" class="input-large" name="formTelefone2" id="formTelefone2">
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formTelefone3"><strong>Telefone 3:</strong></label>
				<div class="controls">  
					<input type="text" class="input-large" name="formTelefone3" id="formTelefone3">
				</div>
			</div>
			<!--
			<div class="control-group">  
				<label class="control-label" for="formDtaChegada"><strong>Data de cadastro:</strong></label>
				<div class="controls">  
					<input type="text" class="input-large" name="formDtaChegada" id="formDtaChegada">
					<img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formDtaChegada'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'
					
				</div>
			</div>
			-->
			<div class="form-actions  form-background">
				<button type="submit" class="btn btn-primary" id="formHospede_submit" name="formHospede_submit" >Cadastrar</button>  
			</div>
			<input type="hidden" id="formIdHospede" value="">
			</form>
		</div>
		<div id="divReserva" style="display:none">
			<form action="viewPousada.php" name="formInserirReserva" id="formInserirReserva" method="POST" class="form-horizontal" enctype="multipart/form-data">
				<div class="control-group">
					<label class="control-label" for="formSelectQuarto"><strong>Quarto<strong></label>
					<div class="controls">
						<select id="formSelectQuarto" style="width:15%;" name="formSelectQuarto">
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formDtaReserva"><strong>Período de reserva</strong></label>
					<div class="controls">  
						<input type="text" class="input-large" name="formDtInicial" id="formDtInicial">
						<img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formDtInicial'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
							há
						<input type="text" class="input-large" name="formDtFinal" id="formDtFinal">
						<img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formDtFinal'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
					</div>
				</div>
				<div class="form-actions form-background">
					<button type="submit" class="btn btn-primary" id="formReserva_submit" name="formReserva_submit">Cadastrar</button>  
				</div>
				<input type="hidden" id="formIdLastHosp" value="">	
			</form>
		</div>
	</fieldset>
<!--<div id="tabelaQuartos"></div>-->
</body>
</html>
