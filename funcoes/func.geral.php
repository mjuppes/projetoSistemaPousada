<?php 

include_once "func.sql.php";

#include "class.upload.php"; #classe usada no upload de fotos

function converterDataDMY($data){
/*
	converte uma data no formado yyyy-mm-dd
	{data} data de entrada, deve ser no formado dd/mm/yyyy
*/	
	$aux = explode("/",$data);		
	return $aux[2]."-".$aux[1]."-".$aux[0];
}

function converterDataMDY($data){
/*
	converte uma data no formado mm-dd-yyyy
	{data} data de entrada, deve ser no formado dd/mm/yyyy
*/	
	$aux = explode("/",$data);		
	return $aux[1]."-".$aux[0]."-".$aux[2];
}
function geraSenha($ln=8){
/*
	gera uma string aleatória
	{ln} quantidade de caracteres
*/
	$chars = array_merge(range('a', 'z'), range(0, 9));
	shuffle($chars);
	return(substr(implode($chars),0,$ln));
}

function usuario(){
/*
	retorna o id do usuário ou 0 caso não tenha usuário
*/

	if (!isset($_SESSION['id_user'])) { return 0; } else { return $_SESSION['id_user']; };
}

function somenteNumeros($string){
/*
	retorna somente os números de uma String
	{string} valor de entrada. Ex. 012.345.678-90 = 01234567890
*/
	$numeros = array("0","1","2","3","4","5","6","7","8","9");
	$retorno = "";
	
	for ($i=0; $i< strlen($string); $i++) {
		
		if (in_array($string{$i},$numeros) == true){
			$retorno .= $string{$i};
		}
		
	}
	
	if ($retorno == ""){
		return "0";
	} else {
		return $retorno;
	}
	
}
function tiraAspas($string){
/*
	substitui as aspas simples da string. No SQL server substituir ' por '' (2 aspas simples) e no mysql por \'
	{string} valor de entrada
*/	
	return str_replace("'", "''", $string);
}

function colocaZero($campo){
/*
	coloca 0 caso o campo seja vazio
	{campo} valor a ser verificado
	
*/	

	if (Trim($campo) == ""){
		return 0;
	} else {
		return $campo;
	}
}

function carregaFoto_($file,$nome_arquivo,$image_x,$dir){
/*
	utilizado para fazer o upload de fotos
	{file}          nome do input file do formulário
	{nome_arquivo}  novo nome do arquivo carregado, deve ter no máximo 25 caracteres contando a extensão
	{image_x}       redimencionar novo tamanho da imagem
	{dir}           diretorio onde a foto ficará armazenada
*/	
	
	$handle = new Upload($_FILES["$file"]);
	
	if ($handle->uploaded){ #carrega a foto
		$handle->image_resize       = true;
		$handle->image_ratio_y      = true;
		$handle->image_x            = $image_x;
		$handle->file_new_name_body = $nome_arquivo;
		$handle->image_convert      = 'jpg';
		$handle->Process($dir);
		
		if ($handle->processed){ #redimencionamento OK
			$arquivo = $handle->file_dst_name;
			$handle->clean();
		} else {
			return 1; #erro 1
		}	
	} else {
		return 2;     #erro 2
	}
	return 0;         #carregamento da foto ok
}

function nomePagina($pagina){
/*
	retorna o nome da página atual
	{pagina} caminho completo $_SERVER[PHP_SELF]
*/

	$pagina = end(explode("/",$pagina));
	return $pagina;
}

function tiraGet($pagina){
/*
	tira os GET do endereço e retorna somente o principal
	{pagina} caminho
*/	
	$pagina = reset(explode("?",$pagina));
	return $pagina;
}

function erro($titulo,$mensagem,$width){
/*
	mostra uma mensagem de erro
	{titulo} titulo da mensagem de erro
	{mensagem} texto que será apresnetado como erro
	{width} largura da caixa de erro
*/	
	echo
	"
	<div class='informar_erro' style='width:$width'>
		<p>$titulo</p>
		<p class='msg'>$mensagem</p>
	</div>
	";
}

function perc($quant,$total){
/*
	calcula o percentual e retorna o arredondamento com 2 casa decimais
*/

	return @round((($quant * 100) / $total),2);
}

function oficio($num,$ano){
/*
	cria uma sring formatada conforme o padrao do ofício apartir de um número e ano informado.
	GA.016/2011/BR-158N
	{num} número de entrada
	{ano} ano de entrada
*/
	return "GA.".str_pad($num,3,0,STR_PAD_LEFT)."/$ano/BR-158N";
}

function formataDouble_($valor){
/*
	formata uma medida ou moeda em formato BR para o formato double, onde substitui . por null e , por . além de retirar o R$ quando presente.
	{$valor} valor de entrada, preferencialmente quando for utilizado a mascara para moeda ou metros
*/	
	if ($valor == NULL){
		return 0;
	} else {
		$procura    = array('.',',','R$ ');
		$substituir = array('','.',''); 
		return str_replace($procura,$substituir,$valor);
	}		
}

	
?>
