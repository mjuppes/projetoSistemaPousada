<link rel="shortcut icon" href="http://www.beaversystem.com.br/beaverPousada/favicon.ico">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/bootstrap-dropdown.js"></script>
<link rel="stylesheet" href="../css/bootstrap-responsive.min.css">
<link rel="stylesheet" href="../css/responsive-nav.css">
<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">


<script src="../js/responsive-nav.js"></script>

<link rel="stylesheet" href="assets/web/assets/mobirise-icons/mobirise-icons.css">
<script>
function moveRelogio()
{
	var  momentoAtual = new Date();
	var  hora = momentoAtual.getHours();
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
	//setTimeout("moveRelogio()",1000);
}

function exit()
{
	//window.location ="http://www.beaversystem.com.br/beaverPousada/login.php";
	window.location ="http://177.70.26.45/beaverpousada/login.php";
}

$(document).ready(function(){

	function montarLink()
	{
		var objParametros = "";

		objParametros = eval({'controller' : 'montarLink'});
		$.ajax({
			type: "POST",
			url: "../viewLogar.php",
			data : objParametros,
			success: function(data)
			{

				$("#menu").html(data);
				
			}
		});
	}
	montarLink();
	moveRelogio();
});
</script>
<div id="menu"></div>
