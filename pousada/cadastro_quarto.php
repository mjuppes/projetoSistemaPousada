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

	if(query_get('idquarto') && query_get('editar'))
	{
		$("#divManutencao").show();
		updateQuarto($.query.get('idquarto'));
		return;
	}
	cadastrarQuarto();
	$("#divManutencao").hide();
	
});
</script>

<body>
<div>
<?php include "../topo.php"; ?>	
</div>
<div style="margin-left:10px;">
  <input type="image" src="../icones/volta.png" name="image" width="40" height="40" onclick="javascript:history.go(-1);"> <strong>Voltar</strong>
</div>
<br>
<div class="erros"></div>
<form action="viewPousada.php" name="formInserirQuarto" id="formInserirQuarto" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset class='moldura fieldAlerta' >
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Quarto</strong></center></legend>
			<div class="control-group">  
				<label class="control-label" for="formNomeQuarto"><strong>Nome do quarto:</strong></label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="formNomeQuarto" id="formNomeQuarto">
				</div>
			</div>
			<p>
				<div style="width:10%;margin-left:-02px">
					<table style="width:10%">
						<thead>
						</thead>
						<tbody>
								<tr>
									<td>
										<div class="controls">  
											<div class="input-prepend">
												<label class="checkbox">
													<input type="checkbox" name="item" id="item[]" value="1"> TV
												</label>
											</div>
										</div>
									</td>
									<td>
										<div class="controls">  
											<div class="input-prepend">
												<label class="checkbox">
													<input type="checkbox" name="item" id="item[]" value="2"> Ventilador
												</label>
											</div>
										</div>
									</td>
									<td>
										<div class="controls">  
											<div class="input-prepend">
												<label class="checkbox">
													<input type="checkbox" name="item" id="item[]" value="3"> Frigobar
												</label>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="controls">  
											<div class="input-prepend">
												<label class="checkbox">
													<input type="checkbox" name="item" id="item[]" value="4"> Split
												</label>
											</div>
										</div>
									</td>
									<td>
										<div class="controls">  
											<div class="input-prepend">
												<label class="checkbox">
													<input type="checkbox" name="item" id="item[]" value="5"> Aquecedor
												</label>
											</div>
										</div>
									</td>
									<td>
										<div class="controls">  
											<div class="input-prepend">
												<label class="checkbox">
													<input type="checkbox" name="item" id="item[]" value="6"> Fogão
												</label>
											</div>
										</div>
									</td>
								</tr>
						</tbody>
					</table>
				</div>
			</p>
			<div class="control-group">
				<label class="control-label" for="formQtdVaga"><strong>Quantidade de vagas:</strong></label>  
				<div class="controls">  
					<input type="text" onkeypress='return keyNum(event)' style="width:5%;" class="input-large" name="formQtdVaga" id="formQtdVaga">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formLocalizacao"><strong>Observações:</strong></label>  
				<div class="controls">  
					<textarea class="input-xlarge" name="formLocalizacao" id="formLocalizacao" rows="3"></textarea>  
				</div>
			</div>
			<div class="control-group" id="divManutencao" style="display:none">
				<label class="checkbox" style="margin-left:17%;">
					<input type="checkbox" onclick="habilitarManutencao()" name="manutencao" id="manutencao" >Em manutenção
				</label>
			</div>
			
			<div class="control-group" id="divPeriodoManutencao" style="display:none">
			<label class="control-label" for="formDtaReserva"><strong>Período de manutenção:</strong></label>
				<div class="controls">  
					<input type="text" class="input-large" name="formDtInicial" id="formDtInicial">
					<img style="cursor:pointer" title='Calendário' onclick= "displayCalendar(document.getElementById('formDtInicial'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
					há
					<input type="text"  class="input-large" name="formDtFinal" id="formDtFinal" onblur="verificaData('formDtInicial','formDtFinal');">
					<img style="cursor:pointer" title='Calendário' onclick= "displayCalendar(document.getElementById('formDtFinal'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
				</div>
			</div>
			
			<div class="form-actions form-background">
				<button type="submit" class="btn btn-primary" id="formQuarto_submit" name="formQuarto_submit">Cadastrar</button>  
			</div>
			<input type="hidden" id="formIdQuarto" value="">
        </fieldset> 
</form>
</body>
</html>
