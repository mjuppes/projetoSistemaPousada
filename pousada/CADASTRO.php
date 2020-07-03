<?php include("cabecalho.php"); ?>
<form action="" name="formInserirEmpresa" id="formInserirEmpresa"	method="POST" class="form-horizontal" enctype="multipart/form-data">
	<fieldset>
		<div class="control-group">
			<label class="control-label" for="formNome"><strong>Nome</strong></label>
			<div class="controls">
				<input type="text" class="input-xlarge" name="formNome" id="formNome">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formTelefone"><strong>Telefone</strong></label>
			<div class="controls">
				<input type="text" class="input-xlarge" name="formTelefone" id="formTelefone">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formEndereco"><strong>Endereco</strong></label>
			<div class="controls">
				<input type="text" class="input-xlarge" name="formEndereco" id="formEndereco">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="formEmail"><strong>Email</strong></label>
			<div class="controls">
				<input type="text" class="input-xlarge" name="formEmail" id="formEmail">
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary" id="form_submit" name="form_submit">Cadastrar</button>  
		</div>
		<input type="hidden" id="formIdEmpresa" value="">
</fieldset>
</form>
<?php include("rodape.php"); ?>