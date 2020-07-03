<?php include "../permissao.php"; ?>

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
	var objectLabel = eval([{"label":"Nome do quarto","width":100}
							,{"label":"Hóspede","width":100}
							,{"label":"Data Inicial","width":100}
							,{"label":"Data Final","width":100}
							,{"label":"","width":10}]);

	var objectConfig = eval({'gridDiv' : 'tabelaCalendario',
							 'width': 600,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'page':true,
							 'title':'Calendario de reservas',
							 'colspan':5,
							 'crud':false});

	 $(document).ready(function(){
		var jq17 = jQuery.noConflict();
		getJsonSelect('tabelaCalendario',false,objectConfig,objectLabel,'viewPousada.php',10);
	});
</script>
<body>
<div>
<?php include "../topo.php"; ?>
</div>
<div id="tabelaCalendario"></div>
</body>
</html>