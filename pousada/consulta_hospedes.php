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
	<!--<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">-->
	
	<script src="../js/dhtmlgoodies_calendar.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<link href="../css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css"/>
</head>
<script>
	var objectLabel = [{"label":"Nome do hóspede","width":'20%'}
							,{"label":"Sexo","width":'7%'}
							,{"label":"Empresa","width":'20%'}
							,{"label":"Estado","width":'20%'}
							,{"label":"Cidade","width":'17%'}
							,{"label":"Data de cadastro","width":'8%'}
							,{"label":"","width":'10%'}];

	var objectLink  =  [{"link":"idhospede","value":"nome","pagina":"historico_hospedes.php"}];
	var objectConfig = {'gridDiv' : 'tabelaHospedes',
						 'width': '100%',
						 'class' : 'tabelaPadrao',
						 'border':1,
						 'id':'idhospede',
						 'push':'cadastro_hospede.php',
						 'page':true,
						 'delete':"excluiHospede",
						 'title':'Tabela de hóspedes',
						 'colspan':7,
						 'crud':true,
						 'update': true,
						 'print': "relHospede",
						 'visualize':"visualizarHospede",
						 'objectLink':objectLink};

	$(document).ready(function(){
		var jq17 = jQuery.noConflict();
		$("#formNome").autocomplete("complete.php",{width:310,selectFirst:false});

		montaCombo('formSelectEstado','selectEstado');
		$("#formSelectCidade").attr('disabled',true);
		$("#formSelectCidade").html("<option value=''>-- Selecione --</option>");
		$("#formSelectEstado").bind("change",function()
		{
			if($("#formSelectEstado").val() == "")
			{
				$("#formSelectCidade").html("<option value=''>-- Selecione --</option>");
				$("#formSelectCidade").attr('disabled',true);
				return;
			}
			montaCombo('formSelectCidade','selectCidade',$("#formSelectEstado").val());
			$("#formSelectCidade").attr('disabled',false);
		});
		montaCombo('formSelectEmpresa','selectEmpresa');
		montaCombo('formSelectSexo','selectSexo');
		$("#formDtInicial").mask("99/99/9999");
		$("#formDtFinal").mask("99/99/9999");
		getJsonSelect('selectHospedeGeral',false,objectConfig,objectLabel,'viewPousada.php',15);
	});
</script>
<body>
<div>
<?php include "../topo.php"; ?>
</div>
<div>
<div style="margin-left:10px;" >
  <input type="image" src="../icones/volta.png" name="image" width="40" height="40" onclick="javascript:history.go(-1);"> <strong>Voltar</strong>
</div>
<br>
<form  name="formInserirCidade" id="formInserirCidade" method="POST" class="form-horizontal" enctype="multipart/form-data">
<fieldset  class='moldura fieldAlertaLista'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Pesquisa de Hóspedes</strong></center></legend>
		
			<div class="control-group">  
				<label class="control-label" for="formNome"><strong>Nome:</strong></label>  
				<div class="controls">  
					<input type="text" class="input-large" style="width:21%;"name="formNome" id="formNome">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectEstado"><strong>Estado:<strong></label>
				<div class="controls">
					<select id="formSelectEstado" style="width:20%;" name="formSelectEstado"></select>
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formSelectCidade"><strong>Cidade:</strong></label>
				<div class="controls">  
					<select id="formSelectCidade" style="width:20%;" name="formSelectCidade"></select>
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formSelectEmpresa"><strong>Empresa:</strong></label>
				<div class="controls">  
					<select id="formSelectEmpresa" style="width:20%;" name="formSelectEmpresa"></select>
				</div>
			</div>
			<div style="margin-left:50%;width:40% ; position:absolute;margin-top:-12.7%">
				<div class="control-group">  
					<label class="control-label" for="formSelectSexo"><strong>Sexo:</strong></label>
					<div class="controls">  
						<select id="formSelectSexo" style="width:50%;" name="formSelectSexo"></select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formDtInicial"><strong>Data inicial:</strong></label>
					<div class="controls">
						<input type="text" class="input-medium"  id="formDtInicial" name="formDtInicial" id="formDtInicial">
						<img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formDtInicial'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formDtFinal"><strong>Data final:</strong></label>  
					<div class="controls">  
						<input type="text" class="input-medium" id="formDtFinal" name="formDtFinal" id="formDtFinal">
							<img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formDtFinal'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
					</div>
				</div>
			</div>
			<div class="form-actions form-background">
			<button type="button" onclick="buscarRegistrosTabelaHospede()" class="btn" title="Buscar">
					<img src="../icones/busca.png" width="25px" height="20px">
		<strong>Buscar</strong></button>
        </fieldset> 
</form>
</div>
<fieldset class='moldura fieldAlertaLista'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de Hóspedes</strong></center></legend>
	<div id="tabelaHospedes" style="width:99%;margin:0px 0.5%;"></div>
</fieldset> 
<div id="myModal"  class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<h4 id="myModalLabel">Informações do Hóspede</h4>
	</div>
	<div class="modal-body">
		<dl class="dl-horizontal">
			<dt>Nome do hóspede:</dt>
				<dd><span id="formHospede" name="formHospede"></span></dd>
				<br>
			<dt>CPF:</dt>
				<dd><span id="formCpf" name="formCpf"></span></dd>
				<br>
			<dt>RG:</dt>
				<dd><span id="formRg" name="formRg"></span></dd>
				<br>
			<dt>Sexo:</dt>
				<dd><span id="formSexo" name="formSexo"></span></dd>
				<br>
			<dt>Motivo:</dt>
				<dd><span id="formMotivo" name="formMotivo"></span></dd>
				<br>
			<div id='divA'>
				<dt>Agência:</dt>
				<dd><span id="formAgencia" name="formAgencia"></span></dd>
				<br>
			</div>		
			<dt>Data de chegada:</dt>
				<dd><span id="formDtaChegada" name="formDtaChegada"></span></dd>
				<br>
			<div id='divE'>
				<dt>Empresa:</dt>
				<dd><span id="formEmpresa" name="formEmpresa"></span></dd>
				<br>
			</div>
			<dt>Estado:</dt>
				<dd><span id="formEstado" name="formEstado"></span></dd>
				<br>
			<dt>Cidade:</dt>
				<dd><span id="formCidade" name="formCidade"></span></dd>
				<br>
			<dt>Endereco:</dt>
				<dd><span id="formEndereco" name="formEndereco"></span></dd>
				<br>
			<dt>Bairro:</dt>
				<dd><span id="formBairro" name="formBairro"></span></dd>
				<br>
			<dt>E-mail:</dt>
				<dd><span id="formEmail" name="formEmail"></span></dd>
				<br>
			<dt>Telefone:</dt>
				<dd><span id="formTelefone" name="formTelefone"></span></dd>
				<br>
			<dt>Data de cadastro:</dt>
				<dd><span id="formDtCadastro" name="formDtCadastro"></span></dd>
		</dl>
	</div>
	<div class="modal-footer"></div>
</div>
</body>
</html>