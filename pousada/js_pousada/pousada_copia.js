var path = "http://177.70.26.45/beaverpousada/";
var pagUrl = path+"pousada/viewPousada.php";

function cadastrarCancelamento()
{
	$("#formInserirCancelamento").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = "";
			var mensagem = "";

			if(!$("#formIdCancelamento").val())
			{
				mensagem = "cadastrado";
				objParametros = eval({'controller' : 'cadastroCancelamento','idreserva' : $.query.get('idreserva')});
			}
			else
			{
				mensagem = "atualizado";
				objParametros = eval({'controller' : 'updateCancelamento','idreserva' : $.query.get('idreserva'),'formIdCancelamento' : $("#formIdCancelamento").val()});
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#formCancelar_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data == 1)
						{
							alert("Cancelamento "+mensagem+" com sucesso!");							
							window.history.go(-1);
						}
						else
						{
							alert("Ocorreu um erro no banco de dados!");
							$('#formCancelar_submit').attr('disabled',false);
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
		formSelectMotivo:
		{
			required: true
		}
	},
	messages:
	{
		formSelectMotivo:
		{
			required: "Informe o motivo"
		}
	}});
}

function cadastrarQuarto()
{
	$("#formInserirQuarto").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = "";
			var mensagem = "";
			var arrItens = Array();

			$("input[type=checkbox][id='item[]']:checked").each(function(){
					arrItens.push($(this).val());
			});

			if(!$("#formIdQuarto").val())
			{
				mensagem = "cadastrado";
				objParametros = eval({'controller' : 'cadastroQuarto','arrItens' : arrItens.toString()});
			}
			else
			{
				mensagem = "atualizado";

				if($("#manutencao").is(":checked"))
				{
					if(!$("#formDtInicial").val() || !$("#formDtFinal").val())
					{
						alert('Por favor informa data inicial e final!');
						return false;
					}

					objParametros = eval({'controller' : 'updateQuarto',
										  'formIdQuarto' : $("#formIdQuarto").val(),
										  'arrItens' : arrItens.toString(),
										  'manutencao':'S',
										  'formDtInicial': $("#formDtInicial").val(),
										  'formDtFinal': $("#formDtFinal").val()});
				}
				else
				{
					objParametros = eval({'controller' : 'updateQuarto',
											'formIdQuarto' : $("#formIdQuarto").val(),
											'arrItens' : arrItens.toString()});
				}
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
							if(!$("#formIdQuarto").val())
							{
								alert("Quarto "+mensagem+" com sucesso!");							
								window.location = "cadastro_precoquarto.php";
							}
							else
							{
								alert("Quarto "+mensagem+" com sucesso!");							
								window.location = "consulta_quartos.php";
							}
						}
						else
						{
							alert("Ocorreu um erro no banco de dados!");
							$('#formQuarto_submit').attr('disabled',false);
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

function cadastrarPrecoQuarto()
{
	$("#formInserirPreco").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var mensagem ="";
			var objParametros = "";

			if(!$("#formIdQuarto").val())
			{
				mensagem = "cadastrado";
				objParametros = eval({'controller' : 'cadastroPreco'});
			}
			else
			{
				mensagem = "atualizado";
				objParametros = eval({'controller' : 'updatePreco','formIdPreco' : $("#formIdPreco").val()});
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#form_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data == 4)
						{
							alert('Valor já cadastrado!');
							$("#formValor").val('');
							$('#form_submit').attr('disabled',false);
							return false;
						}

						if(data == 1)
						{
							if(!confirm("Preço cadastrado deseja cadastrar outro valor?"))
								window.location = "consulta_quartos.php";
							else
							{
								$("#formValor").val('');
								getJsonSelect('selectPrecoQuartoTable',$("#formSelectQuarto").val(),objectConfig,objectLabel,'viewPousada.php');
								$('#form_submit').attr('disabled',false);
							}
						}
						else
						{
							alert("Ocorreu um erro no banco de dados!");
							$('#form_submit').attr('disabled',false);
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
		formSelectQuarto:
		{
			required: true
		},
		formValor:
		{
			required: true
		}
	},
	messages:
	{
		formSelectQuarto:
		{
			required: "Informe o nome do quarto"
		},
		formValor:
		{
			required: "Informe o valor"
		}
	}});
}

function updateQuarto(idquarto)
{
	$("#formQuarto_submit").text("Atualizar");

	$.ajax({
		type: "POST",
		url: pagUrl,
		data :
		{
			controller : 'selectDadosQuarto',
			idquarto : idquarto
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			if(objeto.itens != null)
			{
				var itens = objeto.itens.split("|"); 

				for(var i=0; i<itens.length; i++)
				{
					$("input[type=checkbox][id='item[]']").each(function(){
						if($(this).val() == itens[i])
							this.checked = true;
					});
				}
			}
			
			if(objeto.status == 'S')
			{
				$("#divManutencao").show();
				$("#divPeriodoManutencao").show();
				$("#manutencao").each(function(){ this.checked = true; });
				$("#formDtInicial").val(objeto.datainicial);
				$("#formDtFinal").val(objeto.datafinal);
			}
									 
									 
			$("#formNomeQuarto").val(objeto.nomequarto);
			$("#formQtdVaga").val(objeto.qtdvaga);
			$("#formLocalizacao").val(objeto.localizacao);
			$("#formIdQuarto").val($.query.get('idquarto'));
		}});
		cadastrarQuarto();
}

function montaCombo(form,controller,id,id2)
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
				$('#'+form).html(data);

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
			var opcao = "";

			$("input[type=radio][id='opcao[]']:checked").each(function(){
				opcao = $(this).val();
			});

			if(!opcao)
			{
				alert("Por favor seleciona o tipo de cadastro Físico ou Jurídico!");
				return false;
			}
			
			if(opcao == "J" && !$("#formSelectEmpresa").val())
			{
				alert('Selecione uma empresa!');
				return false;
			}

			if(!$("#formIdHospede").val())
			{
				mensagem = "cadastrado";

				try
				{
					objParametros = eval({'controller' : 'cadastroHospede','formSelectEmpresa':$("#formSelectEmpresa").val(),'opcao':opcao});
				}
				catch(e)
				{
					objParametros = eval({'controller' : 'cadastroHospede','opcao':opcao});
				}
			}
			else
			{
				mensagem = "atualizado";

				try
				{
					objParametros = eval({'controller' : 'updateHospede','formSelectEmpresa':$("#formSelectEmpresa").val(),'opcao':opcao,'formIdHospede' : $("#formIdHospede").val()});
				}
				catch(e)
				{
					objParametros = eval({'controller' : 'updateHospede','formIdHospede' : $("#formIdHospede").val(),'opcao':opcao});
				}
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#formHospede_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data != "Error3")
						{
							if(!$.query.get('editar'))
							{
								if(data == 1)
								{
									if(confirm("Hóspede "+mensagem+" com sucesso, deseja apagar campos?"))
									{
										$('#formHospede_submit').attr('disabled',false);
										$('#formInserirHospede').resetForm();
									}
									else
									{
										$('#formNome').val('');
										$('#formCpf').val('');
										$('#formRg').val('');
										$('#formPassaporte').val('');
										$('#formHospede_submit').attr('disabled',false);
									}
									return;
								}
								else
								{
									alert('erro!');
									$('#formHospede_submit').attr('disabled',false);
									return;
								}

								/*
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
								*/

								if($("#divCadastroEmpresa").show())
								{
									$('#formInserirEmpresa').resetForm();
									$('#formEmpresa_submit').attr('disabled',false);

									$("input[type=radio][id='opcaoE[]']").each(function(){
										$(this).attr('checked', false);
									});
									$("#divPessoaJ").hide();
									
									$("#formSelectEmpresa option[value='']").text();
									$("#divEmpresa").hide()
									
									$("#divCadastroEmpresa").hide();
								}

								$("input[type=radio][id='opcao[]']").each(function(){
									$(this).attr('checked', false);
								});

								$('#formInserirHospede').resetForm();
								$("#formSelectCidade option[value='']").text();
								$("#formSelectCidade").attr('disabled',true);
								$('#formHospede_submit').attr('disabled',false);
								return;
								//else
									//window.location = "consulta_hospedes.php";
							}
							else
							{
								alert("Hóspede "+mensagem+" com sucesso!");
								window.location = "consulta_hospedes.php";
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
			required: false
		},
		formDtaReserva:
		{
			required: false
		},
		formCpf:
		{
			required: false		
		},
		formRg:
		{
			required: false
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
			required: false
		},
		formPassaporte:
		{
			required: false
		},
		formTelefone:
		{
			required: false
		},
		formEndereco:
		{
			required: false
		},
		formDta:
		{
			required: false
		},
		formDtaNascimento:
		{
			required: false
		},
		formTelefone:
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
		formPassaporte:
		{
				required: "Informe o numero do passaporte"
		},
		formTelefone:
		{
				required: "Informe o telefone"
		},
		formEndereco:
		{
				required: "Informe o endereço"
		},
		formDta:
		{
				required: "Informe a data"
		},
		formTelefone:
		{
				required: "Informe o telefone"
		}
	}});
}

function visualizarHospede(idhospede)
{
	$.ajax({
		type: "POST",
		url: "viewPousada.php",
		data : {
			controller : 'selectDadosHospede',
			idhospede : idhospede
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			$("#formHospede").html(objeto.nome);
			$("#formSexo").html(objeto.sexo);

			$("#formSexo").html(objeto.sexo);

			if(!objeto.nomeempresa)
				$("#divE").hide();
			else
			{
				$("#divE").show();
				$("#formEmpresa").html(objeto.nomeempresa);
			}
			
			if(!objeto.nomeagencia)
				$("#divA").hide();
			else
			{
				$("#divA").show();
				$("#formAgencia").html(objeto.nomeagencia);
			}
			

			$("#formDtaChegada").html(objeto.datachegada);
			$("#formMotivo").html(objeto.motivo);
			$("#formBairro").html(objeto.bairro);
			$("#formCpf").html(objeto.cpf);
			$("#formRg").html(objeto.rg);
			$("#formEstado").html(objeto.nomeestado);
			$("#formCidade").html(objeto.nomecidade);
			$("#formEndereco").html(objeto.endereco);
			$("#formEmail").html(objeto.email);
			$("#formTelefone").html(objeto.telefone);
			$("#formDtCadastro").html(objeto.datahoje);
		}});
}

function updateHospede(idhospede)
{
	$("#formHospede_submit").text("Atualizar");
	$.ajax({
		type: "POST",
		url: "viewPousada.php",
		data :
		{
			controller : 'selectDadosHospede',
			idhospede : idhospede
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			if(objeto.opcao == "F")
				$('input:radio[name=opcao]')[0].checked = true;
			else
			{
				$('input:radio[name=opcao]')[1].checked = true;
				$("#divPessoaJ").show();
				$("#divEmpresa").show();

				$('input:radio[name=opcaoE]')[0].checked = true;
				montaCombo('formSelectEmpresa','selectEmpresa',objeto.idempresa);
			}

			$("#formNome").val(objeto.nome);

			montaCombo('formSelectPais','selectPais',objeto.idpais);
			montaCombo('formSelectEstado','selectEstado',objeto.idpais,objeto.idestado);
			$('#formSelectEstado').attr('disabled',false);
			montaCombo('formSelectCidade','selectCidade',objeto.idestado,objeto.idcidade);
			$('#formSelectCidade').attr('disabled',false);
			$("#formCep").val(objeto.cep);
			montaCombo('formSelectAgencia','selectAgenciaCombo',objeto.idagencia);
			$("#formSelectSexo option[value='"+objeto.catSexo+"']").attr("selected","selected");
			$("#formDtaNascimento").val(objeto.datanascimento);
			$("#formCpf").val(objeto.cpf);
			$("#formRg").val(objeto.rg);
			$("#formEmail").val(objeto.email);
			$("#formPassaporte").val(objeto.passaporte);
			$("#formTelefone").val(objeto.telefone);
			$("#formEndereco").val(objeto.endereco);
			$("#formRNE").val(objeto.rne);
			montaCombo('formSelectMotivo','selectMotivoCombo',objeto.idmotivo);
			$("#formBairro").val(objeto.bairro);
			$("#formDtaChegada").val(objeto.datachegada);
			$("#formIdHospede").val($.query.get('idhospede'));
			cadastrarHospede();
		}});
}

function habilitarDiv(opcao)
{
	switch(opcao)
	{
		case 'F':
			$("#divPessoaJ").hide();
		break;
		case 'J':
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
			cadastrarEmpresaHospede();
		break;
	}
}

function cadastrarEmpresaHospede()
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
				mensagem = "cadastrada";

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
			var tipopagamento = "";

			$("input[type=radio][id='opcao[]']:checked").each(function(){
				tipopagamento = $(this).val();
			});

			if(!$("#formIdReserva").val())
			{
				mensagem = "cadastrada";
				objParametros = eval({'controller' : 'cadastroReserva','tipopagamento':tipopagamento});
			}
			else
			{
				mensagem = "atualizada";
				objParametros = eval({'controller' : 'updateReserva','formIdReserva' : $("#formIdReserva").val(),'tipopagamento':tipopagamento});
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
							alert("Capacidade ja foi preenchida!");
							$('#formReserva_submit').attr('disabled',false);
							return false;
						}

						if(data == 1)
						{
							if(confirm("Reserva "+mensagem+" deseja cadastrar outra reserva?"))
							{
								if($("#formIdReserva").val())
								{
									window.location = "consulta_reservas.php";
									return;
								}
								$('#divCartao').hide();
								$('#formReserva_submit').attr('disabled',false);
								montaCombo('formSelectHospede','selectHospede');
							}
							else
							{
								window.location = path+"inicial.php";	
							}
							
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
		},
		formSelectValor:
		{
			required: true
		},
		formSelectTipoPagamento:
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
		},
		formSelectValor:
		{
			required: "Informe o valor"
		},
		formSelectTipoPagamento:
		{
			required: "Informe a forma de pagamento"
		}
	}});
}

function updateReservaHospede(idreserva)
{
	$("#formReserva_submit").text("Atualizar");
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
			montaCombo('formSelectHospede','selectHospedeGeralCombo',objeto.idhospede);
			$('#formSelectHospede').attr('disabled',true);
			montaCombo('formSelectQuarto','selectQuartoCombo',objeto.idquarto);

			$('#formSelectValor').attr('disabled',false);
			montaCombo('formSelectValor','selectValorQuarto',objeto.idquarto,objeto.idpreco);

			$("#formDtInicial").val(objeto.datainicial);
			$("#formDtFinal").val(objeto.datafinal);
			montaCombo('formSelectOpcaoQuarto','selectOpcaoQuarto',objeto.opcao);
			montaCombo('formSelectTipoPagamento','selectTipoPagemento',objeto.idpagamento);
			$("#formObservacao").val(objeto.observacao);
			$("#formIdReserva").val(idreserva);
			cadastrarReservaHospede();
		}});
}

function excluiReserva(idreserva)
{
	$.ajax({
			type: "POST",
			url: pagUrl,
			data : {
				controller : "deleteReserva",
				idreserva : idreserva
			},
			success: function(data)
			{
					if(data == 4)
						$("#mensagem"+idreserva).html('<strong><font color="red" style="text-transform: lowercase;"> Existem pendências abertas para está reserva!</font></strong>');
					else
					{
						$("#divCheckOut"+idreserva).hide();
						$("#mensagem"+idreserva).html('<strong><font color="green" > Saída confirmada!</font></strong>');
					}
			}
	});
}

function visualizarReserva(idreserva)
{
	$.ajax({
		type: "POST",
		url: "pousada/viewPousada.php",
		data : {
			controller : 'selectDadosReserva',
			idreserva : idreserva
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
		
			$("#formQuarto").html(objeto.nomequarto);
			$("#formHospede").html(objeto.nomehospede);
			$("#formDtaInicial").html(objeto.datainicial);
			$("#formDtaFinal").html(objeto.datafinal);
			$("#formOpcao").html(objeto.opcaoQ);
		}});
}

function visualizarReservaIntern(idreserva)
{
	$.ajax({
		type: "POST",
		url: "viewPousada.php",
		data : {
			controller : 'selectDadosReserva',
			idreserva : idreserva
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
		
			$("#formQuarto").html(objeto.nomequarto);
			$("#formHospede").html(objeto.nomehospede);
			$("#formDtaInicial").html(objeto.datainicial);
			$("#formDtaFinal").html(objeto.datafinal);
			$("#formOpcao").html(objeto.opcaoQ);
		}});
}

function visualizarVenda(idhospede)
{
	$.ajax({
		type: "POST",
		url: "pousada/viewPousada.php",
		data : {
			controller : 'selectDadosVenda',
			idhospede : idhospede
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
		
			$("#formQuarto").html(objeto.nomequarto);
			$("#formHospede").html(objeto.nomehospede);
			$("#formDtaInicial").html(objeto.datainicial);
			$("#formDtaFinal").html(objeto.datafinal);
			$("#formOpcao").html(objeto.opcaoQ);
		}});
}

function cadastrarVenda(idvenda)
{
	$("#formInserirVenda").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var opcao = "";
			$("input[type=radio][id='opcao[]']:checked").each(function(){
				opcao = $(this).val();
			});

			var objParametros = "";
			var mensagem = "";

			if(!$("#formIdVenda").val())
			{
				mensagem = "cadastrada";
				objParametros = eval({'controller' : 'cadastroVenda','opcao':opcao});
			}
			else
			{
				mensagem = "atualizada";
				objParametros = eval({'controller' : 'updateVenda','formIdVenda' : $("#formIdVenda").val(),'opcao':opcao});
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#formVenda_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if($("#formIdVenda").val() && data == 1)
						{
							alert("Venda "+mensagem+" com sucesso!");
							window.location = "relatorio_vendas.php";
							return false;
						}

						if(data == 88)
						{
							alert('Produto não está disponível em estoque!');
							$('#formVenda_submit').attr('disabled',false);
							return;
						}
						
						if(data == 77)
						{
							alert('Quantidade maior do que a que está em estoque!');
							$('#formVenda_submit').attr('disabled',false);
							return;
						}
						
						if(data == 99)
						{
							alert('Erro ao gravar movimentação!');
							$('#formVenda_submit').attr('disabled',false);
							return;
						}

						if(data == 1)
						{
							alert("Venda "+mensagem+" com sucesso!");
							montaCombo('formSelectCategoria','selectCategoria');
							$("#formSelectProduto").html("<option value=''>Selecione um valor</option>");
							$("#formSelectProduto").attr('disabled',true);
							$("#formQuantidade").val('');
							$("#formDta").val('');
							$('#formVenda_submit').attr('disabled',false);
							return false;
						}
						else
						{
							alert("Ocorreu erro no banco de dados!");
							$('#formVenda_submit').attr('disabled',false);
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
		formSelectCategoria:
		{
			required: true
		},
		formSelectProduto:
		{
			required: true
		},
		formSelectHospede:
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
		formSelectCategoria:
		{
			required: "Selecione uma categoria"
		},
		formSelectProduto:
		{
			required: "Selecione um produto"
		},
		formSelectHospede:
		{
			required: "Selecione um hóspede"
		},
		formDta:
		{
			required: "Informe a data"
		}
	}});
}

function visualizarVenda(idvenda)
{
	$.ajax({
		type: "POST",
		url: pagUrl,
		data :
		{
			controller : 'selectDadosVenda',
			idvenda : idvenda
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			$("#formNomeHosp").html(objeto.nomehospede);
			$("#formCategoria").html(objeto.nomecategoria);
			$("#formProduto").html(objeto.nomeproduto);
			$("#formDtaVenda").html(objeto.datavenda);
		}});
}

function updateVenda(idvenda)
{
	$("#formVenda_submit").text("Atualizar");
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : 
		{
			controller : 'selectDadosVenda',
			idvenda : idvenda
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			montaCombo('formSelectCategoria','selectCategoria',objeto.idcategoria);
			montaCombo('formSelectProduto','selectProdutos',objeto.idcategoria,objeto.idproduto);
			montaCombo('formSelectHospede','selectHospedeGeralCombo',objeto.idhospede);
			$("#formDta").val(objeto.datavenda);
			$("#formQuantidade").val(objeto.quantidade);
			
			$("#formIdVenda").val(idvenda);
			cadastrarVenda();
		}
	});
}

function visualizarQuarto(idquarto)	
{
	$.ajax({
		type: "POST",
		url: pagUrl,
		data :
		{
			controller : 'selectDadosQuarto',
			idquarto : idquarto
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			$("#formQuarto").html(objeto.nomequarto);
			$("#formQtd").html(objeto.qtdvaga);
			$("#formLocalizacao").html(objeto.localizacao);

			if(objeto.itens != null)
			{
				var itens = objeto.itens.split("|"); 
				var str="";

				for(var i=0; i<itens.length; i++)
				{
					var item = "";

					switch(itens[i])
					{
						case '1': item = "TV";
							break;
						case '2': item = "Ventilador";
							break;
						case '3': item = "Frigobar";
							break;
						case '4': item = "Spliter";
							break;
						case '5': item = "Aquecedor";
							break;
						case '6': item = "Fogão";
							break;
					}

					if(!str)
						str = item;
					else
						str += ","+item;
				}
			}
			$("#formItens").html(str);
		}});
}

function excluiQuarto(idquarto)
{
	if(!confirm("Deseja realmente excluir?"))
		return false;

	$.ajax({
			type: "POST",
			url: pagUrl,
			data : {
				controller : "deleteQuarto",
				idquarto : idquarto
			},
			success: function(data)
			{
					if(data == 1)
						getJsonSelect('selectQuartos',false,objectConfig,objectLabel,'viewPousada.php');
					else
						alert('Ocorreu erro no banco ao exluir registro!');
			}
	});
}

function excluirVenda(idvenda)
{
	if(!confirm("Deseja realmente excluir?"))
		return false;

	$.ajax({
			type: "POST",
			url: pagUrl,
			data :
			{
				controller : "deleteVenda",
				idvenda : idvenda
			},
			success: function(data)
			{
					if(data == 1)
						getJsonSelect('selectVendas',false,objectConfig,objectLabel,'viewPousada.php',10);
					else
						alert('Ocorreu erro no banco ao exluir registro!');
			}
	});
}

function cadastrarEstado()
{
	$("#formInserirEstado").validate({
			errorLabelContainer: ".erros",
			wrapper: "li",
			submitHandler: function(form)
			{
				var objParametros = "";
				var mensagem = "";

				if(!$("#formIdEstado").val())
				{
					mensagem = "cadastrado";
					objParametros = eval({'controller' : 'cadastroEstado'});
				}
				else
				{
					mensagem = "atualizado";
					objParametros = eval({'controller' : 'updateEstado','formIdEstado' : $("#formIdEstado").val()});
				}

				$(form).ajaxSubmit({
						dataType: 'post',
						data : objParametros,
						beforeSubmit:
						function()
						{
							$('#formEstado_submit').attr('disabled',true);
						},
						success:
						function (data)
						{
							if(data == 1)
							{
								alert("Estado "+mensagem+" com sucesso!");
								if($.query.get('editar'))
									window.location = "cadastro_estado.php";
								else
								{
									getJsonSelect('selectTableEstado',false,objectConfig,objectLabel,'viewPousada.php');
									$('#formEstado_submit').attr('disabled',false);
									$('#formInserirEstado').resetForm();
								}
							}
							else
							{
								alert("Ocorreu um erro no banco de dados!");
								$('#formEstado_submit').attr('disabled',false);
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
			formNomeEstado:
			{
				required: true
			},
			formSelectPais:
			{
				required: true
			}
		},
		messages:
		{
			formNomeEstado:
			{
				required: "	Informe o estado!"
			},
			formSelectPais:
			{
				required: "	Informe o pais!"
			}
		}});
}

function updateEstado(idestado)
{
	$("#formEstado_submit").text("Atualizar");
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosEstado',
			idestado : idestado
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			$("#formNomeEstado").val(objeto.nomeestado);
			$("#formIdEstado").val($.query.get('idestado'));

		}});
		cadastrarEstado();
}

function cadastrarPais()
{
	$("#formInserirPais").validate({
			errorLabelContainer: ".erros",
			wrapper: "li",
			submitHandler: function(form)
			{
				var objParametros = "";
				var mensagem = "";

				if(!$("#formIdPais").val())
				{
					mensagem = "cadastrado";
					objParametros = eval({'controller' : 'cadastroPais'});
				}
				else
				{
					mensagem = "atualizado";
					objParametros = eval({'controller' : 'updatePais','formIdPais' : $("#formIdPais").val()});
				}

				$(form).ajaxSubmit({
						dataType: 'post',
						data : objParametros,
						beforeSubmit:
						function()
						{
							$('#formPais_submit').attr('disabled',true);
						},
						success:
						function (data)
						{
							if(data == 1)
							{
								alert("Pais "+mensagem+" com sucesso!");
								if($.query.get('editar'))
									window.location = "cadastro_pais.php";
								else
								{
									getJsonSelect('selectTablePais',false,objectConfig,objectLabel,'viewPousada.php');
									$('#formPais_submit').attr('disabled',false);
									$('#formInserirPais').resetForm();
								}
							}
							else
							{
								alert("Ocorreu um erro no banco de dados!");
								$('#formPais_submit').attr('disabled',false);
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
			formNomePais:
			{
				required: true
			}
		},
		messages:
		{
			formNomePais:
			{
				required: "	Informe o pais!"
			}
		}});
}

function updatePais(idpais)
{
	$("#formPais_submit").text("Atualizar");
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosPais',
			idpais : idpais
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			$("#formNomePais").val(objeto.nomepais);
			$("#formIdPais").val($.query.get('idpais'));

		}});
		cadastrarPais();
}



function updateCidade(idcidade)
{
	$("#formCidade_submit").text("Atualizar");
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosCidade',
			idcidade : idcidade
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			$("#formIdCidade").val(idcidade);
			montaCombo('formSelectEstado','selectEstado',objeto.idestado);
			$("#formNomeCidade").val(objeto.nomecidade);
		}});
		cadastrarCidade();
}

function cadastrarCidade()
{
	$("#formInserirCidade").validate({
			errorLabelContainer: ".erros",
			wrapper: "li",
			submitHandler: function(form)
			{
				var objParametros = "";
				var mensagem = "";

				if(!$("#formIdCidade").val())
				{
					mensagem = "cadastrado";
					objParametros = eval({'controller' : 'cadastroCidade'});
				}
				else
				{
					mensagem = "atualizado";
					objParametros = eval({'controller' : 'updateCidade','formIdCidade' : $("#formIdCidade").val()});
				}
		
				$(form).ajaxSubmit({
						dataType: 'post',
						data : objParametros,
						beforeSubmit:
						function()
						{
							$('#formCidade_submit').attr('disabled',true);
						},
						success:
						function (data)
						{
							$('#formCidade_submit').attr('disabled',false);


								if(data == 1)
								{
									alert("Cidade "+mensagem+" com sucesso!");
									if($.query.get('editar'))
										window.location = "cadastro_cidade.php";
									else
									{
										getJsonSelect('selectTableCidade',false,objectConfig,objectLabel,'viewPousada.php');
										$('#formCidade_submit').attr('disabled',false);
										$('#formInserirCidade').resetForm();
									}
								}
								else
								{
									alert("Ocorreu um erro no banco de dados!");
									$('#formCidade_submit').attr('disabled',false);
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
			formSelectEstado:
			{
				required: true
			},
			formNomeCidade:
			{
				required: true
			}
		},
		messages:
		{
			formSelectEstado:
			{
				required: "	Informe o estado!"
			},
			formNomeCidade:
			{
				required: "	Informe o cidade!"
			}
		}});
}

function excluiCidade(idcidade)
{
	if(!confirm("Deseja realmente excluir?"))
		return false;

	$.ajax({
			type: "POST",
			url: pagUrl,
			data : {
				controller : "deleteCidade",
				idcidade: idcidade
			},
			success: function(data)
			{
					if(data == 1)
						getJsonSelect('selectTableCidade',false,objectConfig,objectLabel,'viewPousada.php');
			}
	});
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
				objParametros = eval({'controller' : 'cadastroEmpresa','form':true});
			}
			else
			{
				mensagem = "atualizado";
				objParametros = eval({'controller' : 'updateEmpresa','formIdEmpresa' : $("#formIdEmpresa").val(),'form':true});
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

						if(data == 1)
						{
							alert("Empresa "+mensagem+" com sucesso!");							
							window.location = "consulta_empresas.php";
						}
						else
						{
							alert("Ocorreu um erro no banco de dados!");
							$('#formEmpresa_submit').attr('disabled',false);
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
		formEmpresa:
		{
			required: true
		},
		formCnpj:
		{
			required: true
		},
		formTelefone:
		{
			required: true
		},
		formIE:
		{
			required: true
		},
		formEndereco:
		{
			required: true
		}
	},
	messages:
	{
		formEmpresa:
		{
			required: "Informe o nome da empresa"
		},
		formCnpj:
		{
			required: "Informe o CNPJ"
		},
		formTelefone:
		{
			required: "Informe o número de telefone"
		},
		formEndereco:
		{
			required: "Informe o endereço"
		},
		formIE:
		{
			required: "Informe a inscrição estadual"
		}
	}});
}

function visualizarEmpresa(idempresa)
{
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosEmpresa',
			idempresa : idempresa
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			$("#formEmpresa").html(objeto.nomeempresa);
			$("#formCnpj").html(objeto.cnpj);
			$("#formTelefone").html(objeto.telefone);
			$("#formFax").html(objeto.fax);
			$("#formEndereco").html(objeto.endereco);
			$("#formIE").html(objeto.inscricaoest);
		}});
}

function updateEmpresa(idempresa)
{
	$("#formEmpresa_submit").text("Atualizar");
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosEmpresa',
			idempresa : idempresa
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			$("#formEmpresa").val(objeto.nomeempresa);
			$("#formCnpj").val(objeto.cnpj);
			$("#formTelefone").val(objeto.telefone);
			$("#formFax").val(objeto.fax);
			$("#formEndereco").val(objeto.endereco)
			$("#formIdEmpresa").val(objeto.idempresa)
			$("#formIE").val(objeto.inscricaoest)
		}
	});
	cadastrarEmpresa();
}

function excluiEmpresa(idempresa)
{
	if(!confirm("Deseja realmente excluir?"))
		return false;

	$.ajax({
			type: "POST",
			url: pagUrl,
			data : {
				controller : "deleteEmpresa",
				idempresa : idempresa
			},
			success: function(data)
			{
					if(data == 1)
						getJsonSelect('selectEmpresaTable',false,objectConfig,objectLabel,'viewPousada.php',10);
			}
	});
}

function buscarRegistrosTabelaHospede()
{
	var objectParametros = "";

	if($("#formSelectEstado").val())
		objectParametros += "&formSelectEstado="+$("#formSelectEstado").val();
	if($("#formSelectCidade").val())
		objectParametros += "&formSelectCidade="+$("#formSelectCidade").val();
	if($("#formSelectEmpresa").val())
		objectParametros += "&formSelectEmpresa="+$("#formSelectEmpresa").val();
	if($("#formSelectSexo").val())
		objectParametros += "&formSelectSexo="+$("#formSelectSexo").val();
	if($("#formNome").val())
		objectParametros += "&formNome="+$("#formNome").val();
	if($("#formDtInicial").val())
		objectParametros += "&formDtInicial="+$("#formDtInicial").val();
	if($("#formDtFinal").val())
		objectParametros += "&formDtFinal="+$("#formDtFinal").val();

	getJsonSelect('selectHospedeGeral',false,objectConfig,objectLabel,'viewPousada.php',10,objectParametros);
}


function buscarRegistrosTabelaEmpresa()
{
	var objectParametros = "";
	if($("#formNomeEmpresa").val())
		objectParametros += "&formNomeEmpresa="+$("#formNomeEmpresa").val();

	getJsonSelect('selectEmpresaTable',false,objectConfig,objectLabel,'viewPousada.php',10,objectParametros);
}


function buscarRegistrosTabelaReserva()
{
	var objectParametros = "";

	if($("#formNome").val())
		objectParametros += "&formNome="+$("#formNome").val();
	if($("#formSelectQuarto").val())
		objectParametros += "&formSelectQuarto="+$("#formSelectQuarto").val();
	if($("#formDtInicial").val())
		objectParametros += "&formDtInicial="+$("#formDtInicial").val();
	if($("#formDtFinal").val())
		objectParametros += "&formDtFinal="+$("#formDtFinal").val();

	getJsonSelect('selectReserva',false,objectConfig,objectLabel,'viewPousada.php',10,objectParametros);
}



function cadastrarProduto()
{
	$('#formInserirProduto').validate({
			errorLabelContainer: '.erros',
			wrapper: 'li',
			submitHandler: function(form)
			{
				var objParametros = "";
				var mensagem = "";

				if(!$("#formIdProduto").val())
				{
					mensagem = "cadastrado";
					objParametros = eval({'controller' : 'cadastroProduto'});
				}
				else
				{
					mensagem = "atualizado";
					objParametros = eval({'controller' : 'updateProduto','formIdProduto' : $("#formIdProduto").val()});
				}

				$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#formProduto_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data == 1)
						{
							alert("Produto "+mensagem+" com sucesso!");							
							window.location = "cadastro_produto.php";
						}
						else
						{
							alert("Ocorreu um erro no banco de dados!");
							$('#formProduto_submit').attr('disabled',false);
						}
					}
				});
			},
			invalidHandler: function()
			{
				$('.erros_programa').html('<p>Os seguintes campos est&#227;o inv&#225;lidos:</p>');
			},
			rules:
			{
				formProduto:
				{
					required: true
				},
				formValor:
				{
					required: true
				},
				formSelectCategoria:
				{
					required: true
				},
				formSelectPE:
				{
					required: true
				}
			},
			messages:
			{
				formProduto:
				{
					required: "Informe o nome do produto"
				},
				formValor:
				{
					required: "Informe um valor"
				},
				formSelectCategoria:
				{
					required: "Informe a categoria"
				},
				formSelectPE:
				{
					required: "Selecione um opção"
				}
			}
	});
}

function visualizarProduto(idproduto)
{
	$.ajax({
		type: "POST",
		url: "viewPousada.php",
		data : {
			controller : 'selectDadosProduto',
			idproduto : idproduto
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			$("#formProduto").html(objeto.nomeproduto);
			$("#formValor").html(objeto.valor);
			$("#formCategoria").html(objeto.nomecategoria);
		}});
}

function updateProduto(idproduto)
{
	$("#formProduto_submit").text("Atualizar");
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosProduto',
			idproduto : idproduto
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			$("#formProduto").val(objeto.nomeproduto);
			$("#formValor").val(objeto.valor);
			montaCombo("formSelectCategoria","selectCategoria",objeto.idcategoria);
			montaCombo("formSelectPE","selectProdutoEstoque",objeto.estoque);
			$("#formIdProduto").val($.query.get('idproduto'));
		}});
		cadastrarProduto();
}

function cadastrarCategoria()
{
	$('#formInserirCategoria').validate({
			errorLabelContainer: '.erros',
			wrapper: 'li',
			submitHandler: function(form)
			{
				var objParametros = "";
				var mensagem = "";

				if(!$("#formIdCategoria").val())
				{
					mensagem = "cadastrado";
					objParametros = eval({'controller' : 'cadastroCategoria'});
				}
				else
				{
					mensagem = "atualizado";
					objParametros = eval({'controller' : 'updateCategoria','formIdCategoria' : $("#formIdCategoria").val()});
				}

				$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#formCategoria_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data == 1)
						{
							alert("Categoria "+mensagem+" com sucesso!");
							window.location = path+"pousada/cadastro_categoria.php";
						}	
						else
						{
							alert("Ocorreu um erro no banco de dados!");
							$('#formCategoria_submit').attr('disabled',false);
						}
					}
				});
			},
			invalidHandler: function()
			{
				$('.erros_programa').html('<p>Os seguintes campos est&#227;o inv&#225;lidos:</p>');
			},
			rules:
			{
				formCategoria:
				{
					required: true
				}
			},
			messages:
			{
				formCategoria:
				{
					required: "Informe a categoria"
				}
			}
	});
}



function cadastrarAgencia()
{
	$("#formInserirAgencia").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = "";
			var mensagem = "";

			if(!$("#formIdAgencia").val())
			{
				mensagem = "cadastrado";
				objParametros = eval({'controller' : 'cadastroAgencia'});
			}
			else
			{
				mensagem = "atualizado";
				objParametros = eval({'controller' : 'updateAgencia','formIdAgencia' : $("#formIdAgencia").val()});
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#formAgencia_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data == 1)
						{
							alert("Agencia "+mensagem+" com sucesso!");							
							window.location = "consulta_agencias.php";
						}
						else
						{
							alert("Ocorreu um erro no banco de dados!");
							$('#formAgencia_submit').attr('disabled',false);
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
		formAgencia:
		{
			required: true
		}
	},
	messages:
	{
		formAgencia:
		{
			required: "Informe o nome!"
		}
	}});
}

function updateAgencia(idagencia)
{
	$("#formAgencia_submit").text("Atualizar");
	$.ajax({
		type: "POST",
		url: pagUrl,
		data :
		{
			controller : 'selectDadosAgencia',
			idagencia : idagencia
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			$("#formAgencia").val(objeto.nomeagencia);
			$("#formContato").val(objeto.contato);
			$("#formObeservacao").val(objeto.obs);
			$("#formIdAgencia").val($.query.get('idagencia'));
		}});
		cadastrarAgencia();
}

function excluiAgencia(idagencia)
{
	if(!confirm("Deseja realmente excluir?"))
	{
		return false;
	}

	$.ajax({
			type: "POST",
			url: pagUrl,
			data : {
				controller : "deleteAgencia",
				idagencia : idagencia
			},
			success: function(data)
			{
					if(data == 1)
						getJsonSelect('selectAgencia',false,objectConfig,objectLabel,'viewPousada.php',10);
					else
						alert('Agência vincula ao hóspede!');
			}
	});
}

function carregaValor(idquarto)
{
	if(!idquarto)
	{
		$("#formSelectValor").html("<option value=''>Selecione um valor</option>");
		$("#formSelectValor").attr('disabled',true);
		$('#formValor').val('');
		$('#formValor').attr('disabled',true);
		$('#form_submit').attr('disabled',true);
		return;
	}
	else
	{
		$('#formSelectValor').attr('disabled',false);
		$('#formValor').attr('disabled',false);
		$('#form_submit').attr('disabled',false);
		montaCombo('formSelectValor','selectValorQuarto',idquarto);
	}
}

function relHospede()
{
	var objectParametros = "";

	if($("#formSelectEstado").val())
		objectParametros += "&formSelectEstado="+$("#formSelectEstado").val();
	if($("#formSelectCidade").val())
		objectParametros += "&formSelectCidade="+$("#formSelectCidade").val();
	if($("#formSelectEmpresa").val())
		objectParametros += "&formSelectEmpresa="+$("#formSelectEmpresa").val();
	if($("#formSelectSexo").val())
		objectParametros += "&formSelectSexo="+$("#formSelectSexo").val();
	if($("#formNome").val())
		objectParametros += "&formNome="+$("#formNome").val();
	if($("#formDtInicial").val())
		objectParametros += "&formDtInicial="+$("#formDtInicial").val();
	if($("#formDtFinal").val())
		objectParametros += "&formDtFinal="+$("#formDtFinal").val();

	window.location = path+"relatorio/rel.php?rel=Hospede&"+objectParametros;
}


function relVenda()
{

	var objPar ="";

	if($("#formSelectHospede").val())
		objPar +="formSelectHospede="+$("#formSelectHospede").val()+"&";

	if($("#formDtInicial").val() && $("#formDtFinal").val())
		objPar += "formDtInicial="+$("#formDtInicial").val()+"&formDtFinal="+$("#formDtFinal").val();
	else
	{
		if($("#formDtInicial").val())
			objPar += "formDtInicial="+$("#formDtInicial").val();
		if($("#formDtFinal").val())
			objPar += "formDtFinal="+$("#formDtFinal").val();
	}
	
	if(objPar)
		objPar += "&filtro=true";

	window.location = path+"relatorio/rel.php?rel=Venda&"+objPar;
}

function relHistorico()
{
	window.location = path+"relatorio/rel.php?rel=Historico";
}

function excluiHospede(idhospede)
{
	if(!confirm("Deseja realmente excluir?"))
	{
		return false;
	}

	$.ajax({
			type: "POST",
			url: pagUrl,
			data : {
				controller : "deleteHospede",
				idhospede : idhospede
			},
			success: function(data)
			{
					if(data == 1)
						getJsonSelect('selectHospedeGeral',false,objectConfig,objectLabel,'viewPousada.php',15);
					else
						alert('Erro ao excluir hospede!');
			}
	});
}

function relHistoricoHp()
{
	window.location = path+"relatorio/rel.php?rel=HistoricoHp&idhospede="+$.query.get('idhospede');
}

function excluiProduto(idproduto)
{
	if(!confirm("Deseja realmente excluir?"))
		return false;

	$.ajax({
			type: "POST",
			url: pagUrl,
			data : {
				controller : "deleteProduto",
				idproduto : idproduto
			},
			success: function(data)
			{
					if(data == 1)
						getJsonSelect('selectProdutosTable',false,objectConfig,objectLabel,'viewPousada.php',10);
					else
						alert('Erro ao excluir hospede!');

			}
	});
}

/*function updatePagamento(idreserva)
{

	alert('teste11');
	/*$("#divPagamento").hide();
	$("#divPagamento").slideDown("slow");

	
	montaCombo('formSelectTransferencia','selectTransferencia');
	montaCombo('formSelecDpAntecipado','selectDpAntecipado');
	$("#formPagamento").val('');
	$('#form_submit').attr('disabled',false);
	$("#idreserva").val(idreserva)
}
*/
function registrarPagamento()
{
	$('#form_submit').attr('disabled',true);
	$.ajax({
		type: "POST",
		url: pagUrl,
		data :
		{
			controller : "registroPagamento",
			formSelectTransferencia: $("#formSelectTransferencia").val(),
			formSelecDpAntecipado: $("#formSelecDpAntecipado").val(),
			formPagamento:$("#formPagamento").val(),
			formData:$("#formData").val(),
			idreserva : $("#idreserva").val()
		},
		success: function(data)
		{
			if(data == 1)
			{
				alert('Valor atualizado!');
				$("#divPagamento").hide();
				getJsonSelect('selectHistoricoReserva',$.query.get('idhospede'),objectConfig_2,objectLabel_2);
			}
			else
			{
				alert('Erro!');
				$('#form_submit').attr('disabled',false);
			}
		}
	});
}

function buscarRegistrosTabelaProduto()
{
	var objectParametros = "";

	if($("#formSelectCategoria").val())
		objectParametros += "&formSelectCategoria="+$("#formSelectCategoria").val();
	if($("#formProdutoStr").val())
		objectParametros += "&formProdutoStr="+$("#formProdutoStr").val();

	getJsonSelect('selectProdutosTable',false,objectConfig,objectLabel,'viewPousada.php',10,objectParametros);
}

function cadastrarPagamento()
{
	$('#formPagamento_submit').attr('disabled',true);

	var objParametros = "";
	var mensagem = "";

	if(!$("#formIdPagamento").val())
	{
		mensagem = "cadastrado";
		objParametros +="controller=cadastroPagamento&";
	}
	else
	{
		mensagem = "atualizado";
		objParametros +="controller=updatePagamento&";
	}
	objParametros +=$("#inserirPagamento").serialize()+"&formIdReserva="+$("#formIdReserva").val();

	$.ajax({
			type: "POST",
			url: pagUrl,
			data: objParametros,
			success: function(data)
			{
				if(data == 1)
				{
					alert("Pagamento "+mensagem+" com sucesso!");
					$('#inserirPagamento').resetForm();
					$('#formPagamento_submit').attr('disabled',false);
					getJsonSelect('selectHistoricoReserva',$.query.get('idhospede'),objectConfig_2,objectLabel_2);
					closeDialogPagamento();
				}
				else
				{
					alert("Ocorreu erro no banco de dados!");
					$('#formPagamento_submit').attr('disabled',false);
				}
			}
	});
}

function updatePagamento(idpagamento)
{
	$("#formPagamento_submit").text("Atualizar");
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosPagamento',
			idpagamento : idpagamento
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			montaCombo('formSelectTransferencia','selectTransferencia',objeto.transferencia);
			montaCombo('formSelecDpAntecipado','selectDpAntecipado',objeto.dpatensipado);
			$("#formData").val(objeto.datapagamento);
			$('#formValor').val(objeto.valor);
			$('#formIdPagamento').val(objeto.idpagamento);
			cadastrarPagamento();
		}});
}

function excluiPagamento(idpagamento)
{
	if(!confirm("Deseja realmente excluir?"))
		return false;

	var objectHideTable = eval([{"value":"idreserva"}]);
	var objectConfig = eval({'gridDiv' : 'tabelaPagamento',
							 'width': 700,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'efect':false,
							 'id':'idpagamento',
							 'title':'Tabela de pagamentos',
							 'colspan':5,
							 'crud':true,
							 'update': 'cadastro_pagamento.php',
							 'delete':"excluiPagamento",
							 'objectHideTable':objectHideTable});

	var objectLabel = eval([{"label":"Transferência","width":'15%'}
							,{"label":"Depósito antecipado","width":'25%'}
							,{"label":"Data efetuada","width":'25%'}
							,{"label":"Valor do pagamento","width":'15%'}
							,{"label":"Responsável pelo pagamento","width":'15%'}
							,{"label":"","width":'10%'}]);
							
	var objectLabel_2 = eval([{"label":"","width":'80%'}
							,{"label":"Valor total","width":'20%'}]);


	var objectConfig_2= eval({'gridDiv' : 'tabelaTotalPagamentos',
							 'width': 700,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'colspan':2});
	
	$.ajax({
			type: "POST",
			url: pagUrl,
			data : {
				controller : "deletePagamento",
				idpagamento : idpagamento
			},
			success: function(data)
			{
					if(data == 1)
					{
						getJsonSelect('selectPagamentos',$("#formIdReservaHidden").val(),objectConfig,objectLabel,'viewPousada.php');
						getJsonSelect('selectTotalPagamentos',$("#formIdReservaHidden").val(),objectConfig_2,objectLabel_2,'viewPousada.php');
					}
					else
						alert('Erro ao excluir pagamento!');

			}
	});
}

function gerarCalendarioReserva()
{
	$.ajax({
			type: "POST",
			url: pagUrl,
			data : {
				controller : "montarCalendario",
				formSelectAno:$("#formSelectAno").val(),
				formSelectMes:$("#formSelectMes").val()
			},
			success: function(data)
			{
				$('#tabela').html(data);
			}
	});
}


function descontoReserva(idreserva)
{
	if(!confirm("Dseja efetuar a regra do desconto?"))
		return false;	

	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : "descontoReserva",
			idreserva:idreserva
		},
		success: function(data)
		{
			if(data == 1)
			{
				alert("Efetuada regra de desconto!");
				getJsonSelect('selectHistoricoReserva',$.query.get('idhospede'),objectConfig_2,objectLabel_2);
			}
			else
				alert("Ocorreu erro no banco de dados");
		}
	});
}


function cadastrarEstoque()
{
	$("#formInserirEstoque").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = "";
			var mensagem = "";

			if(!$("#formIdEstoque").val())
			{
				mensagem = "cadastrado";
				objParametros = eval({'controller' : 'cadastroEstoque'});
			}
			else
			{
				mensagem = "atualizado";
				objParametros = eval({'controller' : 'updateEstoque','formIdEstoque' : $("#formIdEstoque").val()});
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#form_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data == 1)
						{
							alert("Produto "+mensagem+" em  estoque com sucesso!");
							window.location = "consulta_estoque.php";
						}
						else
							alert("Ocorreu erro no banco de dados");
							$('#form_submit').attr('disabled',false);
					}
			});
		},
		invalidHandler: function()
		{
			$(".erros_programa").html("<p>Os seguintes campos est&#227;o inv&#225;lidos:</p>");
		},
		rules:
		{
			formSelectProduto:
			{
				required: true
			},
			formQtd:
			{
				required: true
			}
		},
		messages:
		{
			formSelectProduto:
			{
				required: "Informe o produto"
			},
			formQtd:
			{
				required: "Informe a quantidade"
			}
		}
	
	});
}

function updateEstoque(idestoque)
{
	$("#form_submit").text("Atualizar");
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosEstoque',
			idestoque : idestoque
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			montaCombo('formSelectProduto','selectProdutosEstoque',objeto.idproduto);
			$('#formSelectProduto').attr('disabled',true);
			$('#formQtd').val(objeto.quantidade);
			$('#formIdEstoque').val($.query.get('idestoque'));
			cadastrarEstoque();
		}});
}

var globalIdreserva = "";
function closeDialogDesconto()
{
	$('#myModalDesconto').modal('hide'); 
	$('#formValor').val('');
}

function cadastrarDesconto() 
{

	if(!$('#formValor').val())
	{
		alert('Informar valor do desconto!');
		return false;
	}

	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'descontoReserva',
			idreserva : globalIdreserva,
			valor : $('#formValor').val()
		},
		success: function(data)
		{
			if(data == 1)
			{
				alert("Desconto efetuado!");
				getJsonSelect('selectHistoricoReserva',$.query.get('idhospede'),objectConfig_2,objectLabel_2);
			}
			else
			{
				alert("Ocorreu erro no banco de dados")
			}
		}
	});
	globalIdreserva = "";
	closeDialogDesconto();
}


function closeDialogPagamento()
{
	$('#myModal').modal('hide'); 
	$('#formValor').val('');
}

function descontarReserva(idreserva)
{
	globalIdreserva = idreserva;
}

function updateCategoria(idcategoria)
{
	$("#formCategoria_submit").text("Atualizar");

	$.ajax({
		type: "POST",
		url: pagUrl,
		data :
		{
			controller : 'selectDadosCategoria',
			idcategoria : idcategoria
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			$('#formCategoria').val(objeto.nomecategoria);
			$("#formIdCategoria").val($.query.get('idcategoria'));
		}});
		cadastrarCategoria();
}

function excluiCategoria(idcategoria)
{
	if(!confirm("Deseja realmente excluir?"))
		return false;

	$.ajax({
			type: "POST",
			url: pagUrl,
			data:
			{
				controller : "deleteCategoria",
				idcategoria : idcategoria
			},
			success: function(data)
			{
				if(data == 1)
					getJsonSelect('selectTableCategoria',false,objectConfig,objectLabel,'viewPousada.php');
			}
	});
}

function relGeral()
{
	window.location = path+"relatorio/relatorioGeral.php";
}

function capacidadeDisponivel()
{
	if($("#formDtInicial").val() && $("#formDtFinal").val())
	{
		$.ajax({type: "POST",
				url: pagUrl,
				dataType: 'json',
				data:
				{
					controller : "verificaCapacidade",
					formSelectQuarto : $("#formSelectQuarto").val(),
					formDtInicial:$("#formDtInicial").val(),
					formDtFinal:$("#formDtFinal").val()
				},
				success: function(data)
				{
					alert(data.qtdvaga);
					//$('#formCapacidade").val();		
				}
		});
	
	}
}

function buscarRegistrosTabelaCancelamento()
{

	var objectParametros = "";

	if($("#formNomeCancelamento").val())
		objectParametros += "&formNomeCancelamento="+$("#formNomeCancelamento").val();

	if($("#formSelectQuartoCancelamento").val())
		objectParametros += "&formSelectQuartoCancelamento="+$("#formSelectQuartoCancelamento").val();

	getJsonSelect('selectCancelamento',false,objectConfig_1,objectLabel_1,'viewPousada.php',false,objectParametros);
}


function adicionarValorQuarto()
{
	if(!$("#formValor").val())
	{
		alert('Informar o valor!');
		return false;
	}

	$.ajax({
		type: "POST",
		url: pagUrl,
		data:
		{
			controller : 'cadastroPreco',
			formSelectQuarto : $("#formSelectQuarto").val(),
			formValor : $("#formValor").val()
		},
		success: function(data)
		{
			if(data == 1)
			{
				$("#formValor").val('');
				montaCombo('formSelectValor','selectValorQuarto',$("#formSelectQuarto").val());
				return false;
			}

			if(data == 4)
			{
				alert('Valor já cadastrado!');
				$("#formValor").val('');
				$('#form_submit').attr('disabled',false);
				return false;
			}
			else
			{
				alert('Ocorreu erro no banco de dados!');
				$('#form_submit').attr('disabled',false);
			}
			
		}});
}

function carregaTabPrecoQuarto(obj)
{
	var idquarto = obj.value;
	getJsonSelect('selectPrecoQuartoTable',idquarto,objectConfig,objectLabel,'viewPousada.php');
}

function imprimirFormulario()
{
	window.location = path+"relatorio/rel.php?rel=formularioHospede";
}

function imprimirFormularioReserva()
{
	window.location = path+"relatorio/rel.php?rel=formularioReserva";
}

function getOpcoes()
{
	$('#formReserva_submit').attr('disabled',true);

	var opcaoCheckIn = $("input[id='opcaoCheckIn[]']");
	var opcaoCheckOut = $("input[id='opcaoCheckOut[]']");
	var i=0;

	for(i=0;i<opcaoCheckIn.length;i++)
	{
		if(opcaoCheckIn[i].checked == true)
		{
			validarCheckIn(opcaoCheckIn[i].value);
		}
	}

	for(i=0;i<opcaoCheckOut.length;i++)
	{
		if(opcaoCheckOut[i].checked == true)
			excluiReserva(opcaoCheckOut[i].value);
	}
	$('#formReserva_submit').attr('disabled',false);
}



function verificaData(data1,data2)
{
	var data_1 = $('#'+data1+'').val();
	var data_2 = $('#'+data2+'').val();
	var Compara01 = parseInt(data_1.split("/")[2].toString() + data_1.split("/")[1].toString() + data_1.split("/")[0].toString());
	var Compara02 = parseInt(data_2.split("/")[2].toString() + data_2.split("/")[1].toString() + data_2.split("/")[0].toString());

	if (Compara01 > Compara02)
	{
	   alert('Data final não pode ser menor que a data inicial!');
	   $('#'+data2+'').val('');
	   $('#'+data2+'').focus();
	   
	   return false;
	}
}


function excluiDesconto(iddesconto)
{
	if(!confirm("Deseja realmente excluir?"))
		return false;

	$.ajax({
			type: "POST",
			url: pagUrl,
			data : {
				controller : "deleteDesconto",
				iddesconto : iddesconto
			},
			success: function(data)
			{
					if(data == 1)
						getJsonSelect('selectDescontos',false,objectConfig_3,objectLabel_3,'viewPousada.php',false);
					else
						alert('Ocorreu erro no bando de dados!');
					
			}
	});
}


function buscaEstado(idestado)
{
	$('#formSelectEstado').attr('disabled',false);
	montaCombo('formSelectEstado','selectEstado',idestado);
}

function verificaCEP(valor,endereco,bairro)
{

	$.ajax({
		type: "POST",
		dataType:  'json',
		url: pagUrl,
		data :
		{
			controller : 'verificarCep',
			formCep : valor.value
		},
		success: function(data) 
		{
			$("#"+endereco+"").val(data.complemento);
			$("#"+bairro+"").val(data.bairro);
		}
	});
}



function cadastrarChamado()
{
	$("#formInserirChamado").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = "";
			var mensagem = "";

			if(!$("#formIdChamado").val())
			{
				mensagem = "cadastrado";
				objParametros = eval({'controller' : 'cadastroChamado'});
			}
			else
			{
				mensagem = "atualizado";
				objParametros = eval({'controller' : 'updateChamado','formIdChamado' : $("#formIdChamado").val()});
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#formChamado_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data == 1)
						{
							alert("Chamado "+mensagem+" com sucesso!");							
							window.location = "consulta_chamados.php";
						}
						else
						{
							alert("Ocorreu um erro no banco de dados!");
							$('#formEmpresa_submit').attr('disabled',false);
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
		formTitulo:
		{
			required: true
		},
		formDescricao:
		{
			required: true
		}
	},
	messages:
	{
		formTitulo:
		{
			required: "Informe o titulo"
		},
		formDescricao:
		{
			required: "Informe a descrição"
		}
	}});
}

function excluiChamado(idchamado)
{
	if(!confirm("Deseja realmente chamado?"))
		return false;

	$.ajax({
			type: "POST",
			url: "viewChamado.php",
			data : {
				controller : "deleteChamado",
				idchamado : idchamado
			},
			success: function(data)
			{
					if(data == 1)
						getJsonSelect('selectChamadosTable',false,objectConfig,objectLabel,"viewChamado.php");
					else
						alert('Ocorreu erro no banco ao exluir registro!');
			}
	});	
}

function updateChamado(idchamado)
{
	$("#formChamado_submit").text("Atualizar");
	$("#divChamado").show();

	$.ajax({
		type: "POST",
		url: "viewChamado.php",
		data : 
		{
			controller : 'selectDadosChamado',
			idchamado : idchamado
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			montaComboChamado('formSelectStatus','selectStatus',objeto.status);
			alert(objeto.idchamado+" - "+objeto.titulo+" - "+objeto.descricao+" - "+objeto.status);
			//cadastrarChamado();
		}
	});
}


function montaComboChamado(form,controller,id,id2)
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
		url: "viewChamado.php",
		data: strDado,
		success: function(data)
		{
			if(!data)
			{
				$('#'+form).attr('disabled',true);
				$('#'+form).html(data);
			}
			else
				$('#'+form).html(data);

			$("#loading_"+form).remove();
		}
	});
}

function mostrarPagamentos(key,idreserva)
{
	var idtr = "tr"+key;

	if(($("#trEx").length > 0))
	{
		excliuTr("trEx");
		return;
	}

	var objectLabel = eval([{"label":"Transferência","width":'15%'}
							,{"label":"Depósito antecipado","width":'25%'}
							,{"label":"Data efetuada","width":'25%'}
							,{"label":"Valor do pagamento","width":'15%'}
							,{"label":"Responsável pelo pagamento","width":'15%'}
							,{"label":"","width":'10%'}]);

	var objectHideTable = eval([{"value":"idreserva"}]);

	var objectConfig = eval({'gridDiv' : 'tabelaPagamento',
							 'width': 700,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'efect':false,
							 'id':'idpagamento',
							 'title':'Tabela de pagamentos',
							 'colspan':5,
							 'crud':true,
							 'update': 'cadastro_pagamento.php',
							 'delete':"excluiPagamento",
							 'objectHideTable':objectHideTable});

	var objectLabel_2 = eval([{"label":"","width":'80%'}
							,{"label":"Valor total","width":'20%'}]);


	var objectConfig_2= eval({'gridDiv' : 'tabelaTotalPagamentos',
							 'width': 700,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'colspan':2});

	var objectLabel_3 = eval([{"label":"Valor","width":'95%'}
							,{"label":" ","width":'5%'}]);

	var objectConfig_3= eval({'gridDiv' : 'tabelaTotalDesconto',
							 'width': 700,
							 'class' : 'tabelaPadrao',
							 'id':'iddesconto',
							 'border':1,
							 'crud':true,
							 'delete':"excluiDesconto",
							 'colspan':2});

	getJsonSelect('selectPagamentos',idreserva,objectConfig,objectLabel,'viewPousada.php');
	getJsonSelect('selectTotalPagamentos',idreserva,objectConfig_2,objectLabel_2,'viewPousada.php');
	getJsonSelect('selectDescontos',idreserva,objectConfig_3,objectLabel_3,'viewPousada.php');

	

	var appendTr = "";
		appendTr += '<tr id="trEx">';
		appendTr += '<td  colspan="17" style="text-align: center;">';
		
		appendTr += '<fieldset class="moldura fieldAlertaLista" style="background-color:white">';
		appendTr += '<legend class="legend-2" style="background:#e5e5e5;border-radius:7px">';
		appendTr += '<center>';
		appendTr += '<strong>Lista de pagamentos</strong>';
		appendTr += '</center>';
		appendTr += '</legend>';
		
			appendTr += "<div id='tabelaPagamento'></div>";
			appendTr += "<div id='tabelaTotalPagamentos'></div>";
			appendTr += "<div id='tabelaTotalDesconto'></div>";
			
			appendTr += '<input type="hidden" id="formIdReservaHidden" value="'+idreserva+'">';
		

		appendTr += '</tbody>';
		appendTr += '</table>';

		appendTr += '</fieldset>';
	appendTr += '</td>';
	appendTr += '</td>';
	appendTr += '</tr>';


	$("#tabelaReservas #"+idtr).after(appendTr);

	//$("table#curso1 tbody tr").each(function(){ $(this).removeClass('destaque');});
    /*
	$('table#curso1 tbody tr').hover(
        function(){ $(this).removeClass('destaque');} 
     );
	 */

}



function excliuTr(id)
{
	$("#"+id+"").remove();
}

function habilitarManutencao()
{
	if($("#manutencao").is(":checked") == true)
	{
		$("#formDtInicial").mask("99/99/9999");
		$("#formDtFinal").mask("99/99/9999");
		$("#divPeriodoManutencao").show();
	}
	else
	{
		$("#formDtInicial").val('');
		$("#formDtFinal").val('');
		$("#divPeriodoManutencao").hide();
	}
}

function addHidenPagamento(id)
{
	$("#formIdReserva").val(id);
}

function addHidenDesconto(id)
{
	$("#formIdReserva").val(id);
}