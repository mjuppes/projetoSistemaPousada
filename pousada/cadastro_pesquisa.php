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
$(document).ready(function(){
	 var jq17 = jQuery.noConflict();

	if($.query.get('id_pesquisa') && $.query.get('editar'))
	{
		updatePesquisaContato($.query.get('id_pesquisa'));
		return;
	}

	montaCombo('formSelectEstado','selectEstado');
	$('#formSelectCidade').attr('disabled',true);

	$("#formSelectEstado").bind("change",function()
	{
		if($("#formSelectEstado").val() == "")
		{
			$("#formSelectCidade").html("<option>Selecione uma cidade</option>");
			$("#formSelectCidade").attr('disabled',true);

			$("#formSelectContato").html("<option>-- Selecione --</option>");
			$("#formSelectContato").attr('disabled',true);
			return;
		}

		montaCombo('formSelectCidade','selectCidade',$("#formSelectEstado").val());
		$("#formSelectCidade").attr('disabled',false);
	});

	$("#formSelectCidade").bind("change",function()
	{
		if($("#formSelectCidade").val() == "")
		{
			$("#formSelectCidade").html("<option>Selecione uma cidade</option>");
			$("#formSelectCidade").attr('disabled',true);

			$("#formSelectContato").html("<option>-- Selecione --</option>");
			$("#formSelectContato").attr('disabled',true);
			return;
		}

		var id = "id_estado = "+$("#formSelectEstado").val()+" and id_cidade = "+$("#formSelectCidade").val();

		$("#formSelectContato").attr('disabled',false);
		montaCombo('formSelectContato','selectContatosCombo',id);
	});

	$("#formSelectContato").bind("change",function()
	{
		buscaDadosContato($("#formSelectContato").val());
	});
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
<div id="divFiltro">
	<form action="viewPousada.php" name="formLocalizacao" id="formLocalizacao" method="POST" class="form-horizontal" enctype="multipart/form-data">
	<fieldset class='moldura fieldAlerta'>
		<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Localização</strong></center></legend>
			<div class="control-group">
				<label class="control-label" for="formSelectEstado"><strong>Estado:<strong></label>
				<div class="controls">
					<select id="formSelectEstado" style="width:50%;" name="formSelectEstado">
						<option value="">-- Selecione --</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formSelectCidade"><strong>Cidade:<strong></label>
				<div class="controls">
					<select id="formSelectCidade" disabled style="width:50%;" name="formSelectCidade">
						<option value="">-- Selecione --</option>
					</select>
				</div>
			</div>
		</fieldset>
	</form>
</div>

<form action="viewPousada.php" name="formPesquisaContato" id="formPesquisaContato" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <fieldset class='moldura fieldAlerta'>
			<legend class='legend-2' style='background:#e5e5e5;border-radius:7px'><center><strong>Cadastro de Pesquisa</strong></center></legend>
			<div class="control-group">
				<label class="control-label" for="formSelectContato"><strong>Contato:<strong></label>
				<div class="controls">
					<select id="formSelectContato" disabled style="width:50%;" name="formSelectContato" >
						<option value="">-- Selecione --</option>
					</select>
				</div>
			</div>
			<div class="control-group" id="divTelefone">  
				<label class="control-label" for="formTelefone"><strong>Telefone:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge" disabled style="width:50%;"  name="formTelefone" id="formTelefone">
				</div>
			</div>
			<div class="control-group" id="divEndereco">  
				<label class="control-label" for="formEndereco"><strong>Endereço:</strong></label>
					<div class="controls">  
						<input type="text" class="input-xlarge" disabled style="width:50%;"  name="formEndereco" id="formEndereco">
					</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formNome"><strong>Nome:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge" style="width:50%;"  name="formNome" id="formNome">
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formCargo"><strong>Cargo:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge" style="width:50%;"  name="formCargo" id="formCargo">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label"  disabledfor="formSelectEstrelas" disabled><strong>Estrelas:<strong></label>
				<div class="controls">
					<select id="formSelectEstrelas" style="width:32%;" name="formSelectEstrelas">
						<option value="">- Nenhuma -</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formNQuartos"><strong>Nº Quartos:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge" style="width:10%;"  name="formNQuartos" id="formNQuartos">
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="formNColaboradores"><strong>Nº Colaboradores:</strong></label>
				<div class="controls">  
					<input type="text" class="input-xlarge" style="width:10%;"  name="formNColaboradores" id="formNColaboradores">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label"  disabledfor="formSelectOcupacao" disabled><strong>Taxa Ocupação:<strong></label>
				<div class="controls">
					<select id="formSelectOcupacao" style="width:32%;" name="formSelectOcupacao">
						<option value="">- Não informado -</option>
						<option value="10">10 %</option>
						<option value="20">20 %</option>
						<option value="30">30 %</option>
						<option value="40">40 %</option>
						<option value="50">50 %</option>
						<option value="60">60 %</option>
						<option value="70">70 %</option>
						<option value="80">80 %</option>
						<option value="90">90 %</option>
						<option value="10">100 %</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formObservacaoTaxa"><strong>Observações:</strong></label>  
				<div class="controls">  
					<textarea class="input-xlarge" style="width:50%;" name="formObservacaoTaxa" id="formObservacaoTaxa" rows="3"></textarea>  
				</div>
			</div>
			<div class="control-group">
				<label class="control-label"  disabledfor="formSelectSoftware" disabled><strong>Possui Software?<strong></label>
				<div class="controls">
					<select id="formSelectSoftware" style="width:32%;" name="formSelectSoftware" onchange="habilitaPesquisa();">
						<option value="">- Informar -</option>
						<option value="S">Sim</option>
						<option value="N">Não</option>
					</select>
				</div>
			</div>
			<div id="divTemSoftware" style="display:none">
				<div class="control-group"> 
					<label class="control-label" for="formNSoftware"><strong>Qual o nome do Software?</strong></label>
					<div class="controls">  
						<input type="text" class="input-xlarge" style="width:20%;"  name="formNSoftware" id="formNSoftware">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"  disabledfor="formSelectTipoSoftware" disabled><strong>Tipo de Software?<strong></label>
					<div class="controls">
						<select id="formSelectTipoSoftware" style="width:32%;" name="formSelectTipoSoftware">
							<option value="">- Informar -</option>
							<option value="D">Desktop</option>
							<option value="W">Web</option>
						</select>
					</div>
				</div>
				<div class="control-group"> 
					<label class="control-label" for="formSelectTempoUso"><strong>Quanto tempo usa?</strong></label>
					<div class="controls">  
						<select id="formSelectTempoUso" style="width:32%;" name="formSelectTempoUso">
						<option value="">- Não informado -</option>
						<option value="1">1 ano</option>
						<option value="2">2 ano</option>
						<option value="3">3 anos</option>
						<option value="4">4 anos</option>
						<option value="5">5 anos</option>
						<option value="6">6 anos</option>
						<option value="7">7 anos</option>
						<option value="8">8 anos</option>
						<option value="9">9 anos</option>
						<option value="10">10 anos</option>
					</select>
					</div>
				</div>
				<div class="control-group"> 
					<label class="control-label" for="formTempo"><strong>Tempo:</strong></label>
					<div class="controls">  
						<input type="text" class="input-xlarge" style="width:20%;"  name="formTempo" id="formTempo">
					</div>
				</div>
				<div class="control-group"> 
					<label class="control-label" for="formCusto"><strong>Custo do Sistema?</strong></label>
					<div class="controls">  
						<input type="text" class="input-xlarge" style="width:20%;"  name="formCusto" id="formCusto">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"  disabledfor="formSelectSatisfeito" disabled><strong>Está satisfeito com o Software?<strong></label>
					<div class="controls">
						<select id="formSelectSatisfeito" style="width:32%;" name="formSelectSatisfeito">
							<option value="">- Informar -</option>
							<option value="S">Sim</option>
							<option value="N">Não</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formObsSatisfeito"><strong>Observações:</strong></label>  
						<div class="controls">  
							<textarea class="input-xlarge" style="width:50%;" name="formObsSatisfeito" id="formObsSatisfeito" rows="3"></textarea>  
						</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formObsFalta"><strong>O que sente falta?</strong></label>  
						<div class="controls">  
							<textarea class="input-xlarge" style="width:50%;" name="formObsFalta" id="formObsFalta" rows="3"></textarea>  
						</div>
				</div>
				<div class="control-group">
					<label class="control-label"  disabledfor="formSelectSuporte" disabled><strong>Suporte?<strong></label>
					<div class="controls">
						<select id="formSelectSuporte" style="width:32%;" name="formSelectSuporte">
							<option value="">- Informar -</option>
							<option value="S">Sim</option>
							<option value="N">Não</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formObsSuporte"><strong>Observações Suporte:</strong></label>  
					<div class="controls">  
						<textarea class="input-xlarge" style="width:50%;" name="formObsSuporte" id="formObsSuporte" rows="3"></textarea>  
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label"  disabledfor="formSelectPossuiErros" disabled><strong>Possui Erros?<strong></label>
					<div class="controls">
						<select id="formSelectPossuiErros" style="width:32%;" name="formSelectPossuiErros">
							<option value="">- Informar -</option>
							<option value="S">Sim</option>
							<option value="N">Não</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formObsErros"><strong>Observações Erros:</strong></label>  
					<div class="controls">  
						<textarea class="input-xlarge" style="width:50%;" name="formObsErros" id="formObsErros" rows="3"></textarea>
					</div>
				</div>
				<div class="control-group">  
					<label class="control-label" for="formPUtil"><strong>Quantas pessoas o operam?</strong></label>
					<div class="controls">  
						<input type="text" class="input-xlarge" style="width:10%;"  name="formPUtil" id="formPUtil">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formObsControle"><strong>Como é feito controle, gráficos, relatórios?</strong></label>  
					<div class="controls">  
						<textarea class="input-xlarge" style="width:50%;" name="formObsControle" id="formObsControle" rows="3"></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"  disabledfor="formSelectMotor" disabled><strong>Possui motor de vendas?<strong></label>
					<div class="controls">
						<select id="formSelectMotor" style="width:32%;" name="formSelectMotor">
							<option value="">- Informar -</option>
							<option value="S">Sim</option>
							<option value="N">Não</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"  disabledfor="formSelectNFE" disabled><strong>Possui integração NFE?<strong></label>
					<div class="controls">
						<select id="formSelectNFE" style="width:32%;" name="formSelectNFE">
							<option value="">- Informar -</option>
							<option value="S">Sim</option>
							<option value="N">Não</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formObsNFE"><strong>Observações NFE:</strong></label>  
					<div class="controls">  
						<textarea class="input-xlarge" style="width:50%;" name="formObsNFE" id="formObsNFE" rows="3"></textarea>
					</div>
				</div>

			</div>
			<div id="divNaoTemSoftware" style="display:none">
				<div class="control-group">
					<label class="control-label" for="formObsControleAtual"><strong>Como é feito controle, atualmente (planilhas, execel)?</strong></label>  
					<div class="controls">  
						<textarea class="input-xlarge" style="width:50%;" name="formObsControleAtual" id="formObsControleAtual" rows="3"></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="formObsSoftware"><strong>Qual a importância de um software na sua rotina diária?</strong></label>  
					<div class="controls">  
						<textarea class="input-xlarge" style="width:50%;" name="formObsSoftware" id="formObsSoftware" rows="3"></textarea>
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="formObsGerais"><strong>Observações Gerais:</strong></label>  
					<div class="controls">  
						<textarea class="input-xlarge" style="width:50%;" name="formObsGerais" id="formObsGerais" rows="3"></textarea>
					</div>
			</div>
			<div class="control-group">
				<label class="control-label"  disabledfor="formSelectSituacao" disabled><strong>Situação:<strong></label>
				<div class="controls">
					<select id="formSelectSituacao" style="width:32%;" name="formSelectSituacao">
						<option value="">- Informar -</option>
						<option value="R">Retornar Ligação</option>
						<option value="F">Pesquisa Fizalizada</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label"  disabledfor="formSelectPrioridade" disabled><strong>Prioridade do retorno:<strong></label>
				<div class="controls">
					<select id="formSelectPrioridade" style="width:32%;" name="formSelectPrioridade">
						<option value="">- Informar -</option>
						<option value="1">Sim</option>
						<option value="2">Não</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label"  disabledfor="formSelectOperacao" disabled><strong>Operação:<strong></label>
				<div class="controls">
					<select id="formSelectOperacao" style="width:32%;" name="formSelectOperacao">
						<option value="">- Informar -</option>
						<option value="1">Visita</option>
						<option value="2">Venda</option>
					</select>
				</div>
			</div>
			<div class="form-actions form-background">
				<button type="button" class="btn btn-primary" id="formPesquisaContato_submit" name="formPesquisaContato_submit" onclick="cadastrarPesquisaContato();">Finalizar</button>  
			</div>
			<input type="hidden" id="formIdPesquisaContato" value="">
        </fieldset> 
</form>
</body>
</html>
