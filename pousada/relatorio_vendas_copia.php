<?php //include "../permissao.php"; ?>

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

var grupoAcesso = "";<?php //echo $_SESSION['grupo']; ?>;
$(document).ready(function(){
		var jq17 = jQuery.noConflict();
		$("#formDtInicial").mask("99/99/9999");
		$("#formDtFinal").mask("99/99/9999");

		var objectLabel = eval([{"label":"Nome hóspede","width":100}
								,{"label":"Categoria","width":100}
								,{"label":"Nome do produto","width":100}
								,{"label":"Data da venda","width":100}
								,{"label":"","width":10}]);

		//@exemplo passar mais de um parâmetro var objectLink =  eval([{"link":"dataatendimento|valprato|qtdbebida","value":"dataatendimento","pagina":"historico_atendimento.php"}]);}

		var objectLink  =  eval([{"link":"idvenda","value":"nomehospede","pagina":"historico_atendimento.php"}]);

		var objectConfig = eval({'gridDiv' : 'tabelaVendas',
								 'width': 700,
								 'class' : 'tabelaPadrao',
								 'border':1,
								 'page':true,
								 'id':'idvenda',
								 'crud':true,
								 'title':'Tabela de vendas diárias',
								 'colspan':5,
								 'update': 'cadastro_produto.php',
								 'delete':"excluiReserva",
								 'visualize': 'visualizar_atendimento.php',
								 'objectLink':objectLink});

		getJsonSelect('selectVendas',false,objectConfig,objectLabel,'viewPousada.php',10);

		/*
		$("#formBuscar_submit").click(function(){
			if(!$("#formDtInicial").val() && !$("#formDtFinal").val())
			{
				getJsonSelect('selectAtendDiarios',false,objectConfig,objectLabel,'viewPratos.php');
			}
			else
			{
				var objPar ="";
				if($("#formDtInicial").val() && $("#formDtFinal").val())
					objPar = "formDtInicial="+$("#formDtInicial").val()+"&formDtFinal="+$("#formDtFinal").val();
				else
				{
					if($("#formDtInicial").val())
						objPar = "formDtInicial="+$("#formDtInicial").val();
					if($("#formDtFinal").val())
						objPar = "formDtFinal="+$("#formDtFinal").val();
				}
				getJsonSelect('selectAtendDiarios',false,objectConfig,objectLabel,'viewPratos.php',5,false,objPar);
			}
		});
		*/
});
</script>
<body>
<div>
<?php include "../topo.php"; ?>	
</div>
<form action="viewPratos.php" name="formValores" id="formValores" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset>
		  <div class="control-group">
            <label class="control-label" for="formDtInicial"><strong>Data inicial:</strong></label>
            <div class="controls">
              <input type="text" class="input-medium"  id="formDtInicial" name="formDtInicial" id="formDtInicial">
            </div>
          </div>
		  <div class="control-group">
            <label class="control-label" for="formDtFinal"><strong>Data final:</strong></label>  
            <div class="controls">  
              <input type="text" class="input-medium" id="formDtFinal" name="formDtFinal" id="formDtFinal">
            </div>  
          </div>
          <div class="form-actions">  
            <button type="button" class="btn btn-primary" id="formBuscar_submit" name="formBuscar_submit">Buscar</button>  
          </div>
        </fieldset>
</form>
<div id="tabelaVendas"></div>
</body>
</html>