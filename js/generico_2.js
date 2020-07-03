var gif = "../img/carregar.gif";

/*
UTILZIAR SOMENTE PARA FUNES GENÉRICASe

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
			$(".colAcoes").remove();
		else 
			$(".colAcoes:not(td)").remove();
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
	$("<img src='"+gif+"' class='loadingCombo' id='loading_"+form+"' alt='carregando'/>").insertAfter("#"+form);

	var strDado = "";

	if(id != "")
	{
		if(id2)
			strDado = "controller="+controller+"&id="+id+"&id2="+id2;
		else
			strDado = "controller="+controller+"&id="+id;
	}
	else
	{
		if(id == false || id == '' && id2 != '')
			strDado = "controller="+controller+"&id2="+id2;
		else
			strDado = "controller="+controller;
	}
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
	v = v.replace(/[0-9]{12}/,v = "");   //limita pra máximo 999.999.999,99
	v = v.replace(/(\d{2})(\d{0,2})$/,"$1,$2");	//coloca virgula antes dos últimos 2 digitos

	if(z.value.length > 4)
	{
		v = v.replace(/(\d{1})(\d{5})$/,"$1.$2");  //coloca ponto antes dos últimos 5 digitos
		v = v.replace(/(\d{1})(\d{8})$/,"$1.$2"); //coloca ponto antes dos últimos 8 digitos
	}

	z.value = v;
}

function montaMenu(menuId)
{
	$.ajax({
		type: "POST",
		url: "http://gestorei.solutio.inf.br/GEIMarcio/GestorEI/menulink.php",
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

function valorChecked(obj) //obj formato para par뮥tro $("input[id='opcao[]']")
{
	for(i=0;i<obj.length;i++)
	{
		if(obj[i].checked == true)
			return obj[i].value;
	}
}

function valorInputs(obj) //obj formato para par뮥tro $("input[id='opcao[]']")
{
	var arrValor = Array();
	for(i=0;i<obj.length;i++)
	{
		if(obj[i].value)
			arrValor.push(obj[i].value);
	}

	return arrValor;
}

function clearChecked(obj) //obj formato para par뮥tro $("input[id='opcao[]']")
{
	for(i=0;i<obj.length;i++)
	{
		obj[i].checked = false;
	}
}

function mascaraMoeda(valor)
{  


v = valor.value;
v=v.replace(/\D/g,"") // permite digitar apenas numero
v=v.replace(/(\d{1})(\d{14})$/,"$1.$2") // coloca ponto antes dos ultimos digitos
v=v.replace(/(\d{1})(\d{11})$/,"$1.$2") // coloca ponto antes dos ultimos 11 digitos
v=v.replace(/(\d{1})(\d{8})$/,"$1.$2") // coloca ponto antes dos ultimos 8 digitos
v=v.replace(/(\d{1})(\d{5})$/,"$1.$2") // coloca ponto antes dos ultimos 5 digitos
v=v.replace(/(\d{1})(\d{1,1})$/,"$1,$2") // coloca virgula antes dos ultimos 2 digitos
valor.value = v;
}


function validaData(dta_inicial,dta_final)
{
	var Compara01 = parseInt(dta_inicial.split("/")[2].toString() + dta_inicial.split("/")[1].toString() + dta_inicial.split("/")[0].toString());
	var Compara02 = parseInt(dta_final.split("/")[2].toString() + dta_final.split("/")[1].toString() + dta_final.split("/")[0].toString());

	if (Compara01 < Compara02 || Compara01 == Compara02)
		return true;

	if (Compara01 > Compara02)
	{
		//alert('Data final deve ser maior que inicial!');
		return false
	}
}

function mascara_data(obj,input)
{ 
  var mydata = '';
  mydata = mydata + obj.value;

  switch(mydata.length)
  {
	  case 2:
		mydata += '/';
		document.getElementById(input).value = mydata;
	  break;
	  case 5:
		mydata = mydata + '/';
		document.getElementById(input).value = mydata;
	  break;
	  case 10:
		verifica_data(input); 
	  break;
  }
} 


function verifica_hora(input)
{ 
  var hrs = (document.getElementById(input).value.substring(0,2)); 
  var min = (document.getElementById(input).value.substring(3,5)); 

  var situacao = ""; 
  //verifica data e hora 
  if((hrs < 00 ) || (hrs > 23) || ( min < 00) ||( min > 59))
	  situacao = "falsa"; 
   
  if(document.forms[0].hora.value == "")
	  situacao = "falsa"; 

  if (situacao == "falsa")
  {
	  document.getElementById(input).value = "";
	  document.getElementById(input).focus(); 
  } 
}

function verifica_data(input) 
{ 
	var dia = (document.getElementById(input).value.substring(0,2)); 
	var mes = (document.getElementById(input).value.substring(3,5)); 
	var ano = (document.getElementById(input).value.substring(6,10)); 

	var situacao = "";
	// verifica o dia valido para cada mes 
	if((dia < 01)||(dia < 01 || dia > 30) && (mes == 04 || mes == 06 || mes == 09 || mes == 11 ) || dia > 31)
		situacao = "falsa"; 

	//verifica se o mes e valido 
	if(mes < 01 || mes > 12 )
		situacao = "falsa"; 

	// verifica se e ano bissexto 
	if (mes == 2 && ( dia < 01 || dia > 29 || ( dia > 28 && (parseInt(ano / 4) != ano / 4))))
		situacao = "falsa";

	if (document.getElementById(input).value == "")
		situacao = "falsa";

	if (situacao == "falsa")
	{
		document.getElementById(input).value = "";
		document.getElementById(input).focus(); 
	}
}

function mascara_cnpj(obj,input)
{
  var mydata = '';
  mydata = mydata + obj.value;

  switch(mydata.length)
  {
	  case 2:
		mydata = mydata+".";
		document.getElementById(input).value = mydata;
	  break;
	  case 6:
		mydata = mydata+".";
		document.getElementById(input).value = mydata;
	  break;
	  case 10:
		mydata = mydata+"/";
		document.getElementById(input).value = mydata;
	  break;
	   case 15:
		mydata = mydata+"-";
		document.getElementById(input).value = mydata;
	  break;
  }
} 

function mascara_telefone(obj,input,event)
{
  var mydata = '';
  mydata = mydata + obj.value;

  var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

  switch(mydata.length)
  {
	  case 1:
		mydata = "("+mydata;
		document.getElementById(input).value = mydata;
	  break;
	  case 3:
		mydata = mydata+")";
		document.getElementById(input).value = mydata;
	  break;
	   case 9:
		mydata = mydata+"-";
		document.getElementById(input).value = mydata;
	  break;
  }
}


function somente_letras(event)
{
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	var caract = new RegExp(/^[a-z]+$/i);
	var caract = caract.test(String.fromCharCode(keyCode));

	alert(keyCode);
	//if(keyCode == 97)
		// return false;
	/*
alert(keyCode);
	if ((keyCode > 47 && keyCode < 58)) // numeros de 0 a 9  
	{
		event.keyCode = 0;
        return true;
	}
    else {  
        if (keyCode != 8) // backspace  
            //event.keyCode = 0;  
            return false;  
        else  
            return true;  
    }
	*/

	
	if(keyCode ==8 || keyCode==0 || keyCode==32 || keyCode==9)
	{ 
		alert('Ok');
		return true;
	}

	if(!caract)
	{
		keyCode=0;
		return false;
	}
	else
	{
		return true;
	}
	
}

function mascara_hora(obj,input)
{ 
  var mydata = '';
  mydata = mydata + obj.value;

  
  
  if(obj.length> 7)
  {
	  alert(obj.length);
	  return false;
  }

  switch(mydata.length)
  {
	  case 2:
		mydata += ':';
		document.getElementById(input).value = mydata;
	  break;
	  /*case 5:
		mydata += ':';
		document.getElementById(input).value = mydata;
	  break;*/
  }
}

function verifica_hora(input)
{
  var hrs = (document.getElementById(input).value.substring(0,2)); 
  var min = (document.getElementById(input).value.substring(3,5)); 

  var situacao = ""; 
  //verifica data e hora
  if((hrs < 00 ) || (hrs > 23) || ( min < 00) ||( min > 59))
	  situacao = "falsa"; 
   
  if (document.getElementById(input).value == "")
	  situacao = "falsa"; 

  if (situacao == "falsa")
  {
	  document.getElementById(input).value = "";
	  document.getElementById(input).focus(); 
  } 
}

var Validate = function(method,value,id,event)
{
	var keyCode =  event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;


	this.method = method;
	this.value = value;
	this.id = id;
	var substr = "";

	switch(this.method)
	{
		 case 'name':
			this.Caract = function()
			{
				var	expressao = /[a-zA-Z]/;
				var letra = new RegExp(/^[a-z]+$/i);

				if(letra.test(String.fromCharCode(keyCode)))
					return true;
				else
					return false
			}
		  break;
		  case 'email':
			this.isEmail = function()
			{
				var email  = this.value;
				var atpos  = email.indexOf("@");
				var dotpos = email.lastIndexOf(".");

				if((atpos<1) || (dotpos<atpos+2) || ((dotpos+2) >= email.length))
				{
					alert('Campo de e-mail inválido teste');
					document.getElementById(this.id).value = "";
					document.getElementById(this.id).focus();	
				}
				else
					return true;
			}
		  break;	
		  case 'hora':
			this.formatHour = function()
			{
				var hour = this.value;
				var objHour = document.getElementById(this.id).value;

				if(objHour.length == 2)
					document.getElementById(this.id).value = hour+":";

				if(objHour.length == 5)
				{
					substr = objHour.substring(0,objHour.length);
					document.getElementById(this.id).value = substr+":";
				}
			}

			this.validaHora = function()
			{
				var objHour = document.getElementById(this.id).value;

				var h = objHour.substring(0,2);
				var m = objHour.substring(3,5);
				var s = objHour.substring(6,8);

				if(h > 24 || h < 0)
					document.getElementById(this.id).value = "";

				if(m > 59 || m < 0)
				   document.getElementById(this.id).value = "";

				if(s > 59 || s < 0)
					document.getElementById(this.id).value = "";
			}
		  break;
		  case 'number':
			this.Number = function()
			{
				var tecla = (window.event) ? event.keyCode:event.which;

				if((tecla>47 && tecla<58))
					return true;
				else
				{
					if (tecla ==8 || tecla==0)
						return true;
					else
						return false;
				}
			}
		  break;
		  case 'decimal':
			this.Decimal = function()
			{
				var data = this.value;
				var tecla = (window.event) ? event.keyCode:event.which;

				if((tecla>47 && tecla<58))
				{
					mascaraMoeda(data);
					return true;
				}
				else
				{
					if(tecla==0 || tecla ==8)
						return true;
					else
						return false;
				}
			}
		  break;
		  case 'date':
			this.formatDate = function()
			{
				var data = this.value;

				if(data.length == 2)
					document.getElementById(this.id).value = data+"/";

				if(data.length == 5)
					document.getElementById(this.id).value = data+"/";
			}

			this.verificaData = function()
			{
				var dataValue = (document.getElementById(this.id).value);

				var dia = (dataValue.substring(0,2)); 
				var mes = (dataValue.substring(3,5)); 
				var ano = (dataValue.substring(6,10)); 

				//verifica o dia valido para cada mes
				if ((dia < 01)||(dia < 01 || dia > 30) && (mes == 04 || mes == 06 || mes == 09 || mes == 11 ) || dia > 31)
				{
					document.getElementById(this.id).value = "";
					return false;
				}

				//verifica se o mes e valido
				if (mes < 01 || mes > 12 )
				{
					document.getElementById(this.id).value = "";
					return false;
				}

				//verifica se e ano bissexto 
				if (mes == 2 && ( dia < 01 || dia > 29 || ( dia > 28 && (parseInt(ano / 4) != ano / 4))))
				{
					document.getElementById(this.id).value = "";
					return false;
				}

				//verifica se e ano
				if(ano < 2000)
				{
					document.getElementById(this.id).value = "";
					return false;
				}
			}
		  break;
		  case 'dia':
			this.Day = function()
			{
				var tecla = (window.event) ? event.keyCode:event.which;
				var value = $('#'+this.id).val();
				var min = 0;
				var max = 0;

				if(value.length==0)
				{
					var min = 48;
					var max = 58;
				}
				else if(value.length==1)
				{
					var inteiro = parseInt(value);
					
					if(inteiro>3)
					{
						var min = 10;
						var max = 10;
					}
					else
					{
						if(value!='3')
						{
							var min = 47;
							var max = 58;
						}
						else
						{
							var min = 47;
							var max = 50;
						}
					}
				}

				if((tecla>min && tecla<max))
					return true;
				else
				{
					if (tecla ==8 || tecla==0)
						return true;
					else
						return false;
				}
			}
		  break;
		  case 'telefone':
			this.formatTelefone = function()
			{
				var telefone = this.value;
				var objTelefone = document.getElementById(this.id).value;

				switch(telefone.length)
				{
					case 1:
						document.getElementById(this.id).value = "("+telefone;
					break;
					case 0:
						document.getElementById(this.id).value = "("+telefone;
					break;
					case 3:
						substr = objTelefone.substring(0,objTelefone.length);
						document.getElementById(this.id).value = substr+") ";
					break;
					case 9:
						substr = objTelefone.substring(0,objTelefone.length);
						document.getElementById(this.id).value = substr+"-";
					break;
				}
			}
		  break;
		  case 'cpf':
			this.formatCpf = function()
			{
				var cpf = this.value;
				var objCpf = document.getElementById(this.id).value;

				switch(objCpf.length)
				{
					case 3:
						document.getElementById(this.id).value = cpf+".";
					break;
					case 7:
						substr = objCpf.substring(0,objCpf.length);
						document.getElementById(this.id).value = substr+".";
					break;
					case 11:
						substr = objCpf.substring(0,objCpf.length);
						document.getElementById(this.id).value = substr+"-";
					break;
				}
			}
		  break;
		  case 'cnpj':
			this.formatCnpj = function()
			{
				var cnpj = this.value;
				var objCnpj = document.getElementById(this.id).value;

				switch(objCnpj.length)
				{
					case 2:
						document.getElementById(this.id).value = cnpj+".";
					break;
					case 6:
						substr = objCnpj.substring(0,objCnpj.length);
						document.getElementById(this.id).value = substr+".";
					break;
					case 10:
						substr = objCnpj.substring(0,objCnpj.length);
						document.getElementById(this.id).value = substr+"/";
					break;
					case 15:
						substr = objCnpj.substring(0,objCnpj.length);
						document.getElementById(this.id).value = substr+"-";
					break;
				}
			}
		break;
		case 'cep':
			this.formatCep = function()
			{
				var cep = this.value;
				var objCep = document.getElementById(this.id).value;

				if(objCep.length == 5)
					document.getElementById(this.id).value = cep+"-";
			}
		break;
	}
};

var validaFormulario = function (form,objValidacao,callFunction,param,length_elements)
{
	/*******************************************************
		@ Valida formulário 30/09/2015
		parâmetros do objeto:
		{
			"Campo" :
					[
						{
							"valida": true,
							"tipo": "Nome",
							"mensagem": "Informe nome",
							"function": "nome da função"
						}
					]
		}
	******************************************************/

	var form_nome = form;
	var form = document.getElementById(form);
	var j=0;

	if(length_elements)
	{
		var arrMultiSetField = Array();
		var button_submit = "";
		var tipo_obj = "";

		for(var key in objValidacao)
		{
			if(objValidacao[key][j].fieldSetMulti == true)
			{
				for(var z=0; z<length_elements; z++)
				{
					var multi_field = key+""+z;
					arrMultiSetField.push(multi_field);
				}
			}
		}

		for(var i = 0; i < form.elements.length; i++)
		{
			var campo = form.elements[i].id;
			var type  = form.elements[i].type;

			if(campo && arrMultiSetField.indexOf(campo) != '-1')
			{
				var key2 = campo.substring(0,(campo.length-1));
				tipo_obj = objValidacao[key2][j].tipo;
				maskMultiFields(tipo_obj,campo,key2,objValidacao);
			}

			if(type == 'button')
			{
				document.getElementById(campo).onclick = function(e)
				{
					document.getElementById(campo).disabled = true;
					button = campo;
					submit_MultiFields(arrMultiSetField,objValidacao,callFunction,param,button);
				}
			}
		}
	}
	else
	{
		for(var i = 0; i < form.elements.length; i++)
		{
			var campo = form.elements[i].id;
			var input_value = "";

			for(var key in objValidacao)
			{
				if(key == campo || key == name)
				{
					maskMultiFields(objValidacao[key][j].tipo,campo,key,objValidacao);

					if(objValidacao[key][j].tipo == 'button')
					{
						document.getElementById(campo).onclick = function(e)
						{
							button = campo;
							checkedFields(form,form_nome,objValidacao,callFunction,param,button);
						}
					}
				}
			}
		}
	}
}

function maskMultiFields(tipo,campo,key,objValidacao)
{
		var j=0;
		switch(objValidacao[key][j].tipo)
		{
			case 'name':
				document.getElementById(campo).onkeypress = function(event)
				{
					var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

					if(keyCode == 46 || keyCode == 36)
						return true;

					if(keyCode != 8)
					{
						if(objValidacao[key][j].length)
						{
							var tamanho_str = document.getElementById(key).value.length;
							var tamanho_max = objValidacao[key][j].length;

							if(tamanho_str >= tamanho_max)
								return false;
						}
					}

					switch(keyCode)
					{
						case 180:
						case 8:
						case 226:
						case 94:
						case 32:
							return true;
						break;
					}

					var v = new Validate(objValidacao[key][j].tipo,false,false,event);

					if(!v.Caract())
						return false;
					else
						return true;
				}
			break;
			case 'number':
				document.getElementById(campo).onkeypress = function(event)
				{
					var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

					if(keyCode == 46 || keyCode == 36)
						return true;

					if(keyCode != 8)
					{
						if(objValidacao[key][j].length)
						{
							var tamanho_str = document.getElementById(campo).value.length;
							var tamanho_max = objValidacao[key][j].length;

							if(tamanho_str >= tamanho_max)
								return false;
						}
					}

					var v = new Validate(objValidacao[key][j].tipo,false,false,event);
					if(!v.Number())
						return false;
					else
						return true;
				}
			break;
			case 'decimal':
				document.getElementById(campo).onkeypress = function(event)
				{
					input_value = document.getElementById(campo);

					var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

					if(keyCode == 46 || keyCode == 36)
						return true;

					var v = new Validate(objValidacao[key][j].tipo,input_value,false,event);

					if(keyCode == 46)
						return true;
					
					if(!v.Decimal())
						return false;
					else
						return true;

					if(input_value.indexOf(",") != -1)
					{
						if(keyCode == 44)
							return false;
					}

					if(keyCode == 44)
						return true;
				}
			break;
			case 'email':
				document.getElementById(campo).onblur = function(event)
				{
					input_value = document.getElementById(campo).value;
					var v = new Validate(objValidacao[key][j].tipo,input_value,campo,event);
					v.isEmail();
					return;
				}
			break;
			case 'cep':
				document.getElementById(campo).onkeypress = function(event)
				{
					var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

					if(keyCode == 46 || keyCode == 36)
						return true;

					if(keyCode > 47 && keyCode < 58)
					{
						input_value = document.getElementById(campo).value;
						var v = new Validate(objValidacao[key][j].tipo,input_value,campo,event);

						if(input_value.length == 9)
							return false;
						else
							v.formatCep();
					}
					else
					{
						 if(keyCode == 8 || keyCode == 0 || keyCode == 9)
							return true;
						 else
							return false;
					}
				}

				document.getElementById(campo).onblur = function(event)
				{
					input_value = document.getElementById(campo).value;
					window[objValidacao[key][j].function](input_value)
				}
			break;
			case 'telefone':
				document.getElementById(campo).onkeypress = function(event)
				{
					var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

					if(keyCode == 46 || keyCode == 36)
						return true;

					if(keyCode > 47 && keyCode < 58)
					{
						input_value = document.getElementById(campo).value;
						var v = new Validate(objValidacao[key][j].tipo,input_value,campo,event);
						if(input_value.length == 15)
							return false;
						else
							v.formatTelefone();
					}
					else
					{
						 if(keyCode == 8 || keyCode == 0 || keyCode == 9)
							 return true;
						 else
							return false;
					}
				}

				document.getElementById(campo).onkeyup = function(event)
				{
					var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

					if(keyCode > 47 && keyCode < 58)
					{
						input_value = document.getElementById(campo).value;
						var v = new Validate(objValidacao[key][j].tipo,input_value,campo,event);

						if(keyCode == 8)
							return true;

						if(input_value.length == 15)
							return false;
						else
						{
							if(input_value.length == 1)
								v.formatTelefone();
						}
					}
					else
					{
						 if(keyCode == 8 || keyCode == 0 || keyCode == 9)
							return true;
						 else
							return false;
					}
				}

				document.getElementById(campo).onblur = function(event)
				{
					return true;
				}
			break;
			case 'date':
				document.getElementById(campo).onkeypress = function(event)
				{
					var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

					if(keyCode == 46 || keyCode == 36)
						return true;

					if(keyCode > 47 && keyCode < 58)
					{
						input_value = document.getElementById(campo).value;
						var v = new Validate(objValidacao[key][j].tipo,input_value,campo,event);

						if(keyCode == 8)
							return true;

						if(input_value.length == 10)
							return false;
						else
							v.formatDate();
					}
					else
					{
						 if(keyCode == 8 || keyCode == 0 || keyCode == 9)
							return true;
						 else
							return false;
					}
				}
				document.getElementById(campo).onblur = function(event)
				{
					input_value = document.getElementById(campo).value;
					var v = new Validate(objValidacao[key][j].tipo,input_value,campo,event);
					if(!v.verificaData())
					{
						document.getElementById(campo).focus();
						return false;
					}
				}
			break;
			case 'dia':
				document.getElementById(campo).onkeypress = function(event)
				{
					var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

					if(keyCode == 46 || keyCode == 36)
						return true;

					var v = new Validate(objValidacao[key][j].tipo,false,campo,event);

					if(keyCode == 8)
						return true;

					if(!v.Day())
						return false;
					else
						return true;
				}
			break;
			case 'cpf':
				document.getElementById(campo).onkeypress = function(event)
				{
					var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

					if(keyCode == 46 || keyCode == 36)
						return true;

					if(keyCode > 47 && keyCode < 58)
					{
						input_value = document.getElementById(campo).value;
						var v = new Validate(objValidacao[key][j].tipo,input_value,campo,event);

						if(keyCode == 8)
							return true;

						if(input_value.length == 14)
							return false;
						else
							v.formatCpf();
					}
					else
					{
						 if(keyCode == 8 || keyCode == 0 || keyCode == 9)
							return true;
						 else
							return false;
					}
				}
			break;
			case 'cnpj':
				document.getElementById(campo).onkeypress = function(event)
				{
					var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

					if(keyCode == 46 || keyCode == 36)
						return true;


					if(keyCode > 47 && keyCode < 58)
					{
						input_value = document.getElementById(campo).value;
						var v = new Validate(objValidacao[key][j].tipo,input_value,campo,event);

						if(keyCode == 8)
							return true;

						if(input_value.length == 18)
							return false;
						else
							v.formatCnpj();
					}
					else
					{
						 if(keyCode == 8 || keyCode == 0 || keyCode == 9)
							 return true;
						 else
							return false;
					}
				}

				document.getElementById(campo).onblur = function(e)
				{
					return true;
				}
			break;
			case 'hora':
				document.getElementById(campo).onkeypress = function(event)
				{
					if(keyCode == 46 || keyCode == 36)
						return true;

					var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

					if(keyCode > 47 && keyCode < 58)
					{
						if(keyCode == 8)
							return true;

						input_value = document.getElementById(campo).value;
						var v = new Validate(objValidacao[key][j].tipo,input_value,campo,event);

						if(input_value.length == 8)
							return false;
						else
							v.formatHour();
					}
					else
					{
						 if(keyCode == 8 || keyCode == 0 || keyCode == 9)
							return true;
						 else
							return false;
					}
				}
	
				document.getElementById(campo).onblur = function(e)
				{
					input_value = document.getElementById(campo).value;

					if(keyCode == 8)
						return true;

					var v = new Validate(objValidacao[key][j].tipo,input_value,campo,event);
					v.validaHora();
					return true;
				}
			break;
		}
}

function submit_MultiFields(arrMultiSetField,objValidacao,callFunction,param,button)
{
	var j = 0;	
	var campo = "";
	var key = "";

	for(var i=0; i< arrMultiSetField.length; i++)
	{
		campo = arrMultiSetField[i];
		key = campo.substring(0,(campo.length-1));

		if(objValidacao[key][j].valida == true)
		{
			if(!document.getElementById(campo).value)
			{
				if(objValidacao[key][j].mensagem != "")
					messageModal('warning',objValidacao[key][j].mensagem);
				else
					messageModal('warning',"Campo "+campo+" precisa de um valor!");

				document.getElementById(button).disabled = false;
				return false;
			}
		}
	}

	if(param)
		window[callFunction](param);
	else
		window[callFunction]();
}

function checkedFields(form,form_nome,objValidacao,callFunction,param,button)
{
		for(var i = 0; i < form.elements.length; i++)
		{
			var campo = form.elements[i].id;
			var name  = form.elements[i].name;
			var type  = form.elements[i].type;

			var radio = false;
			var j = 0;

			for(var key in objValidacao)
			{
				if(key == campo || key == name)
				{

					/*
						@Parte validação de radios! 
						10/12/2015 16:49
					*/

					if(type == "radio" && radio == false)
					{
						var qtd_radio = objValidacao[key][j].numero;
						var obj_radio = "";
						var cont = 0;

						for(var qtd = 0; qtd < qtd_radio; qtd++)
						{
							obj_radio = 'document.'+form_nome+'.'+name+'['+qtd+']'+'.checked';
							obj_radio = eval(obj_radio);

							if(obj_radio == false)
								cont++;

							if(cont == qtd_radio)
							{
								messageModal('warning',objValidacao[key][j].mensagem);
								document.getElementById(button).disabled = false;
								return false;
							}
						}

						radio = true;
					}

					if(objValidacao[key][j].valida == true)
					{
						if(!form.elements[i].value)
						{
							if(objValidacao[key][j].mensagem != "")
								messageModal('warning',objValidacao[key][j].mensagem);
							else
								messageModal('warning',"Campo "+key+" precisa de um valor!");

							form.elements[i].focus();
							document.getElementById(button).disabled = false;
							return false;
						}
					}
				}
			}
		}

		if(param)
			window[callFunction](param);
		else
			window[callFunction]();
}

var autoComplete = function (objInputs,pagina,function_obj)
{
	for(var key in objInputs)
	{
		var i = 0;
		var cont = 0;

		document.getElementById(key).onkeyup = function(event)
		{
			var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

			if(keyCode == 37 || keyCode == 39 || keyCode == 38 || keyCode == 40)
				return false;

			if(!$("#"+key+"").val())
			{
				var inputObj = objInputs[key][i].inputObj;
				$("#loading_"+inputObj).remove();
				$("#ul_"+inputObj).remove();
				return false;
			}

			var value = $("#"+key+"").val();

			ajaxComplete(pagina,objInputs[key][i].controller,value,objInputs[key][i].inputObj,objInputs[key][i].id,objInputs[key][i].recordSet,key,objInputs[key][i].parametro,objInputs[key][i].type,function_obj,objInputs[key][i].max_height,objInputs[key][i].mensagem);
		}
	}
};

function ajaxComplete(pagina,controller,value,inputObj,id,recordSet,campo,parametro,type,function_obj,max_height,mensagem)
{
	if(!max_height)
		max_height = '200px';

	$("#ul_"+inputObj).html('');
	$("#ul_"+inputObj).remove();
	$("#ul_"+inputObj).html('');
	$("#ul_"+inputObj).remove();


	$("<img src='"+gif+"' class='loadingCombo' id='loading_"+inputObj+"' alt='carregando'/>").insertAfter("#"+inputObj);

	var li = "";
	var arrId = Array();
	var arrRecordSet = Array();
	var arrParametro = Array();

	$.ajax({
		type: "POST",
		dataType: 'json',
		url: pagina,
		data:
		{
			controller : controller,
			value: value
		},
		success: function(obj)
		{
			if(obj.numero != 0)
			{
				for(var key in obj)
				{
					for(var key2 in obj[key])
					{
						if(id == key)
							arrId.push(obj[key][key2]);

						if(recordSet == key)
							arrRecordSet.push(obj[key][key2]);

						if(parametro == key)
							arrParametro.push(obj[key][key2]);
					}
				}

				for(var i=0; i< arrId.length; i++)
				{
					var mod = (i%2);

					if((mod) == 0)
						li += "<li id='ul_"+i+"' style='cursor:pointer;background-color:#d1d1d1;' onclick=\"valorCampo('"+campo+"','"+inputObj+"','"+arrRecordSet[i]+"','"+arrId[i]+"','"+type+"','"+function_obj+"');\"><span id='span_"+i+"' >"+arrRecordSet[i]+" - "+arrParametro[i]+"</span></li>";
					else
						li += "<li id='ul_"+i+"' style='cursor:pointer;' onclick=\"valorCampo('"+campo+"','"+inputObj+"','"+arrRecordSet[i]+"','"+arrId[i]+"','"+type+"','"+function_obj+"');\"><span id='span_"+i+"'>"+arrRecordSet[i]+" - "+arrParametro[i]+"</span></li>";
				}
			}
			else
			{
				
				if(!mensagem)
					li += "<li id='ul_' onclick='"+function_obj+"()'  style='cursor:pointer;background-color:#d1d1d1;text-align:center;'><span >Nenhum registro encontrado!</span></li>";
				else
					li += "<li id='ul_' onclick='"+function_obj+"()'  style='cursor:pointer;background-color:#d1d1d1;text-align:center;'><span >"+mensagem+"</span></li>";
			}

			$("<ul  id='ul_"+inputObj+"' style='max-height:"+max_height+"; overflow-y: auto;'>"+li+"</ul>").insertAfter("#"+campo);
			$("#loading_"+inputObj).remove();
		}
	});
}

function valorCampo(campo,inputObj,valor,id,type,function_obj)
{
	$('.control-label').addClass('active');
	$("#"+campo).val(valor);
	$("#ul_"+inputObj).html('');
	$("#ul_"+inputObj).remove();
	$("#ul_"+inputObj).html('');
	$("#ul_"+inputObj).remove();

	switch(type)
	{
		case 'select':
			var strOption = "<option selected value='"+id+"'>"+valor+"</option>";
			$("#"+inputObj+"").html(strOption);
		break;
		case 'hide':
			$("#"+inputObj+"").val(id);

			if(function_obj)
				window[function_obj](id);
		break;
	}
}

function messageModal(type,text,callback,param)
{
	var title = '';
	var icon = '';
	var msg = '';

	switch(type)
	{
		case 'warning':
			icon  = '<i class="large material-icons" style="color:yellow;" >warning</i>';
			title = 'Atenção';
		break;
		case 'error':
			icon ='<i class="large material-icons" style="color:red;" >error</i>';
			title ='Erro';
		break;
		case 'info':
			icon ='<i class="large material-icons" style="color:blue;">info</i>';
			title ='Informação';
		break;
		case 'sucess':
			icon ='<i class="large material-icons" style="color:green;">check_circle</i>';
			title ='Sucesso';
		break;
	}

	msg  = '<div>';
	msg += '<div><h5>'+title+'</h5></div>';
	msg += '<hr>';
	msg += '<div><table><tr><td style="width:150px;text-align:center">'+icon+'</td><td>'+text+'</td></tr></table></div>';
	msg += '<button type="button" style="background-color:#d32f2f" class="btn btn-primary" onclick="fadeMsg();';
	if(callback!=undefined)
	{
		msg += callback;
		if(param==undefined)
		{
			msg += '();'
		}
		else
		{
			msg +='(\''+param+'\');'
		}
		
	}

	msg +='">OK</button>'+'</div>';

	$.blockUI({ 
           message: msg,
		   css:
		   {
			    border: 'none', 
				padding: '15px', 
				cursor: 'poiter',
				backgroundColor: 'white',
				'-webkit-border-radius': '10px',
				'-moz-border-radius': '10px',
				opacity: 0.9,
                top:  ($(window).height() - 500) /2 + 'px', 
                left: ($(window).width() - 500) /2 + 'px', 
                width: '500px' 
            }
        });
		
}

function questionModal(title,text,options,wdt)
{
	if(wdt==undefined)
		wdt=500;

	var icon = '';
	var msg  = '';

	icon  = '<i class="large material-icons" style="color:blue;" >help</i>';
	
	msg  = '<div>';
	msg += '<div><h5>'+title+'</h5></div>';
	msg += '<hr>';
	msg += '<div><table><tr><td style="width:150px;text-align:center">'+icon+'</td><td><strong>'+text+'</strong></td></tr></table></div>';
	msg += '<div>'

	var j =0;

	//options
	for(var key in options)
	{
		var btTitle  = options[key][j].title;
		var btFunc   = options[key][j].function;
		var btParam  = options[key][j].param;
		var btReturn = options[key][j].return;

		msg += '<span style="padding:3px;">';
		msg += '<button type="button" style="background-color:#d32f2f" class="btn btn-primary" onclick="fadeMsg();';

		if(btFunc!=undefined && btFunc!='')
		{
			if(btParam != undefined && btParam != '')
			{
				if(typeof btParam === 'object')
				{
					var obj = JSON.stringify(btParam);  
					var obj2 = btFunc+'('+obj+')';
					obj2 = obj2.split('"').join("'");
					msg += obj2;
				}
				else
					msg += btFunc+'(\''+btParam+'\')';
			}
			else
				msg += btFunc+'()';
		}
		else 
			if(btReturn != undefined && btReturn != '')
				msg += 'return '+btReturn+';';

		msg += '">'+btTitle+'</button></span>';
	}

	$.blockUI({ 
           message: msg,
		   css:
		   {
			    border: 'none', 
            padding: '15px', 
			cursor: 'poiter',
            backgroundColor: 'white', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: 0.9,
                top:  ($(window).height() - 500) /2 + 'px', 
                left: ($(window).width() - wdt) /2 + 'px', 
                width: wdt+'px'
            }
        });
}

function fadeMsg()
{
	$.unblockUI();
	$('#modal_contrato').closeModal();
}
