<?php include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>
	<script src="../js/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.query.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.maskedinput-1.2.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/additional-methods.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.form.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/jquery.ui.plugingrid.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="../js/generico.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/msg_js/alertify.js"></script>
	<link rel="stylesheet" href="../js/msg_js/css/alertify.css" />
	<link rel="stylesheet" href="../js/msg_js/css/themes/default.css" />

	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.bgiframe.min.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/lib/thickbox-compressed.js"></script>
	<script type="text/javascript" src="../js/jquery-autocomplete/jquery.autocomplete.js"></script>
	<link  href="../js/jquery-autocomplete/jquery.autocomplete.css" rel="stylesheet" type="text/css">
	
	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">

	<script src="../js/dhtmlgoodies_calendar.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<link href="../css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css"/>
	<!--<link href="../css/bordasombreada.css" rel="stylesheet" type="text/css"/>-->
</head>
<script>
var objectLabel_1 =
[
	{"label":"Nome hóspede","width":'20%'}
	,{"label":"Categoria","width":'15%'}
	,{"label":"Nome do produto","width":'20%'}
	,{"label":"Data da venda","width":'10%'}
	,{"label":"Valor","width":'10%'}
	,{"label":"Quantidade","width":'10%'}
	,{"label":"Valor Total","width":'10%'}
	,{"label":"","width":'10%'}
];

//@exemplo passar mais de um parâmetro var objectLink =  eval([{"link":"dataatendimento|valprato|qtdbebida","value":"dataatendimento","pagina":"historico_atendimento.php"}]);}
var objectLink_1  =  
[
	{"link":"idhospede","value":"nomehospede","pagina":"historico_hospedes.php"}
];

var objectConfig_1 = 
{
	'gridDiv' : 'tabelaVendas',
	 'width': '100%',
	 'class' : 'tabelaPadrao',
	 'border':1,
	 'id':'idvenda',
	 'crud':true,
	 'colspan':10,
	 'push':'cadastro_venda.php',
	 'delete':"excluirVenda",
	 //'visualize': "visualizarVenda",
	 'print': "relVenda",
	 'objectLink':objectLink_1
};


var objectLabel_2 =
[
	{"label":"","width":'90%'}
	,{"label":"","width":'10%'}
];

var objectConfig_2 = 
{
	'gridDiv' : 'tabelaVendasTotal'
};

$(document).ready(function(){
		var jq17 = jQuery.noConflict();
		montaCombo('formSelectHospede','selectHospede');
		$("#formDtInicial").mask("99/99/9999");
		$("#formDtFinal").mask("99/99/9999");

		getJsonSelect('selectVendas',false,objectConfig_1,objectLabel_1,'viewPousada.php',false);
		getJsonSelect('selectVendasTotal',false,objectConfig_2,objectLabel_2,'viewPousada.php',false);

		$("#formBuscar_submit").click(function(){
			
			var arrIdsHospede = Array();
			$("#formSelectHospSelecionado option").each(function()
			{	
				if($(this).val() != "")
				arrIdsHospede.push($(this).val());
			});

			if(!$("#formDtInicial").val() || !$("#formDtFinal").val())
			{
				alert('Informe o período data inicial e final!!');
				return;
			}

			var objPar ="";

			if(arrIdsHospede.length != 0)
				objPar +="arrIdsHospede="+arrIdsHospede.toString()+"&";

			if($("#formDtInicial").val() && $("#formDtFinal").val())
				objPar += "formDtInicial="+$("#formDtInicial").val()+"&formDtFinal="+$("#formDtFinal").val();
			else
			{
				if($("#formDtInicial").val())
					objPar += "formDtInicial="+$("#formDtInicial").val();
				if($("#formDtFinal").val())
					objPar += "formDtFinal="+$("#formDtFinal").val();
			}
			getJsonSelect('selectVendas',false,objectConfig,objectLabel,'viewPousada.php',false,false,objPar);
		});
});
</script>
<body>
<div>
<?php include "../topo.php"; ?>	
</div>
<div style="margin-left:10px;" >
  <input type="image" src="../icones/volta.png" name="image" width="40" height="40" onclick="javascript:history.go(-1);"> <strong>Voltar</strong>
</div

<br>
<form action="viewPratos.php" name="formValores" id="formValores" method="POST" class="form-horizontal" enctype="multipart/form-data">
	<fieldset  class='moldura fieldAlertaLista'>
		<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Pesquisa de Vendas</strong></center></legend>

	<div class="control-group">
	<label class="control-label" for="formSelectHospede"><strong>Hóspede:<strong></label>
		<div class="controls">
			<select disabled id="formSelectHospede" style="width:50%;" name="formSelectHospede">
				<option value="">Selecione hóspede...</option>
			</select>
			<button class="btn" href='#myModalHospede' role='button' title='Visualizar'  data-toggle='modal' onclick='mostraHospedesTable();' >
				<img width="20px" height="20px" src="../icones/busca.png">
				<strong>Pesquisar</strong>
			</button>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<select multiple id="formSelectHospSelecionado"  style="width:50%;" name="formSelectHospSelecionado">
			</select>
			<a href="#" onclick="removeOption('formSelectHospSelecionado');">Remover</a>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="formDtInicial"><strong>Data inicial:</strong></label>
		<div class="controls">
			<input type="text" class="input-medium"  id="formDtInicial" name="formDtInicial" id="formDtInicial">
			<img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formDtInicial'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="formDtFinal"><strong>Data final:</strong></label>  
		<div class="controls">
			<input type="text" class="input-medium" id="formDtFinal" name="formDtFinal" id="formDtFinal">
			<img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formDtFinal'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
		</div>  
	</div>
		<div class="form-actions form-background">
		<button type="button"  id="formBuscar_submit" name="formBuscar_submit" class="btn" title="Buscar">
			<img src="../icones/busca.png" width="25px" height="20px">
			<strong>Buscar</strong>
		</button>
	</div>
</fieldset>
</form>
<br>
<fieldset class='moldura fieldAlertaLista'>
	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Lista de Vendas</strong></center></legend>
	<div id="tabelaVendas" style="width:99%;margin:0px 0.5%;"></div>
	<div id="tabelaVendasTotal" style="width:99%;margin:0px 0.5%;"></div>
</fieldset>


<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<h4 id="myModalLabel">Informações da venda</h4>
	</div>
	<div class="modal-body">
		<dl class="dl-horizontal">
			<dt><strong>Nome do hóspede:</strong></dt>
			<dd><span id="formNomeHosp" name="formNomeHosp"></span></dd>
				<br>
			<dt><strong>Categoria:</strong></dt>
				<dd><span id="formCategoria" name="formCategoria"></span></dd>
				<br>
			<dt><strong>Nome do produto:</strong></dt>
				<dd><span id="formProduto" name="formProduto"></span></dd>
				<br>
			<dt><strong>Data da venda:</strong></dt>
				<dd><span id="formDtaVenda" name="formDtaVenda"></span></dd>
				<br>
		</dl>
	</div>
	<div class="modal-footer"></div>
</div>

<div style="width:100%">
<div id="myModalHospTable"  style="left:35%;margin-right:60%;width:70%;" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<h4 id="myModalLabel">Adicionar hóspede...</h4>
	</div>
	<div class="modal-body">
		<form action="viewPousada.php" name="formInserirVenda" id="formInserirVenda" method="POST" class="form-horizontal" enctype="multipart/form-data">
			<div class="control-group">  
				<label class="control-label" for="formNomeHospede"><strong>Hospede:</strong></label>
				<div class="controls">  
					<input type="text" class="input-large"  style="width:50%;" name="formNomeHospede" id="formNomeHospede">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectQuarto"><strong>Quarto:</strong></label>
				<div class="controls">
					<select  id="formSelectQuarto"  style="width:50%;" name="formSelectQuarto">
						<option value=""></option>
					</select>
				</div>
			</div>
			<div class="form-actions">
				<button type="button" onclick="buscarHospedesTable()" class="btn" title="Buscar">
				<img src="../icones/busca.png" width="25px" height="20px">
				<strong>Buscar</strong></button>
			</div>

		</form>
		<div id="tabelaHospede" style="width:99%;margin:0px 0.5%;"></div>
	</div>
	<div class="modal-footer"></div>
</div>
</div>

</body>
</html>