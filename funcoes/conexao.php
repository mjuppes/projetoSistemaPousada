<?php

$BD_server = "Desen-Anderson\SQLEXPRESSS";
$BD_user   = "sa";
$BD_senha  = "1089";
$BD_name   = "erp";

/*
	$BD_server = "CPRO4120\SQLEXPRESS";
	$BD_user   = "portoMaravilha";
	$BD_senha  = "pr0717tm";
	$BD_name   = "sig_porto_maravilha";
*/
$conexao = @mssql_connect($BD_server, $BD_user, $BD_senha);

if(!$conexao) {

	die("<p>Erro ao realizar a conexão com o Banco de Dados.</p>");
	
} else {
	
	if (!@mssql_select_db($BD_name, $conexao)){
	
		die("<p>Erro ao selecionar o Banco de Dados.</p>");	
		
	}
	
}
	
	

?>