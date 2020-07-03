<?php
	session_start(); 
	
	include_once "../funcoes/constantes.php";
	include_once "../funcoes/func.geral.php";
	
	if (!isset($_GET['form'])){
		$formulario = base64_decode($_GET['referencia']);
	} else {
		$formulario = base64_decode($_GET['form']);
	}
	
	$SQL_form   = query("SELECT titulo FROM menu WHERE id = $formulario AND permissao LIKE '%[$_SESSION[grupo]]%'");
	$info_form  = fetch_array($SQL_form);
	
	if (!$info_form){
		Header("Location: ".DIR_ROOT."/funcoes/logout.php");
	}
	
?>