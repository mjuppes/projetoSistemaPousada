
<?php 
	include "permissao.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>
<script src="js/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>

	<script src="js/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.query.js" type="text/javascript" charset="utf-8"></script>
	<script src="pousada/js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="js/jquery.maskedinput-1.2.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/additional-methods.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.ui.plugingrid.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	

</head>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap-dropdown.js"></script>
<script>
function exit()
{
	window.location ="http://www.beaversystem.com.br/beaverPousada/login.php";
}

$(document).ready(function(){
	var jq17 = jQuery.noConflict();
	function montarCalendario()
	{
		var objParametros = "";

		objParametros = eval({'controller' : 'montarCalendario'});
		$.ajax({
			type: "POST",
			url: "viewLogar2.php",
			data : objParametros,
			success: function(data)
			{
				$("#tableCalendario").html(data);
			}
		});
	}
	montarCalendario();
});
</script>
<body >
<div  id="tableCalendario"  style="box-shadow: 5px 5px 15px #b6b6b6;"></div>
 </body>
 </html>