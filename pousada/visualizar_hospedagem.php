<?php include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>

	<script src="../js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="utf-8"></script>

	<script src="../js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/additional-methods.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.form.js" type="text/javascript" charset="utf-8"></script>

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>


	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
</head>
<script>

$(document).ready(function(){
	var jq17 = jQuery.noConflict();

	visualizarReserva($.query.get('idreserva'));
});
</script>
<body>
<div>
<?php include "../topo.php"; ?>	
</div>
<dl class="dl-horizontal">
	<dt>Nome do quarto:</dt>
		<dd><span id="formQuarto" name="formQuarto"></span></dd>
		<br><br>
	<dt>Nome do hóspede:</dt>
		<dd><span id="formHospede" name="formHospede"></span></dd>
		<br><br>
	<dt>Data inicial:</dt>
		<dd><span id="formDtaInicial" name="formDtaInicial"></span></dd>
		<br><br>
	<dt>Data final:</dt>
		<dd><span id="formDtaFinal" name="formDtaFinal"></span></dd>
		<br><br>
	<dt>Tipo de aluguel:</dt>
		<dd><span id="formOpcao" name="formOpcao"></span></dd>
</dl>
</body>
</html>
