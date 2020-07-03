<?php include "../permissao.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title></title>

	
	<script src="../js/jquery-1.7.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
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
	<link href="../css/modal.css" rel="stylesheet">
</head>
<script>
$(document).ready(function(){
	var jq17 = jQuery.noConflict();

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
<div id="erros" class="erros"></div>
<form action="viewPousada.php" name="formInserirLancaInsumo" id="formInserirLancaInsumo" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset class='moldura fieldAlerta'>
		 	<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Controle da Auditoria</strong></center></legend>
			<div class="control-group">
				<label class="control-label" for="formSelectProduto"><strong>Produto:<strong></label>
					<div class="controls">
						<select id="formSelectProduto" disabled style="width:50%;" name="formSelectProduto">
							<option value="">Produto selecionado...</option>
						</select>
						<button class="btn" href='#myModal' role='button' title='Visualizar'  data-toggle='modal' onclick='mostraProdutosAuditoria();' >
							<img width="20px" height="20px" src="../icones/busca.png">
							<strong>Pesquisar</strong>
						</button>
					</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectHistorico"><strong>Histórico:<strong></label>
					<div class="controls">
						<select id="formSelectHistorico" style="width:50%;" name="formSelectHistorico">
							<option value="">Históricos</option>
							<option value='1'>Saída pela Auditoria</option>
							<option value='2'>Entrada pela Auditoria</option>
						</select>
					</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formQuantidade"><strong>Quantidade:</strong></label>
				<div class="controls">  
					<input type="text" class="input-large" style="width:20%;" name="formQuantidade" id="formQuantidade">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formDescricao"><strong>Descrição:</strong></label>  
				<div class="controls">  
					<textarea class="input-xlarge" name="formDescricao" id="formDescricao" rows="3"></textarea>  
				</div>
			</div>
			<div class="form-actions form-background">
				<button type="button" onclick="cadastrarControleAuditoria();" class="btn btn-primary" id="formLancaInsumo_submit" name="formLancaInsumo_submit">Cadastrar</button>  
			</div>
        </fieldset> 
</form>
<div style="width:100%">
<div id="myModal"  style="left:35%;margin-right:60%;width:70%;" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<h4 id="myModalLabel">Selecionar um Produto...</h4>
	</div>
	<div class="modal-body">

	<div class="control-group">
		<label class="control-label" for="formFornecedorStr"><strong>Código/Nome:<strong></label>
		<div class="controls">
			<input type="text" class="input-large" name="formStr" id="formStr" style="width:31%;">
			<button class="btn" type="button"	onclick="mostraProdutosAuditoria()" title='Visualizar'>
				<img width="20px" height="20px" src="../icones/busca.png">
				<strong>Pesquisar</strong>
			</button>
		</div>
	</div>
		<div id="tabelaProdutos" style="width:99%;margin:0px 0.5%;"></div>
	</div>
	<div class="form-actions form-background">
		<button type="button" onclick="incluirProdAuditoria();"  class="btn btn-primary" id="formProduto_submit" name="formProduto_submit">Confirmar</button>  
	</div>
	<div class="modal-footer"></div>
</div>
</div>
</body>
</html>
