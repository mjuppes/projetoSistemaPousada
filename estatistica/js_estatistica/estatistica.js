var pagUrl = "viewGrafico.php";
var flagBebida = false;

function gerarGrafico()
{
	if(!$("#formDtInicial").val() || !$("#formDtFinal").val())
	{
		alert("Escolher data inicial e final!");
		return false;
	}

	var arrIdPrato = Array();

	$("input[type=checkbox][id='idprato[]']:checked").each(function(){
		arrIdPrato.push($(this).val());
	});

	if(arrIdPrato.length == 0)
	{
		alert('Escolher um prato!');
		return false;
	}

	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'getDadosIdprato',
			formDtInicial:$("#formDtInicial").val(),
			formDtFinal:$("#formDtFinal").val(),
			formSelectAno:$("#formSelectAno").val(),
			arrIdPrato : arrIdPrato.toString()
		},
		success: function(data)
		{
			if(data == 0)
				alert("Sem dados");
			else
				grafico(data);
		}});
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

var arrQtd = Array();
function addField1(strField)
{
	if(arrQtd.length == 0)
	{
		arrQtd.push(strField)
	}
	else
	{
		var flag = arrQtd.indexOf(strField);

		if(flag == "-1")
			arrQtd.push(strField)
		else
			return true;
	}		
}

function grafico(strObj)
{
	var object = eval("("+strObj+")");

	var arrMes = Array();
	var arrPrato = Array();
	var flag;
	var arrStringPrato = Array();

	var respostasJSONObject;
	var arrStringJson = Array();

	arrMes = Array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");

	var chart;	
	chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: '',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: arrMes
            },
            yAxis: {
                title: {
                    text: ''
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +' quantidade';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: object
        });
}

function graficoOcupacao(strObj)
{
	var vetor = strObj.split("|"); 
	var arrMes = Array();

	arrMes = vetor[0].split(",");
	var qtdVenda = eval("["+vetor[1]+"]");
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
                text: 'Ocupação de quartos por período'
            },
            xAxis:
			{
                categories: arrMes
            },
            yAxis: 
			{
                allowDecimals: false,
                min: 0,
                title: {
                    text: 'Numero de ocupações'
                }
            },
            tooltip:
			{
                formatter: function()
				{
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total de ocupações: '+ this.point.stackTotal;
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },
			credits: {
				enabled: false
			},
          series: qtdVenda
        });

}

function gerarChartOcupacao()
{
	$.blockUI({
	   css: 
		   {
				border: 'none',
				padding: '15px',
				'-webkit-border-radius': '10px',
				'-moz-border-radius': '10px',
				opacity: .5,
				top:  ($(window).height() - 200) /2 + 'px',
				left: ($(window).width() - 200) /2 + 'px',
				width: '200px'
            }
	});

	$.ajax({
		type: "POST",
		url: 'viewGrafico.php',
		data : {
			controller : 'getDadosQuarto',
			formSelectAno : $("#formSelectAno").val()
		},
		success: function(data)
		{
			if(data == 0)
			{
				alert('Sem dados!');
				$("#container").html("");
			}
			else
				graficoOcupacao(data);
		}});

		setTimeout($.unblockUI, 1000); 

}


function gerarChartTipoHospAgencia()
{

	$.ajax({
		type: "POST",
		url: pagUrl,
		data:
		{
			controller : 'getDadosTipoHospAgencia',
			formSelectMes : $("#formSelectMes").val()
		},
		success: function(data)
		{
			if(data == 0)
			{
				$("#container").html("");
				return false;
			}
			else
				graficoTipoHospAgencia(data);
		}});

		var objectParametros = "&formSelectMes="+$("#formSelectMes").val();
		getJsonSelect('selectAgenciasQtd',false,objectConfig,objectLabel,'viewGrafico.php',false,objectParametros);
}

function graficoTipoHospAgencia(strSeries)
{
	var arrStringJson = Array();
	var arrSeries = strSeries.split(",");
	var respostasJSONObject = '{"name":"", "type": "pie", "data":['+arrSeries+']}';

	arrStringJson.push(respostasJSONObject);

	var chart;
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			backgroundColor:'transparent'
		},
		title:
		{
			text: 'Hospede por agência'
		},
		tooltip:
		{
			 formatter: function() 
			 {
                return 'Quantidade de '+this.point.name+': '+this.y+' <b>'+Math.round(this.point.percentage)+'%</b>';
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

function gerarChartNumeroHospede()
{
	var objectParametros = "";
	if($("#formSelectAno").val())
		objectParametros += "&formSelectAno="+$("#formSelectAno").val();
	if($("#formSelectMes").val())
		objectParametros += "&formSelectMes="+$("#formSelectMes").val();
	if($("#formSelectAgencia").val())
		objectParametros += "&formSelectAgencia="+$("#formSelectAgencia").val();

	var strObj = "";

	if(objectParametros)
		strObj = "controller=getDadosNumeroHospede"+objectParametros;
	else
		strObj = "controller=getDadosNumeroHospede";

	$.ajax({
		type: "POST",
		url: pagUrl,
		data : strObj,
		success: function(data)
		{
			if(data == 0)
			{
				alert("Sem dados");
				return false;
			}
			else
				graficoNumeroHospede(data);
		}});
		getJsonSelect('selectNumeroHospede',false,objectConfig,objectLabel,'viewGrafico.php',false,objectParametros);
}

function graficoNumeroHospede(strSeries)
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
                categories: ['Gráfico geral de agenciados']
            },
			yAxis: 
			{
                allowDecimals: false,
                min: 0,
                title:
				{
                    text: 'Estatística de agenciados'
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
				formatter: function() {
							return Math.round(this.percentage) +'%';
						}
            },
			credits: {
				enabled: false
			},
			 series: eval(strSeries)
        });
}

function gerarChartProdutoBebida()
{
	if(!$("#formSelectAno").val() || !$("#formSelectMes").val())
	{
		alert("Escolher Ano e Mês!");
		return false;
	}
	if(!$("#formSelectTipoBebida").val())
	{
		alert('Selecione o tipo de bebida!');
		return false;
	}

	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'getDadosProdutoBebida',
			formSelectMes:$("#formSelectMes").val(),
			formSelectAno:$("#formSelectAno").val(),
			formSelectTipoBebida:$("#formSelectTipoBebida").val()
		},
		success: function(data)
		{
			if(data == 0)
			{
				alert("Sem dados");
				return false;
			}
			else
				graficoProdutoBebida(data);
		}});
}

function graficoProdutoBebida(strSeries)
{
	var arrStringJson = Array();
	var arrSeries = strSeries.split(",");
	var respostasJSONObject = '{"name":"", "type": "pie", "data":['+arrSeries+']}';

	arrStringJson.push(respostasJSONObject);

	var chart;

	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false
		},
		title: {
			text: 'Marcas de produto por tipo'
		},
		tooltip: {
			 formatter: function() {
                    return 'Quantidade de '+this.point.name+': '+this.y;
                }
		},
		plotOptions: {
				pie:
				{
					showInLegend: true,
					dataLabels:
					{
						enabled: true,
						color: '#000000',
						formatter: function() {
							return Math.round(this.percentage) +'%';
						}
					},
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
		series: eval("["+arrStringJson+"]")
	});
}


function gerarChartVariacaoPrato()
{
	if(!$("#formSelectAno").val() || !$("#formSelectMes").val())
	{
		alert("Escolher Ano e Mês!");
		return false;
	}
	if(!$("#formSelectPratos").val())
	{
		alert('Selecione o tipo de prato!');
		return false;
	}

	$.ajax({
		type: "POST",
		url: pagUrl,
		data : {
			controller : 'getDadosVariacaoPrato',
			formSelectMes:$("#formSelectMes").val(),
			formSelectAno:$("#formSelectAno").val(),
			formSelectPratos:$("#formSelectPratos").val()
		},
		success: function(data)
		{
			//alert(data);
			//return false;

			if(data == 0)
			{
				alert("Sem dados");
				return false;
			}
			else
				graficoVariacaoPrato(data);
		}});
}

function graficoVariacaoPrato(strObj)
{
	var vetor = Array();
	vetor = strObj.split("|");

	var arr = Array();
	arr = vetor[0].split(",");

	var object = eval("["+vetor[1]+"]");
	var chart;

	chart = new Highcharts.Chart({
            chart: {
				renderTo: 'container',
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: 'Variacao de precos',
                x: -20 //center
            },
            xAxis: {
                categories: arr
            },
            yAxis: {
                title: {
                    text: ''
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '°C'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: object
        });
}

function teste()
{
	var colors = Highcharts.getOptions().colors,
	categories = ['MSIE', 'Firefox', 'Chrome', 'Safari', 'Opera'],
	name = 'Browser brands',
	data = [{
			y: 55.11,
			color: colors[0],
			drilldown: {
				name: 'MSIE versions',
				categories: ['MSIE 6.0', 'MSIE 7.0', 'MSIE 8.0', 'MSIE 9.0'],
				data: [10.85, 7.35, 33.06, 2.81],
				color: colors[0]
			}
		}, {
			y: 21.63,
			color: colors[1],
			drilldown: {
				name: 'Firefox versions',
				categories: ['Firefox 2.0', 'Firefox 3.0', 'Firefox 3.5', 'Firefox 3.6', 'Firefox 4.0'],
				data: [0.20, 0.83, 1.58, 13.12, 5.43],
				color: colors[1]
			}
		}, {
			y: 11.94,
			color: colors[2],
			drilldown: {
				name: 'Chrome versions',
				categories: ['Chrome 5.0', 'Chrome 6.0', 'Chrome 7.0', 'Chrome 8.0', 'Chrome 9.0',
					'Chrome 10.0', 'Chrome 11.0', 'Chrome 12.0'],
				data: [0.12, 0.19, 0.12, 0.36, 0.32, 9.91, 0.50, 0.22],
				color: colors[2]
			}
		}, {
			y: 7.15,
			color: colors[3],
			drilldown: {
				name: 'Safari versions',
				categories: ['Safari 5.0', 'Safari 4.0', 'Safari Win 5.0', 'Safari 4.1', 'Safari/Maxthon',
					'Safari 3.1', 'Safari 4.1'],
				data: [4.55, 1.42, 0.23, 0.21, 0.20, 0.19, 0.14],
				color: colors[3]
			}
		}, {
			y: 2.14,
			color: colors[4],
			drilldown: {
				name: 'Opera versions',
				categories: ['Opera 9.x', 'Opera 10.x', 'Opera 11.x'],
				data: [ 0.12, 0.37, 1.65],
				color: colors[4]
			}
		}];
    
    
        // Build the data arrays
        var browserData = [];
        var versionsData = [];
        for (var i = 0; i < data.length; i++) {
    
            // add browser data
            browserData.push({
                name: categories[i],
                y: data[i].y,
                color: data[i].color
            });
    
            // add version data
            for (var j = 0; j < data[i].drilldown.data.length; j++) {
                var brightness = 0.2 - (j / data[i].drilldown.data.length) / 5 ;
                versionsData.push({
                    name: data[i].drilldown.categories[j],
                    y: data[i].drilldown.data[j],
                    color: Highcharts.Color(data[i].color).brighten(brightness).get()
                });
            }
        }
		
		
		
    // Create the chart		
	var chart;
	chart = new Highcharts.Chart({
            chart: {
				renderTo: 'container',
                type: 'pie'
            },
            title: {
                text: 'Browser market share, April, 2011'
            },
            yAxis: {
                title: {
                    text: 'Total percent market share'
                }
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    center: ['50%', '50%']
                }
            },
            tooltip: {
        	    valueSuffix: '%'
            },
            series: [{
                name: 'Browsers',
                data: browserData,
                size: '60%',
                dataLabels: {
                    formatter: function() {
                        return this.y > 5 ? this.point.name : null;
                    },
                    color: 'white',
                    distance: -30
                }
            }, {
                name: 'Versions',
                data: versionsData,
                size: '80%',
                innerSize: '60%',
                dataLabels: {
                    formatter: function() {
                        // display only if larger than 1
                        return this.y > 1 ? '<b>'+ this.point.name +':</b> '+ this.y +'%'  : null;
                    }
                }
            }]
        });

}

function gerarChartFaturamento()
{
	$.blockUI({
	   css: 
		   {
				border: 'none',
				padding: '15px',
				'-webkit-border-radius': '10px',
				'-moz-border-radius': '10px',
				opacity: .5,
				top:  ($(window).height() - 200) /2 + 'px',
				left: ($(window).width() - 200) /2 + 'px',
				width: '200px'
            }
	});

	$.ajax({
		type: "POST",
		url: 'viewGrafico.php',
		data : {
			controller : 'getDadosQuarto',
			formSelectAno : $("#formSelectAno").val()
		},
		success: function(data)
		{
			if(data == 0)
			{
				alert('Sem dados!');
				$("#container").html("");
			}
			else
				graficoFaturamento(data);
		}});
		setTimeout($.unblockUI, 1000); 

}


function graficoFaturamento(obj_categorias,name,series)
{
	var chart;

	chart = new Highcharts.Chart({
            chart:
			{
				type: 'line',
				renderTo: 'container',
    			backgroundColor:'transparent'
            },
			title: 
			{
				text: 'Gráfico de Faturamento Anual'
			},
			xAxis:
			{
				categories: obj_categorias
			},
			yAxis:
			{
				title:
				{
					text: ''
				}
			},
			plotOptions:
			{
				line:
				{
					dataLabels:
					{
						enabled: true
					}
				},
				tooltip: {
					formatter: function() 
					{
						return 'The value for <b>' + this.x + '</b> is <b>' + this.y + '</b>, in series '+ this.series.name;
					}
				}
			},
			series: series
	});
}




function gerarTipoChart()
{
	if(!$("#formSelectGraficos").val())
		return false;

	if(!$("#formSelectAno").val())
		return false;

	$.blockUI({
	   css: 
		   {
				border: 'none',
				padding: '15px',
				'-webkit-border-radius': '10px',
				'-moz-border-radius': '10px',
				opacity: .5,
				top:  ($(window).height() - 200) /2 + 'px',
				left: ($(window).width() - 200) /2 + 'px',
				width: '200px'
            }
	});


	
	
	var objParametros = new Object();

	if($("#formSelectGraficos").val() == 'A')
		objParametros.controller = 'graficoFatAnual';
	
	if($("#formSelectGraficos").val() == 'D')
		objParametros.controller = 'graficoFatDiscriminado';	

		objParametros.formSelectAno = $("#formSelectAno").val();

	$.ajax({
		type: "POST",
		url: 'viewGrafico.php',
		data : objParametros,
		dataType:'json',
		success: function(data)
		{
			if($("#formSelectGraficos").val() == 'A')
			{
				var series = eval("("+data.series.toString()+")");
				graficoFaturamento(data.obj_categorias,data.name,series);
			}
			if($("#formSelectGraficos").val() == 'D')
			{
				//var series = eval("("+data.series.toString()+")");
				//graficoFaturamentoDiscriminado(data.obj_categorias,data.name,series);
				graficoFaturamentoDiscriminado();
			}
			
		}});

	setTimeout($.unblockUI, 1000); 
}

function graficoFaturamentoDiscriminado()
{
	gerarChartTipoHospAgencia();


}