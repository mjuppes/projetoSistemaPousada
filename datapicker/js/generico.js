/*
UTILZIAR SOMENTE PARA FUNÇÕES GENÉRICAS
CRIADO EM 27/01/2012
*/

function tirarAcoes(removeCol){
	/*
		{removeCol} : true  = retira a coluna toda
		{removeCol} : false = retira somente os icones
	*/
	if (grupoAcesso > 2)
	{
		if (removeCol == true)
		{
			$(".colAcoes").remove();
		}
		else 
		{
			$(".colAcoes:not(td)").remove();
		}
	}
}

function keyNum(obj)
{
	var tecla = (window.event) ? event.keyCode:obj.which;

	if((tecla>47 && tecla<58))
		return true;
	else
	{
		if (tecla ==8 || tecla==0) return true;
		else return false;
	}

}

function toUpperCase(obj)
{
	obj.keyup(function() {
	  $(this).val($(this).val().toUpperCase());
	});
}

function montaCombo(form,controller,id,id2)
{
	$("<img src='http://172.16.0.150/GestorEIFabiano/img/carregar.gif' class='loadingCombo' id='loading_"+form+"' alt='carregando'/>").insertAfter("#"+form);

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

function formataMoeda(z)
{
	var v;

	v = z.value;
	v = v.replace(/\D/g,"");  //permite digitar apenas números
	v = v.replace(/[0-9]{12}/,"inválido");   //limita pra máximo 999.999.999,99
	v = v.replace(/(\d{1})(\d{8})$/,"$1.$2");  //coloca ponto antes dos últimos 8 digitos
	v = v.replace(/(\d{1})(\d{5})$/,"$1.$2");  //coloca ponto antes dos últimos 5 digitos
	v = v.replace(/(\d{1})(\d{1,2})$/,"$1,$2");	//coloca virgula antes dos últimos 2 digitos
	z.value = v;
}

function montaMenu(menuId)
{
	$.ajax({
		type: "POST",
		url: "http://172.16.0.150/GestorEIFabiano/menulink.php",
		data:
		{
			MENU : menuId
		},
		success: function(data)
		{
			$("#menulink").html(data);
		}
	});
}