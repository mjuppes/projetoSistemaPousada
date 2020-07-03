<?php include('../CONFIG/config.php');?>
<?php include('../'.DIR_ACTIONS.'genericFunction.php');?>
<?php
	session_start();

	include "conexao.php";
	include "func.sql.php";
	include "func.geral.php";
	include "constantes.php";
	
	ini_set("memory_limit", "400M");
	ini_set('max_execution_time', 600);
	
	#$data      = converterDataDMY($_POST['formBoletimOcorrencia_data']); 
	
	//Divide uma string em strings,formada pela divisão dela a partir do delimiter.// 
	$extensao  = end(explode(".",$_FILES["formBoletimOcorrencia_doc"]["name"]));

	
	if(!verificarExtensao($extensao))
	{
		echo 'e5';
		return;
	}


	#verifica se a extensao não esta contida no array de extensoes nao permitidas.
	if (!in_array($extensao,$array_ext_npermitidas)){
		
		$nome_arq  = "boletim_".mktime().".$extensao";
		$descricao = tiraAspas($_POST["formBoletimOcorrencia_descricao"]);
		
		$destino  = "../boletim_ocorrencia/";
			
		//Move um arquivo enviado para um novo local * no caso abaixo o arquivo vai para a pasta "boletim ocorrencia."//
		if (move_uploaded_file($_FILES["formBoletimOcorrencia_doc"]["tmp_name"],$destino."$nome_arq")){
			
			$dataArquivo = formatDate($_POST['formBoletimOcorrencia_data']);
			
			$into   = array("descricao","data","arquivo","usuario","data_cadastro");
			$values = array("'$descricao'", "'$dataArquivo'","'$nome_arq'","$_SESSION[usuario]","GETDATE()");
			
			if (inserir("boletins",$into, $values) <> 1){
				
				@unlink($destino."$nome_arq");
				#Erro ao inserir o arquivo
				$retorno = "e1";
				
			} else {
				#cadastro realizado com sucesso
				$retorno = "1"; 
			}
			
		} else { 
			#erro ao carregar o arquivo
			$retorno = "e2";
		}
	
	} else {
		#extensao não permitidas
		$retorno = "e3";
		
	}
	
	echo $retorno;
	
?>