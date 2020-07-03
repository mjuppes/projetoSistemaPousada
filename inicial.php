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
	<script src="js/jquery-1.4.4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.query.js" type="text/javascript" charset="utf-8"></script>
	<link href="css/bootstrap.css" rel="stylesheet">
</head>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap-dropdown.js"></script>
<script src="js/jquery.blockUI.js"></script>
<script>
var pagUrl = "viewLogar.php";
function moveRelogio()
{
	var momentoAtual = new Date();
	var hora = momentoAtual.getHours();
	var minuto = momentoAtual.getMinutes();
	var segundo = momentoAtual.getSeconds();
	
	if(segundo < 10)
		segundo = "0"+segundo;

	if(minuto < 10)
		minuto = "0"+minuto;

	if(hora < 10)
		hora = "0"+hora;

    horaImprimivel = hora +":"+ minuto+ ":" +segundo;
	$("#hora").html("<strong>Bem vindo: </strong><?php echo $_SESSION['usuario']?> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>"+horaImprimivel+"</strong>");
}

function exit()
{
	window.location ="http://177.70.26.45/beaverpousada/login.php";
}

$(document).ready(function(){
	var jq17 = jQuery.noConflict();
	function montarLink()
	{
		var objParametros = "";

		objParametros = eval({'controller' : 'montarLink'});
		$.ajax({
			type: "POST",
			url: "viewLogar.php",
			data : objParametros,
			success: function(data)
			{
				$("#menu").html(data);
			}
		});
	}
	montarLink();
});

function desabilitarLembrete(div)
{
	$("#divteste").html('');
	$("#"+div+"").fadeTo("slow", 1);
	$("<img src='img/carregar.gif' class='loadingCombo' id='loading_"+div+"' alt='carregando'/>").insertAfter("#divteste");
}
</script>

<style>
.wrapper
{
    margin: 20px auto;
	margin-left: 2%;
    width: 300px;
    height: 130px;
    background: white;
    border-radius: 10px;
    -webkit-box-shadow: 5px 5px 15px rgba(0,0,0,0.3);
    -moz-box-shadow: 5px 5px 15px rgba(0,0,0,0.3);
	box-shadow: 5px 5px 15px #b6b6b6;
    position: relative;
    z-index: 90;
	float: left;
	cursor:pointer;
	border: 1px solid;
	border-color:#0088cc;
	text-align:center;

}

.fade-in
{
    opacity:.5;
}
.fade-in:hover{
	opacity:1;
}
</style>
<body >
	<script src="js/msg_js/alertify.min.js"></script>
<link rel="stylesheet" href="js/msg_js/css/alertify.min.css" />
<link rel="stylesheet" href="js/msg_js/css/themes/default.min.css" />
<div  id="menu"></div>
  <?php include "calendario.php"; ?>
 </body>
 </html>