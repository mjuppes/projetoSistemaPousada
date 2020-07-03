var path = "http://177.70.26.45/beaverpousada/";
var pagUrl = path+"pousada/viewPousada.php";

function cadastrarCancelamento()
{
	$("#formInserirCancelamento").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = new Object();
			var mensagem = "";

			if(!$("#formIdCancelamento").val())
			{
				mensagem = "cadastrado";
				objParametros = {'controller' : 'cadastroCancelamento','idreserva' : $.query.get('idreserva')};
			}
			else
			{
				mensagem = "atualizado";
				objParametros = {'controller' : 'updateCancelamento','idreserva' : $.query.get('idreserva'),'formIdCancelamento' : $("#formIdCancelamento").val()};
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
			var objParametros = new Object();
			var mensagem = "";
			var arrItens = Array();

			$("input[type=checkbox][id='item[]']:checked").each(function(){
					arrItens.push($(this).val());
			});

			if(!$("#formIdQuarto").val())
			{
				mensagem = "cadastrado";
				objParametros =
				{
					'controller' : 'cadastroQuarto',
					'arrItens' : arrItens.toString()
				};
			}
			else
			{
				mensagem = "atualizado";

				if($("#manutencao").is(":checked"))
				{
					if(!$("#formDtInicial").val() || !$("#formDtFinal").val())
					{
						alertify.alert('', '<strong><font color="red">Por favor informa data inicial e final!</font></strong>', function(){ alertify.confirm().close(); }).setHeader('');
						return false;
					}

					objParametros = 
					{
						'controller' : 'updateQuarto',
						'formIdQuarto' : $("#formIdQuarto").val(),
						'arrItens' : arrItens.toString(),
						'manutencao':'S',
						'formDtInicial': $("#formDtInicial").val(),
						'formDtFinal': $("#formDtFinal").val()
					};
				}
				else
				{
					objParametros = 
					{
						'controller' : 'updateQuarto',
						'formIdQuarto' : $("#formIdQuarto").val(),
						'arrItens' : arrItens.toString()
					};
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
								alertify.alert('', '<strong><font color="green">Quarto '+mensagem+' com sucesso!</font></strong>',
								function()
								{
									alertify.confirm().close(); 
									window.location = "cadastro_precoquarto.php";
								}).setHeader('');
								
							}
							else
							{
								alertify.alert('', '<strong><font color="green">Quarto '+mensagem+' com sucesso!</font></strong>',
								function()
								{
									alertify.confirm().close();
									window.location = "consulta_quartos.php";
								}).setHeader('');
								
							}
						}
						else
						{
							alertify.alert('', '<strong><font color="red">Ocorreu um erro no banco de dados!</font></strong>', function(){ alertify.confirm().close(); }).setHeader('');
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
			var objParametros = new Object();

			if(!$("#formIdQuarto").val())
			{
				mensagem = "cadastrado";

				objParametros = {'controller' : 'cadastroPreco'};
			}
			else
			{
				mensagem = "atualizado";

				objParametros = 
				{
					'controller' : 'updatePreco',
					'formIdPreco' : $("#formIdPreco").val()
				};
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
							alertify.alert('', '<strong><font color="red">Valor já cadastrado!</font></strong>', function(){ alertify.confirm().close(); }).setHeader('');
							$("#formValor").val('');
							$('#form_submit').attr('disabled',false);
							return false;
						}

						if(data == 1)
						{
							alertify.confirm('','<strong><font color="green">Preço cadastrado deseja cadastrar outro valor?</font></strong>',
								function()
								{ 
									alertify.confirm().close();
									$("#formValor").val('');
									getJsonSelect('selectPrecoQuartoTable',$("#formSelectQuarto").val(),objectConfig,objectLabel,'viewPousada.php');
									$('#form_submit').attr('disabled',false);
								},
								function()
								{ 
									window.location = "consulta_quartos.php";
								}).set('labels', {ok:'Sim', cancel:'Não'}).setHeader('');
						}
						else
						{
							alertify.alert('', '<strong><font color="red">Ocorreu um erro no banco de dados!</font></strong>', function(){ alertify.confirm().close(); }).setHeader('');
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

function montaCombo(form,controller,id,id2,setLast)
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
			
				if(setLast)
					$("#"+form+" option:last").attr("selected", "selected");
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
			var objParametros = new Object();
			var mensagem = "";
			var opcao = "";

			$("input[type=radio][id='opcao[]']:checked").each(function(){
				opcao = $(this).val();
			});

			if(!opcao)
			{
				alertify.alert('', '<strong><font color="red">Por favor seleciona o tipo de cadastro "Físico" ou "Jurídico"!</font></strong>', function(){ alertify.confirm().close(); }).setHeader('');
				return false;
			}
			
			if(opcao == "J" && !$("#formSelectEmpresa").val())
			{
				alertify.alert('', "<strong><font color='red'>Selecione uma empresa!</font></strong>", function(){ alertify.confirm().close(); }).setHeader('');
				return false;
			}

			if(!$("#formIdHospede").val())
			{
				mensagem = "cadastrado";

				try
				{
					objParametros = {'controller' : 'cadastroHospede','formSelectEmpresa':$("#formSelectEmpresa").val(),'opcao':opcao,'formIdLastHosp':$("#formIdLastHosp").val()};
				}
				catch(e)
				{
					objParametros = {'controller' : 'cadastroHospede','opcao':opcao,'formIdLastHosp':$("#formIdLastHosp").val()};
				}
			}
			else
			{
				mensagem = "atualizado";

				try
				{
					objParametros = {'controller' : 'updateHospede','formSelectEmpresa':$("#formSelectEmpresa").val(),'opcao':opcao,'formIdHospede' : $("#formIdHospede").val()};
				}
				catch(e)
				{
					objParametros = {'controller' : 'updateHospede','formIdHospede' : $("#formIdHospede").val(),'opcao':opcao};
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
						
						// alert(data);
						// $('#formHospede_submit').attr('disabled',false);
						// return;
						if(data != "Error3")
						{
							if(!$.query.get('editar'))
							{
								if(data == 1)
								{

									alertify.confirm('','<strong><font color="green">Hóspede '+mensagem+' com sucesso, deseja apagar campos?</font></strong>',
									function()
									{ 
										$('#formHospede_submit').attr('disabled',false);
										$('#formInserirHospede').resetForm();
									},
									function()
									{ 

										$('#formNome').val('');
										$('#formCpf').val('');
										$('#formRg').val('');
										$('#formPassaporte').val('');
										$('#formHospede_submit').attr('disabled',false);
										alertify.confirm().close();

									}).set('labels', {ok:'Sim', cancel:'Não'}).setHeader('');

									return false;
								}
								else
								{
									if($('#formIdLastHosp').val())
										window.location = "cadastro_reserva.php?idhospede="+data+"&formDtInicial="+$.query.get('formDtInicial');
									else
									{
										alertify.alert('', "<strong>erro!</strong>", function(){ alertify.confirm().close(); }).setHeader('');
										$('#formHospede_submit').attr('disabled',false);
										return;
									}
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
			var objParametros = new Object();
			var mensagem = "";

			if(!$("#formIdEmpresa").val())
			{
				mensagem = "cadastrado";
				objParametros = {'controller' : 'cadastroEmpresa'};
			}
			else
			{
				mensagem = "atualizado";
				objParametros = {'controller' : 'updateEmpresa','formIdPrato' : $("#formIdQuarto").val()};
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
			var objParametros = new Object();
			var mensagem = "";

			if(!$("#formIdEmpresa").val())
			{
				mensagem = "cadastrada";

				if(idlasthosp)
					objParametros = {'controller' : 'cadastroReserva','idlasthosp':idlasthosp};
				else
					objParametros = {'controller' : 'cadastroReserva'};
			}
			else
			{
				mensagem = "atualizado";
				objParametros = {'controller' : 'updateReserva','formIdPrato' : $("#formIdQuarto").val()};
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

	var arrIdsHospede = Array();
	$("#formSelectHospSelecionado option").each(function()
	{	
		if($(this).val() != "")
			arrIdsHospede.push($(this).val());
	});

	if(arrIdsHospede.length == 0)
	{
		alertify.alert('', '<strong><font color="red">Selecione o hóspede</font></strong>', function(){ alertify.confirm().close(); }).setHeader('');
		return false;
	}

	if(!erroValidate('formSelectQuarto','Informe o Quarto'))
		return false;

	if(!erroValidate('formDtInicial','Informe a Data Inicial'))
		return false;

	if(!erroValidate('formDtFinal','Informe a Data Final'))
		return false;

	if(!erroValidate('formSelectOpcaoQuarto','Selecione uma opção de quarto'))
		return false;

	if(!erroValidate('formSelectValor','Informe o Valor'))
		return false;
	
	
	if(!CompareDatas($("#formDtInicial").val(),$("#formDtFinal").val()))
	{
		alertify.alert('', " <font color='red'>Data Inicial maior que Data Final</font>", function(){
			alertify.confirm().close(); 
			$("#formDtFinal").val('');
		}).setHeader('');
		return false;
	}

	var objParametros = new Object();
	var mensagem = "";

	if(!$("#formIdReserva").val())
	{
		objParametros.controller = 'cadastroReserva';
		mensagem = "cadastrada";
	}
	else
	{
		objParametros.controller 	= 'updateReserva';
		objParametros.formIdReserva = $("#formIdReserva").val();
		mensagem = "atualizada";
	}

	$("input[type=radio][id='opcao[]']:checked").each(function(){
		objParametros.tipo_pagamento = $(this).val();
	});

	objParametros.arrIdsHospede 		= arrIdsHospede.toString();
	objParametros.formSelectQuarto 		= $("#formSelectQuarto").val();
	objParametros.formSelectValor 		= $("#formSelectValor").val();
	objParametros.formDtInicial			= $("#formDtInicial").val();
	objParametros.formDtFinal			= $("#formDtFinal").val();
	objParametros.formSelectOpcaoQuarto = $("#formSelectOpcaoQuarto").val();

	$('#formReserva_submit').attr('disabled',true);

	$.ajax({
			type: "POST",
			url: pagUrl,
			data : objParametros,
			success: function(data)
			{
				switch(data)
				{
					case '8':
						alertify.alert('', '<strong><font color="red">Vaga reservada para esse período!</font></strong>', function(){ alertify.confirm().close(); }).setHeader('');
						$('#formReserva_submit').attr('disabled',false);
					break;
					case '4':
						alertify.alert('', '<strong><font color="red">Capacidade ja foi preenchida!</font></strong>', function(){ alertify.confirm().close(); }).setHeader('');
						$('#formReserva_submit').attr('disabled',false);
					break;
					case '1':
						alertify.confirm('','<strong><font color="green">Reserva '+mensagem+' deseja cadastrar outra reserva?</font></strong>',
						function()
						{
							if($("#formIdReserva").val())
								window.location = "consulta_reservas.php";
							
							window.location = "cadastro_reserva.php";
						},
						function()
						{ 
							window.location = path+"inicial.php";

						}).set('labels', {ok:'Sim', cancel:'Não'}).setHeader('');
					break;
					default:
						alertify.alert('', '<strong><font color="red">Ocorreu um erro no banco de dados!</font></strong>', function(){ alertify.confirm().close(); }).setHeader('');
						$('#formReserva_submit').attr('disabled',false);
				}
			}
	});
}

function updateReservaHospede(idreserva)
{
	$("#formReserva_submit").text("Atualizar");
	$.ajax({
		type: "POST",
		url: pagUrl,
		data :
		{
			controller : 'selectDadosReservaHospede',
			idreserva : idreserva
		},
		success: function(data)
		{
			var ids_hospedes = data.toString();
			$("#divAutoComplete").hide();
			addHospedeReservaCombo(data,idreserva);
			carregaDadosReserva(idreserva);
		}});
}

function carregaDadosReserva(idreserva)
{
	$.ajax({
		type: "POST",
		url: pagUrl,
		data :
		{
			controller : 'selectDadosReserva',
			idreserva : idreserva
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			montaCombo('formSelectQuarto','selectQuartoCombo',objeto.idquarto);
			$('#formSelectValor').attr('disabled',false);
			montaCombo('formSelectValor','selectValorQuarto',objeto.idquarto,objeto.idpreco);

			$("#formDtInicial").val(objeto.datainicial);
			$("#formDtFinal").val(objeto.datafinal);
			
			$("input[type=radio][id='opcao[]']").filter('[value="'+objeto.tipo_pagamento+'"]').attr('checked', true);
			montaCombo('formSelectOpcaoQuarto','selectOpcaoQuarto',objeto.opcao);
			// montaCombo('formSelectTipoPagamento','selectTipoPagemento',objeto.idpagamento);
			$("#formObservacao").val(objeto.observacao);
			$("#formIdReserva").val(idreserva);
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
					{
						//Colocar o nome do hóspede
						alertify.confirm('<div><strong><font color="black" style="text-transform: ;text-align:center;fontWeight:20px;color:red"> Existem pendências abertas para está reserva!</font></strong></div>').set('basic', true); 
						$("#mensagem"+idreserva).html('<strong><font color="black" style=""> Existem pendências abertas para está reserva!</font></strong>');
					}else
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



function cadastrarVenda()
{
	if(!erroValidate('formSelectCategoria','Selecione a categoria'))
		return false;

	if(!erroValidate('formSelectProduto','Selecione a categoria'))
		return false;
		
	var arrIdsHospede = Array();
	$("#formSelectHospSelecionado option").each(function()
	{	
		if($(this).val() != "")
			arrIdsHospede.push($(this).val());
	});

	if(arrIdsHospede.length == 0)
	{
		if(!erroValidate('formSelectHospSelecionado','Selecione o(s) hóspede(s)'))
			return false;
	}

	var opcao = "";
	$("input[type=radio][id='opcao[]']:checked").each(function(){
		opcao = $(this).val();
	});
	

	if(!erroValidate('formQuantidade','Informe a data'))
		return false;

	if(!erroValidate('formDta','Informe a data'))
		return false;
	
	var objPar = new Object();

	objPar.controller 				= 'cadastroVenda';
	
	objPar.formSelectCategoria		= $("#formSelectCategoria").val();
	objPar.formSelectProduto		= $("#formSelectProduto").val();
	objPar.arrIdsHospede			= arrIdsHospede.toString();
	objPar.opcao 					= opcao;

	if(opcao == 2)
		objPar.formSelectEmpresa 	= $("#formSelectEmpresa").val();

	objPar.formQuantidade 			= $("#formQuantidade").val();
	objPar.formDta 					= $("#formDta").val();
	
	$('#formVenda_submit').attr('disabled',true);

	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data : objPar,
			success: function(data)
			{
				alertify.alert('', '<strong><font color="green">'+data.msg+'!!</font></strong>', function(){ alertify.confirm().close(); }).setHeader('');
				if(data.resposta == 1)
				{
					$("#formSelectHospSelecionado option").each(function()
					{
						if($(this).val() != "")
							$(this).remove();
					});

					$("#formSelectProduto").html("<option value=''>-- Selecione --</option>");
					$('#formSelectProduto').attr('disabled',true);
					$('#formInserirVenda').resetForm();
				}

				$('#formVenda_submit').attr('disabled',false);
			}
	});
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

	alertify.confirm('','<strong><font color="green">Deseja realmente excluir?</font></strong>',
	function()
	{
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
				{
					alertify.confirm().close();
					getJsonSelect('selectQuartos',false,objectConfig,objectLabel,'viewPousada.php');
				}
				else
					alertify.alert('', "<strong>Ocorreu erro no banco ao exluir registro!</strong>", function(){ alertify.confirm().close(); }).setHeader('');
			}
		});
	},
	function()
	{ 
		alertify.confirm().close();
	}).set('labels', {ok:'Sim', cancel:'Não'}).setHeader('');
}

function excluirVenda(idvenda)
{
	alertify.confirm('','<strong><font color="green">Deseja realmente excluir?</font></strong>',
	function()
	{
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
					alertify.alert('', "<strong>Ocorreu erro no banco ao exluir registro!</strong>", function(){ alertify.confirm().close(); }).setHeader('');
			}
		});
	},
	function()
	{ 
		alertify.confirm().close();
	}).set('labels', {ok:'Sim', cancel:'Não'}).setHeader('');

}

function cadastrarEstado()
{
	$("#formInserirEstado").validate({
			errorLabelContainer: ".erros",
			wrapper: "li",
			submitHandler: function(form)
			{
				var objParametros = new Object();
				var mensagem = "";

				if(!$("#formIdEstado").val())
				{
					mensagem = "cadastrado";
					objParametros = {'controller' : 'cadastroEstado'};
				}
				else
				{
					mensagem = "atualizado";
					objParametros = {'controller' : 'updateEstado','formIdEstado' : $("#formIdEstado").val()};
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
				var objParametros = new Object();
				var mensagem = "";

				if(!$("#formIdPais").val())
				{
					mensagem = "cadastrado";
					objParametros = {'controller' : 'cadastroPais'};
				}
				else
				{
					mensagem = "atualizado";
					objParametros = {'controller' : 'updatePais','formIdPais' : $("#formIdPais").val()};
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
				var objParametros = new Object();
				var mensagem = "";

				if(!$("#formIdCidade").val())
				{
					mensagem = "cadastrado";
					objParametros = {'controller' : 'cadastroCidade'};
				}
				else
				{
					mensagem = "atualizado";
					objParametros = {'controller' : 'updateCidade','formIdCidade' : $("#formIdCidade").val()};
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
	alertify.confirm('','<strong><font color="green">Deseja realmente excluir?</font></strong>',
	function()
	{
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
					{
						alertify.confirm().close();
						getJsonSelect('selectTableCidade',false,objectConfig,objectLabel,'viewPousada.php');
					}
				}
		});
	},
	function()
	{ 
		alertify.confirm().close();
	}).set('labels', {ok:'Sim', cancel:'Não'}).setHeader('');

}

function cadastrarEmpresa()
{
	$("#formInserirEmpresa").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = new Object();
			var mensagem = "";

			if(!$("#formIdEmpresa").val())
			{
				mensagem = "cadastrado";
				objParametros = {'controller' : 'cadastroEmpresa','form':true};
			}
			else
			{
				mensagem = "atualizado";
				objParametros = {'controller' : 'updateEmpresa','formIdEmpresa' : $("#formIdEmpresa").val(),'form':true};
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
							alertify.alert('', "<strong>Empresa "+mensagem+" com sucesso!</strong>", function(){ alertify.confirm().close(); window.location = "consulta_empresas.php"; }).setHeader('');
						else
						{

							alertify.alert('', "<strong>Ocorreu um erro no banco de dados!</strong>", function(){ alertify.confirm().close(); }).setHeader('');
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
 	if(!erroValidate('formProduto','Informe nome do produto'))
		return false;
	
	if(!erroValidate('formCodigo','Informe código'))
		return false;

	if(!erroValidate('formValor','Informe o valor'))
		return false;

	if(!erroValidate('formSelectFornecedor','Informe o fornecedor'))
		return false;

	if(!erroValidate('formSelectCategoria','Informe a categoria'))
		return false;

	if(!erroValidate('formDtaCompra','Informe a data da compra'))
		return false;

	if(!erroValidate('formDtaValidade','Informe a data da validade'))
		return false;

	if(!erroValidate('formSelectInsumo','Informe o insumo sim ou não'))
		return false;
	
	if(!erroValidate('formSelectPE','Informe o estoque sim ou não'))
		return false;

	if($('#formSelectPE').val() == 'S')
	{
		if(!erroValidate('formSelectSigla','Informe o tipo de sigla'))
			return false;

		if(!erroValidate('formQuantidade','Informe a quantidade'))
			return false;

		if(!erroValidate('formEstMinino','Informe a quantidade minima'))
			return false;
	
		if(!erroValidate('formEstMaximo','Informe a quantidade máxima'))
			return false;

		if(!erroValidate('formCustoMedio','Informe o estoque sim ou não'))
			return false;
	}

	var objPar = new Object();
	var mensagem = "";

	if(!$("#formIdProduto").val())
	{
		mensagem		  = "cadastrado";
		objPar.controller = 'cadastroProduto';
	}
	else
	{
		mensagem = "atualizado";
		objPar.controller 	 = 'updateProduto';
		objPar.formIdProduto = $("#formIdProduto").val();
	}

	objPar.formProduto 			= $("#formProduto").val();
	objPar.formCodigo 			= $("#formCodigo").val();
	objPar.formValor			= $("#formValor").val();
	objPar.formSelectFornecedor	= $("#formSelectFornecedor").val();
	objPar.formSelectCategoria	= $("#formSelectCategoria").val();
	objPar.formDtaCompra		= $("#formDtaCompra").val();
	objPar.formDtaValidade		= $("#formDtaValidade").val();
	objPar.formSelectInsumo		= $("#formSelectInsumo").val();
	objPar.formSelectPE			= $("#formSelectPE").val();

	if($('#formSelectPE').val() == 'S')
	{
		objPar.formSelectSigla	= $("#formSelectSigla").val();
		objPar.formQuantidade 	= $("#formQuantidade").val();
		objPar.formEstMinino 	= $("#formEstMinino").val();
		objPar.formEstMaximo 	= $("#formEstMaximo").val();
		objPar.formCustoMedio 	= $("#formCustoMedio").val();
	}

	$('#formProduto_submit').attr('disabled',true);

	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data : objPar,
			success: function(data)
			{
				if(data.resposta == 1)
				{
					alertify.alert('', data.msg, function(){ alertify.confirm().close(); }).setHeader('');
					$('#formInserirProduto').resetForm();
					$("#formSelectSigla").html("<option value=''></option>");
					$('#formSelectSigla').attr("disabled",true);
					$('#formQuantidade').val('');
					$('#formEstMinino').val('');
					$('#formEstMaximo').val('');
					$('#formCustoMedio').val('');
					$('#divInfoEstoque').hide();
				}
				else
					alertify.alert('', data.resposta, function(){ alertify.confirm().close(); }).setHeader('');

				$('#formProduto_submit').attr('disabled',false);
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

			$("#formProdutoNome").html(objeto.nomeproduto);
			$("#formFornecedor").html(objeto.nome_fornecedor);
			$("#formCategoria").html(objeto.nomecategoria);
			$("#formValor").html(objeto.valor);
			$("#formUnidade").html(objeto.unidade);
			$("#formDtaCompra").html(objeto.data_compra);
			$("#formDtaValidade").html(objeto.data_validade);
			$("#formDtaCadastro").html(objeto.data_cadastro);

			
			 if(objeto.insumo == 'S')
				 $("#formProdInsumo").html("Sim");
			 if(objeto.insumo == 'N')
				 $("#formProdInsumo").html("Não");

			 if(objeto.estoque == 'S')
				 $("#formProdEstoque").html("Sim");
			 if(objeto.estoque == 'N')
				 $("#formProdEstoque").html("Não");
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
			montaCombo("formSelectFornecedor","selectFornecedor",objeto.id_fornecedor);
			$("#formProduto").val(objeto.nomeproduto);
			$("#formCodigo").val(objeto.codigo);
			$("#formValor").val(objeto.valor);
			montaCombo("formSelectCategoria","selectCategoria",objeto.idcategoria);
			$("#formQuantidade").val(objeto.quantidade);
			$("#formDtaValidade").val(objeto.data_compra);
			$("#formDtaCompra").val(objeto.data_validade);
			montaCombo("formSelectInsumo","selectProdutoInsumo",objeto.insumo);
			montaCombo("formSelectPE","selectProdutoEstoque",objeto.estoque);
			$("#formIdProduto").val($.query.get('idproduto'));
		}});
}

function cadastrarCategoria()
{
	$('#formInserirCategoria').validate({
			errorLabelContainer: '.erros',
			wrapper: 'li',
			submitHandler: function(form)
			{
				var objParametros = new Object();
				var mensagem = "";

				if(!$("#formIdCategoria").val())
				{
					mensagem = "cadastrado";
					objParametros = {'controller' : 'cadastroCategoria'};
				}
				else
				{
					mensagem = "atualizado";
					objParametros = {'controller' : 'updateCategoria','formIdCategoria' : $("#formIdCategoria").val()};
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
							$('#formCategoria').val('');

							
							if($("#formIdCategoria").val())
							{
								$("#formIdCategoria").val('');
								$("#formCategoria_submit").text("Cadastrar");
							}

							alertify.alert('', '<strong>Categoria '+mensagem+' com sucesso!</strong>', '');
							getJsonSelect('selectTableCategoria',false,objectConfig,objectLabel,'viewPousada.php');
							$('#formCategoria_submit').attr('disabled',false);
						}	
						else
						{
							alertify.alert('', '<strong>Ocorreu um erro no banco de dados!</strong>', '');
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
			var objParametros = new Object();
			var mensagem = "";

			if(!$("#formIdAgencia").val())
			{
				mensagem = "cadastrado";
				objParametros = {'controller' : 'cadastroAgencia'};
			}
			else
			{
				mensagem = "atualizado";
				objParametros = {'controller' : 'updateAgencia','formIdAgencia' : $("#formIdAgencia").val()};
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
							alertify.alert('', '<strong><font color="green">Agencia '+mensagem+' com sucesso!</font></strong>', function(){ alertify.confirm().close(); window.location = "consulta_agencias.php"; }).setHeader('');
						else
							alertify.alert('', '<strong><font color="red">Ocorreu erro no banco ao exluir registro!</font></strong>', function(){ alertify.confirm().close(); }).setHeader('');

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


	alertify.confirm('','<strong>Deseja realmente excluir?</strong>',
	function()
	{ 
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
					{
						alertify.confirm().close(); 
						getJsonSelect('selectAgencia',false,objectConfig,objectLabel,'viewPousada.php',10);
					}
					else
						alertify.alert('', '<strong>Agência vincula ao hóspede!</strong>', '');
			}
		});
	},
	function()
	{ 
		alertify.confirm().close(); 
	}).set('labels', {ok:'Sim', cancel:'Não'}).setHeader('');

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

	var arrIdsHospede = Array();
	$("#formSelectHospSelecionado option").each(function()
	{	
		if($(this).val() != "")
			arrIdsHospede.push($(this).val());
	});

	if(arrIdsHospede.length != 0)
		objectParametros += "&formSelectHospede="+arrIdsHospede.toString()+"&";

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

	window.open("http://177.70.26.45/beaverpousada/relatorio/rel.php?rel=Venda&"+objPar);
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
						alertify.alert('', '<strong>Erro ao excluir hospede!</strong>', '');
			}
	});
}

function relHistoricoHp()
{
	window.location = path+"relatorio/rel.php?rel=HistoricoHp&idhospede="+$.query.get('idhospede');
}

function excluiProduto(idproduto)
{
	
	var arrIdsProduto = Array();
	$("input[type=checkbox][name='idproduto[]']").each(function(i)
	{
		if(this.checked)
			arrIdsProduto.push($(this).val());
	});
	
	if(arrIdsProduto.length == 0)
	{
		
		alertify.alert('', "<strong><font color='red'>Nenhum produto foi selecionado!</font></strong>", '');
		return false;
	}

	alertify.confirm('','<strong>Deseja realmente excluir?</strong>',
	function()
	{ 
		$.ajax({
			type: "POST",
			url: pagUrl,
			data :
			{
				controller : "deleteProduto",
				arrIdsProduto : arrIdsProduto.toString()
			},
			success: function(data)
			{
				if(data == 1)
					getJsonSelect('selectProdutosTable',false,objectConfig,objectLabel,'viewPousada.php',10);
				else
					alertify.alert('', '<strong>Erro ao excluir produto!</strong>', '');
			}
		});
	},
	function()
	{ 
		alertify.confirm().close(); 
	}).set('labels', {ok:'Sim', cancel:'Não'}).setHeader('');
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
				alertify.alert('', '<strong>Valor atualizado!</strong>', '');
				$("#divPagamento").hide();
				getJsonSelect('selectHistoricoReserva',$.query.get('idhospede'),objectConfig_2,objectLabel_2);
			}
			else
			{
				alertify.alert('', '<strong>Erro!</strong>', '');
				$('#form_submit').attr('disabled',false);
			}
		}
	});
}

function buscarRegistrosTabelaProduto()
{
	var objectParametros = "";

	if($("#formSelectFornecedor").val())
		objectParametros += "&formSelectFornecedor="+$("#formSelectFornecedor").val();
	if($("#formSelectCategoria").val())
		objectParametros += "&formSelectCategoria="+$("#formSelectCategoria").val();
	if($("#formProdutoStr").val())
		objectParametros += "&formProdutoStr="+$("#formProdutoStr").val();
	if($("#formSelectOrdem").val())
		objectParametros += "&formSelectOrdem="+$("#formSelectOrdem").val();
	
	getJsonSelect('selectProdutosTable',false,objectConfig,objectLabel,'viewPousada.php',10,objectParametros);
}

function cadastrarPagamento()
{
	var objParametros = "";
	var mensagem = "";

	if(!$("#formIdPagamento").val())
	{
		mensagem = "cadastrado";
		objParametros +="controller=cadastroPagamento&";
	}

	if(!erroValidate('formSelectTransferencia','Informe o Tipo de Pagamento'))
		return false;

	if(!erroValidate('formSelecDpAntecipado','Forma de Pagamento'))
		return false;

	if($("#formSelecDpAntecipado").val() == '1')
	{
		if(!erroValidate('formData','Informe a data'))
			return false;

		if(!erroValidate('formValorPagamento','Informe o valor'))
			return false;
	}
	
	if($("#formSelecDpAntecipado").val() == '2')
	{
		if(!erroValidate('formSelectCartao','Informe a Bandeira'))
			return false;

		var opcao = "";
		$("input[type=radio][id='opcao[]']:checked").each(function(){
			opcao = $(this).val();
		});

		if(opcao == 'C')
		{
			if(!erroValidate('formSelectParcelas','Informe o número de parcelas'))
			return false;
		}

		if(!erroValidate('formValorPagamento','Informe o valor'))
			return false;
	}

	if($("#formSelecDpAntecipado").val() == '3')
	{
		if(!erroValidate('formSelectBanco','Informe o banco'))
			return false;
	}
	
	if($("#formSelecDpAntecipado").val() == '4')
	{
		if(!erroValidate('formValorPagamento','Informe o valor'))
			return false;

		if(!erroValidate('formSelectDepBanco','Informe o banco'))
			return false;

		if(!erroValidate('formAgencia','Informe o banco'))
			return false;

		if(!erroValidate('formConta','Informe o banco'))
			return false;

		if(!erroValidate('formSelectTipoConta','Informe o banco'))
			return false;
	}

	$('#formPagamento_submit').attr('disabled',true);
	objParametros +=$("#inserirPagamento").serialize()+"&formIdReserva="+$("#formIdReserva").val();

	$.ajax({
			type: "POST",
			url: pagUrl,
			data: objParametros,
			success: function(data)
			{
				if(data == 1)
				{
					alertify.alert('', "<font color='green'>Pagamento "+mensagem+" com sucesso!</font>", '');
					$('#inserirPagamento').resetForm();
					$('#formPagamento_submit').attr('disabled',false);
					getJsonSelect('selectHistoricoReserva',$.query.get('idhospede'),objectConfig_2,objectLabel_2);
					closeDialogPagamento();
				}
				else
				{
					alertify.alert('', "Ocorreu erro no banco de dados!", '');
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

	alertify.confirm('','<strong>Deseja realmente excluir?</strong>',
		function()
		{ 
			var objectHideTable = [{"value":"idreserva"}];
			var objectConfig = 
			{
				'gridDiv' : 'tabelaPagamento',
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
				'objectHideTable':objectHideTable
			};

			var objectLabel =
			[
				{"label":"Transferência","width":'15%'}
				,{"label":"Depósito antecipado","width":'25%'}
				,{"label":"Data efetuada","width":'25%'}
				,{"label":"Valor do pagamento","width":'15%'}
				,{"label":"Responsável pelo pagamento","width":'15%'}
				,{"label":"","width":'10%'}
			];
							
			var objectLabel_2 =
			[
				{"label":"","width":'80%'}
				,{"label":"Valor total","width":'20%'}
			];


			var objectConfig_2 =
			{
				'gridDiv' : 'tabelaTotalPagamentos',
				'width': 700,
				'class' : 'tabelaPadrao',
				'border':1,
				'colspan':2
			};

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
								alertify.alert('', "Erro ao excluir pagamento!", '');

					}
			});
		},
		function()
		{
			alertify.confirm().close();
		}).set('labels', {ok:'Sim', cancel:'Não'}).setHeader('');

/*
	if(!confirm("Deseja realmente excluir?"))
		return false;

	var objectHideTable = [{"value":"idreserva"}];
	var objectConfig = {'gridDiv' : 'tabelaPagamento',
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
						 'objectHideTable':objectHideTable};

	var objectLabel = [{"label":"Transferência","width":'15%'}
						,{"label":"Depósito antecipado","width":'25%'}
						,{"label":"Data efetuada","width":'25%'}
						,{"label":"Valor do pagamento","width":'15%'}
						,{"label":"Responsável pelo pagamento","width":'15%'}
						,{"label":"","width":'10%'}];
							
	var objectLabel_2 = [{"label":"","width":'80%'}
						,{"label":"Valor total","width":'20%'}];


	var objectConfig_2= {'gridDiv' : 'tabelaTotalPagamentos',
							 'width': 700,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'colspan':2};
	
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
						alertify.alert('', "Erro ao excluir pagamento!", '');

			}
	});
	*/
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
				alertify.alert('', "Efetuada regra de desconto!", '');
				getJsonSelect('selectHistoricoReserva',$.query.get('idhospede'),objectConfig_2,objectLabel_2);
			}
			else
				alertify.alert('',"Ocorreu erro no banco de dados", '');
		}
	});
}

function cadastrarEstoque()
{
	var objPar 	 = new Object();
	var mensagem = "";

	if(!erroValidate('formSelectProduto','Informe o produto'))
		return false;

	if(!erroValidate('formSelectSigla','Informe a sigla de controle'))
		return false;

	if(!erroValidate('formQtd','Informe a quantidade'))
		return false;

	if(!erroValidate('formValor','Informe um valor'))
		return false;

	$('#formEstoque_submit').attr('disabled',true);

	objPar.controller		 	= 'cadastroEstoque';
	objPar.formSelectProduto	= $('#formSelectProduto').val();
	objPar.formSelectSigla		= $('#formSelectSigla').val();
	objPar.formQtd				= $('#formQtd').val();
	objPar.formValor			= $('#formValor').val();
	objPar.formObservacao		= $('#formObservacao').val();

	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data : objPar,
			success: function(data)
			{
				if(data.resposta == 1)
				{
					alertify.alert('',data.msg, '');
					$('#formEstoque_submit').attr('disabled',false);
					montaCombo('formSelectProduto','selectProdutosEstoque',false);
					montaCombo("formSelectSigla","selectSiglaCombo");
					$('#formInserirEstoque').resetForm();
				}
				else
				{
					alertify.alert('',data.resposta, '');
					$('#formEstoque_submit').attr('disabled',false);
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
				alertify.alert('',"Desconto efetuado!", '');
				getJsonSelect('selectHistoricoReserva',$.query.get('idhospede'),objectConfig_2,objectLabel_2);
			}
			else
				alertify.alert('',"Ocorreu erro no banco de dados", '');
		}
	});
	globalIdreserva = "";
	closeDialogDesconto();
}


function closeDialogPagamento()
{
	$('#divDataPagamento').hide();
	$('#divValorPagamento').hide();
	$('#divCartao').hide();
	$('#divBandeira').hide();
	$('#divCheque').hide();
	$('#divDeposito').hide();
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
	alertify.confirm('','<strong>Deseja realmente excluir?</strong>',
		function()
		{ 
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
		},
		function()
		{
			alertify.confirm().close();
		}).set('labels', {ok:'Sim', cancel:'Não'}).setHeader('');
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
					alertify.alert('',data.qtdvaga, '');
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
		alertify.alert('', "<strong><font color='red'>Informe o valor!</font></strong>", function(){ alertify.confirm().close(); }).setHeader('');
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
				montaCombo('formSelectValor','selectValorQuarto',$("#formSelectQuarto").val(),false,true);
				return false;
			}

			if(data == 4)
			{
				alertify.alert('', "<strong><font color='red'>Valor já cadastrado!</font></strong>", function(){ alertify.confirm().close(); }).setHeader('');
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
	window.open(path+"relatorio/rel.php?rel=formularioHospede",'_blank');
}

function imprimirFormularioReserva()
{
	window.open(path+"relatorio/rel.php?rel=formularioReserva",'_blank');
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
			validarCheckIn(opcaoCheckIn[i].value);
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
			var objParametros = new Object();
			var mensagem = "";

			if(!$("#formIdChamado").val())
			{
				mensagem = "cadastrado";
				objParametros = {'controller' : 'cadastroChamado'};
			}
			else
			{
				mensagem = "atualizado";
				objParametros = {'controller' : 'updateChamado','formIdChamado' : $("#formIdChamado").val()};
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

	var objectLabel = [{"label":"Transferência","width":'15%'}
							,{"label":"Depósito antecipado","width":'25%'}
							,{"label":"Data efetuada","width":'15%'}
							,{"label":"Valor do pagamento","width":'15%'}
							,{"label":"Responsável pelo pagamento","width":'25%'}
							,{"label":"","width":'10%'}];

	var objectHideTable = [{"value":"idreserva"}];

	var objectConfig = {'gridDiv' : 'tabelaPagamento',
							 'width': 700,
							 'class' : 'tabelaPadrao',
							 'border':1,
							 'efect':false,
							 'id':'idpagamento',
							 'title':'Tabela de pagamentos',
							 'colspan':5,
							 'crud':true,
							 'record':false,
							 'delete':"excluiPagamento",
							 'objectHideTable':objectHideTable};

	var objectLabel_2 = [{"label":"","width":'80%'}
						,{"label":"Valor total","width":'20%'}];


	var objectConfig_2= {'gridDiv' : 'tabelaTotalPagamentos',
						 'width': 700,
						 'class' : 'tabelaPadrao',
						 'border':1,
						 'record':false,
						 'colspan':2};

	var objectLabel_3 = [{"label":"Valor","width":'95%'}
							,{"label":" ","width":'5%'}];

	var objectConfig_3= {'gridDiv' : 'tabelaTotalDesconto',
						 'width': 700,
						 'class' : 'tabelaPadrao',
						 'id':'iddesconto',
						 'border':1,
						 'crud':true,
						 'record':false,
						 'delete':"excluiDesconto",
						 'colspan':2};

	getJsonSelect('selectPagamentos',idreserva,objectConfig,objectLabel,'viewPousada.php');
	getJsonSelect('selectTotalPagamentos',idreserva,objectConfig_2,objectLabel_2,'viewPousada.php');
	getJsonSelect('selectDescontos',idreserva,objectConfig_3,objectLabel_3,'viewPousada.php');

	

	var appendTr = "";
		appendTr += '<tr id="trEx">';
		appendTr += '<td  colspan="17" style="text-align: center;background-color:white;">';
		
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


function montaPainelAcoes()
{
	var objParametros = new Object();
	objParametros = {'controller' : 'montarPainelConfig'};
	$.ajax({
		type: "POST",
		url: pagUrl,
		dataType : 'json',
		data : objParametros,
		success: function(data)
		{
			$("#titulo").html(data.titulo);
			$("#list_config").html(data.html);
		}
	});	
}


function montaPainelAcoesModulo(idmodulo)
{
	var objParametros = new Object();
	objParametros = {'controller' : 'montaPainelAcoesModulo','idmodulo':idmodulo};
	$.ajax({
		type: "POST",
		url: pagUrl,
		dataType : 'json',
		data : objParametros,
		success: function(data)
		{
			$("#titulo").html(data.titulo);
			$("#list_config").html(data.html);
		}
	});	
}

function montaPainelAcoesModuloSubMenu(iditens)
{

	var objParametros = new Object();
	objParametros = {'controller' : 'montaPainelAcoesModuloSubMenu','iditens':iditens};
	$.ajax({
		type: "POST",
		url: pagUrl,
		dataType : 'json',
		data : objParametros,
		success: function(data)
		{
			$("#titulo").html(data.titulo);
			$("#list_config").html(data.html);
		}
	});	
}

function cadastrarFornecedor()
{
	$("#formInserirFornecedor").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objPar = new Object();
			var mensagem = "";

			if(!$("#formIdFornecedor").val())
			{
				mensagem = "cadastrado";
				objPar.controller = 'cadastroFornecedor';
			}
			else
			{
				mensagem = "atualizado";
				
				objPar.controller = 'updateFornecedor';
				objPar.formIdFornecedor = $("#formIdFornecedor").val();
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objPar,
					beforeSubmit:
					function()
					{
						$('#formFornecedor_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data == 1)
						{
							alertify.confirm('','<strong><font color="green">Fornecedor '+mensagem+' com sucesso ir para lista?</font></strong>',
								function()
								{ 
									alertify.confirm().close();
									window.location = "consulta_fornecedor.php";
								},
								function()
								{ 
									$('#formInserirFornecedor').resetForm();
									$('#formFornecedor_submit').attr('disabled',false);
							}).set('labels', {ok:'Sim', cancel:'N&atilde;o'}).setHeader('');
						}
						else
						{
							alertify.alert('', "<strong>Ocorreu erro no banco ao exluir registro!</strong>", function(){ alertify.confirm().close(); }).setHeader('');
							$('#formFornecedor_submit').attr('disabled',false);
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
		formFornecedor:
		{
			required: true
		},
		formSelectTipoForn:
		{
			required: true
		},
		formSelectDepBanco:
		{
			required: true
		},
		formAgencia:
		{
			required: true
		},
		formConta:
		{
			required: true
		},
		formSelectTipoConta:
		{
			required: true
		},
		formCpfCnpj:
		{
			required: true
		},
		formEndereco:
		{
			required: true
		},
		formTelefone:
		{
			required: true
		},
		formObeservacao:
		{
			required: false
		}
	},
	messages:
	{
		formFornecedor:
		{
			required: 'Informe o nome do fornecedor'
		},
		formSelectTipoForn:
		{
			required: 'Informe o tipo de categoria'
		},
		formSelectDepBanco:
		{
			required: 'Informe o banco!'
		},
		formAgencia:
		{
			required: 'Informe a agência'
		},
		formConta:
		{
			required: 'Informe a conta!'
		},
		formSelectTipoConta:
		{
			required: 'Informe o tipo de conta'
		},
		formCpfCnpj:
		{
			required: 'Informe o cpf ou cnpj'
		},
		formEndereco:
		{
			required: 'Informe o endereço'
		},
		formTelefone:
		{
			required: 'Informe o telefone'
		},
		formObeservacao:
		{
			required: false
		}
	}
	});
}

function updateFornecedor(id_fornecedor)
{
	$("#formFornecedor_submit").text("Atualizar");

	$.ajax({
		type: "POST",
		url: pagUrl,
		dataType:'json',
		data :
		{
			controller : 'selectDadosFornecedor',
			id_fornecedor : id_fornecedor
		},
		success: function(data)
		{
			$("#formFornecedor").val(data.nome);
			montaCombo('formSelectTipoForn','selectComboTipoFornecedor',data.id_tipo_fornecedor);
			$("#formCpfCnpj").val(data.cpfcnpj);
			$("#formEndereco").val(data.endereco);
			$("#formTelefone").val(data.telefone);
			$("#formObeservacao").val(data.observacao);
			$("#formIdFornecedor").val(data.id_fornecedor);
		}});
		cadastrarFornecedor();
}


function excluiFornecedor(id_fornecedor)
{
	alertify.confirm('','<strong><font color="green">Deseja realmente excluir?</font></strong>',
	function()
	{ 
		$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data : {
				controller : "deleteFornecedor",
				id_fornecedor : id_fornecedor
			},
			success: function(data)
			{
				if(data.resposta == 1)
				{
					alertify.confirm().close();
					getJsonSelect('selectTableFornecedor',false,objectConfig,objectLabel);
				}
				else
					alertify.alert('', "<strong>Ocorreu erro no banco ao exluir registro!</strong>", function(){ alertify.confirm().close(); }).setHeader('');
			}
		});
	},
	function()
	{
		alertify.confirm().close();
	}).set('labels', {ok:'Sim', cancel:'Não'}).setHeader('');

}

function cadastrarUnidade()
{
	$("#formInserirUnidade").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objPar = new Object();
			var mensagem = "";

			if(!$("#formIdUnidade").val())
			{
				mensagem = "cadastrado";
				objPar.controller = 'cadastroUnidade';
			}
			else
			{
				mensagem = "atualizado";
				
				objPar.controller = 'updateUnidade';
				objPar.formIdUnidade = $("#formIdUnidade").val();
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objPar,
					beforeSubmit:
					function()
					{
						$('#formUnidade_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data == 1)
						{
							if(confirm("Unidade "+mensagem+" com sucesso, ir para lista?"))
								window.location = "consulta_unidades.php";
							else
							{
								$('#formInserirUnidade').resetForm();
								$('#formUnidade_submit').attr('disabled',false);
							}
						}
						else
						{
							alert("Ocorreu um erro no banco de dados!");
							$('#formUnidade_submit').attr('disabled',false);
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
		formUnidade:
		{
			required: true
		},
		formQuantidade:
		{
			number:true,
			required: true
		},
		formDescricao:
		{
			required: false
		}
	},
	messages:
	{
		formUnidade:
		{
			required: 'Informe o nome da unidade!'
		},
		formQuantidade:
		{
			required: 'Informe o valor!'
		},
		formDescricao:
		{
			required: 'Informe o endereço'
		}
	}
});
}



function updateUnidade(id_unidade)
{
	$("#formUnidade_submit").text("Atualizar");

	$.ajax({
		type: "POST",
		url: pagUrl,
		dataType:'json',
		data :
		{
			controller : 'selectDadosUnidade',
			id_unidade : id_unidade
		},
		success: function(data)
		{
			$("#formUnidade").val(data.unidade);
			$("#formQuantidade").val(data.quantidade);
			$("#formDescricao").val(data.descricao);
			$("#formIdUnidade").val(data.id_unidade);
		}});
		cadastrarUnidade();
}


function excluiUnidade(id_unidade)
{
	if(!confirm("Deseja realmente excluir?"))
		return false;

	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data : {
				controller : "deleteUnidade",
				id_unidade : id_unidade
			},
			success: function(data)
			{
					if(data.resposta == 1)
						getJsonSelect('selectTableUnidade',false,objectConfig,objectLabel);
					else
						alert('Ocorreu erro no banco ao exluir registro!');
			}
	});
}

function cadastrarTipoFornecedor()
{
	$("#formInserirTipoFornecedor").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objPar = new Object();
			var mensagem = "";

			mensagem = "cadastrado";
			objPar.controller = 'cadastroTipoFornecedor';

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objPar,
					beforeSubmit:
					function()
					{
						$('#formTipoFornecedor_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data == 1)
						{
							if(confirm("Tipo de fornecedor "+mensagem+" com sucesso, ir para lista?"))
								window.location = "consulta_tipo_fornecedor.php";
							else
							{
								$('#formInserirTipoFornecedor').resetForm();
								$('#formTipoFornecedor_submit').attr('disabled',false);
							}
						}
						else
						{
							alert("Ocorreu um erro no banco de dados!");
							$('#formTipoFornecedor_submit').attr('disabled',false);
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
		formTipoFornecedor:
		{
			required: true
		},
		formDescricao:
		{
			required: false
		}
	},
	messages:
	{
		formUnidade:
		{
			required: 'Informe o nome da unidade!'
		},
		formDescricao:
		{
			required: 'Informe o endereço'
		}
	}
});
}


function excluiTipoFornecedor(id_tipo_fornecedor)
{
	if(!confirm("Deseja realmente excluir?"))
		return false;

	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data : {
				controller : "deleteTipoFornecedor",
				id_tipo_fornecedor : id_tipo_fornecedor
			},
			success: function(data)
			{
					if(data.resposta == 1)
						getJsonSelect('selectTableTipoFornecedor',false,objectConfig,objectLabel);
					else
						alert('Ocorreu erro no banco ao exluir registro!');
			}
	});
}



function buscarRegistrosTabelaFornecedor()
{
	var objectParametros = "";
	
	if($("#formFornecedorStr").val())
		objectParametros += "&formFornecedorStr="+$("#formFornecedorStr").val();
	if($("#formSelectTipoForn").val())
		objectParametros += "&formSelectTipoForn="+$("#formSelectTipoForn").val();

	getJsonSelect('selectTableFornecedor',false,objectConfig,objectLabel,'viewPousada.php',10,objectParametros);
}

function mostraProdutosInsumo()
{
	
	var objectLabel = [{"label":"","width":"5%"}
						,{"label":"Código","width":"10%"}
						,{"label":"Produto","width":"30%"}
						,{"label":"Valor","width":"10%"}];

	var objectConfig = {'gridDiv' : 'tabelaProdutos',
						 'width': 100,
						 'class' : 'tabelaPadrao',
						 'border':1,
						 'radio':true,
						 'id':'idproduto'};

	var objectParametros = "";
	
	if($("#formStr").val())
	{
		objectParametros += "&formStr="+$("#formStr").val();
		getJsonSelect('selectProdutosInsumo',false,objectConfig,objectLabel,'viewPousada.php',false,objectParametros);
	}
	else
	{
		getJsonSelect('selectProdutosInsumo',false,objectConfig,objectLabel);
	}
}

function incluirInsumo()
{
	
	var idproduto = "";

	$("input[type=radio][id='idproduto[]']:checked").each(function(){
		idproduto = $(this).val();
	});

	if(!idproduto)
	{
		alert("Por favor selecionar um produto!");
		return false;
	}

	$('#myModal').modal('hide'); 
	montaCombo('formSelectProduto','selectProdutosEstoque',idproduto);
	$('#formSelectProduto').attr('disabled',true);
}

function cadastrarLancamentoInsumo()
{
	var objPar = new Object();
	var mensagem = "";

	if(!erroValidate('formSelectProduto','Informe o produto'))
		return false;
	
	if(!erroValidate('formSelectHistorico','Informe o historico'))
		return false;
	
	if(!erroValidate('formQuantidade','Informe a quantidade'))
		return false;
	
	mensagem				 	= "cadastrado";
	objPar.controller		 	= 'cadastroLancamentoInsumo';
	objPar.formSelectProduto 	= $('#formSelectProduto').val();
	objPar.formSelectHistorico	= $('#formSelectHistorico').val();
	objPar.formQuantidade		= $('#formQuantidade').val();
	objPar.formDescricao		= $('#formDescricao').val();

	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data : objPar,
			success: function(data)
			{
				if(data.resposta == 1)
				{
					alert(data.msg);
					$('#formSelectProduto').html("<option value=''>Produto selecionado...</option>");
					$('#formInserirLancaInsumo').resetForm();
				}
				else
					alert(data.resposta);
			}
	});
}

function buscarTabelaLancamentoInsumo()
{
	var objectParametros = "";
	
	if($("#formInsumoStr").val())
		objectParametros += "&formInsumoStr="+$("#formInsumoStr").val();
	if($("#formSelectHistorico").val())
		objectParametros += "&formSelectHistorico="+$("#formSelectHistorico").val();

	getJsonSelect('selectTableLancamentoInsumo',false,objectConfig,objectLabel,'viewPousada.php',10,objectParametros);
}

function buscarTabelaLancamentoAuditoria()
{
	var objectParametros = "";
	
	if($("#formInsumoStr").val())
		objectParametros += "&formInsumoStr="+$("#formInsumoStr").val();
	if($("#formSelectHistorico").val())
		objectParametros += "&formSelectHistorico="+$("#formSelectHistorico").val();

	getJsonSelect('selectTableLancamentoAuditoria',false,objectConfig,objectLabel,'viewPousada.php',10,objectParametros);
}

function mostraProdutosAuditoria()
{
	
	var objectLabel = [{"label":"","width":"15%"}
						,{"label":"Código","width":"15%"}
						,{"label":"Produto","width":"15%"}
						,{"label":"Valor","width":"10%"}];

	var objectConfig = {'gridDiv' : 'tabelaProdutos',
						 'width': 100,
						 'class' : 'tabelaPadrao',
						 'border':1,
						 'radio':true,
						 'id':'idproduto'};

	var objectParametros = "";
	
	if($("#formStr").val())
	{
		objectParametros += "&formStr="+$("#formStr").val();
		getJsonSelect('selectProdutosAuditoria',false,objectConfig,objectLabel,'viewPousada.php',false,objectParametros);
	}
	else
		getJsonSelect('selectProdutosAuditoria',false,objectConfig,objectLabel);

}

function incluirProdAuditoria()
{
	var idproduto = "";

	$("input[type=radio][id='idproduto[]']:checked").each(function(){
		idproduto = $(this).val();
	});

	if(!idproduto)
	{
		alert("Por favor selecionar um produto!");
		return false;
	}

	$('#myModal').modal('hide'); 
	montaCombo('formSelectProduto','selectProdutosEstoque',idproduto);
	$('#formSelectProduto').attr('disabled',true);
}

function cadastrarControleAuditoria()
{
	var objPar = new Object();
	var mensagem = "";

	if(!erroValidate('formSelectProduto','Informe o produto'))
		return false;
	
	if(!erroValidate('formSelectHistorico','Informe o historico'))
		return false;

	if(!erroValidate('formQuantidade','Informe a quantidade'))
		return false;

	if(!erroValidate('formDescricao','Informe uma descrição'))
		return false;

	mensagem				 	= "cadastrado";
	objPar.controller		 	= 'cadastroControleAuditoria';
	objPar.formSelectProduto 	= $('#formSelectProduto').val();
	objPar.formSelectHistorico	= $('#formSelectHistorico').val();
	objPar.formQuantidade		= $('#formQuantidade').val();
	objPar.formDescricao		= $('#formDescricao').val();

	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data : objPar,
			success: function(data)
			{
				if(data.resposta == 1)
				{
					alert(data.msg);
					$('#formSelectProduto').html("<option value=''>Produto selecionado...</option>");
					$('#formInserirLancaInsumo').resetForm();
				}
				else
					alert(data.resposta);
			}
	});	
}

function habilitarInfoEstoque()
{
	if($('#formSelectPE').val() == "S")
	{
		$('#divInfoEstoque').show();
		$('#formCustoMedio').priceFormat({
			prefix: '',
			centsSeparator: ',',
			thousandsSeparator: '.'
		});

		$('#formSelectSigla').attr("disabled",false);
		montaCombo("formSelectSigla","selectSiglaCombo");
	}
	else
	{
		$("#formSelectSigla").html("<option value=''></option>");
		$('#formSelectSigla').attr("disabled",true);
		$('#formQuantidade').val('');
		$('#formEstMinino').val('');
		$('#formEstMaximo').val('');
		$('#formCustoMedio').val('');
		$('#divInfoEstoque').hide();
	}
}

function imprimirProdutos()
{
	var objectParametros = "";

	if($("#formSelectFornecedor").val())
		objectParametros += "&formSelectFornecedor="+$("#formSelectFornecedor").val();
	if($("#formSelectCategoria").val())
		objectParametros += "&formSelectCategoria="+$("#formSelectCategoria").val();
	if($("#formProdutoStr").val())
		objectParametros += "&formProdutoStr="+$("#formProdutoStr").val();
	if($("#formSelectOrdem").val())
		objectParametros += "&formSelectOrdem="+$("#formSelectOrdem").val();

	window.open("http://177.70.26.45/beaverpousada/relatorio/rel.php?rel=relProdutos"+objectParametros);
}



function mostraProdutosEstoque()
{
	var objectLabel = 
	[
		 {"label":"","width":"15%"}
		,{"label":"Codigo","width":"15%"}
		,{"label":"Produto","width":"15%"}
		,{"label":"Controle","width":"15%"}
	];

	var objectConfig = 
	{
		'gridDiv' : 'tabelaProdutos',
		 'width': 100,
		 'class' : 'tabelaPadrao',
		 'border':1,
		 'radio':true,
		 'id':'idproduto'
	};

	var objectParametros = "";
	
	if($("#formStr").val())
	{
		objectParametros += "&formStr="+$("#formStr").val();
		getJsonSelect('selectProdEstoqueTable',false,objectConfig,objectLabel,'viewPousada.php',false,objectParametros);
	}
	else
		getJsonSelect('selectProdEstoqueTable',false,objectConfig,objectLabel);
}

function incluirProdEstoque()
{
	var idproduto = "";

	$("input[type=radio][id='idproduto[]']:checked").each(function(){
		idproduto = $(this).val();
	});

	if(!idproduto)
	{
		alert("Por favor selecionar um produto!");
		return false;
	}

	$('#myModal').modal('hide'); 
	
	
	$.ajax({
		type: "POST",
		url: pagUrl,
		dataType:'json',
		data :
		{
			controller : 'selectDadosProduto',
			idproduto:idproduto
		},
		success: function(data)
		{
			montaCombo('formSelectProduto','selectProdutosEstoque',idproduto);
			$('#formSelectProduto').attr('disabled',true);
			montaCombo("formSelectSigla","selectSiglaCombo",data.id_sigla);
			$('#formValor').val(data.valor);
		}});
}

function atualizarValor(idproduto)
{	
	$.ajax({
		type: "POST",
		url: pagUrl,
		dataType:'json',
		data :
		{
			controller : 'selectDadosProduto',
			idproduto:idproduto
		},
		success: function(data)
		{
			$('#formIdProduto').val(idproduto);
			$('#myModalValor').modal('show'); 
			$('#formValorProd').val(data.valor);
		}});
}

function atualizarValorProduto() 
{
	if(!$('#formValorProd').val())
	{
		alert('Informar o valor!');
		return false;
	}

	$.ajax({
		type: "POST",
		url: pagUrl,
		dataType:'json',
		data : {
			controller : 'updateProduto',
			formIdProduto : $('#formIdProduto').val(),
			formValorProd : $('#formValorProd').val()
		},
		success: function(data)
		{
			if(data.resposta == 1)
			{
				alert(data.msg);
				$('#formValor').val('');
				$('#formIdProduto').val('');
				$('#myModalValor').modal('hide'); 
				getJsonSelect('selectProdutosTable',false,objectConfig,objectLabel,'viewPousada.php',10);
			}
			else
				alert(data.resposta);
		}
	});
}

function closeDialogProd()
{
	$('#formValor').val('');
	$('#formIdProduto').val('');
	$('#myModalValor').modal('hide');
}

function imprimirMovEstoque()
{
	var objPar ="";
	
	if($('#formSelectProduto').val())
		objPar = "&formSelectProduto="+$('#formSelectProduto').val();
	
	if(!$('#formSelectTipo').val())
	{
		alertify.alert('', '<strong>Informe o tipo de relatório</strong>', '');
		return false;
	}
	else
		objPar = "&formSelectTipo="+$('#formSelectTipo').val();

	window.location = "http://177.70.26.45/beaverPousada/relatorio/relmov_estoque.php?rel=relMovEstoque"+objPar;
}

function buscarRegistrosTabelaEstoque()
{
	var objPar = "&formSelectProduto="+$('#formSelectProduto').val();

	if(!$('#formSelectTipo').val())
	{
		alertify.alert('', '<strong>Informe o tipo de relatorio!</strong>', '');

		return false;
	}

	if($('#formSelectTipo').val() == 1)
	{
		var objectLabel = 
		[
			{"label":"CÃ³digo","width":"20%"}
			,{"label":"Categoria","width":"15%"}
			,{"label":"Produto","width":"15%"}
			,{"label":"Quantidade","width":"10%"}
			,{"label":"Tipo","width":"5%"}
			,{"label":"Est. MÃ­nimo","width":"10%"}
			,{"label":"Est. MÃ¡ximo","width":"10%"}
			,{"label":"Custo MÃ©dio","width":"20%"}
			,{"label":"Valor","width":"20%"}
			,{"label":"Total","width":"20%"}
		];

		var objectConfig = 
		{
			'gridDiv' : 'tabelaEstoque',
			'width': 500,
			'class' : 'tabelaPadrao',
			'print':'imprimirMovEstoque',
			'border':1,
			'id':'idproduto',
			'colspan':5,
			'push':'cadastro_estoque.php'
		};
		getJsonSelect('selectEstoqueAtualTable',false,objectConfig,objectLabel,false,false,objPar);	
	}

	if($('#formSelectTipo').val() == 2)
	{
			var objectLabel = 
			[
				{"label":"Produto","width":"20%"}
				,{"label":"Data da movimentaÃ§Ã£o","width":"15%"}
				,{"label":"Tipo movimentaÃ§Ã£o","width":"15%"}
				,{"label":"Tipo","width":"10%"}
				,{"label":"Quantidade","width":"5%"}
				,{"label":"Valor Atual","width":"10%"}
				,{"label":"Total","width":"10%"}
				,{"label":"ObservaÃ§Ã£o","width":"20%"}
			];

			var objectConfig = 
			{
				'gridDiv' : 'tabelaEstoque',
				'width': 500,
				'class' : 'tabelaPadrao',
				'print':'imprimirMovEstoque',
				'border':1,
				'id':'id_mov_estoque',
				'colspan':5,
				'push':'cadastro_estoque.php'
			};

			getJsonSelect('selectEstoqueTable',false,objectConfig,objectLabel,false,false,objPar);	
	}
}

function cadastrarCartao()
{
	var objPar = new Object();
	var mensagem = "";

	if(!erroValidate('formSelectBandeira','Informe a bandeira'))
		return false;
	
	
	var opcao = "";

	$("input[type=radio][id='opcao[]']:checked").each(function(){
		opcao = $(this).val();
	});

	if(!opcao)
	{
		alertify.alert('', '<strong>Por favor selecionar uma opção!</strong>', '');
		return false;
	}
	
	
	if(opcao == 'C')
	{
		if(!erroValidate('formParcelas','Informe o numero de parcelas'))
			return false;
	}

	if(!erroValidate('formDiaRecebimento','Informe o dia de recebimento'))
		return false;
	
	if(!erroValidate('formPercentual','Informe o percentual'))
		return false;

	mensagem				 	= "cadastrado";
	objPar.controller		 	= 'cadastroCartao';
	objPar.formSelectBandeira 	= $('#formSelectBandeira').val();
	objPar.opcao				= opcao;

	if(opcao == 'C')
		objPar.formParcelas	 	= $('#formParcelas').val();
	
	objPar.formDiaRecebimento	= $('#formDiaRecebimento').val();
	objPar.formPercentual		= $('#formPercentual').val();
	
	if($("#formBaixaAutomatica").is(":checked") == true)
		objPar.formBaixaAutomatica = "t";

	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data : objPar,
			success: function(data)
			{
				if(data.resposta == 1)
				{
					alertify.alert('', '<strong>'+data.msg+'</strong>', '');
					$('#formInserirCartao').resetForm();
				}
				else
					alertify.alert('', '<strong>'+data.resposta+'</strong>', '');
			}
	});
}

function buscaNomeHospedes()
{
	montaCombo('formSelectHospede','selectHospede',true,$('#formNomePesquisa').val());
}

function habilitarFormaPagamamento(tipo)
{
	if(tipo == '')
	{
		$('#divDataPagamento').hide();
		$('#divValorPagamento').hide();
		$('#divCartao').hide();
		$('#divBandeira').hide();
		$('#divDeposito').hide();
	}
	else
	{
		switch(tipo)
		{
			case '1':
				$('#divDataPagamento').show();
				$('#divValorPagamento').show();
				$('#formValorPagamento').val('');
				$('#divTipoCartao').hide();
				$('#divCartao').hide();
				$("#formSelectCartao").html("<option value=''></option>");
				$('#divParcelas').hide();
				$("#formSelectParcelas").html("<option value=''></option>");
				$('#divCheque').hide();
				$("#formSelectDepBanco").html("<option value=''></option>");
				$('#divDeposito').hide();
			break;
			case '2':
				$('#divTipoCartao').show();
				$('#divCartao').show();
				montaCombo('formSelectCartao','selectCartoesCombo',false);
				$('#divValorPagamento').show();
				$('#formValorPagamento').val('');
				$('#divDataPagamento').hide();
				$('#divCheque').hide();
				$("#formSelectDepBanco").html("<option value=''></option>");
				$('#divDeposito').hide();
			break;
			case '3':
				$('#divCheque').show();
				montaCombo('formSelectBanco','selectBancoCombo',false);
				$("input[type=text][name='formDataCheque[]']").each(function(i)
				{
					$(this).mask("99/99/9999");
				});
				
				$("input[type=text][name='formValorCheque[]']").each(function(i)
				{
					$(this).priceFormat({
								prefix: '',
								centsSeparator: ',',
								thousandsSeparator: '.'
					});
				});

				$('#formValorPagamento').val('');
				$('#divValorPagamento').hide();
				$("#formSelectCartao").html("<option value=''></option>");
				$("#formSelectParcelas").html("<option value=''></option>");
				$('#divTipoCartao').hide();
				$('#divCartao').hide();
				$('#divParcelas').hide();
				$("#formSelectDepBanco").html("<option value=''></option>");
				$('#divDeposito').hide();
			break;
			case '4':
				$('#divDataPagamento').show();
				$('#divValorPagamento').show();
				$('#formValorPagamento').val('');
				$('#divDeposito').show();
				montaCombo('formSelectDepBanco','selectBancoCombo',false);
				$('#divTipoCartao').hide();
				$("#formSelectCartao").html("<option value=''></option>");
				$('#divCartao').hide();
				$("#formSelectParcelas").html("<option value=''></option>");
				$('#divParcelas').hide();
				$("#formSelectBanco").html("<option value=''></option>");
				$('#divCheque').hide();
			break;
		}
	}
}

function habilitaCartoes(tipo)
{
	montaCombo('formSelectCartao','selectCartoesCombo',tipo);
	
	if(tipo == 'C')
		$("#divParcelas").show();
	else
		$("#divParcelas").hide();

}

function habilitarCampoParcelas(tipo)
{
	if(tipo == 'C')
		$('#divParcelas').show();
	else
		$('#divParcelas').hide();
}

function selectComboParcelas(id_cartao)
{
	var opcao = "";

	$("input[type=radio][id='opcao[]']:checked").each(function(){
		opcao = $(this).val();
	});

	if(opcao == 'C')
	{
		$('#formSelectParcelas').attr("disabled",false);
		montaCombo('formSelectParcelas','selectParcelasCombo',true,id_cartao);
	}
	else
		return false;
}

function visulalizarPagamento(idreserva)
{
	$('#myModalPagamento').modal('show');

	var objectLabel = [{"label":"Valor","width":"15%"}
						,{"label":"Tipo de pagamento","width":"85%"}];

	var objectConfig = {'gridDiv' : 'tabelaPagamento',
						 'width': 100};

	var objectParametros = "";

	objectParametros += "&idreserva="+idreserva;
	getJsonSelect('selectTipoPagamento',false,objectConfig,objectLabel,'viewPousada.php',false,objectParametros);
}

function cadastrarSubCatCentro()
{
	$('#myModalSubCatCentro').modal('show');
	montaCombo('formSelectCatCentro','selectCatCentro',$('#formSelectCategoria').val());
	$('#formSelectCatCentro').attr('disabled',true);
	getJsonSelect('selectSubCentro',$('#formSelectCategoria').val(),objectConfig,objectLabel,'viewPousada.php');
}

function cadastrarCentroCusto()
{
	if(!erroValidate('formSelectCategoria','Selecione a categoria'))
		return false;

	if(!erroValidate('formSelectSubCategoria','Selecione a sub-categoria'))
		return false;

	if(!erroValidate('formSelecFormPagamento','Selecione a forma de pagamento'))
		return false;

	if($("#formSelecFormPagamento").val() == '1')
	{
		if(!erroValidate('formData','Informe a data'))
			return false;

		if(!erroValidate('formValorPagamento','Informe o valor'))
			return false;
	}
	
	if($("#formSelecFormPagamento").val() == '2')
	{
		if(!erroValidate('formSelectCartao','Informe a Bandeira'))
			return false;

		var opcao = "";
		$("input[type=radio][id='opcao[]']:checked").each(function(){
			opcao = $(this).val();
		});

		if(opcao == 'C')
		{
			if(!erroValidate('formSelectParcelas','Informe o número de parcelas'))
			return false;
		}

		if(!erroValidate('formValorPagamento','Informe o valor'))
			return false;
	}

	
	if($("#formSelecFormPagamento").val() == '4')
	{
		if(!erroValidate('formValorPagamento','Informe o valor'))
			return false;

		if(!erroValidate('formSelectDepBanco','Informe o banco'))
			return false;

		if(!erroValidate('formAgencia','Informe o banco'))
			return false;

		if(!erroValidate('formConta','Informe o banco'))
			return false;

		if(!erroValidate('formSelectTipoConta','Informe o banco'))
			return false;
	}
	
	if(!erroValidate('formData','Informe a data'))
		return false;

	if(!erroValidate('formDescricao','Informe a data'))
		return false;

	var objPar = new Object();

	objPar.controller 				= 'cadastroCentroCusto';
	objPar.formSelectSubCategoria 	= $('#formSelectSubCategoria').val();
	objPar.formSelecFormPagamento 	= $('#formSelecFormPagamento').val();
	
	if($("#formSelectFornecedor").val() != "")
		objPar.formSelectFornecedor = $('#formSelectFornecedor').val();
	
	
	if($("#formSelecFormPagamento").val() == '2')
	{
		objPar.formSelectCartao = $('#formSelectCartao').val();

		if(opcao == 'C')
			objPar.formSelectParcelas = $('#formSelectParcelas').val();
	}

	
	if($("#formSelecFormPagamento").val() == '4')
	{
		objPar.formSelectDepBanco 	= $('#formSelectDepBanco').val();
		objPar.formAgencia 			= $('#formAgencia').val();
		objPar.formConta 			= $('#formConta').val();
		objPar.formSelectTipoConta 	= $('#formSelectTipoConta').val();
	}

	objPar.formData					= $('#formData').val();
	objPar.formValorPagamento		= $('#formValorPagamento').val();
	objPar.formDescricao			= $('#formDescricao').val();
	
	$('#form_submit').attr('disabled',true);

	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data : objPar,
			success: function(data)
			{
				if(data.resposta == 1)
				{
					alertify.alert('', '<strong>'+data.msg+'</strong>', '');
					$('#formInserirCentroCusto').resetForm();
				}
				else
					alertify.alert('', '<strong>'+data.resposta+'</strong>', '');

				$('#form_submit').attr('disabled',false);
			}
	});
}

function cadastrarCatCentroCusto()
{
	if(!erroValidate('formCategoria','Selecione a categoria'))
		return false;

	var objPar = new Object();
	var mensagem = "";

	mensagem		  			= "cadastrado";
	objPar.controller 			= 'cadastroCatCentroCusto';
	objPar.formCategoria 		= $('#formCategoria').val();

	$('#formCategoria_submit').attr('disabled',true);

	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data : objPar,
			success: function(data)
			{
				if(data.resposta != 0)
				{
					alertify.alert('', '<strong>'+data.msg+'</strong>', '');
					$('#formCategoria').val('');
					getJsonSelect('selectTableCatCentro',false,objectConfig_2,objectLabel_2,'viewPousada.php');
					$('#myModalSubCatCentro').modal('show');
					montaCombo('formSelectCatCentro','selectCatCentro',data.id_cat_centro);
					$('#formSelectCatCentro').attr('disabled',true);
					getJsonSelect('selectSubCentro',data.id_cat_centro,objectConfig,objectLabel,'viewPousada.php');
				}
				else
					alertify.alert('', '<strong>'+data.resposta+'</strong>', '');

				$('#formCategoria_submit').attr('disabled',false);
			}
	});
}

function cadastrarSubCatCentroCusto()
{
	if(!erroValidate('formSubCategoria','Informe a sub-categoria'))
		return false;

	var objPar = new Object();

	objPar.controller 			= 'cadastroSubCatCentroCusto';
	objPar.formSelectCatCentro 	= $('#formSelectCatCentro').val();
	objPar.formSubCategoria 	= $('#formSubCategoria').val();

	if($('#formObservacao').val())
		objPar.formObservacao = $('#formObservacao').val();

	$('#formSubCategoria_submit').attr('disabled',true);

	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data : objPar,
			success: function(data)
			{
				if(data.resposta == 1)
				{
					alert(data.msg);
					getJsonSelect('selectSubCentro',$('#formSelectCatCentro').val(),objectConfig,objectLabel,'viewPousada.php');
				}
				else
					alert(data.resposta);

				$('#formSubCategoria_submit').attr('disabled',false);
			}
	});
}

function excluiSubCategoria(id_sub_cat_centro)
{
	if(!confirm("Deseja realmente excluir sub-categoria?"))
		return false;

	var objPar = new Object();

	objPar.controller 			= 'excluiSubCatCentroCusto';
	objPar.id_sub_cat_centro 	= id_sub_cat_centro;

	$.ajax({
		type: "POST",
		url: pagUrl,
		dataType:'json',
		data : objPar,
		success: function(data)
		{
			if(data.resposta == 1)
			{
				alert(data.msg);
				getJsonSelect('selectSubCentro',$('#formSelectCatCentro').val(),objectConfig,objectLabel,'viewPousada.php');
			}
			else
				alert(data.msg);
		}
	});	
}

function atualizarSubCategoria(id_cat_centro)
{
	$('#myModalSubCatCentro').modal('show');
	montaCombo('formSelectCatCentro','selectCatCentro',id_cat_centro);
	$('#formSelectCatCentro').attr('disabled',true);
	getJsonSelect('selectSubCentro',id_cat_centro,objectConfig,objectLabel,'viewPousada.php');
}

function buscarTabelaContasPagar()
{
	var objectParametros = "";

	if($("#formSelectCategoria").val())
		objectParametros += "&formSelectCategoria="+$("#formSelectCategoria").val();
	if($("#formSelectSubCategoria").val())
		objectParametros += "&formSelectSubCategoria="+$("#formSelectSubCategoria").val();
	if($("#formDtInicial").val())
		objectParametros += "&formDtInicial="+$("#formDtInicial").val();
	if($("#formDtFinal").val())
		objectParametros += "&formDtFinal="+$("#formDtFinal").val();

	if($("#formSelectSit").val() == 1)
	{
		var objectLabel = 
		[
			{"label":"","width":"5%"}
			,{"label":"Sub-Categoria","width":"20%"}
			,{"label":"Categoria","width":"20%"}
			,{"label":"Valor","width":"10%"}
			,{"label":"Data de Pagamento","width":"20%"}
			,{"label":"Data de Cadastro","width":"20%"}
			,{"label":"","width":"10%"}
		];

		var objectConfig = 
		{
			'gridDiv' : 'tabelaCentroCusto',
			'width': 500,
			'class' : 'tabelaPadrao',
			'border':1,
			'id':'id_centro_custo',
			'colspan':6,
			'crud':true,
			'push':'centro_custo.php',
			'print':'imprimirListaCentroCusto',
			'checkbox': true,
			'checkTitle': 'Confirmar Pagamento',
			'checkImg': 'pagar.png',
			'checkFunction':'confirmarPagamentoCP',
			'visualize':"visualizarCP"
		};
	}
	else
	{
		var objectLabel = 
		[
			{"label":"Sub-Categoria","width":"20%"}
			,{"label":"Categoria","width":"20%"}
			,{"label":"Valor","width":"10%"}
			,{"label":"Data de Pagamento","width":"20%"}
			,{"label":"Data de Cadastro","width":"20%"}
			,{"label":"","width":"5%"}
		];

		var objectConfig = 
		{
			'gridDiv' : 'tabelaCentroCusto',
			'width': 500,
			'class' : 'tabelaPadrao',
			'border':1,
			'id':'id_centro_custo',
			'colspan':6,
			'crud':true,
			'print':'imprimirListaCentroCusto',
			'push':'centro_custo.php',
			'visualize':"visualizarCP"
		};

		objectParametros += "&formStatus=P";
	}
	getJsonSelect('selectCentroCustoTable',false,objectConfig,objectLabel,'viewPousada.php',10,objectParametros);
}

function confirmarPagamentoCP()
{
	var arrIdsCentroCusto = Array();
	$("input[type=checkbox][name='id_centro_custo[]']").each(function(i)
	{
		if(this.checked)
			arrIdsCentroCusto.push($(this).val());
	});

	if(arrIdsCentroCusto.length == 0)
	{
		alertify.alert('', "<strong><font color='red'>Nenhum produto foi selecionado!</font></strong>", '');
		return false;
	}


	alertify.confirm('','<strong><font color="green">Confirmar pagamento?</font></strong>',
				function()
				{ 
					$.ajax({type: "POST",
							url: pagUrl,
							dataType:'json',
							data :
							{
								controller : "confirmarPagamentoCP",
								arrIdsCentroCusto : arrIdsCentroCusto.toString()
							},
							success: function(data)
							{
								if(data.resposta == 1)
								{
									alertify.alert('', "<strong><font color='green'>"+data.msg+"</font></strong>", '');
									buscarTabelaContasPagar();
									alertify.confirm().close();
								}
								else
									alertify.alert('', "<strong><font color='red'>"+data.msg+"</font></strong>", '');
							}
					});
				},
				function()
				{
					alertify.confirm().close();
				}).set('labels', {ok:'Sim', cancel:'Não'}).setHeader('');

			/*
				if(!confirm("Confirmar pagamento?"))
					return false;

				$.ajax({
						type: "POST",
						url: pagUrl,
						dataType:'json',
						data : {
							controller : "confirmarPagamentoCP",
							arrIdsCentroCusto : arrIdsCentroCusto.toString()
						},
						success: function(data)
						{
							if(data.resposta == 1)
							{
								alert(data.msg);
								buscarTabelaContasPagar();
							}
							else
								alert(data.msg);
						}
				});
			*/
}


function habilitarFormaPagamentoCP(tipo)
{
	if(tipo == '')
	{
		$('#divDataPagamento').hide();
		$('#divValorPagamento').hide();
		$('#divCartao').hide();
		$('#divBandeira').hide();
		$('#divDeposito').hide();
	}
	else
	{
		switch(tipo)
		{
			case '1':
				$('#divDataPagamento').show();
				$('#divValorPagamento').show();
				$('#formValorPagamento').val('');
				$('#divTipoCartao').hide();
				$('#divCartao').hide();
				$("#formSelectCartao").html("<option value=''></option>");
				$('#divParcelas').hide();
				$("#formSelectParcelas").html("<option value=''></option>");
				$("#formSelectDepBanco").html("<option value=''></option>");
				$('#divDeposito').hide();
			break;
			case '2':
				$('#divTipoCartao').show();
				$('#divCartao').show();
				montaCombo('formSelectCartao','selectCartoesCombo',false);
				$('#divValorPagamento').show();
				$('#formValorPagamento').val('');
				$('#divDataPagamento').hide();
				$("#formSelectDepBanco").html("<option value=''></option>");
				$('#divDeposito').hide();
			break;
			case '4':
				$('#divDataPagamento').show();
				$('#divValorPagamento').show();
				$('#formValorPagamento').val('');
				$('#divDeposito').show();
				montaCombo('formSelectDepBanco','selectBancoCombo',false);
				$('#divTipoCartao').hide();
				$("#formSelectCartao").html("<option value=''></option>");
				$('#divCartao').hide();
				$("#formSelectParcelas").html("<option value=''></option>");
				$('#divParcelas').hide();
				$("#formSelectBanco").html("<option value=''></option>");
			break;
		}
	}
}


function buscaInfoContaFornecedor(id_fornecedor)
{
	if(id_fornecedor == "")
	{
		$("#formBanco").val("");
		$("#formAgencia").val("");
		$("#formConta").val("");
		$("#formTipoConta").val("");
		$('#divInfoConta').hide();
		return false;
	}
	$.ajax({
		type: "POST",
		url: pagUrl,
		dataType:'json',
		data :
		{
			controller : 'selectDadosFornecedor',
			id_fornecedor : id_fornecedor
		},
		success: function(data)
		{
			$('#divInfoConta').show();
			$("#formBanco").val(data.banco);
			$("#formAgencia").val(data.agencia);
			$("#formConta").val(data.conta);
			$("#formTipoConta").val(data.tipo_conta);
		}
	});
}

function visualizarCP(id_centro_custo)
{

	$('#myModalInfoCP').modal('show'); 
	
	$.ajax({
		type: "POST",
		url: pagUrl,
		dataType:'json',
		data :
		{
			controller : 'selectDadosCentroCusto',
			id_centro_custo : id_centro_custo
		},
		success: function(data)
		{
			$("#formCategoria").val(data.categoria_centro);
			$("#formSubCategoria").val(data.sub_cat_centro);
			$("#formValor").val(data.valor);
			$("#formDataPagamento").val(data.data);
			$("#formDataCadastro").val(data.data_cadastro);
			$("#formTipoPagamento").val(data.tipo_pagamento);
			
			if(data.tp == 2)
			{
				$("#divTipoCartCP").show();
				$("#formBandeiraC").val(data.bandeira);
			}
			else
			{
				$("#formBandeiraC").val('');
				$("#divTipoCartCP").hide();
			}

			if(data.tp == 4)
			{
				$("#divTipoDepositoCP").show();
				$("#formBanco").val(data.banco);
				$("#formAgencia").val(data.agencia);
				$("#formConta").val(data.conta);
				$("#formTipoConta").val(data.tipo_conta);
			}
			else
			{
				$("#formBanco").val('');
				$("#formAgencia").val('');
				$("#formConta").val('');
				$("#formTipoConta").val('');
				$("#divTipoDepositoCP").hide();
			}

			$("#formDescricao").val(data.descricao);
		}
	});
}


function imprimirListaCentroCusto()
{
	var objectP = "";

	if($("#formSelectCategoria").val())
		objectP += "&formSelectCategoria="+$("#formSelectCategoria").val();
	if($("#formSelectSubCategoria").val())
		objectP += "&formSelectSubCategoria="+$("#formSelectSubCategoria").val();
	if($("#formDtInicial").val())
		objectP += "&formDtInicial="+$("#formDtInicial").val();
	if($("#formDtFinal").val())
		objectP += "&formDtFinal="+$("#formDtFinal").val();

	if($("#formSelectSit").val() != 1)
		objectP += "&formStatus=P";	

	window.open("http://177.70.26.45/beaverpousada/relatorio/rel.php?rel=relCentroCusto"+objectP);
}

function mostraHospedesTable()
{
	$('#myModalHospTable').modal('show'); 
	$("#formNomeHospede").autocomplete("complete.php",{width:310,selectFirst:false});
	montaCombo('formSelectQuarto','selectQuartoCombo');
	var objectLabel =
	[
		{"label":"","width":"5%"}
		,{"label":"Nome","width":"80%"}
	];

	var objectConfig = 
	{
		'gridDiv' : 'tabelaHospede',
		 'width': 500,
		 'class' : 'tabelaPadrao',
		 'border':1,
		 'id':'idhospede',
		 'colspan':2,
		 'checkbox': true	,
		 'checkTitle': 'Adicionar',
		 'checkImg': 'pagar.png',
		 'checkFunction':'addHospedeVendaCombo'
	};
	
	var objectParametros 	= "";
	var arrIdsHospede 		= Array();

	$("#formSelectHospSelecionado option").each(function()
	{	
		if($(this).val() != "")
			arrIdsHospede.push($(this).val());
	});

	if(arrIdsHospede.length != 0)
		objectParametros += "&arrIdsHospede="+arrIdsHospede.toString();

	if(objectParametros == "")
		getJsonSelect('selectHospedeTable',false,objectConfig,objectLabel,false,5);
	else
		getJsonSelect('selectHospedeTable',false,objectConfig,objectLabel,false,5,false,objectParametros);
}

function addHospedeVendaCombo()
{
	var arrIdsHospede = Array();
	$("input[type=checkbox][name='idhospede[]']").each(function(i)
	{
		if(this.checked)
			arrIdsHospede.push($(this).val());
	});
	
	if(arrIdsHospede.length == 0)
	{
		alertify.alert('', '<strong><font color="red">Nenhum hóspede foi selecionado!!</font></strong>', function(){ alertify.confirm().close(); }).setHeader('');
		return false;
	}

	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data :
			{
				controller : "selectHospedeMultipleCombo",
				arrIdsHospede : arrIdsHospede.toString()
			},
			success: function(data)
			{

				for(var key in data)
				{
					$("#formSelectHospSelecionado").append("<option value='"+data[key].idhospede+"'>"+data[key].nome+"</option>");
				}

				alertify.confirm('','<strong><font color="green">Hóspede(s) foram adicionados, deseja incluir outros?</font></strong>',
				function()
				{ 
					$("input[type=checkbox][id='idhospede[]']").each(function(){
						this.checked = false;
					});

					buscarHospedesTable();
					alertify.confirm().close();
				},
				function()
				{
					$('#myModalHospTable').modal('hide');

				}).set('labels', {ok:'Sim', cancel:'Não'}).setHeader('');
			}
	});
}

function buscarHospedesTable()
{
	var objectParametros = "";

	if($("#formNomeHospede").val())
		objectParametros += "&formNomeHospede="+$("#formNomeHospede").val();
	if($("#formSelectQuarto").val())
		objectParametros += "&formSelectQuarto="+$("#formSelectQuarto").val();

	var arrIdsHospede = Array();
	$("#formSelectHospSelecionado option").each(function()
	{	
		if($(this).val() != "")
			arrIdsHospede.push($(this).val());
	});

	if(arrIdsHospede.length != 0)
		objectParametros += "&arrIdsHospede="+arrIdsHospede.toString();

	var objectLabel =
	[
		{"label":"","width":"5%"}
		,{"label":"Nome","width":"80%"}
	];

	var objectConfig = 
	{
		'gridDiv' : 'tabelaHospede',
		 'width': 500,
		 'class' : 'tabelaPadrao',
		 'border':1,
		 'id':'idhospede',
		 'colspan':2,
		 'checkbox': true	,
		 'checkTitle': 'Adicionar',
		 'checkImg': 'pagar.png',
		 'checkFunction':'addHospedeVendaCombo'
	};

	getJsonSelect('selectHospedeTable',false,objectConfig,objectLabel,false,10,false,objectParametros);
}


function buscarProduto(id_categoria)
{
	montaCombo('formSelectProduto','selectProdutos',id_categoria);
}


function habilitarEmpresa(tipo)
{
	if(tipo == 2)
	{
		$("#divEmpresa").show();
		montaCombo('formSelectEmpresa','selectEmpresa');
	}
	else
	{
		$("#divEmpresa").hide();
		$("#formSelectEmpresa").html("<option value=''>-- Selecione --</option>");
	}
}


function cadastrarContato()
{
	if(!erroValidate('formNome','Informe o nome'))
		return false;

	if(!erroValidate('formSelectEstado','Informe o estado'))
		return false;
	
	if(!erroValidate('formSelectCidade','Informe a cidade'))
		return false;

	if(!erroValidate('formTelefone','Informe o telefone'))
		return false;

	if(!erroValidate('formSelectFonte','Informe a fonte'))
		return false;
	
	if($("#formSelectFonte").val() == "5")
	{
		if(!erroValidate('formFonteNome','Informe a fonte'))
		return false;
	}

	var objPar = new Object();

	objPar.controller 			= 'cadastroContatos';
	
	objPar.formNome				= $("#formNome").val();
	objPar.formSelectEstado		= $("#formSelectEstado").val();
	objPar.formSelectCidade		= $("#formSelectCidade").val();
	objPar.formTelefone 		= $("#formTelefone").val();
	
	objPar.formCep 				= $("#formCep").val();
	objPar.formEndereco 		= $("#formEndereco").val();
	objPar.formBairro 			= $("#formBairro").val();
	objPar.formSelectEstrelas 	= $("#formSelectEstrelas").val();
	
	if($("#formSelectFonte").val() != "5")
		objPar.formSelectFonte 		= $("#formSelectFonte").val();	
	else
		objPar.formFonteNome 		= $("#formFonteNome").val();	
	
	
	objPar.formObservacao 		= $("#formObservacao").val();

	$('#formContatos_submit').attr('disabled',true);

	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data : objPar,
			success: function(data)
			{
				if(data.resposta == 1)
				{
					alert(data.msg);
					var id_estado = $("#formSelectEstado").val();
					var id_cidade = $("#formSelectCidade").val();

					$('#formInserirContato').resetForm();
					
					montaCombo('formSelectEstado','selectEstado',true,id_estado);
					montaCombo('formSelectCidade','selectCidade',id_estado,id_cidade);
				}
				$('#formContatos_submit').attr('disabled',false);
			}
	});
}

function habilitaFonte()
{
	if($("#formSelectFonte").val() == "5")
		$("#divOutraFonte").show();
	else
		$("#divOutraFonte").hide();
}

function habilitaPesquisa()
{
	if($("#formSelectSoftware").val() == "")
	{
		$("#divTemSoftware").hide();
		$("#divNaoTemSoftware").hide();
	}

	if($("#formSelectSoftware").val() == "S")
	{
		$("#divTemSoftware").show();
		$("#divNaoTemSoftware").hide();
	}

	if($("#formSelectSoftware").val() == "N")
	{
		$("#divTemSoftware").hide();
		$("#divNaoTemSoftware").show();
	}
}

function cadastrarPesquisaContato()
{
	if(!erroValidate('formSelectContato','Informe o contato'))
		return false;

	if($("#formObsGerais").val() == "")
	{
		if(!erroValidate('formSelectSoftware','Selcione um opção'))
		return false;

	}
	if(!erroValidate('formSelectSituacao','Informe a situação'))
		return false;

	if($("#formSelectSituacao").val() == "R")
	{
		if(!erroValidate('formSelectPrioridade','Selcione um opção'))
		return false;
	}

	var objPar = new Object();

	if(!$("#formIdPesquisaContato").val())
	{
		objPar.controller 			= 'cadastroPesquisaContato';
		objPar.formSelectContato	= $("#formSelectContato").val();
	}
	else
	{
		objPar.controller 				= 'updatePesquisaContato';
		objPar.formIdPesquisaContato	= $("#formIdPesquisaContato").val();
	}

	objPar.formNome				= $("#formNome").val();
	objPar.formCargo			= $("#formCargo").val();
	objPar.formSelectEstrelas	= $("#formSelectEstrelas").val();
	objPar.formNQuartos 		= $("#formNQuartos").val();

	objPar.formNColaboradores 	= $("#formNColaboradores").val();
	objPar.formSelectOcupacao 	= $("#formSelectOcupacao").val();
	objPar.formObservacaoTaxa 	= $("#formObservacaoTaxa").val();
	
	objPar.formSelectSoftware 	= $("#formSelectSoftware").val();

	if($("#formSelectSoftware").val() == "S")
	{
		objPar.formNSoftware 			= $("#formNSoftware").val();
		objPar.formSelectTipoSoftware 	= $("#formSelectTipoSoftware").val();
		
		if($("#formSelectTempoUso").val() != "")
			objPar.formSelectTempoUso 	= $("#formSelectTempoUso").val();
		else
			objPar.formTempo 			= $("#formTempo").val();

		
		objPar.formCusto 				= $("#formCusto").val();
		objPar.formSelectSatisfeito 	= $("#formSelectSatisfeito").val();
		objPar.formObsSatisfeito 		= $("#formObsSatisfeito").val();
		
		objPar.formObsFalta 			= $("#formObsFalta").val();
		objPar.formObsSatisfeito 		= $("#formObsSatisfeito").val();
		objPar.formObsFalta 			= $("#formObsFalta").val();
		objPar.formSelectSuporte 		= $("#formSelectSuporte").val();

		objPar.formObsSuporte 			= $("#formObsSuporte").val();
		objPar.formSelectPossuiErros 	= $("#formSelectPossuiErros").val();
		objPar.formObsErros 			= $("#formObsErros").val();
		
		objPar.formPUtil 				= $("#formPUtil").val();
		objPar.formObsControle 			= $("#formObsControle").val();
		objPar.formSelectMotor 			= $("#formSelectMotor").val();
		objPar.formSelectNFE 			= $("#formSelectNFE").val();
		objPar.formObsNFE 				= $("#formObsNFE").val();
	}
	else
	{
		objPar.formObsControleAtual = $("#formObsControleAtual").val();	
		objPar.formObsSoftware 		= $("#formObsSoftware").val();	
	}

	objPar.formObsGerais 		= $("#formObsGerais").val();
	objPar.formSelectSituacao 	= $("#formSelectSituacao").val();
	
	if($("#formSelectPrioridade").val())
		objPar.formSelectPrioridade 	= $("#formSelectPrioridade").val();

	objPar.formSelectOperacao 	= $("#formSelectOperacao").val();

	$('#formPesquisaContato_submit').attr('disabled',true);

	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data : objPar,
			success: function(data)
			{
				if(data.resposta == 1)
				{
					alert(data.msg);
					var id = "id_estado = "+$("#formSelectEstado").val()+" and id_cidade = "+$("#formSelectCidade").val();

					montaCombo('formSelectContato','selectContatosCombo',id);
					
					$('#formPesquisaContato').resetForm();
					$("#divTemSoftware").hide();
					$("#divNaoTemSoftware").hide();
				}
				else
					alert(data.msg);

				$('#formPesquisaContato_submit').attr('disabled',false);
			}
	});	
}

function buscaDadosContato(id_contato)
{
	$.ajax({
		type: "POST",
		url: pagUrl,
		dataType:'json',
		data : {
			controller : 'selectDadosContato',
			id_contato : id_contato
		},
		success: function(data)
		{
			$('#formTelefone').val(data.telefone);
			$('#formEndereco').val(data.endereco);
		}});
}

function updatePesquisaContato(id_pesquisa)
{
		$("#formPesquisaContato_submit").text("Atualizar");
		$("#divFiltro").hide();
		$("#divEndereco").hide();

		$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data : {
				controller : 'selectDadosPesquisaContato',
				id_pesquisa : id_pesquisa
			},
			success: function(data)
			{
				montaCombo('formSelectContato','selectContatosCombo',true,data.id_contato);
				$("#formTelefone").val(data.telefone);
				$("#formNome").val(data.nome);
				$("#formCargo").val(data.cargo);
				$("#formSelectEstrelas option[value='"+data.estrelas+"']").attr("selected","selected");
				$("#formNQuartos").val(data.num_quartos);
				$("#formNColaboradores").val(data.num_colaboradores);
				$("#formSelectOcupacao option[value='"+data.taxa_ocupacao+"']").attr("selected","selected");
				$("#formObservacaoTaxa").val(data.observacao_taxa);
				$("#formSelectSoftware option[value='"+data.sistema+"']").attr("selected","selected");
				
				if(data.sistema == 'S')
				{
					$("#divTemSoftware").show();
					$("#formNSoftware").val(data.nome_sistema);
					$("#formSelectTipoSoftware option[value='"+data.tipo_sistema+"']").attr("selected","selected");
					$("#formSelectTempoUso option[value='"+data.tempo_uso+"']").attr("selected","selected");
					$("#formTempo").val(data.tempo_uso);
					$("#formCusto").val(data.custo);
					$("#formSelectSatisfeito option[value='"+data.satisfeito+"']").attr("selected","selected");
					$("#formObsSatisfeito").val(data.observacao_satisfeito);
					$("#formObsFalta").val(data.observacao_falta);
					$("#formSelectSuporte option[value='"+data.suporte+"']").attr("selected","selected");
					$("#formObsSuporte").val(data.observacao_suporte);
					$("#formSelectPossuiErros option[value='"+data.possui_erros+"']").attr("selected","selected");
					$("#formObsErros").val(data.observacao_erros);
					$("#formPUtil").val(data.numero_usuarios);
					$("#formObsControle").val(data.observacao_controle);
					$("#formSelectMotor option[value='"+data.motor_vendas+"']").attr("selected","selected");
					$("#formSelectNFE option[value='"+data.nfe+"']").attr("selected","selected");
					$("#formObsNFE").val(data.observacao_motor_nfe);
				}
				else
				{
					$("#divNaoTemSoftware").show();
					$("#formObsControleAtual").val(data.observacao_c_atual);
					$("#formObsSoftware").val(data.observacao_sistema);
				}
				
				$("#formObsGerais").val(data.observacao_gerais);
				$("#formSelectSituacao option[value='"+data.situacao_pesquisa+"']").attr("selected","selected");
				$("#formSelectPrioridade option[value='"+data.prioridade+"']").attr("selected","selected");
				$("#formSelectOperacao option[value='"+data.operacao+"']").attr("selected","selected");

				$("#formIdPesquisaContato").val(data.id_pesquisa)
			}
		});
}

function buscarTabelaPesquisaContato()
{
	var objectParametros = "";

	if($("#formSelectEstado").val())
		objectParametros += "&formSelectEstado="+$("#formSelectEstado").val();
	if($("#formSelectCidade").val())
		objectParametros += "&formSelectCidade="+$("#formSelectCidade").val();
	if($("#formSelectSoftware").val())
		objectParametros += "&formSelectSoftware="+$("#formSelectSoftware").val();
	if($("#formSelectSituacao").val())
		objectParametros += "&formSelectSituacao="+$("#formSelectSituacao").val();
	if($("#formSelectPrioridade").val())
		objectParametros += "&formSelectPrioridade="+$("#formSelectPrioridade").val();
	if($("#formDtaIni").val())
		objectParametros += "&formDtaIni="+$("#formDtaIni").val();
	if($("#formDtaFinal").val())
		objectParametros += "&formDtaFinal="+$("#formDtaFinal").val();

	getJsonSelect('selectPesquisaContatoTable',false,objectConfig,objectLabel,'viewPousada.php',false,objectParametros);
}

function carregaJsonHospedes(idreserva)
{
	var objParametros = new Object();

	if(idreserva == false)
		objParametros = {'controller' : 'carregaJsonHospedes'};
	else
		objParametros = {'controller' : 'carregaJsonHospedes','idreserva':idreserva};

	$.ajax({
		type: "POST",
		url: pagUrl,
		data : objParametros,
		success: function(data)
		{
			var json_string  = "";
			json_string = JSON.parse(data);

			$(".autocomplete-select").html('<span class="autocomplete-select" style="width:70%"></span>');
			var autocomplete = new SelectPure(".autocomplete-select", {
				options : json_string,
				value: [],
				multiple: true,
				autocomplete: true,
				icon: "fa fa-times",
				onChange: value => 
				{
					arrIdsHospede = Array();
					arrIdsHospede.push(value);
					addHospedeReservaCombo(arrIdsHospede,idreserva);	
				}
			  });
		}
	});
}

function addHospedeReservaCombo(arrIdsHospede,idreserva)
{
	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data :
			{
				controller : "selectHospedeMultipleCombo",
				idreserva : idreserva,
				arrIdsHospede : arrIdsHospede.toString()
			},
			success: function(data)
			{
				$("#formSelectHospSelecionado").html('');
				for(var key in data)
				{
					$("#formSelectHospSelecionado").append("<option value='"+data[key].idhospede+"'>"+data[key].nome+"</option>");
				}
			}
	});
}


function mostrarHospedes(key,idreserva)
{
	var idtr = "tr"+key;

	if(($("#trEx").length > 0))
	{
		excliuTr("trEx");
		return;
	}

	var objectLabel = 
	[
		{"label":"Hóspede","width":'100%'}
	];
	var objectHideTable = [{"value":"id_hospede"}]
	var objectConfig = 
	{
		'gridDiv' : 'tabelaReservaHospede',
		'width': 700,
		'class' : 'tabelaPadrao',
		'id':'id_reserv_hospede',
		'border':1,
		'efect':false,
		'record':false,
		'objectHideTable':objectHideTable,
		'delete':"excluiPagamento"
	};

	getJsonSelect('selectReservaHospede',idreserva,objectConfig,objectLabel,'viewPousada.php');

	var appendTr = "";
		appendTr += '<tr id="trEx">';
		appendTr += '<td  colspan="17" style="text-align: center;background-color:white;">';
		
		appendTr += '<fieldset class="moldura fieldAlertaLista" style="background-color:white">';
		appendTr += '<legend class="legend-2" style="background:#e5e5e5;border-radius:7px">';
		appendTr += '<center>';
		appendTr += '<strong>Lista de Hóspedes em Reserva</strong>';
		appendTr += '</center>';
		appendTr += '</legend>';
			appendTr += "<div id='tabelaReservaHospede'></div>";
			appendTr += '<input type="hidden" id="formIdReservaHidden" value="'+idreserva+'">';
		appendTr += '</tbody>';
		appendTr += '</table>';
		appendTr += '</fieldset>';
	appendTr += '</td>';
	appendTr += '</td>';
	appendTr += '</tr>';

	$("#tabelaReservas #"+idtr).after(appendTr).show("slow");
}

function removeOptionReserva(formSelect)
{
	var arrIdsHospede = Array();
	arrIdsHospede = removeOption(formSelect)

	$.ajax({
			type: "POST",
			url: pagUrl,
			dataType:'json',
			data :
			{
				controller : "updateComboOption",
				id_reserva : $("#formIdReserva").val(),
				arrIdsHospede : arrIdsHospede.toString()
			},
			success: function(data)
			{	
				carregaJsonHospedes($("#formIdReserva").val());
			}
	});
}