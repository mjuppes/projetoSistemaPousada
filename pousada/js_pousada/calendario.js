	
function calendario2()
{
	
	var objPar = new Object();

	objPar.controller		 	= 'showCalendarioSemanal';
	
	$.ajax({
			type: "POST",
			url: 'viewCalendario.php',
			//dataType:'json',
			data : objPar,
			success: function(data)
			{
				//$("#calendario").html(data.html);
				$("#calendario").html(data);
				efectCalendario();
				return;

				if(data.resposta == 1)
				{
					
					alert(data.msg);
					$('#formInserirCartao').resetForm();
				}
				else
					alert(data.resposta);
			}
	});
}

function mostraModal()
{
	$('#myModal').modal('show'); 
}


function efectCalendario()
{
    $('table#tableCalendario tbody tr').hover(
		function(){ $(this).addClass('destaque');}, 
        function(){ $(this).removeClass('destaque');} 
     );
}
