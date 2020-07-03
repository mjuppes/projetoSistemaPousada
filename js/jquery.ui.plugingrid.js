var numPage = 0;
var arrayField = Array();

function push_2(pag)
{
	window.location = pag;
}

function efect()
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
				objParametros += "controller="+controller+"&numPage="+numPage+"&numRows="+numRows+"&id="+id;;
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

	$("#"+objectConfig.gridDiv+"").html("<div style='margin-left:auto;margin-right:auto;width:20%;'><center><img src='../img/loding_grid.gif'/></center></div>");

	if(!view)
	{
		if(pagUrl)
			view = pagUrl;
	}
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
			
			$("#previous").click(function() {
				if(numPage != 0)
				{
					numPage--;
					getJsonSelect(controller,id,objectConfig,objectLabel,view,numRows,numPage);
				}
			});

			$("#next").click(function() {
				if(objectDados.rows.length == numRows)
					numPage++;

				getJsonSelect(controller,id,objectConfig,objectLabel,view,numRows,numPage);
			});

			if(objectConfig.efect != false)
				efect();
		}
	});
}

function marcarCheckbox(id)
{
	$("input[type=checkbox][id='"+id+"[]']").each(function(){
		if($('#idmarca').is(':checked'))
			this.checked = true;
		else
			this.checked = false;
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
			'checkwidth': false,
			'checkImg':false,
			'arrLink':true,
			'checkTitle':false,
			'checkFunction':false,
			'radio':false,
			'save':true,
			'objectHideTable':false,
			'pagamento':'',
			'chekout':'',
			'chart':'',
			'efect':true,
			'discount':'',
			'paddingLeft':'',
			'printDetails': '',
			'paddingRight':'',
			'record': true
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
					gridDados +="<button id='push' type='button' onclick="+config.print+"() class='btn' title='Imprimir'><img src='../icones/print.png' width=25px height=25px>&nbsp;&nbsp;<strong>Imprimir</strong></button>";
					gridDados +="</td>";
					gridDados +="<td>";
					gridDados +="</td>";
					gridDados +="<td width=95% align='right'>";
					gridDados +="<button id='push' type='button' onclick=push_2('"+config.push+"') class='btn' title='Adicionar'><img src='http://177.70.26.45/beaverpousada/icones/adicionar.png' width='20px' height='20px'>&nbsp;<strong>Adicionar</strong></button>";
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
					gridDados +="<button id='push' type='button' onclick=push_2('"+config.push+"') class='btn' title='Adicionar'><img src='http://177.70.26.45/beaverpousada/icones/adicionar.png' width='20px' height='20px'>&nbsp;<strong>Adicionar</strong></button>";
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
			
			if(config.record != false)
			{
				gridDados +="<table  class='"+config.class+"' width=100% style='position:relative'>";
				gridDados +="<tr>";
				gridDados +="<td width=100% align='left' >";
				gridDados +="Numero de registro(s):&nbsp;&nbsp;"+object.rows.length;
				gridDados +="</td>";
				gridDados +="</tr>";
				gridDados +="</table>";				
			}
			
			if(config.efect == false)
				gridDados +="<table id='' style='overflow: auto;' class='table table-striped table-bordered table-condensed' width="+config.width+">";
			else
				gridDados +="<table id='curso'  style='overflow: auto;' class='table table-striped table-bordered table-condensed' width="+config.width+">";

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
					gridDados +="<th width='"+objectLabel[keyL].width+"' align='center'>"+objectLabel[keyL].label+"</th>";
				}
				gridDados +="</tr>";
			}
			
			gridDados +="</thead>";
			gridDados +="<tbody>";

			var numRows = object.rows.length;

			var gridC = "";
			if(config.checkbox)
			{
				if(config.checkwidth == false)
					config.checkwidth = "5%";

				var checkW = config.checkwidth;

				gridC +="<fieldset class='moldura fieldAlerta' style='width:98%'>";
				gridC +="<table  class='table table-bordered' width=100% style='position:relative'>";
				gridC += "<tr>";
				gridC += "<td align=center width="+checkW+"><input type='checkbox' id='idmarca' onclick=marcarCheckbox('"+config.id+"')></td>";
				gridC += "<td align=center>Selecionar todos</td>";
				gridC += "</tr>";
				gridC += "</table>";
			}

			var flag = false;
			var p = "";

			for(var key in object)
			{
				var object2 = object[key];
				var id = "";

				for(var key2 in object2)
				{
					object3 = object2[key2];
					
					//alert(config.gridDiv);
					var nameTr = config.gridDiv;
					gridDados += "<tr class='trlabel' id='tr"+key2+"'>";
					
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
										gridDados += "<td align=center><a href='"+conf.pagina+strLink+"'>"+object3[key3]+"</a></td>";
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
										gridDados += "<td align=center>"+object3[key3]+"</td>";
								}
							}
							else
							{
								id = object3[key3];
								if(config.checkbox)
									gridDados += "<td align=center><input type='checkbox' name='"+key3+"[]' value='"+id+"' id='"+key3+"[]'></td>";
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
										gridDados += "<td align=center>"+object3[key3]+"</td>";

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
												gridDados += "<td align=center>"+object3[key3]+"</td>";
										}
									}
									else
										gridDados += "<td align=center>"+object3[key3]+"</td>";
								}
							}
							else
							{
								id = object3[key3];
								if(config.checkbox)
								{
									gridDados += "<td align=center> <input type='checkbox' name='"+key3+"[]' value='"+id+"' id='"+key3+"[]'></td>";
								}
								if(config.radio)
								{
									for(var ir = 0; ir<config.radio; ir++)
									{
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
						{
							gridDados += "<a href='#myModal' "+styleCursor+"  role='button' onclick='"+config.pagamento+"("+id+")' title='Pagamento'  data-toggle='modal'><img src='http://177.70.26.45/beaverpousada/icones/pagamento.png' width='25px' height='20px' title='Pagamento'></a>";
						}

						if(config.lista)
							gridDados += "<a "+styleCursor+" href='"+config.lista+"?"+config.id+"="+id+"'  title='Listar' alt='Listar'><img src='http://177.70.26.45/beaverpousada/icones/lista.png' width='25px' height='20px' title='Listar'></a>";						
						if(config.visualize)
							gridDados += "<a href='#myModal' "+styleCursor+"  role='button' onclick='"+config.visualize+"("+id+")' title='Visualizar'  data-toggle='modal'><img src='http://177.70.26.45/beaverpousada/icones/visualizar.png' width='20px' height='20px' title='Visualizar'></a>";

						if(config.update)
						{
							if(config.update != true)
							{
								var verifica_ext = config.update.indexOf(".php");

								if(verifica_ext == "-1")
									gridDados += "<a "+styleCursor+" onclick='"+config.update+"("+id+")"+"'  title='Editar' alt='Editar'><img src='http://177.70.26.45/beaverpousada/icones/editar.png' width='25px' height='20px' title='Editar'></a>";
								else
									gridDados += "<a "+styleCursor+" href='"+config.update+"?"+config.id+"="+id+"&editar=true' title='Editar' alt='Editar'><img src='http://177.70.26.45/beaverpousada/icones/editar.png' width='25px' height='20px' title='Editar'></a>";
							}
							else
								gridDados += "<a "+styleCursor+" href='"+config.push+"?"+config.id+"="+id+"&editar=true'  title='Editar' alt='Editar'><img src='http://177.70.26.45/beaverpousada/icones/editar.png' width='25px' height='20px' title='Editar'></a>";
						}
						else
						{
							if(config.update && config.push)
								gridDados += "<a "+styleCursor+" href='"+config.push+"?"+config.id+"="+id+"&editar=true'  title='Editar' alt='Editar'><img src='http://177.70.26.45/beaverpousada/icones/editar.png' width='25px' height='20px' title='Editar'></a>";
							if(config.update && !config.push)
								gridDados += "<a "+styleCursor+" href='"+config.update+"?"+config.id+"="+id+"&editar=true' title='Editar' alt='Editar'><img src='http://177.70.26.45/beaverpousada/icones/editar.png' width='25px' height='20px' title='Editar'></a>";	
						}

						if(config.arrLink)
						{
							var arrLinkObj 	  = config.arrLink;
							var icon 		  = "";
							var function_icon = "";
							
							for(var key6 in  arrLinkObj)
							{
								var icon 		  = arrLinkObj[key6]['icon'];
								var function_icon = arrLinkObj[key6]['function'];
								var title 		  = arrLinkObj[key6]['title'];

								gridDados += "<span  "+styleCursor+" onclick='"+function_icon+"("+id+")' value='' title='"+title+"'><img src='http://177.70.26.45/beaverpousada/icones/"+icon+"' width='20px' height='22px'></span>";
							}						
						}						
						if(config.chart)
							gridDados += "<a "+styleCursor+" href='"+config.chart+"?"+config.id+"="+id+"' title='Estatística' alt='Editar'><img src='http://177.70.26.45/beaverpousada/icones/grafico.png' width='25px' height='20px' title='Estatística'></a>";
						if(config.printDetails)
							gridDados += "<a "+styleCursor+" onclick='"+config.printDetails+"("+key2+","+id+")'  title='Listar' alt='Listar'><img src='http://177.70.26.45/beaverpousada/icones/visualizar.png' width='20px' height='20px' title='Visualizar'></a>";						
						if(config.delete)
							gridDados += "<span  "+styleCursor+" onclick='"+config.delete+"("+id+")' value='' title='Excluir'><img src='http://177.70.26.45/beaverpousada/icones/excluir.png' width='20px' height='20px'></span>";
						
						if(config.discount)
						{
							if(key3 == "desconto")
							{
								if(object3[key3] != "S" && object3[key3] != "N")
								{
									gridDados += "<a href='#myModalDesconto' "+styleCursor+"  role='button' onclick='descontarReserva("+id+")' title='Descontar'  data-toggle='modal'><img src='http://177.70.26.45/beaverpousada/icones/baixo.jpg' width='20px' height='20px' title='Descontar'></a>";
								}
								/*
								else if(object3[key3] != "N")
								{
									gridDados += "<a href='#myModal' "+styleCursor+"  role='button'   data-toggle='modal'><img src='http://177.70.26.45/beaverpousada/icones/seta_c.png' width='20px' height='20px'></a>";
								}
								*/
							}
						}

						if(config.chekout)
							gridDados += "<span  "+styleCursor+" onclick='"+config.chekout+"("+id+")' value='' title='Checkout'><img src='http://177.70.26.45/beaverpousada/icones/cancel2.png' width='20px' height='20px'></span>";
						gridDados += "</td>";
					}
					gridDados += "</tr>";
				}
			}
			gridDados +="</tbody>";
			gridDados +="</table>";

			if(config.page)
			{
				gridDados +="<table class='"+config.class+"' style='position:relative'>";
				gridDados +="<tr>";
				gridDados +="<td>";
				gridDados +="<button id='previous' type='button' class='btn' title='Anterior'><img src='http://177.70.26.45/beaverpousada/icones/back.png' width='20px' height='20px'></button>";
				gridDados +="</td>";
				gridDados +="<td>";
				gridDados +="<button id='next' type='button' class='btn' title='Próxima'> <img src='http://177.70.26.45/beaverpousada/icones/next.png' width='20px' height='20px'></button>";
				gridDados +="</td>";
				gridDados +="</tr>";
				gridDados +="</table>";
			}

			if(gridC != "")
			{
				gridDados = gridC+gridDados;
				
				var checkImg = config.checkImg;
				var checkTitle = config.checkTitle;
			
				gridDados +="</fieldset><br><table  class='table form-actions' width=100% style='position:relative;'>";
				gridDados +="<tr>";
				gridDados +="<td width=5% align='left'>";
				
				if(checkImg && checkTitle)
					gridDados +="<button id='push' type='button' onclick='"+config.checkFunction+"()' class='btn' title='"+checkTitle+"'><img src='../icones/"+checkImg+"' width='30px' height='40px'><strong>"+checkTitle+"</strong></button>";
				else
					gridDados +="<button id='push' type='button' onclick='"+config.checkFunction+"()' class='btn' title='Adicionar'>Salvar</button>";

				gridDados +="</td>";
				gridDados +="<td>";
				gridDados +="</td>";
				gridDados +="</tr>";
				gridDados +="</table>";
				gridDados +="";
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
				arrayField.push(strField)
			else
				return true;
		}
	}