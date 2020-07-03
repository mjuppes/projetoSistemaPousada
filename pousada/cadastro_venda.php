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
	
	<script src="../js/dhtmlgoodies_calendar.js" type="text/javascript" charset="charset=iso-8859-1"></script>
	<link href="../css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css"/>
</head>
<script>
$(document).ready(function(){
	var jq17 = jQuery.noConflict();
	$("#formNome").autocomplete("complete.php",{width:310,selectFirst:false});
	$("#formDta").mask("99/99/9999");
	if($.query.get('idvenda') && $.query.get('editar'))
	{
		updateVenda($.query.get('idvenda'));
		return;
	}

	$("#formSelectProduto").attr('disabled',true);
	$("#formSelectCategoria").bind("change",function()
	{
		montaCombo('formSelectProduto','selectProdutos',$("#formSelectCategoria").val());
		$("#formSelectProduto").attr('disabled',false);
	});
	$("#formVenda_submit").click(function(){
		cadastrarVenda();
	});

	montaCombo('formSelectCategoria','selectCategoria');
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
<div class="erros" id="erros"></div>
<form action="viewPousada.php" name="formInserirVenda" id="formInserirVenda" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset class='moldura fieldAlerta'>
		 	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Venda</strong></center></legend>
			<div class="control-group">
				<label class="control-label" for="formSelectCategoria"><strong>Categoria:<strong></label>
					<div class="controls">
						<select id="formSelectCategoria" style="width:50%;" name="formSelectCategoria" onchange="buscarProduto(this.value);">
						</select>
					</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectProduto"><strong>Produto:<strong></label>
					<div class="controls">
						<select id="formSelectProduto" style="width:50%;" name="formSelectProduto">
							<option>Selecione um produto</option>
						</select>
					</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectHospede"><strong>Hóspede:<strong></label>
					<div class="controls">
						<select disabled id="formSelectHospede" style="width:50%;" name="formSelectHospede">
							<option value="">Selecione hóspede...</option>
						</select>
						<button class="btn" href='#myModal' role='button' title='Visualizar'  data-toggle='modal' onclick='mostraHospedesTable();' >
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
				<label class="control-label" for="formOpcao"><strong>Pagamento:</strong></label>
				<div class="controls">  
					<input type="radio" id="opcao[]" name="opcao" value="1" onclick="habilitarEmpresa(this.value);" checked> Hóspede
					<input type="radio" id="opcao[]" name="opcao" value="2" onclick="habilitarEmpresa(this.value);"> Empresa
				</div>
			</div>
			<div class="control-group" id="divEmpresa" style="display:none">
				<label class="control-label" for="formSelectEmpresa"><strong>Empresa:<strong></label>
					<div class="controls">
						<select id="formSelectEmpresa" style="width:50%;" name="formSelectEmpresa" onchange="buscarProduto(this.value);">
						</select>
					</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formQuantidade"><strong>Quantidade:</strong></label>
				<div class="controls">  
					<input type="text" class="input-large" style="width:10%;" name="formQuantidade" id="formQuantidade">
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formDta"><strong>Data de venda:</strong></label>
				<div class="controls">  
					<input type="text" class="input-large" name="formDta" id="formDta">
					<img style="cursor:pointer" title='Calendário'  onclick= "displayCalendar(document.getElementById('formDta'),'dd/mm/yyyy',this)"src='../icones/calendario.jpg'  width='35px' height='20px'>
				</div>
			</div>
			<div class="form-actions form-background">
				<button type="button" class="btn btn-primary" id="formVenda_submit" name="formVenda_submit">Cadastrar</button>  
			</div>
		  <input type="hidden" id="formIdVenda" value="">
        </fieldset> 
</form>

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
