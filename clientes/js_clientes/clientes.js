var objectLabel = eval([{"label":"Cliente","width":200}
					,{"label":"E-mail","width":100}
					,{"label":"Telefone","width":100}
					,{"label":"Contato","width":100}
					,{"label":"Produto","width":100}
					,{"label":"Serviço","width":100}
					,{"label":"","width":160}]);

var objectConfig = eval({'gridDiv' : 'tabelaClientes',
					 'width': 760,
					 'class' : 'tabelaPadrao',
					 'border':1,
					 'id':'idcliente',
					 'page':true,
					 'crud':true,
					 'visualize': 'visualizar_clientes.php',
					 'update': 'cadastro_clientes.php'});

function cadastrarClientes()
{
	$("#formInserirClientes").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = "";
			var mensagem = "";

			if(!$("#formIdCliente").val())
			{
				mensagem = "cadastrado";
				objParametros = eval({'controller' : 'cadastroCliente'});
			}
			else
			{
				mensagem = "atualizado";
				objParametros = eval({'controller' : 'updateCliente','formIdCliente' : $("#formIdCliente").val()});
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#formCliente_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
						if(data == 1)
						{
							alert("Cliente "+mensagem+" com sucesso!");
							$('#formInserirClientes').resetForm();
							$('#formCliente_submit').attr('disabled',false);

							if($.query.get('editar'))
							{
								window.location="consulta_clientes.php";
							}
						}
						else
						{
							alert("Ocorreu um erro no banco de dados!");
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
			formNomeCliente:
			{
				required: true
			},
			formEmail:
			{
				required: true
			},
			formCNPJ:
			{
				required: true
			},
			formTelefone:
			{
				required: true
			},
			formContato:
			{
				required: true
			}
		},
		messages:
		{
			formNomeCliente:
			{
				required: "Digite o nome do cliente"
			},
			formEmail:
			{
				required: "Informe o email"
			},
			formCNPJ:
			{
				required: "Informe o CNPJ"
			},
			formTelefone:
			{
				required: "Informe o telefone"
			},
			formContato:
			{
				required: "Informe o contato"
			}
		}
	});
}


function montaCombo(pagina,form,controller,id,id2,loading)
{
	$("<img src='../img/carregar.gif' class='loadingCombo' id='loading_"+form+"' alt='carregando'/>").insertAfter("#"+form);

	var strDado = "";

	if(id != "")
	{
		if(id2)
		{
			strDado = "controller="+controller+"&id="+id+"&id2="+id2;
		}
		else
		{
			strDado = "controller="+controller+"&id="+id;
		}
	}
	else
	{
		strDado = "controller="+controller;
	}

	$.ajax({
		type: "POST",
		url: pagina,
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

function montaTabela(controller,id,tabela)
{
	var quantTH = ($("#"+tabela+" thead th:not(.thAcoes)").length);
	
	$("#"+tabela+" tbody").html("<tr><td colspan='"+quantTH+"' align='center'><img src='../img/carregar.gif'/></td></tr>");

	var objParametros = "";

	if(id)
	{
		objParametros = eval({'controller' : controller,'id' : id});
	}
	else
	{
		objParametros = eval({'controller' : controller});
	}

	$.ajax({
		type: "POST",
		url: "viewClientes.php",
		data : objParametros,
		success: function(data){
			if(!data)
			{
				$("#"+tabela+" tbody").html("Nenhum registro encontrado.");
			}
			else
			{
				$("#"+tabela+" tbody").html(data);
			}
		}
	});
}

function visualizarCliente(idcliente)
{
	$.ajax({
		type: "POST",
		url: 'viewClientes.php',
		data : {
			controller : 'selectDadosCliente',
			idcliente : idcliente
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			$("#formNomeCliente").html(objeto.nome);
			$("#formEmail").html(objeto.email);
			$("#formCNPJ").html(objeto.cnpj);
			$("#formTelefone").html(objeto.telefone);
			$("#formContato").html(objeto.contato);
		}
	});
}

function updateCliente(idcliente)
{
	$("#formCliente_submit").attr("value","Atualizar");

	$.ajax({
		type: "POST",
		url: 'viewClientes.php',
		data : {
			controller : 'selectDadosCliente',
			idcliente : idcliente
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');

			$("#formNomeCliente").val(objeto.nome);
			$("#formEmail").val(objeto.email);
			$("#formCNPJ").val(objeto.cnpj);
			$("#formTelefone").val(objeto.telefone);
			$("#formContato").val(objeto.contato);
			$("#formIdCliente").val($.query.get('idcliente'));
		}});
		cadastrarClientes();
}

function excluiCliente(idcliente)
{
	if(!confirm("Deseja realmente excluir?"))
	{
		return false;
	}

	$.ajax({
			type: "POST",
			url: "viewClientes.php",
			data : {
				controller : "delete",
				idcliente : idcliente
			},
			success: function(data)
			{
				if(data == 1)
				{
					alert('Registro excluido com sucesso!');
					montaTabela('selectClientes',false,'tabelaClientes');
				}
			}
	});
}

function buscarRegistrosTabela()
{
	var parametros = "";

	parametros = "controller=selectClientes&filtro=true";

	if($("#formNomeCliente").val())
	{
		parametros += "&formNomeCliente="+$("#formNomeCliente").val();
	}
	getJsonSelect('selectClientes',false,objectConfig,objectLabel,'viewClientes.php',10,1,parametros);
}


function buscaHistorico(idcliente)
{
	if(idcliente)
	{
		montaTabela("selectPropostaCliente",idcliente,"tabelaProposta");
		montaTabela("selectPropClienteServico",idcliente,"tabelaPropoServ");
	}
}

function buscarRegistrosHistorico(idcliente,controllerProd,controllerServ)
{
	var parametros1 = "";
	var parametros2 = "";

	parametros1 = "controller="+controllerProd+"&filtro=true";
	parametros2 = "controller="+controllerServ+"&filtro=true";

	parametros1 += "&idcliente="+idcliente;
	parametros2 += "&idcliente="+idcliente;

	montaTabelaFiltro(parametros1,'tabelaProposta');
	montaTabelaFiltro(parametros2,'tabelaPropoServ');
}


function montaTabelaFiltro(parametros,tabela)
{
	$("#"+tabela+" tbody").html("<tr><td align='center'><img src='../img/carregar.gif'/></td></tr>");	
	
	var objParametros = "";
	
	$.ajax({
		type: "POST",
		url: "viewClientes.php",
		data : parametros,
		success: function(data)
		{
			if (!data)
			{
				$("#"+tabela+" tbody").html("Nenhum registro encontrado.");
			}
			else
			{
				$("#"+tabela+" tbody").html(data);
			}
			tirarAcoes(false);
		}
	});
}