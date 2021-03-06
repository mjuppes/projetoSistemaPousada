var numPage = 0;

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
				objParametros = eval({'controller' : controller,'id' : id,'numPage':numPage});
			else
				objParametros = eval({'controller' : controller,'id' : id,'numRows':numRows,'numPage':numPage});
		}
		else
		{
			if(!numRows)
				objParametros = eval({'controller' : controller,'numPage':numPage});
			else
				objParametros = eval({'controller' : controller,'numRows':numRows,'numPage':numPage});
		}
	}
	else
	{

		if(!numRows){
			//objParametros = objectPar+',numPage:'+numPage;
			objParametros = "'numPage':"+numPage;
		}else{
			//objParametros = objectPar+",numRows:"+numRows+',numPage:'+numPage;
			objParametros = "'numRows':"+numRows+",'numPage':"+numPage;
		}
		objParametros = eval("{"+objParametros+"}");
		alert(objParametros);
	}

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
			'objectLink':''
		};
		if (settings){$.extend(config, settings);}

		var quantTH = ($("#"+config.gridDiv+" thead th:not(.thAcoes)").length);
		$("#"+config.gridDiv+" tbody").html("<tr><td colspan='"+quantTH+"' align='center'><img src='../img/carregar.gif'/></td></tr>");

			var gridDados = "";
			gridDados +="<table border='"+config.border+"' id='"+config.gridDiv+"' width='"+config.width+"' class='"+config.class+"'>";
			gridDados +="<thead>";

			if(config.title)
			{
				gridDados +="<tr>";
				gridDados +="<th  colspan='"+config.colspan+"' align='center'>"+config.title+"</th>";
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

			/*************
				for(var keyLink in config.objectLink)
				{
					//alert(config.objectLink[keyLink].link+' = '+config.objectLink[keyLink].enabled);
					alert(config.objectLink[keyLink].row);
				}
			**************/

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
						if(key3 != config.id)
							gridDados += "<td align=center>"+object3[key3]+"</td>";
						else
							id = object3[key3];
					}
					if(config.crud)
					{
						gridDados += "<td align=center class='colAcoes'>";	
						
						if(config.visualize)
							gridDados += "<a href='"+config.visualize+"?"+config.id+"="+id+"' title='Visualizar' class='btnAcoes btnVisualizar'/>";
						if(config.update)
							gridDados += "<a href='"+config.update+"?"+config.id+"="+id+"&editar=true' class='btnEditar btnAcoes colAcoes' alt='Editar'></a>";
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
				gridDados +="	<div id='previous' style='cursor: pointer'>Anterior</div>";
				gridDados +="</td>";
				gridDados +="<td>";
				gridDados +="	<div id='next' style='cursor: pointer'>Pr�xima</div>";
				gridDados +="</td>";
				gridDados +="</tr>";
				gridDados +="</table>";
			}
			$('#'+config.gridDiv).html(gridDados);
	};