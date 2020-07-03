<?php
	
	session_start();
		
	include "conexao.php";
	include "func.sql.php";
	include "func.geral.php";
	include "constantes.php";
	
	if ($_POST['formAtualizarInfo_senha'] <> md5($_POST['formAtualizarInfo_senhaAtual'])){
		
		$retorno['retorno'] = "e1";
		
	} else {
	
		$telefone =	somenteNumeros($_POST['formAtualizarInfo_telefone']);
		
		$into   = array("nome_completo","email","telefone","senha","atualizar_info");
		
		$values = array(
			"'$_POST[formAtualizarInfo_nomeComp]'",
			"'$_POST[formAtualizarInfo_email]'",
			"$telefone",
			"'$_POST[formAtualizarInfo_senhaNova]'",
			"0"
		);
		
		if (isset($_SESSION['atualizar_user'])){
			$usuarioEdissao = $_SESSION['atualizar_user'];	
		} else {
			$usuarioEdissao = $_SESSION['usuario'];
		}

		$retorno['retorno'] = update("usuarios",$into,$values,"id = $usuarioEdissao");
		
	}	
	
	echo json_encode($retorno);
	
?>