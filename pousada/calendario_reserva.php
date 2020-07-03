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
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
</head>
<style>
table {
	 border-collapse: collapse;
    }
     table, td, th {
	 border-top: 1px solid #ddd;
	-webkit-border-radius: 0 0 6px 6px;
     -moz-border-radius: 0 0 6px 6px;
          border-radius: 0 0 6px 6px;
	 
	 border: 5px solid F6ACB6;
	      }
	      th {
	        background-color: rgba( 83, 136, 230   ,0.2);
	       color: #125900;
	     }
	      td {
	        color: #3E5C2A;
	       font-weight: bold;
	      }
		  
		  
.panel-liberado
{
    background-color: #04D47D;
    border-color: #04D47D;
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

.panel-aguardandoconfirmacao
{
	background-color: #9ACD32;
    border-color: #9ACD32;
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
$(document).ready(function(){
	var jq17 = jQuery.noConflict();
	montaCombo("formSelectAno","selectAno");
	montaCombo("formSelectMes","selectMes");
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
	<form action="viewPousada.php" name="formInserirProduto" id="formInserirProduto"	method="POST" class="form-horizontal" enctype="multipart/form-data">
		<fieldset class='moldura fieldAlerta'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Calendário de Reservas</strong></center></legend>
			<div class="control-group">
				<label class="control-label" for="formSelectAno"><strong>Ano:<strong></label>
					<div class="controls">
						<select id="formSelectAno" style="width:21%;" name="formSelectAno">
						</select>
					</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectMes"><strong>Mês:<strong></label>
					<div class="controls">
						<select id="formSelectMes" style="width:21%;" name="formSelectMes" onchange="gerarCalendarioReserva()">
						</select>
					</div>
			</div>
		</fieldset>
	</form>
	<br>
	<fieldset class='moldura fieldAlerta' style='width: 55%'>";
		<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Informação de staus do mapa</strong></center></legend>
		<table id='curso' class='table table-striped   table-bordered table-condensed' >
			<tbody>
				<tr>
					<td><div class='panel-liberado'>&nbsp;&nbsp;&nbsp;&nbsp; </div></td>
					<td>Liberado</td>
				</tr>
				<tr>
					<td><div class='panel-aguardandoconfirmacao'>&nbsp;&nbsp;&nbsp;&nbsp;  </div></td>
					<td>Reservado</td>
				</tr>
				<tr>
					<td><div class='panel-confirmado'>&nbsp;&nbsp;&nbsp;&nbsp; </div></td>
					<td>Ocupado</td>
				</tr>
				<tr>
					<td><div class='panel-saiuquarto'>&nbsp;&nbsp;&nbsp;&nbsp;  </div></td>
					<td>Saiu do quarto</td>
				</tr>
			</tbody>
		</table>
	</fieldset>
	<br>
	<div id="tabela" style="width:99%;margin:0px 0.5%;"></div>
</body>
</html>
