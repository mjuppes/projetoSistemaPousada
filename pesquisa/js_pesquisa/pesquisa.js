var pagUrl = "viewPesquisa.php";

function cadastrarPesquisa()
{
	$("#formPesquisa").validate({
		errorLabelContainer: ".erros",
		wrapper: "li",
		submitHandler: function(form)
		{
			var objParametros = "";
			var mensagem = "";

			if(!$("#formIdPesquisa").val())
			{
				mensagem = "cadastrado";
				objParametros = eval({'controller' : 'cadastroPesquisa'});
			}
			else
			{
				mensagem = "atualizado";
				objParametros = eval({'controller' : 'updatePesquisa','formIdPesquisa' : $("#formIdPesquisa").val()});
			}

			$(form).ajaxSubmit({
					dataType: 'post',
					data : objParametros,
					beforeSubmit:
					function()
					{
						$('#formPesquisa_submit').attr('disabled',true);
					},
					success:
					function (data)
					{
					
						if(data == "Erro3")
						{
							alert("Erro ao cadastrar pesquisa!");
						}
						else
						{
							if($("#formIdPesquisa").val())
							{
								alert("Registro atualizado com sucesso!");
								window.location = "consulta_pesquisa.php";
							}
							else
							{
								var idpesquisa = data;
								$("#divPesquisa").hide();
								$("#formIdPesquisa").val(idpesquisa);
								$("#divParametros").show();
								buscarNome(idpesquisa);
							}
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
		formNomePesquisa:
		{
			required: true
		}
	},
	messages:
	{
		formNomePesquisa:
		{
			required: "Informe o nome da pesquisa!"
		}
	}});
}

function buscarNome(idpesquisa)
{
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosPesquisa',
			idpesquisa : idpesquisa
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			$("#NomePesquisa").html(objeto.nomepesquisa);
		}});
		
}

function visualizarEmpresa(idpesquisa)
{
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosPesquisa',
			idpesquisa : idpesquisa
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			$("#formNomePesquisa").html(objeto.nomepesquisa);
		}});
}

function updatePesquisa(idpesquisa)
{
	$("#formPesquisa_submit").text("Atualizar");
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'selectDadosPesquisa',
			idpesquisa : idpesquisa
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			$("#btnParametro").show();
			$("#formNomePesquisa").val(objeto.nomepesquisa);
			$("#formIdPesquisa").val(objeto.idpesquisa);
		}
	});
	cadastrarPesquisa();
}


function adicionarParametros()
{
	var strButtonParametros ="";
	strButtonParametros += '<div class="control-group">';
	strButtonParametros += '	<label class="control-label" for="formNomeParametro"><strong>Parametro:</strong></label>';
	strButtonParametros += '	<div class="controls">';
	strButtonParametros += '		<input type="text" class="input-xlarge" name="formNomeParametro[]" id="formNomeParametro[]">';
	strButtonParametros += '	</div>';
	strButtonParametros += '</div>';
	$("#buttonParametros").append(strButtonParametros);
}

function getParametros()
{
    var arrParametros = Array();

	$("input[name^='formNomeParametro']").each(function(){ 
		arrParametros.push($(this).val());
	});

	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'cadastroParametros',
			idpesquisa : $("#formIdPesquisa").val(),
			arrParametros: arrParametros.toString()
		},
		success: function(data)
		{
			if(data == 1)
			{
				alert("Parametros cadastrados!");
				window.location = "cadastro_perguntas.php?idpesquisa="+$("#formIdPesquisa").val();
			}
		}
	});
}

var strButtonPerguntas ="";
function adicionarPerguntas()
{
	strButtonPerguntas += '<div class="control-group">';
	strButtonPerguntas += '	<label class="control-label" for="formPegunta"><strong>Pergunta:</strong></label>';
	strButtonPerguntas += '	<div class="controls">';
	strButtonPerguntas += '		<input type="text" class="input-xlarge" name="formPegunta[]" id="formPegunta[]">';
	strButtonPerguntas += '	</div>';
	strButtonPerguntas += '</div>';
	$("#buttonPerguntas").html(strButtonPerguntas);
}

function getPerguntas()
{
	var arrPerguntas = Array();

	$("input[name^='formPegunta']").each(function(){ 
		arrPerguntas.push($(this).val());
	});

	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'cadastroPerguntas',
			idpesquisa : $("#formIdPesquisa").val(),
			arrPerguntas: arrPerguntas.toString()
		},
		success: function(data)
		{
			if(data == 1)
			{
				window.location = "consulta_pesquisa.php";
			}
		}
	});
}

function montaFormulario()
{
	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'formularioPesquisa',
			idpesquisa : $.query.get('idpesquisa'),
		},
		success: function(data)
		{
			$("#tabelaFormularioPesquisa").html(data);
		}
	});
}

function getRespostas()
{
	var arrIdPerguntas = Array();
	var arrResposta = Array();
	
	$("input[type=radio]:checked").each(function(){
		var pergunta =  $(this).attr('name').substring(7,10);
		arrResposta.push($(this).val());
		arrIdPerguntas.push(pergunta);
	});

	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'cadastroRespostas',
			idpesquisa : $.query.get('idpesquisa'),
			arrResposta: arrResposta.toString(),
			arrIdPerguntas: arrIdPerguntas.toString()
		},
		success: function(data)
		{
			if(data == 1)
			{
				alert("Obrigado por nos ajudar!");
				window.location = "consulta_pesquisa.php";
			}
			else
			{
				alert("Ocorreu erro no sistema!");
			}
		}
	});
}

var tipoGrafico = "Pie";
function gerarGraficoPesquisa(idpesquisa)
{
	$.ajax({
		type: "POST",
		url: pagUrl,
		data :
		{
			controller : 'geraGraficoPesquisa',
			tipoGrafico: tipoGrafico,
			idpesquisa : idpesquisa
		},
		success: function(data)
		{
			switch(tipoGrafico)
			{
				/*
					case "Barra":
						chartFormatBarra(data);
					break;
				*/
				case "Pie":
					chartFormatPie(data);
				break;
				case "Bar":
					chartFormatBar(data);
				break;
			}
		}
	});
}

/*
function chartFormatBarra()
{

}
*/

function chartFormatBar(str)
{

	var chart;

	chart = new Highcharts.Chart({
			chart:
			{
				renderTo: 'container',
                type: 'column',
                margin: [ 50, 50, 100, 80],
				backgroundColor:'transparent'
            },
			title:
			{
                text: ''
            },
            xAxis:
			{
                categories: ['Pesquisa']
            },
			yAxis:
			{
                allowDecimals: false,
                min: 0,
                title:
				{
                    text: 'Estatística de pesquisas'
                }
            },
            legend:
			{
                align: 'right',
                x: -0,
                verticalAlign: 'top',
                y: 10,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false,
				backgroundColor:'transparent'
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y ;
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                },
				formatter:
					function() 
					{
						return Math.round(this.percentage) +'%';
					},
            },
			credits: {
				enabled: false
			},
			 series: eval(str)
        });
}

function chartFormatPie(data)
{
	var arrStringJson = Array();
	var arrSeries = data.split(",");
	var respostasJSONObject = '{"name":"", "type": "pie", "data":['+arrSeries+']}';

	arrStringJson.push(respostasJSONObject);

	var chart;
	chart = new Highcharts.Chart({
		chart: 
		{
			renderTo: 'container',
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: true,
			backgroundColor:'transparent'
		},
		title:
		{
			text: 'Pesquisa'
		},
		tooltip:
		{
			 formatter: function() 
			 {
                return this.point.name+': '+this.y+' <b>'+Math.round(this.point.percentage)+'%</b>';
             }
		},
		plotOptions:
		{
			pie:
			{
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels:
				{
					enabled: true,
					color: '#000000',
					connectorColor: '#000000',
					formatter: function()
					{
						return ''+this.point.name +': '+ Math.round(this.percentage) +'% ';
					}
				},
				showInLegend: true,
				point:
				{
					events:
					{
						legendItemClick: function()
						{
							if (this.visible)
							{
								this['y_old'] = this.y;
								this.update(0);
							}
							else
								this.update(this.y_old);
						}
					}
				}
			}
		},
		credits: {
			enabled: false
		},
		series: eval("["+arrStringJson+"]")
	});
}

function gerarChartPergunta()
{
	if(!$("#formSelectPergunta").val())
		gerarGraficoPesquisa($.query.get('idpesquisa'))
	else
	{
		$.ajax({
			type: "POST",
			url: pagUrl,
			data : {
				controller : 'geraGraficoPergunta',
				tipoGrafico : tipoGrafico,
				idpergunta : $("#formSelectPergunta").val(),
				idpesquisa : $.query.get('idpesquisa')
			},
			success: function(data)
			{
				switch(tipoGrafico)
				{
					case "Pie":
						chartFormatPie(data);
					break;
					case "Bar":
						chartFormatBar(data);
					break;
				}
			}
		});
	}
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

function directChart()
{
	window.location="estatististica_pesquisa.php?idpesquisa="+$.query.get('idpesquisa');
}

function modificaPergunta(idpergunta)
{
	$.ajax({
		type: "POST",
		url: pagUrl,
		data: {
			controller : 'selectDadosPergunta',
			idpergunta : idpergunta,
		},
		success: function(data)
		{
			var objeto = eval('(' +data+ ')');
			alert(objeto.pergunta);
			$('#'+id).html('<input type="text" value="aaa" class="input-xlarge" name="formPegunta" id="formPegunta">');
			$("#formPegunta").val(objeto.pergunta);
		}
	});
}

function addPergunta(idpesquisa)
{
	$("#divPesquisa").hide();
	$("#formIdPesquisa").val(idpesquisa);
	$("#divParametros").show();
	buscarNome(idpesquisa);
}


function excluirPergunta(idpergunta)
{
	if(!confirm("Deseja realmente excluir?"))
		return false;

	$.ajax({
		type: "POST",
		url: pagUrl,
		data:
		{
			controller : 'excluirPergunta',
			idpergunta : idpergunta
		},
		success: function(data)
		{
			if(data == 1)
			{
				alert("Registro excluido com sucesso!");
				window.location = "formulario_pesquisa.php?idpesquisa="+$.query.get('idpesquisa');
			}
			else
				alert("Ocorreu erro!");
		}
	});
}

function excluirPesquisa(idpesquisa)
{
	if(!confirm("Deseja realmente excluir?"))
		return false;

	$.ajax({
		type: "POST",
		url: pagUrl,
		data:
		{
			controller : 'excluirPesquisa',
			idpesquisa : idpesquisa
		},
		success: function(data)
		{
			if(data == 1)
			{
				alert("Pesquisa excluida com sucesso!");
				window.location = "consulta_pesquisa.php";
			}
			else
				alert("Ocorreu erro!");
		}
	});
}


function tabelaFormatoGrafico()
{
	$.ajax({
		type: "POST",
		url: pagUrl,
		data:
		{
			controller : 'tableTipoGrafico'
		},
		success: function(data)
		{
			$("#tabelaTipoGrafico").html(data);

			$("input[type=radio]:checked").each(function(){
				tipoGrafico = $(this).val();
			});
		}
	});
}

function grafico(parametro)
{
	tipoGrafico = parametro;
	
	if($("#formSelectPergunta").val())
		gerarChartPergunta();
	else
		gerarGraficoPesquisa($.query.get('idpesquisa'))
	
}

