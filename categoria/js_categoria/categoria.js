function cadastrarCategoria()
{
	$("#formInserirCategoria").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = "";
			var mensagem = "";

			if(!$("#formIdCategoria").val())
			{
				mensagem = "cadastrada";
				objParametros = eval({'controller' : 'cadastroCategoria'});
			}
			else
			{
				mensagem = "atualizada";
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
						alert("Categoria "+mensagem+" com sucesso!");
						if($.query.get('editar'))
						{
							window.location="cadastro_categoria.php";
						}
						else
						{
							$('#formCategoria').val('');
							$('#formCategoria_submit').attr('disabled',false);
							montaTabela('selectCategorias',false,'tabelaCategorias');
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
			formCategoria:
			{
				required: true
			}
		},
		messages:
		{
			formCategoria:
			{
				required: "Digite uma categoria"
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
		url: "viewCategoria.php",
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
			//tirarAcoes(false);
		}
	});
}


function updateCategoria(idcategoria)
{
	$("#formCategoria_submit").attr("value","Atualizar");

	$.ajax({
		type: "POST",
		url: 'viewCategoria.php',
		data : {
			controller : 'selectDadosCategoria',
			idcategoria : idcategoria
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			$("#formIdCategoria").val($.query.get('idcategoria'));
			$("#formCategoria").val(objeto.nomecategoria);
			montaCombo('viewCategoria.php','formSelectFornecedor','selectFornecedor',objeto.idfornecedor,false,false);
			montaCombo('viewCategoria.php','formSelectServicos','selectServicos',objeto.idservico,false,false);

		}});
		cadastrarCategoria();
}



function excluiCategoria(idcategoria)
{
	if(!confirm("Deseja realmente excluir?"))
	{
		return false;
	}

	$.ajax({
			type: "POST",
			url: "viewCategoria.php",
			data : {
				controller : "delete",
				idcategoria : idcategoria
			},
			success: function(data)
			{
				if(data == 1)
				{
					alert('Registro excluido com sucesso!');
					montaTabela('selectCategorias',false,'tabelaCategorias');
				}
			}
	});
}

function montaTabelaFiltro(parametros,tabela)
{
	var quantTH = ($("#"+tabela+" thead th:not(.thAcoes)").length);
	
	$("#"+tabela+" tbody").html("<tr><td colspan='"+quantTH+"' align='center'><img src='../img/carregar.gif'/></td></tr>");	
	
	var objParametros = "";
	
	$.ajax({
		type: "POST",
		url: "viewLicencas.php",
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