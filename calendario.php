<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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

	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">

	<link href="tooltip/themes/1/tooltip.css" rel="stylesheet" type="text/css" />
	<script src="tooltip/themes/1/tooltip.js" type="text/javascript"></script>
</head>
<style>

.panel-liberado
{
    background-color: #05F28F;
    border-color: #05F28F;
    color: #a94442;
	width: 27%;
}

.panel-confirmado
{
    background-color: #FF4500;
    border-color: #FF4500;
    color: #a94442;
	width: 27%;
}

.panel-aindacomvagas
{
	background-color: #E99254;
    border-color: #E99254;
    color: #a94442;
	width: 27%;
	font-size: 2%;
}
.panel-lotado
{
	background-color: #FA3B3B;
    border-color: #FA3B3B;
    color: #a94442;
	width: 27%;
}
.panel-saiuquarto
{
	background-color: #363434;
    border-color: #363434;
    color: #a94442;
	width: 27%;
	font-color: F8F1F1;
}

.panel-manutencaoquarto
{
	background-color: #0C0CDA;
    border-color: #0C0CDA;
    color: #a94442;
	width: 27%;
	
}
.destaqueCalendario{bgcolor:#CCCCCC;background:#CCCCCC;color:#000000;}
.panel-aguardandoconfirmacao
{
	background-color: #FCF6A1;
    border-color: #FCF6A1;
    color: #a94442;
	width: 27%;
}







.moldura {
    border: 1px solid #cccccc ;
    border-radius: 7px;
    margin-left: 10px;
    margin-right: 70%;
    margin-top: 10px;
    padding: 10px;
}

.fieldAlerta {
    border: 1px solid #cccccc ;
    color: #b14400;
	
}
.legend-2{
 font-family: Verdana,Arial,Helvetica,sans-serif;
    font-size: 13px;
	width: 30%;
}
</style>

<script>

function efetcQuarto()
{

	$('table#aba tbody tr').hover(
		function(){ $(this).addClass('destaque');}, 
        function(){ $(this).removeClass('destaque');} 
     );
    $('table#quarto tbody tr').hover(
		function(){ $(this).addClass('destaque');}, 
        function(){ $(this).removeClass('destaque');} 
     );
	 
	 
}  

function calendario()
{
		$("#tabelaCalendario").html("<div style='margin-left:auto;margin-right:auto;width:20%;'><img src='img/loding_grid.gif'/></div>");
		$.ajax({
		type: "POST",
		url: "viewLogar.php",
		data :
		{
			controller : 'tableCalendario'
		},
		success: function(data)
		{
			$("#tabelaCalendario").html(data);
			efetcQuarto();
			gerarCalendarioReserva();
			// efetcCalendario()

		}});
}

function efetcCalendario()
{

	
	 $('table#calendario tbody tr').hover(
		function(){ $(this).addClass('destaque');}, 
        function(){ $(this).removeClass('destaque');} 
     );
	
	
}
function gerarCalendarioReserva()
{
	var objParametros = "";

	if(!$('#formSelectAno').val() && !$('#formSelectMes').val())
	{
		if($('#formSelectQuarto').val())
			objParametros = eval({'controller' : 'montarCalendario','formSelectQuarto' : $('#formSelectQuarto').val()});
		else
			objParametros = eval({'controller' : 'montarCalendario'});
	}
	else
	{
		if($('#formSelectAno').val() && $('#formSelectMes').val())
		{
			if($('#formSelectQuarto').val())
				objParametros = eval({'controller' : 'montarCalendario','formSelectAno' : $('#formSelectAno').val(),'formSelectMes' : $('#formSelectMes').val(),'formSelectQuarto' : $('#formSelectQuarto').val()});
			else
				objParametros = eval({'controller' : 'montarCalendario','formSelectAno' : $('#formSelectAno').val(),'formSelectMes' : $('#formSelectMes').val()});
		}
		else
		{
				alert('Informe ano e mês!');
				return false;
		}
	}
	
		$.blockUI({
		message:  '<img src="img/loading.gif" height="250px" width="250px">',
	    css: 
		   {
				border: 'none',
				padding: '15px',
				'-webkit-border-radius': '10px',
				'-moz-border-radius': '10px',
				opacity: .5,
				top:  ($(window).height() - 200) /2 + 'px',
				left: ($(window).width() - 200) /2 + 'px',
				width: '200px'
            }
		});
	


	$.ajax({
			type: "POST",
			url: pagUrl,
			data : objParametros,
			success: function(data)
			{
				$('#tabela').html(data);
				efetcCalendario();
			}
	});
	setTimeout($.unblockUI, 1000); 
}

function validarCheckIn(idhospconf)
{

	$.ajax({
			type: "POST",
			url: "viewLogar.php",
			data :
			{
				controller : "checkIn",
				idhospconf : idhospconf
			},
			success: function(data)
			{
				if(data != 1)
				{
					$("#mensagemCheckIn"+idhospconf).html('<strong><font color="red" style="text-transform: lowercase;"> Erro ao fazer checkIn!</font></strong>');
				}
				else
				{
					$("#divCheckin"+idhospconf).hide();
					$("#mensagemCheckIn"+idhospconf).html('<strong><font color="green" > Confirmado</font></strong>');
				}
			}
	});
}

function changeNumQuarto(idquarto)
{
	$("#formQtd"+idquarto+"").attr('disabled',false);
}

function sendNewValue(idquarto)
{
	if(confirm("Deseja confirmar alteração?"))
	{
		$.ajax({
				type: "POST",
				url: "viewLogar.php",
				data :
				{
					controller : "novoQtdQuarto",
					qdt : $("#formQtd"+idquarto+"").val(),
					idquarto : idquarto
				},
				success: function(data)
				{
					if(data == 1)
					{
						alert('Alteração de quantidade feita com sucesso!');
						$("#formQtd"+idquarto+"").attr('disabled',true);
					}
					else
					{
						alert('ERRO!');
						$("#formQtd"+idquarto+"").attr('disabled',false);
					}
				}
		});
	}
	else
		$("#formQtd"+idquarto+"").attr('disabled',true);
}


function openModalReserva(data,idquarto)
{
	window.location = 'pousada/cadastro_reserva.php?formDtInicial='+data+'&idquarto='+idquarto;
}

function buscarInicial()
{
	$.ajax({
		type: "POST",
		url: "viewLogar.php",
		data :
		{
			controller : 'tableCalendario',
			formSelectQuarto : $('#formSelectQuarto1').val(),
			formNome : $('#formNome').val()
		},
		success: function(data)
		{
			$("#tabelaCalendario").html(data);
			efetcQuarto();
			gerarCalendarioReserva();
	}});
}

$(document).ready(function(){
	var jq17 = jQuery.noConflict();
	calendario();
});
</script>
<style>
.span3 {  
    height: 200px !important;
}
body { overflow-x: hidden; }
</style>
<body >


<div id="tabelaCalendario"  style="width:99%;margin:0px 0.5%;"></div>
<div class="span3">
	<!--<table id="legenda" class="table" width="300" >-->
	<!--</table>-->
</div>
	<div class="modal-footer"></div>
</div>
</body>
</html>