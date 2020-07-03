var numPage = 0;
var arrayField = Array();
var path = "http://172.16.0.150/projetogestori/icones/";

function efetc()
{
    $('table#curso tbody tr').hover(
		function(){ $(this).addClass('destaque');}, 
        function(){ $(this).removeClass('destaque');} 
     );
}

function getJsonSelect(controller,id,objectConfig,objectLabel,view,numRows,numPage,objectPar)
{
	var objParametros = "";

	if(!numPage)
		numPage = 1;

	if(!objectPar)
	{
		if(id)
		{
			if(!numRows)
				objParametros += "controller="+controller+"&numPage="+numPage+"&id="+id;
			else
				objParametros += "controller="+controller+"&numPage="+numPage+"&numRows="+numRows+"&id="+id;
		}
		else
		{
			if(!numRows)
				objParametros += "controller="+controller+"&numPage="+numPage;
			else
				objParametros += "controller="+controller+"&numPage="+numPage+"&numRows="+numRows;
		}
	}
	else
	{
		if(!numRows)
			objParametros += "controller="+controller+"&numPage="+numPage+"&filtro=true";
		else
			objParametros += "controller="+ controller+"&numRows="+numRows+"&numPage="+numPage+"&filtro=true";

		objParametros+="&"+objectPar;
	}

	$("#"+objectConfig.gridDiv+"").html("<div style='margin-left:auto;margin-right:auto;width:20%;'><center><img src='http://172.16.0.150/projetogestori/img/loding_grid.gif'/></center></div>");

	if(pagUrl)
		view = pagUrl;

	$.ajax({
		type: "POST",
		url: view,
		data : objParametros,
		dataType:  'json',
		success: function(data)
		{
			if(data == "0")
			{
				var msg = "";

				if(objectConfig.aviso)
					msg = "<div class='alert' aling='center'><div align='center'><strong>"+objectConfig.aviso+"</strong></div></div>";
				else
					 msg = "<div class='alert' aling='center'><div align='center'><strong>Nenhum registro encontrado!</strong></div></div>";

				$("#"+objectConfig.gridDiv+"").html(msg);
				return false;
			}
			else
				var objectDados = eval("("+data+")");

			$.gridJqueryPlugin(objectDados,objectConfig,objectLabel);
			
			$("#previous").click(function(){
				if(numPage != 0)
				{
					numPage--;
					getJsonSelect(controller,id,objectConfig,objectLabel,view,numRows,numPage);
				}
			});

			$("#next").click(function() {
				if(objectDados.rows.length == numRows)
				{
					numPage++;
				}
				getJsonSelect(controller,id,objectConfig,objectLabel,view,numRows,numPage);
			});
			efetc();
		}
	});
}

function push(pag)
{
	window.location = pag;
}

function marcarCheckbox(id)
{
	$("input[type=checkbox][id='"+id+"[]']").each(function(){
		if(this.checked == true)
			this.checked = false;
		else
			this.checked = true;
	});
}

jQuery.gridJqueryPlugin = function(object,settings,objectLabel)
{
		//settings
		var config = 
		{
			'gridDiv':'',
			'width': '',
			'class':'',
			'border':'',
			'print':false,
			'id':'',
			'page':false,
			'title':'',
			'colspan':'',
			'crud':false,
			'push':false,
			'visualize':'',
			'update':'',
			'delete':'',
			'objectLink':false,
			'recordset':false,
			'objectRecordTab':false,
			'checkbox':false,
			'radio':false,
			'save':true,
			'objectHideTable':false,
			'pagamento':'',
			'chekout':'',
			'chart':'',
			'id2':'',
			'money':false,
			'discount':'',
			'paddingLeft':'',
			'paddingRight':'',
			'inputName':false,
			'functioCheckbox':''
		};

		var styleCursor = "style='cursor:pointer'";

		if (settings){$.extend(config, settings);}
			$("#"+config.gridDiv+"").html("<div style='margin-left:auto;margin-right:auto;width:20%;'><center><img src='../img/loding_grid.gif'/><center></div>");

		
			var gridDados = "";

			if(config.push)
			{
				if(config.print != "")
				{
					gridDados +="<table  class='"+config.class+"' width=100% style='position:relative'>";
					gridDados +="<tr>";
					gridDados +="<td width=80% align='left' >";
					gridDados +="<button id='push' type='button' onclick="+config.print+"() class='btn' title='Imprimir'><img src='"+path+"Imprimir.png' width=25px height=25px>&nbsp;&nbsp;<strong>Imprimir</strong></button>";
					gridDados +="</td>";
					gridDados +="<td>";
					gridDados +="</td>";
					gridDados +="<td width=95% align='right'>";
					gridDados +="<button id='push' type='button' onclick=push('"+config.push+"') class='btn' title='Adicionar'><img src='"+path+"Adicionar.png' width='20px' height='20px'>&nbsp;<strong>Adicionar</strong></button>";
					gridDados +="</td>";
					gridDados +="</tr>";
					gridDados +="</table>";
				}
				else
				{
					gridDados +="<table  class='"+config.class+"' width=100% style='position:relative'>";
					gridDados +="<tr>";
					gridDados +="<td  >";
					gridDados +="</td>";
					gridDados +="<td>";
					gridDados +="</td>";
					gridDados +="<td width=95% align='right'>";
					gridDados +="<button id='push' type='button' onclick=push('"+config.push+"') class='btn' title='Adicionar'><img src='"+path+"Adicionar.png' width='20px' height='20px'>&nbsp;<strong>Adicionar</strong></button>";
					gridDados +="</td>";
					gridDados +="</tr>";
					gridDados +="</table>";
				}
			}

			if(config.print != "" && !config.push)
			{
				gridDados +="<table  class='"+config.class+"' width=100% style='position:relative'>";
				gridDados +="<tr>";
				gridDados +="<td width=80% align='left' >";
				gridDados +="<button id='push' type='button' onclick="+config.print+"() class='btn' title='Imprimir'><img src='../icones/print.png' width=25px height=25px>&nbsp;&nbsp;<strong>Imprimir</strong></button>";
				gridDados +="</td>";
				gridDados +="<td>";
				gridDados +="</td>";
				gridDados +="<td width=95% align='right'>";
				gridDados +="</td>";
				gridDados +="</tr>";
				gridDados +="</table>";
			}

			gridDados +="<table id='curso' class='table table-striped table-bordered table-condensed' width="+config.width+">";
			gridDados +="<thead>";

			if(config.title)
			{
				gridDados +="<tr class='trlabel'>";

				if(config.paddingRight)
					gridDados +="<th   colspan='"+config.colspan+"' style='padding-right:"+config.paddingRight+";text-align: center;'>"+config.title+"</th>";
				else
					if(config.paddingLeft)
						gridDados +="<th   colspan='"+config.colspan+"' style='padding-left:"+config.paddingLeft+";text-align: center;'>"+config.title+"</th>";
				else
					gridDados +="<th  colspan='"+config.colspan+"' style='text-align: center;'   >"+config.title+"</th>";
				gridDados +="</tr>";
			}

			if(objectLabel != false)
			{
				gridDados +="<tr class='trlabel'>";
				for(var keyL in objectLabel)
				{
					gridDados +="<th width='"+objectLabel[keyL].width+"' style='text-align: center;' align='center'>"+objectLabel[keyL].label+"</th>";
				}
				gridDados +="</tr>";
			}
			gridDados +="</thead>";
			gridDados +="<tbody>";

			var numRows = object.rows.length;
			var flag = false;
			var p = "";

			for(var key in object)
			{
				var object2 = object[key];
				var id = "";

				for(var key2 in object2)
				{
					object3 = object2[key2];
					gridDados += "<tr class='trlabel'>";

					for(var key3 in object3)
					{
						if(config.objectLink)
						{
							if(key3 != config.id)
							{
								for(var key in config.objectLink)
								{
									var conf = config.objectLink[key];

									if(key3 == conf.value)
									{
										var n=conf.link.split("|");
										var strLink = "?";

										for(var i=0; i< n.length; i++)
										{
											var key = n[i].split(":");
											if(key.length == 1)
											{
												if(strLink == "?")
													strLink += n[i]+"="+object3[n[i]];
												else
													strLink += "&"+n[i]+"="+object3[n[i]];
											}
											else
											{
												for(var j=0; j< key.length; j++)
												{	
													if(strLink != "")
														strLink += "&"+key[0]+"="+key[1];
														break;
												}
											}
										}
										gridDados += "<td ><a href='"+conf.pagina+strLink+"'>"+object3[key3]+"</a></td>";
										addField(key3);
									}
								}

								if(config.objectHideTable)
								{
									for(var key in config.objectHideTable)
									{
										var hide = config.objectHideTable[key];

										if(key3 == hide.value)
										{
											addField(hide.value)
										}
									}
								}

								if(addField(key3) != true)
								{
									if(conf.link != key3)
										gridDados += "<td align=center  >"+object3[key3]+"</td>";
								}
							}
							else
							{
								id = object3[key3];
								if(config.checkbox)
								{
									gridDados += "<td align=center><input type='checkbox' name='"+key3+"[]' value='"+id+"' id='"+key3+"[]'></td>";
								}
							}

							arrayField = Array();
						}
						else
						{
							if(key3 != config.id)
							{
								if(config.recordset == true)
								{
									for(var keyTab in config.objectRecordTab)
									{
										var confTab = config.objectRecordTab[keyTab];
										addField(confTab.recordset);
									}
									if(addField(key3))
										gridDados += "<td   >"+object3[key3]+"</td>";

									arrayField = Array();
								}
								else
								{
									if(config.objectHideTable)
									{
										for(var key in config.objectHideTable)
										{
											var hide = config.objectHideTable[key];

											if(hide.value != key3)
												gridDados += "<td  >"+object3[key3]+"</td>";
										}
									}
									else
										gridDados += "<td  >"+object3[key3]+"</td>";
								}
							}
							else
							{
								id = object3[key3];
								id2 = object3[config.id2];

								if(config.checkbox)
								{
									gridDados += "<td align=center><input type='checkbox' onclick='"+config.functioCheckbox+"(this);' name='"+key3+"[]' value='"+id+"' id='"+key3+"[]'></td>";
								}
								if(config.radio)
								{
									for(var z = 0; z<config.radio; z++)
									{
										if(config.id2)
											gridDados += "<td align=center><input type='radio' name='"+key3+"[]' value='"+id+"|"+id2+"' id='"+key3+"[]'></td>";
										else
											gridDados += "<td align=center><input type='radio' name='"+key3+"[]' value='"+id+"' id='"+key3+"[]'></td>";
									}
								}
							}
						}
					}

					if(config.crud)
					{
						gridDados += "<td align=center >";	
						if(config.pagamento)
							gridDados += "&nbsp;&nbsp;<a "+styleCursor+" href='"+config.pagamento+"?"+config.id+"="+id+"&idhospede="+$.query.get('idhospede')+"'  title='Pagamento' alt='Pagamento'><img src='"+path+"icones/pagamento.png' width='25px' height='20px' title='Pagamento'></a>";
						if(config.lista)
							gridDados += "&nbsp;&nbsp;<a "+styleCursor+" href='"+config.lista+"?"+config.id+"="+id+"'  title='Listar' alt='Listar'><img src='"+path+"icones/lista.png' width='25px' height='20px' title='Listar'></a>";						
						if(config.visualize)
							gridDados += "&nbsp;&nbsp;<a href='#myModal' "+styleCursor+"  role='button' onclick='"+config.visualize+"("+id+")' title='Visualizar'  data-toggle='modal'><img src='"+path+"visualizar.png' width='20px' height='20px' title='Visualizar'></a>";
						if(config.update && config.push)
							gridDados += "&nbsp;&nbsp;<a "+styleCursor+" href='"+config.push+"?"+config.id+"="+id+"&editar=true'  title='Editar' alt='Editar'><img src='"+path+"editar.png' width='25px' height='20px' title='Editar'></a>";
						if(config.update && !config.push)
							gridDados += "&nbsp;&nbsp;<a "+styleCursor+" href='"+config.update+"?"+config.id+"="+id+"&editar=true' title='Editar' alt='Editar'><img src='"+path+"editar.png' width='25px' height='20px' title='Editar'></a>";
						if(config.chart)
							gridDados += "&nbsp;&nbsp;<a "+styleCursor+" href='"+config.chart+"?"+config.id+"="+id+"' title='Estatística' alt='Editar'><img src='"+path+"grafico.png' width='25px' height='20px' title='Estatística'></a>";
						if(config.delete)
							gridDados += "&nbsp;&nbsp;<span  "+styleCursor+" onclick='"+config.delete+"("+id+")' value='' title='Excluir'><img src='"+path+"excluir.png' width='20px' height='20px'></span>";

						if(config.discount)
						{
							if(key3 == "desconto")
							{
								if(object3[key3] != "S" && object3[key3] != "N")
									gridDados += "<a href='#myModal' "+styleCursor+"  role='button' onclick='descontarReserva("+id+")' title='Descontar'  data-toggle='modal'><img src='"+path+"baixo.jpg' width='20px' height='20px' title='Descontar'></a>";

								/*
									else if(object3[key3] != "N")
									{
										gridDados += "<a href='#myModal' "+styleCursor+"  role='button'   data-toggle='modal'><img src='http://localhost/beaverpousada/icones/seta_c.png' width='20px' height='20px'></a>";
									}
								*/
							}
						}

						if(config.chekout)
							gridDados += "<span  "+styleCursor+" onclick='"+config.chekout+"("+id+")' value='' title='Checkout'><img src='http://localhost/beaverpousada/icones/cancel2.png' width='20px' height='20px'></span>";
						gridDados += "</td>";
					}

					if(config.inputName)
					{
						var inputName = config.inputName.split("|");
						var tipo   = inputName[0];
						var name   = inputName[1];
						var hidden = inputName[2];
						var funcao = inputName[3];
						var evento = inputName[4];
						var disabled = inputName[5];

						gridDados += "<td align=center>";

						if(tipo == 'text' && funcao != '')
						{
							if(config.money == true)
								gridDados += "<input type='text' onKeyUp='mascaraMoeda(this);' "+evento+"='"+funcao+"(this.value)' class='input-xlarge'  name='"+name+"[]' style='width:90px' id='"+name+"[]'>";
							else
							{
								if(disabled == 'true')
									gridDados += "<input type='text' disabled "+evento+"='"+funcao+"(this.value)' class='input-xlarge'  name='"+name+"[]' style='width:50px' id='"+name+"[]'>";
								else
									gridDados += "<input type='text' "+evento+"='"+funcao+"(this.value)' class='input-xlarge'  name='"+name+"[]' style='width:50px' id='"+name+"[]'>";
							}
						}
						else
						{
							if(tipo == 'text')
							{
							
									gridDados += "<input type='text' class='input-xlarge' disabled name='"+name+"[]' style='width:50px' id='"+name+"[]'>";
									
								
							}
						}

						if(hidden == 'hidden')
							gridDados += "<input type='hidden'  name='formIdHidden[]'  id='formIdHidden[]' value='"+id+"'>";
						gridDados += "</td>";
					}
					gridDados += "</tr>";
				}
			}
			gridDados +="</tbody>";
			gridDados +="</table>";

			if(config.radio)
			{
				gridDados +="<table  class='"+config.class+"' width=100% style='position:relative'>";
				gridDados +="<tr>";
				gridDados +="<td width=95% align='left'>";
				gridDados +="<button id='push' type='button' onclick='"+config.save+"()'  class='btn' title='Adicionar'><strong>Salvar</strong></button>";
				gridDados +="</td>";
				gridDados +="</tr>";
				gridDados +="</table>";
			}

			if(config.page)
			{
				gridDados +="<table class='"+config.class+"' style='position:relative'>";
				gridDados +="<tr>";
				gridDados +="<td>";
				gridDados +="<button id='previous' type='button' class='btn' title='Anterior'><img src='"+path+"back.png' width='20px' height='20px'></button>";
				gridDados +="</td>";
				gridDados +="<td>";
				gridDados +="<button id='next' type='button' class='btn' title='Próxima'> <img src='"+path+"next.png' width='20px' height='20px'></button>";
				gridDados +="</td>";
				gridDados +="</tr>";
				gridDados +="</table>";
			}

			$('#'+config.gridDiv).html(gridDados);
};

function addField(strField)
{
	if(arrayField.length == 0)
		arrayField.push(strField)
	else
	{
		var flag = arrayField.indexOf(strField);

		if(flag == "-1")
			arrayField.push(strField);
		else
			return true;
	}
}


function formatReal(mixed)
{
  var int = parseInt(mixed.toFixed(2).toString().replace(/[^\d]+/g, ''));
  var tmp = int + '';
  tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
  if (tmp.length > 6)
    tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
 return tmp;
}


function mascaraMoeda(valor){  

   v = valor.value;
   v=v.replace(/\D/g,"")  
   v=v.replace(/[0-9]{12}/,"inválido") 
   v=v.replace(/(\d{1})(\d{8})$/,"$1.$2") 
   v=v.replace(/(\d{1})(\d{5})$/,"$1.$2") 
   v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2")
   
   valor.value = v;
   
}

