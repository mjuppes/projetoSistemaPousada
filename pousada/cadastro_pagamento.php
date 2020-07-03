<?php include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>
	<script src="../js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="utf-8"></script>

	<script src="../js/jquery.ui.plugingrid.js" type="text/javascript" charset="charset=iso-8859-1"></script>
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
$(document).ready(function(){
	var jq17 = jQuery.noConflict();
	$("#formData").mask("99/99/9999");
	$('#formValor').priceFormat({prefix: '',centsSeparator: ',',thousandsSeparator: '.'});

	if($.query.get('idpagamento') && $.query.get('editar'))
	{
		updatePagamento($.query.get('idpagamento'));
		return;
	}
	else
	{
		montaCombo('formSelectTransferencia','selectTransferencia');
		montaCombo('formSelecDpAntecipado','selectDpAntecipado');
		cadastrarPagamento();
	}
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
<form action="viewPousada.php" name="inserirPagamento" id="inserirPagamento" method="POST" class="form-horizontal" enctype="multipart/form-data">
		  <fieldset class='moldura fieldAlerta'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Pagamento</strong></center></legend>
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
					<select id="formSelectTransferencia" style="width:20%;" name="formSelectTransferencia">
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelecDpAntecipado"><strong>Forma de pagamento:<strong></label>
				<div class="controls">
					<select id="formSelecDpAntecipado" style="width:20%;" name="formSelecDpAntecipado">
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formData"><strong>Data efetuada:</strong></label>
				<div class="controls">
					<input type="text" class="input-large" name="formData" id="formData">
					<img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formData'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formValor"><strong>Valor do pagamento:</strong></label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="formValor" id="formValor">
				</div>
			</div>
          <div class="form-actions form-background">
            <button type="submit" class="btn btn-primary" id="formPagamento_submit" name="formPagamento_submit">Cadastrar</button>  
          </div>
		  <input type="hidden" id="formIdPagamento" value="">
		</fieldset> 
	</form>
</body>
</html>
