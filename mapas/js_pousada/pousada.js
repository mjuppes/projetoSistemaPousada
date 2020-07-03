var pagUrl = "viewPousada.php";
var flagBebida = false;

function cadastrarQuarto()
{
	$("#formInserirQuarto").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = "";
			var mensagem = "";

			if(!$("#formIdQuarto").val())
			{
				mensagem = "cadastrado";
				objParametros = eval({'controller' : 'cadastroQuarto'});
			}
			else
			{
				mensagem = "atualizado";
				objParametros = eval({'controller' : 'updateQuarto','formIdPrato' : $("#formIdQuarto").val()});
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#formQuarto_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data == 1)
						{
							alert("Atendimento "+mensagem+" com sucesso!");							
							window.location = "consulta_quartos.php";
						}
						else
						{
							alert("Ocorreu um erro no banco de dados!");
							$('#formPratos_submit').attr('disabled',false);
						}
					}
			});
		},
		invalidHandler: function()
		{
			$(".erros_programa").html("<p>Os seguintes campos est&#227;o inv&#225;lidos:</p>");
		},
	rules:
	{
		formNomeQuarto:
		{
			required: true
		},
		formSelectDisponibilidade:
		{
			required: true
		}
	},
	messages:
	{
		formNomeQuarto:
		{
			required: "Informe o nome do quarto"
		},
		formSelectDisponibilidade:
		{
			required: "Informe a disponibilidade"
		}
	}});
}

function updateQuarto(idquarto)
{
	$("#formQuarto_submit").attr("value","Atualizar");

	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosQuarto',
			idquarto : idquarto
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			$("#formNomeQuarto").val(objeto.nomequarto);
			montaCombo('formSelectDisponibilidade','selectDisponibilidade',idquarto);
			$("#formLocalizacao").val(objeto.localizacao);
			$("#formIdQuarto").val($.query.get('idquarto'));
		}});
		cadastrarQuarto();
}

function montaCombo(form,controller,id,id2,loading)
{
	$("<img src='../img/carregar.gif' class='loadingCombo' id='loading_"+form+"' alt='carregando'/>").insertAfter("#"+form);

	var strDado = "";

	if(id != "")
	{
		if(id2)
			strDado = "controller="+controller+"&id="+id+"&id2="+id2;
		else
			strDado = "controller="+controller+"&id="+id;
	}
	else
		strDado = "controller="+controller;

	$.ajax({
		type: "POST",
		url: pagUrl,
		data: strDado,
		success: function(data)
		{
			if(!data)
			{
				$('#'+form).attr('disabled',true);
				$('#'+form).html(data);
			}
			else
			{
				$('#'+form).html(data);
			}
			$("#loading_"+form).remove();
		}
	});
}

function cadastrarHospede()
{
	$("#formInserirHospede").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = "";
			var mensagem = "";

			if(!$("#formIdHospede").val())
			{
				mensagem = "cadastrado";

				try
				{
					objParametros = eval({'controller' : 'cadastroHospede','formSelectEmpresa':$("#formSelectEmpresa").val()});
				}
				catch(e)
				{
					objParametros = eval({'controller' : 'cadastroHospede'});
				}
			}
			else
			{
				mensagem = "atualizado";
				objParametros = eval({'controller' : 'updateHospede','formIdHospede' : $("#formIdHospede").val()});
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#formQuarto_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data != "Error3")
						{
							if(confirm("Deseja incluir para reserva?"))
							{
								$("#divReserva").show();
								$("#divHospede").hide();
								$("#divCadastroEmpresa").hide();
								$("#divEmpresa").hide();
								$("#divOpcao").hide();
								$("#divPessoaJ").hide();
								montaCombo('formSelectQuarto','selectQuartoCombo');
								cadastrarReserva(data);
							}
						}
						else
						{
							alert("Ocorreu um erro no banco de dados!");
							$('#formHospede_submit').attr('disabled',false);
						}
					}
			});
		},
		invalidHandler: function()
		{
			$(".erros_programa").html("<p>Os seguintes campos est&#227;o inv&#225;lidos:</p>");
		},
	rules:
	{
		formNome:
		{
			required: true
		},
		formSelectSexo:
		{
			required: true
		},
		formDtaReserva:
		{
			required: true
		},
		formCpf:
		{
			required: true		
		},
		formRg:
		{
			required: true
		},
		formSelectEstado:
		{
			required: true
		},
		formSelectCidade:
		{
			required: true
		},
		formEmail:
		{
			required: true
		},
		formDta:
		{
			required: true
		}
	},
	messages:
	{
		formNome:
		{
				required: "Informe o nome do quarto"
		},
		formSelectSexo:
		{
				required: "Informe o sexo"
		},
		formDtaReserva:
		{
				required: "Informe a data de reserva"
		},
		formCpf:
		{
				required: "Informe o cpf"
		},
		formRg:
		{
				required: "Informe o rg"
		},
		formSelectEstado:
		{
				required: "Informe o estado"
		},
		formSelectCidade:
		{
				required: "Informe a cidade"
		},
		formEmail:
		{
				required: "Informe o e-mail"
		},
		formDta:
		{
				required: "Informe a data"
		}
	}});
}



function habilitarDiv(opcao)
{
	switch(opcao)
	{
		case '1':
			$("#divPessoaJ").hide();
		break;
		case '2':
			$("#divPessoaJ").show();
			$("#divPessoaF").hide();
		break;
		case 'S':
			$("#divEmpresa").show();
			montaCombo('formSelectEmpresa','selectEmpresa');
			$("#divCadastroEmpresa").hide();
		break;
		case 'N':
			$("#divCadastroEmpresa").show();
			$("#divEmpresa").hide();
			cadastrarEmpresa();
		break;
	}
}


function cadastrarEmpresa()
{
	$("#formInserirEmpresa").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = "";
			var mensagem = "";

			if(!$("#formIdEmpresa").val())
			{
				mensagem = "cadastrado";
				objParametros = eval({'controller' : 'cadastroEmpresa'});
			}
			else
			{
				mensagem = "atualizado";
				objParametros = eval({'controller' : 'updateEmpresa','formIdPrato' : $("#formIdQuarto").val()});
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#formEmpresa_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data != "Error3")
						{
							var idempresa = data;

							if($("#divCadastroEmpresa").show())
							{
								$("#divEmpresa").show();
								$("#divCadastroEmpresa").hide();
								montaCombo('formSelectEmpresa','selectEmpresa',idempresa);
							}
						}
						else
						{
							alert('Erro ao cadastrar empresa');
							$('#formEmpresa_submit').attr('disabled',true);
						}
					}
			});
		},
		invalidHandler: function()
		{
			$(".erros_programa").html("<p>Os seguintes campos est&#227;o inv&#225;lidos:</p>");
		},
	rules:
	{
		formNomeQuarto:
		{
			required: true
		},
		formSelectDisponibilidade:
		{
			required: true
		}
	},
	messages:
	{
		formNomeQuarto:
		{
			required: "Informe o nome do quarto"
		},
		formSelectDisponibilidade:
		{
			required: "Informe a disponibilidade"
		}
	}});
}

function cadastrarReserva(idlasthosp)
{
	$("#formInserirReserva").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = "";
			var mensagem = "";

			if(!$("#formIdEmpresa").val())
			{
				mensagem = "cadastrado";

				if(idlasthosp)
					objParametros = eval({'controller' : 'cadastroReserva','idlasthosp':idlasthosp});
				else
					objParametros = eval({'controller' : 'cadastroReserva'});
			}
			else
			{
				mensagem = "atualizado";
				objParametros = eval({'controller' : 'updateReserva','formIdPrato' : $("#formIdQuarto").val()});
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#formReserva_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						$('#formReserva_submit').attr('disabled',false);
						getJsonSelect('selectReserva',false,objectConfig,objectLabel,'viewPousada.php');
					}
			});
		},
		invalidHandler: function()
		{
			$(".erros_programa").html("<p>Os seguintes campos est&#227;o inv&#225;lidos:</p>");
		},
	rules:
	{
		formSelectQuarto:
		{
			required: true
		},
		formDtInicial:
		{
			required: true
		},
		formDtFinal:
		{
			required: true
		}
	},
	messages:
	{
		formSelectQuarto:
		{
			required: "Selecione um quarto"
		},
		formDtInicial:
		{
			required: "Informe a data inicial"
		},
		formDtFinal:
		{
			required: "Informe a data final"
		}
	}});
}


function cadastrarReservaHospede()
{
	$("#formInserirReserva").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = "";
			var mensagem = "";

			if(!$("#formIdReserva").val())
			{
				mensagem = "cadastrado";
				objParametros = eval({'controller' : 'cadastroReserva'});
			}
			else
			{
				mensagem = "atualizado";
				objParametros = eval({'controller' : 'updateReserva','formIdReserva' : $("#formIdReserva").val()});
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#formReserva_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data == 8)
						{
							alert("Vaga reservada para esse período!");
							$('#formReserva_submit').attr('disabled',false);
							return false;
						}

						if(data == 4)
						{
							alert("Não existem mais vagas para esse quarto!");
							$('#formReserva_submit').attr('disabled',false);
							return false;
						}

						if(data == 1)
						{
							alert("Reserva "+mensagem+" com sucesso!");

							if($("#formIdReserva").val())
							{
								window.location = "consulta_reservas.php";
								return;
							}

							$('#formReserva_submit').attr('disabled',false);
							$('#formInserirReserva').resetForm();
							montaCombo('formSelectHospede','selectHospede');
							getJsonSelect('selectReserva',false,objectConfig,objectLabel,'viewPousada.php');
						}
						else
						{
							alert("Ocorreu um erro no banco de dados!");
							$('#formReserva_submit').attr('disabled',false);
							return;
						}
					}
			});
		},
		invalidHandler: function()
		{
			$(".erros_programa").html("<p>Os seguintes campos est&#227;o inv&#225;lidos:</p>");
		},
	rules:
	{
		formSelectHospede:
		{
			required: true
		},
		formSelectQuarto:
		{
			required: true
		},
		formDtInicial:
		{
			required: true
		},
		formDtFinal:
		{
			required: true
		},
		formSelectOpcaoQuarto:
		{
			required: true
		}
	},
	messages:
	{
		formSelectHospede:
		{
			required: "Selecione um hóspede"
		},
		formSelectQuarto:
		{
			required: "Selecione um quarto"
		},
		formDtInicial:
		{
			required: "Informe a data inicial"
		},
		formDtFinal:
		{
			required: "Informe a data final"
		},
		formSelectOpcaoQuarto:
		{
			required: "Informe a opção de quarto"
		}
	}});
}


function updateReservaHospede(idreserva)
{
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosReserva',
			idreserva : idreserva
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			montaCombo('formSelectHospede','selectHospedeGeral',objeto.idhospede);
			$('#formSelectHospede').attr('disabled',true);
			montaCombo('formSelectQuarto','selectQuartoCombo',objeto.idquarto);

			$("#formDtInicial").mask("99/99/9999");
			$("#formDtFinal").mask("99/99/9999");
			$("#formDtInicial").val(objeto.datainicial);
			$("#formDtFinal").val(objeto.datafinal);
			montaCombo('formSelectOpcaoQuarto','selectOpcaoQuarto',objeto.opcao);
			$("#formIdReserva").val(idreserva);
			cadastrarReservaHospede();
		}});
}

function excluiReserva(idreserva)
{
	if(!confirm("Deseja realmente excluir?"))
	{
		return false;
	}

	$.ajax({
			type: "POST",
			url: pagUrl,
			data : {
				controller : "deleteReserva",
				idreserva : idreserva
			},
			success: function(data)
			{
					if(data == 1)
					{
						alert('Registro excluido com sucesso!');
						getJsonSelect('selectReservaHospede',false,objectConfig,objectLabel,'viewPousada.php',10);
						getJsonSelect('selectReserva',false,objectConfig1,objectLabel1,'viewPousada.php');
					}
			}
	});
}

function cadastrarVenda()
{


}
/*
function visualizarPrato(idprato)
{
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosPrato',
			idprato : idprato
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			$("#formTipoPrato").html(objeto.nomeprato);
			$("#formPreco").html(objeto.preco);
			$("#formDescricao").html(objeto.descricao);
			$("#formDtAtualizacao").html(objeto.dataatualizacao);
		}});
}

function visualizarAtendimento(idatendimento)
{
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosAtendimento',
			idatendimento : idatendimento
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			$("#formAtendente").html(objeto.nomeatendente);
			$("#formPrato").html(objeto.nomeprato);
			$("#formMesa").html(objeto.nomemesa);
			$("#formPreco").html(objeto.preco);

			if(objeto.nomebebida != null)
			{
				$("#descBebida").show();
				$("#formTBebida").html(objeto.tipobebida);
				$("#formBebida").html(objeto.nomebebida);
				$("#formPBebida").html(objeto.valor);
			}

			$("#formObservacao").html(objeto.observacao);
			$("#formDtAtendimento").html(objeto.dataatendimento);
		}});
}



function habilitaCombo()
{
	if($("#boolBebida").attr("checked"))
	{
		flagBebida = true;
		$("#divBebida").show();
		montaCombo('formSelectTipoBebida','selectTipoBebida');
	}
	else
	{
		flagBebida = false;
		$("#divBebida").hide();
	}
}

function selectComboBebidas(idtipobebida)
{
	$('#formSelectBebida').attr('disabled',false);
	montaCombo('formSelectBebida','selectBebida',true,idtipobebida,false);
}

function cadastrarAtendimento()
{
	$("#formInserirAtendimento").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = "";
			var mensagem = "";

			if(!$("#formIdAtendimento").val())
			{
				mensagem = "cadastrado";
				objParametros = eval({'controller' : 'cadastroAtendimento'});
			}
			else
			{
				mensagem = "atualizado";
				objParametros = eval({'controller' : 'updateAtendimento','formIdAtendimento' : $("#formIdAtendimento").val()});
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#formAtendimento_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data == 1)
						{
							alert("Atendimento "+mensagem+" com sucesso!");

							if($("#formIdAtendimento").val())
							{
								window.location = "consulta_atendimento.php";
								return false;
							}
							$('#formInserirAtendimento').resetForm();
							$('#formAtendimento_submit').attr('disabled',false);
						}
						else
						{
							alert("Ocorreu um erro no banco de dados!");
							$('#formAtendimento_submit').attr('disabled',false);
						}
					}
			});
		},
		invalidHandler: function()
		{
			$(".erros_programa").html("<p>Os seguintes campos est&#227;o inv&#225;lidos:</p>");
		},
	rules:
	{
		formSelectAtendente:
		{
			required: true
		},
		formSelectPrato:
		{
			required:false
		},
		formSelectMesa:
		{
			required:true
		},
		formSelectTipoBebida:
		{
			required: flagBebida
		},
		formSelectBebida:
		{
			required: flagBebida
		},
		formDtAtendimento:
		{
			required: true
		}
	},
	messages:
	{
		formSelectAtendente:
		{
			required: "Por favor selecione uma atendente!"
		},
		formSelectPrato:
		{
			required: "Informe o prato"
		},

		formSelectTipoBebida:
		{
			required: "Selecione o tipo de bebida"
		},
		formSelectMesa:
		{
			required: "Selecione uma mesa"
		},
		formSelectBebida:
		{
			required: "Selecione a bebida"
		},
		formDtAtendimento:
		{
			required: "Informe a data de atendimento"
		}
	}});
}

function updateAtendimento(idatendimento)
{
		$("#formAtendimento_submit").attr("value","Atualizar");
		$.ajax({
			type: "POST",
			url: 'viewPratos.php',
			data : {
				controller : 'selectDadosAtendimento',
				idatendimento : idatendimento
			},
			success: function(data)
			{
				var objeto = eval('(' +data+ ')');
				if(objeto.idbebida != null)
				{
					$("#divBebida").show();
					montaCombo('formSelectTipoBebida','selectTipoBebida',objeto.idtipobebida);
					$('#formSelectBebida').attr('disabled',false);
					montaCombo('formSelectBebida','selectBebida',objeto.idbebida,objeto.idtipobebida);
				}

				montaCombo('formSelectAtendente','selectAtendente',objeto.idatendente);
				montaCombo('formSelectPrato','selectPrato',objeto.idprato);
				montaCombo('formSelectMesa','selectMesa',objeto.idmesa);
				$("#formObservacao").val(objeto.observacao);
				$("#formDtAtendimento").val(objeto.dataatendimento);
				$("#formIdAtendimento").val($.query.get('idatendimento'));
			}});
			cadastrarAtendimento();
}

function cadastrarTipoBebida()
{
	$("#formInserirTipoBebida").validate({
			errorLabelContainer: ".erros",
			wrapper: "li",
			submitHandler: function(form)
			{
				var objParametros = "";
				var mensagem = "";

				if(!$("#formIdTipoBebida").val())
				{
					mensagem = "cadastrado";
					objParametros = eval({'controller' : 'cadastroTipoBebida'});
				}
				else
				{
					mensagem = "atualizado";
					objParametros = eval({'controller' : 'updateTipoBebida','formIdTipoBebida' : $("#formIdTipoBebida").val()});
				}

				$(form).ajaxSubmit({
						dataType: 'post',
						data : objParametros,
						beforeSubmit:
						function()
						{
							$('#formTipoBebida_submit').attr('disabled',true);
						},
						success:
						function (data)
						{
							if(data == 1)
							{
								alert("Categoria "+mensagem+" com sucesso!");
								getJsonSelect('selectCatBebidas',false,objectConfig,objectLabel,'viewPratos.php',5);
								$('#formInserirTipoBebida').resetForm();
								$('#formTipoBebida_submit').attr('disabled',false);
							}
							else
							{
								alert("Ocorreu um erro no banco de dados!");
								$('#formTipoBebida_submit').attr('disabled',false);
							}
						}
				});
			},
			invalidHandler: function()
			{
				$(".erros_programa").html("<p>Os seguintes campos est&#227;o inv&#225;lidos:</p>");
			},
		rules:
		{
			formTipoBebida:
			{
				required: true
			}
		},
		messages:
		{
			formTipoBebida:
			{
				required: "	Informe o tipo de bebida!"
			}
		}});
}

function updateTipoBebida(idtipobebida)
{
	$("#formTipoBebida_submit").attr("value","Atualizar");

	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosTipoBebida',
			idtipobebida : idtipobebida
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			$("#formTipoBebida").val(objeto.tipobebida);
			$("#formIdTipoBebida").val($.query.get('idtipobebida'));
		}});
		cadastrarTipoBebida();
}


function cadastrarBebida()
{
	$("#formInserirBebida").validate({
			errorLabelContainer: ".erros",
			wrapper: "li",
			submitHandler: function(form)
			{
				var objParametros = "";
				var mensagem = "";

				if(!$("#formIdBebida").val())
				{
					mensagem = "cadastrado";
					objParametros = eval({'controller' : 'cadastroBebida'});
				}
				else
				{
					mensagem = "atualizado";
					objParametros = eval({'controller' : 'updateBebida','formIdBebida' : $("#formIdBebida").val()});
				}

				$(form).ajaxSubmit({
						dataType: 'post',
						data : objParametros,
						beforeSubmit:
						function()
						{
							$('#formBebida_submit').attr('disabled',true);
						},
						success:
						function (data)
						{
							if(data == 1)
							{
								alert("Categoria "+mensagem+" com sucesso!");
								if($("#formIdBebida").val())
								{
									window.location = "consulta_bebidas.php";
									return;
								}
								
								$('#formInserirBebida').resetForm();
								$('#formBebida_submit').attr('disabled',false);
							}
							else
							{
								alert("Ocorreu um erro no banco de dados!");
								$('#formBebida_submit').attr('disabled',false);
							}
						}
				});
			},
			invalidHandler: function()
			{
				$(".erros_programa").html("<p>Os seguintes campos est&#227;o inv&#225;lidos:</p>");
			},
		rules:
		{
			formSelectTipoBebida:
			{
				required: true
			},
			formNomeBebida:
			{
				required: true
			},
			formPreco:
			{
				required: true
			}
		},
		messages:
		{
			formSelectTipoBebida:
			{
				required: 'Selecione um tipo de bebida'
			},
			formNomeBebida:
			{
				required: 'Informe o nome da bebida'
			},
			formPreco:
			{
				required: 'Informe um valor'
			}
		}});
}

function updateBebida(idbebida)
{
	$("#formBebida_submit").attr("value","Atualizar");
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosBebida',
			idbebida : idbebida
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			montaCombo('formSelectTipoBebida','selectTipoBebida',objeto.idtipobebida);
			$("#formNomeBebida").val(objeto.nomebebida);
			$("#formPreco").val(objeto.valor);
			$("#formIdBebida").val($.query.get('idbebida'));
		}});
		cadastrarBebida();
}

function visualizarBebida(idbebida)
{

	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosBebida',
			idbebida : idbebida
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			$("#formTipoBebida").html(objeto.tipobebida);
			$("#formNomeBebida").html(objeto.nomebebida);
			$("#formPreco").html(objeto.valor);
		}});

}

function cadastrarAtendente()
{
	$("#formInserirAtendente").validate({
			errorLabelContainer: ".erros",
			wrapper: "li",
			submitHandler: function(form)
			{
				var objParametros = "";
				var mensagem = "";

				if(!$("#formIdAtendente").val())
				{
					mensagem = "cadastrado";
					objParametros = eval({'controller' : 'cadastroAtendente'});
				}
				else
				{
					mensagem = "atualizado";
					objParametros = eval({'controller' : 'updateAtendente','formIdAtendente' : $("#formIdAtendente").val()});
				}

				$(form).ajaxSubmit({
						dataType: 'post',
						data : objParametros,
						beforeSubmit:
						function()
						{
							$('#formAtendente_submit').attr('disabled',true);
						},
						success:
						function (data)
						{
							if(data == 1)
							{
								alert("Categoria "+mensagem+" com sucesso!");
								getJsonSelect('selectAtendenteTable',false,objectConfig,objectLabel,'viewPratos.php');
								$('#formInserirAtendente').resetForm();
								$('#formAtendente_submit').attr('disabled',false);
								
								if($("#formIdAtendente").val())
								{
									$("#formAtendente_submit").attr("value","Cadastrar");
									$("#formIdAtendente").val('');
								}

							}
							else
							{
								alert("Ocorreu um erro no banco de dados!");
								$('#formAtendente_submit').attr('disabled',false);
							}
						}
				});
			},
			invalidHandler: function()
			{
				$(".erros_programa").html("<p>Os seguintes campos est&#227;o inv&#225;lidos:</p>");
			},
		rules:
		{
			formNomeAtendente:
			{
				required: true
			}
		},
		messages:
		{
			formNomeAtendente:
			{
				required: "	Informe o nome da atendente!"
			}
		}});
}

function updateAtendente(idatendente)
{
	$("#formAtendente_submit").attr("value","Atualizar");

	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosAtendente',
			idatendente : idatendente
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			$("#formNomeAtendente").val(objeto.nomeatendente);
			$("#formIdAtendente").val($.query.get('idatendente'));
		}});
		cadastrarAtendente();
}


function cadastrarMesa()
{
	$("#formInserirMesa").validate({
			errorLabelContainer: ".erros",
			wrapper: "li",
			submitHandler: function(form)
			{
				var objParametros = "";
				var mensagem = "";

				if(!$("#formIdMesa").val())
				{
					mensagem = "cadastrado";
					objParametros = eval({'controller' : 'cadastroMesa'});
				}
				else
				{
					mensagem = "atualizado";
					objParametros = eval({'controller' : 'updateMesa','formIdMesa' : $("#formIdMesa").val()});
				}

				$(form).ajaxSubmit({
						dataType: 'post',
						data : objParametros,
						beforeSubmit:
						function()
						{
							$('#formMesa_submit').attr('disabled',true);
						},
						success:
						function (data)
						{
							if(data == 1)
							{
								alert("Categoria "+mensagem+" com sucesso!");
								getJsonSelect('selectMesaTable',false,objectConfig,objectLabel,'viewPratos.php');
								$('#formInserirMesa').resetForm();
								$('#formMesa_submit').attr('disabled',false);

								if($("#formIdMesa").val())
								{
									$("#formMesa_submit").attr("value","Cadastrar");
									$("#formIdMesa").val('');
								}
								
							}
							else
							{
								alert("Ocorreu um erro no banco de dados!");
								$('#formMesa_submit').attr('disabled',false);
							}
						}
				});
			},
			invalidHandler: function()
			{
				$(".erros_programa").html("<p>Os seguintes campos est&#227;o inv&#225;lidos:</p>");
			},
		rules:
		{
			formNomeMesa:
			{
				required: true
			},
			formPosicao:
			{
				required: true
			}
		},
		messages:
		{
			formNomeMesa:
			{
				required: "Informe o nome da mesa"
			},
			formPosicao:
			{
				required: "Informe a posição da mesa"
			}
		}});
}


function updateMesa(idmesa)
{
	$("#formMesa_submit").attr("value","Atualizar");

	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosMesa',
			idmesa : idmesa
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			$("#formNomeMesa").val(objeto.nomemesa);
			$("#formPosicao").val(objeto.posicao);
			$("#formIdMesa").val($.query.get('idmesa'));
		}});
		cadastrarMesa();
}



function buscarAtendimento()
{
	if(!$("#formSelectAtendente").val() && !$("#formSelectPrato").val() && !$("#formSelectMesa").val() && !$("#formDtInicial").val() && !$("#formDtFinal").val() && !$("#formSelectBebida").val())
		alert('Selecione pelo menos um filtro!');
	else
	{
		var objPar ="";

		if($("#formSelectAtendente").val())
			objPar +="&formSelectAtendente="+$("#formSelectAtendente").val();
		if($("#formSelectPrato").val())
			objPar +="&formSelectPrato="+$("#formSelectPrato").val()
		if($("#formSelectMesa").val())
			objPar +="&formSelectMesa="+$("#formSelectMesa").val()
		if($("#formSelectBebida").val())
			objPar +="&formSelectBebida="+$("#formSelectBebida").val()

		if($("#formDtInicial").val() && $("#formDtFinal").val())
			objPar += "&formDtInicial="+$("#formDtInicial").val()+"&formDtFinal="+$("#formDtFinal").val();
		else
		{
			if($("#formDtInicial").val())
				objPar += "&formDtInicial="+$("#formDtInicial").val();
			if($("#formDtFinal").val())
				objPar += "&formDtFinal="+$("#formDtFinal").val();
		}
		getJsonSelect('selectAtendimentos',false,objectConfig,objectLabel,'viewPratos.php',10,false,objPar);
	}
}

function comboJson(form,controller,id,id2,loading)
{
	$("<img src='../img/carregar.gif' class='loadingCombo' id='loading_"+form+"' alt='carregando'/>").insertAfter("#"+form);

	var strDado = "";

	if(id != "")
	{
		if(id2)
			strDado = "controller="+controller+"&id="+id+"&id2="+id2;
		else
			strDado = "controller="+controller+"&id="+id;
	}
	else
		strDado = "controller="+controller;

	$.ajax({
		type: "POST",
		url: pagUrl,
		data: strDado,
		success: function(data)
		{
			if(!data)
			{
				$('#'+form).attr('disabled',true);
				$('#'+form).html(data);
			}
			else
			{
				//var str = data;
				alert(data.nomeatendente);
				$('#'+form).html(data);
			}
			$("#loading_"+form).remove();
		}
	});
}

function excluiMesa(idmesa)
{
	if(!confirm("Deseja realmente excluir?"))
		return false;

	$.ajax({
			type: "POST",
			url: pagUrl,
			data : {
				controller : "deleteMesa",
				idmesa : idmesa
			},
			success: function(data)
			{
					if(data == 1)
					{
						alert('Registro excluido com sucesso!');
						getJsonSelect('selectMesaTable',false,objectConfig,objectLabel,'viewPratos.php',5);
					}
			}
	});
}

function excluiAtendente(idatendente)
{
	if(!confirm("Deseja realmente excluir?"))
		return false;

	$.ajax({type: "POST",
			url: pagUrl,
			data : {
				controller : "deleteAtendente",
				idatendente : idatendente
			},
			success: function(data)
			{
				if(data == 1)
				{
					alert('Registro excluido com sucesso!');
					getJsonSelect('selectAtendenteTable',false,objectConfig,objectLabel,'viewPratos.php');
				}
			}
	});
}*/