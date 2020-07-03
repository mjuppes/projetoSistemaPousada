<?php
	session_start();
	include "conexao.php";
	include "func.sql.php";
	include "func.geral.php";
	include "constantes.php";

	ini_set("memory_limit", "400M");
	ini_set('max_execution_time', 600);

	#$data  = converterDataDMY($_POST['formMapaPdf_data']);
	//Divide uma string em strings,formada pela divisão dela a partir do delimiter.
	$extensao  = end(explode(".",$_FILES["formMapaPdf_pdf"]["name"]));

	#verifica se a extensao não esta contida no array de extensoes nao permitidas.
	if($extensao == "pdf")
	{
		$nome_arq  = "boletim_".mktime().".$extensao";
		$descricao = tiraAspas($_POST["formMapaPdf_descricao"]);
		$destino  = "../mapas_pdf/";
		$arqSize =  filesize($_FILES["formMapaPdf_pdf"]["tmp_name"]);
		/*
		if((int)$arqSize > 150000)
		{
			$retorno = "e0";
		}
		else
		{*/
		
			#$data  = converterDataDMY($_POST['formMapaPdf_data']);

			//Move um arquivo enviado para um novo local * no caso abaixo o arquivo vai para a pasta "boletim ocorrencia."//
			if(move_uploaded_file($_FILES["formMapaPdf_pdf"]["tmp_name"],$destino."$nome_arq"))
			{
				$into   = array("descricao","data","arquivo","usuario","programa","setor","data_cadastro");
				$values = array("'$descricao'", "'$_POST[formMapaPdf_data]'","'$nome_arq'","$_SESSION[usuario]", "'$_POST[formMapaPdf_programa]'", "'$_POST[formMapaPdf_setor]'","GETDATE()");
				if(inserir("mapaspdf",$into, $values) <> 1)
				{
					@unlink($destino."$nome_arq");
					#Erro ao inserir o arquivo
					$retorno = "e1";
				}
				else
				{
					#cadastro realizado com sucesso
					$retorno = "1"; 
				}
			}
			else
			{
				#erro ao carregar o arquivo
				$retorno = "e2";
			}
		#}
	}
	else
	{
		#extensao não permitidas
		$retorno = "e3";
	}
	echo $retorno;
?>