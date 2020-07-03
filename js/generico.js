/*
UTILZIAR SOMENTE PARA FUNÇÕES GENÉRICAS
CRIADO EM 27/01/2012
*/

function tirarAcoes(removeCol){
	/*
		{removeCol} : true  = retira a coluna toda
		{removeCol} : false = retira somente os icones
	*/
	if (grupoAcesso > 2){
	
		if (removeCol == true){
			
			$(".colAcoes").remove();
			
		} else {
			
			$(".colAcoes:not(td)").remove();
			
		}
	
	}
	
}

function inicializeModal(myModal,myBtn,myClassClose)
{
	// Get the modal
	var modal = document.getElementById(myModal);

	// Get the button that opens the modal
	var btn = document.getElementById(myBtn);

	alert(myModal+' - '+myBtn);
	// When the user clicks the button, open the modal 
	btn.onclick = function() {
		modal.style.display = "block";
	}

	if(myClassClose != false)
	{	// Get the <span> element that closes the modal
		var span = document.getElementsByClassName(myClassClose)[0];

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() 
		{
			modal.style.display = "none";
		}
	}

	
}


function erroValidate(formElement,msg,erros)
{
	if(!$("#"+formElement).val())
	{
		$("#"+formElement).addClass("error");


		if(!erros || erros == "" || erros == 'undefined')
			$("#erros").html('<li><label class="error" for="'+formElement+'" generated="true" style="display: block;">'+msg+'!</label></li>');
		else
			$("#"+erros).html('<li><label class="error" for="'+formElement+'" generated="true" style="display: block;">'+msg+'!</label></li>')
		return false;
	}
	else
	{
		$("#"+formElement).removeClass("error");
		if(!erros || erros == "")
			$("#erros").html('');
		else
			$("#"+erros).html('');
		return true;
	}
}

function removeOption(id)
{
	var arrIdOption = Array();

	$("#"+id+" :selected").each(function()
	{
		arrIdOption.push($(this).val());
		$(this).remove();
	});
	
	return arrIdOption;
}


// Funções de validação 28/03/2018 15:00 @Marcio Juppes

function validaTeste(mensagem,function_sim,funcion_nao)
{

		alertify.confirm('',mensagem,
		function()
		{ 
			// if(function_sim == '')
			// {
				alert('teste1');
				//return true;
			// }
			//alertify.success('Agora sim') 
		},
		function()
		{ 
			// if(function_nao == '')
			// {
				alert('teste2');
				//return false;
			// }
				

			
		}).set('labels', {ok:'Sim', cancel:'Não'}).setHeader('');
 
}


//function CompareDatas(datainicial,dataFinal)
function CompareDatas(dtInicio,dtFim)
{
		// var dtInicio = '22/05/2018';//document.getElementById("data_abertura").value;
		// var dtFim = '21/05/2018';//document.getElementById("data_encerramento").value;

	var dtBegin = dtInicio.split("/");
	var bdia = dtBegin[0];
	var bmes = dtBegin[1];
	var bano = dtBegin[2];
	var startDate = new Date(bmes +"/"+bdia+"/"+bano);

	var dtFinish = dtFim.split("/");
	var fdia = dtFinish[0];
	var fmes = dtFinish[1];
	var fano = dtFinish[2];
	var endDate = new Date(fmes +"/"+fdia+"/"+fano);

	if ( new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate()) > 
			 new Date(endDate.getFullYear(), endDate.getMonth(), endDate.getDate()) ){
	   return false;
	}
	else
		return true;
		
}





