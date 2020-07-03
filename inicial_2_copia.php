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
<!--<script src="js/jquery.blockUI.js"></script>-->
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
	//setTimeout("moveRelogio()",1000);
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
	moveRelogio();
});

function desabilitarLembrete(div)
{
	$("#divteste").html('');
	$("#"+div+"").fadeTo("slow", 1);
	$("<img src='img/carregar.gif' class='loadingCombo' id='loading_"+div+"' alt='carregando'/>").insertAfter("#divteste");
	//$("#"+div+"").hide();
}
</script>

<body>
<link href="menu/bootstrap.css" rel="stylesheet">
<!--<div  id="menu"  style="box-shadow: 5px 5px 15px #b6b6b6;"></div>-->

<head>
<script type="text/javascript" src="menu/libs/jquery/jquery.js"></script>
<script type="text/javascript" src="menu/jquery.smartmenus.js"></script>
<script type="text/javascript">
	$(function()
	{
		$('#main-menu').smartmenus({
			subMenusSubOffsetX: 1,
			subMenusSubOffsetY: -8
		});
	});
</script>

<link href="menu/css/sm-core-css.css" rel="stylesheet" type="text/css" />
<link href="menu/css/sm-blue/sm-blue.css" rel="stylesheet" type="text/css" />
<link href="menu/libs/demo-assets/demo.css" rel="stylesheet" type="text/css" />

</head>

<body>


<div class="navbar" >
	<div class="navbar-inner" style="height:125px" >
		<a class="brand" title="Ir para a tela inicial" href="http://177.70.26.45/beaverpousada/inicial.php">
		<img  width=140 height=10 style="position:absolute;margin-top:-15px" src="http://177.70.26.45/beaverpousada/hospedaaki_logo.png"></img></a>

		<div style="position: relative;margin-top:35px;margin-left:200px">
<nav id="main-nav" role="navigation">
  <!-- Sample menu definition -->
  <ul id="main-menu" class="sm sm-blue">
    <li><a href="http://www.smartmenus.org/">Inicio</a></li>
    <li>
	<a href="http://www.smartmenus.org/about/">Cadastros</a>
      <ul>
        <li><a href="http://www.smartmenus.org/about/introduction-to-smartmenus-jquery/">Introduction to SmartMenus jQuery</a></li>
        <li><a href="http://www.smartmenus.org/about/themes/">Themes</a></li>
        <li><a href="http://vadikom.com/about/#vasil-dinkov">The author</a></li>
        <li>
			<a href="http://www.smartmenus.org/about/vadikom/">The company</a>
          <ul>
            <li><a href="http://vadikom.com/about/">About Vadikom</a></li>
            <li><a href="http://vadikom.com/projects/">Projects</a></li>
            <li><a href="http://vadikom.com/services/">Services</a></li>
            <li><a href="http://www.smartmenus.org/about/vadikom/privacy-policy/">Privacy policy</a></li>
          </ul>
        </li>
      </ul>
    </li>
	   <li>
	<a href="http://www.smartmenus.org/about/">Relatorios</a>
      <ul>
        <li><a href="http://www.smartmenus.org/about/introduction-to-smartmenus-jquery/">Introduction to SmartMenus jQuery</a></li>
        <li><a href="http://www.smartmenus.org/about/themes/">Themes</a></li>
        <li><a href="http://vadikom.com/about/#vasil-dinkov">The author</a></li>
        <li>
			<a href="http://www.smartmenus.org/about/vadikom/">The company</a>
          <ul>
            <li><a href="http://vadikom.com/about/">About Vadikom</a></li>
            <li><a href="http://vadikom.com/projects/">Projects</a></li>
            <li><a href="http://vadikom.com/services/">Services</a></li>
            <li><a href="http://www.smartmenus.org/about/vadikom/privacy-policy/">Privacy policy</a></li>
          </ul>
        </li>
      </ul>
    </li>
	   <li>
	<a href="http://www.smartmenus.org/about/">Finaceiro</a>
      <ul>
        <li><a href="http://www.smartmenus.org/about/introduction-to-smartmenus-jquery/">Introduction to SmartMenus jQuery</a></li>
        <li><a href="http://www.smartmenus.org/about/themes/">Themes</a></li>
        <li><a href="http://vadikom.com/about/#vasil-dinkov">The author</a></li>
        <li>
			<a href="http://www.smartmenus.org/about/vadikom/">The company</a>
          <ul>
            <li><a href="http://vadikom.com/about/">About Vadikom</a></li>
            <li><a href="http://vadikom.com/projects/">Projects</a></li>
            <li><a href="http://vadikom.com/services/">Services</a></li>
            <li><a href="http://www.smartmenus.org/about/vadikom/privacy-policy/">Privacy policy</a></li>
          </ul>
        </li>
      </ul>
    </li>
	<li>
	<a href="http://www.smartmenus.org/about/">Estatistica</a>
      <ul>
        <li><a href="http://www.smartmenus.org/about/introduction-to-smartmenus-jquery/">Introduction to SmartMenus jQuery</a></li>
        <li><a href="http://www.smartmenus.org/about/themes/">Themes</a></li>
        <li><a href="http://vadikom.com/about/#vasil-dinkov">The author</a></li>
        <li>
			<a href="http://www.smartmenus.org/about/vadikom/">The company</a>
          <ul>
            <li><a href="http://vadikom.com/about/">About Vadikom</a></li>
            <li><a href="http://vadikom.com/projects/">Projects</a></li>
            <li><a href="http://vadikom.com/services/">Services</a></li>
            <li><a href="http://www.smartmenus.org/about/vadikom/privacy-policy/">Privacy policy</a></li>
          </ul>
        </li>
      </ul>
    </li>
	<li>
	<a href="http://www.smartmenus.org/about/">Chamados</a>
      <ul>
        <li><a href="http://www.smartmenus.org/about/introduction-to-smartmenus-jquery/">Introduction to SmartMenus jQuery</a></li>
        <li><a href="http://www.smartmenus.org/about/themes/">Themes</a></li>
        <li><a href="http://vadikom.com/about/#vasil-dinkov">The author</a></li>
        <li>
			<a href="http://www.smartmenus.org/about/vadikom/">The company</a>
          <ul>
            <li><a href="http://vadikom.com/about/">About Vadikom</a></li>
            <li><a href="http://vadikom.com/projects/">Projects</a></li>
            <li><a href="http://vadikom.com/services/">Services</a></li>
            <li><a href="http://www.smartmenus.org/about/vadikom/privacy-policy/">Privacy policy</a></li>
          </ul>
        </li>
      </ul>
    </li>
	<li><a href="#">Sair</a></li>
  </ul>
</nav>
<br>
</div>
		</div>
			</div>

<style type="text/css">
	@media (min-width: 768px) {
		#main-menu > li {
			float: none;
			display: table-cell;
			width: 1%;
			text-align: center;
		}
	}
</style>

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

</div>
<br><br>
<script src="js/jquery.blockUI.js"></script>
<?php include "calendario.php"; ?>
</body>
</html>
