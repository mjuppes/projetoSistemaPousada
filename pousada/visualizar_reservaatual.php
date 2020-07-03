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

	<script src="js_pousada/pousada.js" type="text/javascript" charset="charset=iso-8859-1"></script>

	<script src="../js/mascaraMoeda.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>	

	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="../css/formularios.css" rel="stylesheet" type="text/css"/>
	<link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
</head>
<script>
	var objectLabel = eval([{"label":"Hóspede","width":100}
							,{"label":"Categoria","width":100}
							,{"label":"Nome do produto","width":100}
							,{"label":"Valor","width":100}
							,{"label":"Data da venda","width":100}
							,{"label":"","width":10}]);

	var objectConfig = eval({'gridDiv' : 'tabelaVendas',
							 'width': 700,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'id':'idvenda',
							 'page':false,
							 'crud':true,
							 'title':'Tabela de vendas',
							 'colspan':5,
							 'update': 'cadastro_venda.php',
							 'delete':"excluiVenda"});

	$(document).ready(function(){
		var jq17 = jQuery.noConflict();

		var parametros = "";
		parametros = "idhospede="+$.query.get('idhospede');
		getJsonSelect('selectVendasReserva',false,objectConfig,objectLabel,'viewPousada.php',false,false,parametros);
	});
</script>
<body>
<div>
<?php include "../topo.php"; ?>
</div>
<div id="tabelaVendas"></div>
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<h4 id="myModalLabel">Informações da locação</h4>
	</div>
	<div class="modal-body">
		<dl class="dl-horizontal">
			<dt>Nome do quarto:</dt>
				<dd><span id="formQuarto" name="formQuarto"></span></dd>
				<br>
			<dt>Nome do hóspede:</dt>
				<dd><span id="formHospede" name="formHospede"></span></dd>
				<br>
			<dt>Data inicial:</dt>
				<dd><span id="formDtaInicial" name="formDtaInicial"></span></dd>
				<br>
			<dt>Data final:</dt>
				<dd><span id="formDtaFinal" name="formDtaFinal"></span></dd>
				<br>
			<dt>Tipo de aluguel:</dt>
				<dd><span id="formOpcao" name="formOpcao"></span></dd>
		</dl>
	</div>
	<div class="modal-footer"></div>
</div>
</body>
</html>