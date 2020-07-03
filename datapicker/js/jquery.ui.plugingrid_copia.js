var numPage = 0;
var arrayField = Array();

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

	//$("<span id='msg'>Carregando</span>");
	$("#"+objectConfig.gridDiv+"").html("<div style='margin-left:auto;margin-right:auto;width:20%;'><img src='../img/loading.gif'/></div>");

	$.ajax({
		type: "POST",
		url: view,
		data : objParametros,
		dataType:  'json',
		success: function(data)
		{
			var objectDados = eval("("+data+")");

			$.gridJqueryPlugin(objectDados,objectConfig,objectLabel);
			//objectDados.rows.length
			$("#previous").click(function() {
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
		}
	});
}

jQuery.gridJqueryPlugin = function(object,settings,objectLabel)
{
		//settings
		var config = {
			'gridDiv':'',
			'width': '',
			'class':'',
			'border':'',
			'id':'',
			'page':false,
			'title':'',
			'colspan':'',
			'crud':false,
			'visualize ':'',
			'update':'',
			'delete':'',
			'objectLink':false,
			'recordset':false,
			'objectRecordTab':false,
			'checkbox':false,
			'radio':false
		};

		if (settings){$.extend(config, settings);}

			$("#"+config.gridDiv+"").html("<div style='margin-left:auto;margin-right:auto;width:20%;'><img src='../img/loading.gif'/></div>");
		
			var gridDados = "";

			gridDados +="<table class='table table-striped table-bordered table-condensed' width="+config.width+">";
			gridDados +="<thead>";

			if(config.title)
			{
				gridDados +="<tr>";
				gridDados +="<th  colspan='"+config.colspan+"' style='text-align: center;'   >"+config.title+"</th>";
				gridDados +="</tr>";
			}
			gridDados +="<tr>";

			for(var keyL in objectLabel)
			{
				gridDados +="<th width='"+objectLabel[keyL].width+"' align='center'>"+objectLabel[keyL].label+"</th>";
			}

			gridDados +="</tr>";
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
					gridDados += "<tr>";
					
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
									{
										gridDados += "<td align=center>"+object3[key3]+"</td>";
									}
									arrayField = Array();
								}
								else
								{
									gridDados += "<td align=center>"+object3[key3]+"</td>";
								}
							}
							else
							{
								id = object3[key3];
								if(config.checkbox)
									gridDados += "<td align=center><input type='checkbox' name='"+key3+"[]' value='"+id+"' id='"+key3+"[]'></td>";
								if(config.radio)
									gridDados += "<td align=center><input type='radio' name='"+key3+"[]' value='"+id+"' id='"+key3+"[]'></td>";
							}
						}
					}
					if(config.crud)
					{
						gridDados += "<td align=center >";	

						if(config.visualize)
							//gridDados += "<a href='"+config.visualize+"?"+config.id+"="+id+"' title='Visualizar' class='icon-zoom-in'/>";
							//gridDados += "<a href='#myModal' title='Visualizar' class='icon-zoom-in'/>";
							gridDados +="<a data-toggle='modal' href='remote.html' data-target='#modal' class='icon-zoom-in'></a>";
						if(config.update)
							gridDados += "<a href='"+config.update+"?"+config.id+"="+id+"&editar=true' class='icon-pencil' title='Editar' alt='Editar'></a>";
						if(config.delete)
							gridDados += "<span class='icon-trash' onclick='"+config.delete+"("+id+")' value='' title='Excluir'></span>";
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
				gridDados +="<td  >";
				gridDados +="	<a id='previous' class='prev' style='cursor: pointer'><li class='icon-backward'></li> Anterior</a>";
				gridDados +="</td>";
				gridDados +="<td>";
				gridDados +="	<a id='next' class='prev' style='cursor: pointer'>Próxima <li class='icon-forward'></li></a>";
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
				arrayField.push(strField)
			else
				return true;
		}
	}