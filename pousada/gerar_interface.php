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
	<script src="../js/jquery.ui.plugingrid.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="../js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
</head>
<script>
var strTemplet = "";
function Adicionar()
{
	strTemplet += "<div class='control-group'>";
	strTemplet += "<label class='control-label' for='form'><strong>Nome:</strong></label>";
	strTemplet += "<div class='controls'>"
	strTemplet += "<input type='text' class='input-xlarge' name='form[]' id='form[]'>";
	strTemplet += "</div>";
	strTemplet += "</div>";
	$("#containerTemplet").html(strTemplet);
}
</script>
<body>
<br><br><br>
<div class="erros"></div>
<form action="gerar_interface.php" name="formInserirQuarto" id="formInserirQuarto" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset>
			<div class="control-group">  
				<label class="control-label" for="form"><strong>Nome:</strong></label>
				<div class="controls">
					<input type="text" class="input-xlarge" name="form[]" id="form[]"> <a href='#' onclick='Adicionar()' class='icon-large icon-plus-sign' title='Adicionar' alt='Adicionar'></a>
				</div>
				<div class="input-append">
				</div>
			</div>
			<div id="containerTemplet"></div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary" id="form_submit" name="form_submit">Criar</button>  
			</div>
        </fieldset> 
</form>
<?php
if(isset($_POST['form']))
{
	$name = "C:/tmp/interfaceHTML.php";
	$strInterface = "";
	$strInterface.= "<?php include('cabecalho.php'); ?>\n";
	$strInterface.= "\n<form action='' name='formInserirEmpresa' id='formInserirEmpresa'	method='POST' class='form-horizontal' enctype='multipart/form-data'>\n";
    $strInterface.= "\n<fieldset>";

	foreach($_POST['form'] as $key => $value)
	{
		$strInterface.="\n<div class='control-group'>";
		$strInterface.="\n<label class='control-label' for='form$value'><strong>$value</strong></label>";
		$strInterface.="\n<div class='controls'>";
		$strInterface.="\n<input type='text' class='input-xlarge' name='form$value' id='form$value'>";
		$strInterface.="\n</div>";
		$strInterface.="\n</div>";
	}

	$strInterface.="\n<div class='form-actions'>";
	$strInterface.="\n<button type='submit' class='btn btn-primary' id='form_submit' name='form_submit'>Cadastrar</button>  ";
	$strInterface.="\n</div>";
	$strInterface.="\n<input type='hidden' id='formIdEmpresa' value=''>";
    $strInterface.="\n</fieldset>";
	$strInterface.="\n</form>";
	$strInterface 	.= "\n<?php include('rodape.php'); ?>";
	$file = fopen($name, "w+");
	fwrite($file, $strInterface);
	fclose($file);

	$name = "C:/tmp/interfaceJS.php";
	$strJS.="\n$('#').validate({";
	$strJS.="\nerrorLabelContainer: '.erros',";
	$strJS.="\nwrapper: 'li',";
	$strJS.="\nsubmitHandler: function(form)";
	$strJS.="\n{";
	$strJS.="\n$(form).ajaxSubmit({";
	$strJS.="\ndataType: 'post',";
	$strJS.="\ndata : objParametros,";
	$strJS.="\nbeforeSubmit:";
	$strJS.="\nfunction()";
	$strJS.="\n{";
	$strJS.="\n$('#form_submit').attr('disabled',true);";
	$strJS.="\n},";
	$strJS.="\n	success:";
	$strJS.="\nfunction (data)";
	$strJS.="\n{";
	$strJS.="\n}";
	$strJS.="\n});";
	$strJS.="\n},";
	$strJS.="\n invalidHandler: function()";
	$strJS.="\n	{";
	$strJS.="\n$('.erros_programa').html('<p>Os seguintes campos est&#227;o inv&#225;lidos:</p>');";
	$strJS.="\n},";
	$strJS.="\nrules:";
	$strJS.="\n{";
	
	$bool = false;
	foreach($_POST['form'] as $key => $value)
	{
		if($bool == false)
		{
			$strJS.="\n";
			$strJS.="\nform$value:";
			$strJS.="\n{";
			$strJS.="\n required: true";
			$strJS.="\n}";
			$bool = true;
		}
		else
		{
			$strJS.="\n";
			$strJS.="\n,form$value:";
			$strJS.="\n{";
			$strJS.="\n required: true";
			$strJS.="\n}";
		}
	}
	$strJS.="\n},";
	$strJS.="\nmessages:";
	$strJS.="\n{";

	$bool = false;
	foreach($_POST['form'] as $key => $value)
	{
		if($bool == false)
		{
			$strJS.="\n";
			$strJS.="\nform$value:";
			$strJS.="\n{";
			$strJS.="\n required: ''";
			$strJS.="\n}";
			$bool = true;
		}
		else
		{
			$strJS.="\n";
			$strJS.="\n,form$value:";
			$strJS.="\n{";
			$strJS.="\n required: ''";
			$strJS.="\n}";
		}
	}
	$strJS.="}});";
	$strJS.="\n";

	$file = fopen($name, "w+");
	fwrite($file, $strJS);
	fclose($file);
}
/*
foreach($_POST['form'] as $key => $value)
{
		echo "<br>".$value;
}
*/
?>
</body>
</html>
