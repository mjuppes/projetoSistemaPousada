<?php

	session_start();

	include_once "func.geral.php";
	include_once "informacao_usuario.php";
	
	$retorno = array();
	
	$SQL_login = query("SELECT id, grupo, atualizar_info FROM usuarios WHERE usuario = '$_POST[formLogin_user]' AND senha = '$_POST[formLogin_senha]'");
	
	$login     = fetch_array($SQL_login);
	
	if ($login){
		if ($login['atualizar_info'] == 1){
			$_SESSION['atualizar_user'] = $login['id'];
			$retorno["login"]     = 0;
			$retorno["atualizar"] = 1;
		} else {
			$SQL_log = query("INSERT INTO usuarios_acesso (usuario, data, browser, so, ip) VALUES ($login[id], GETDATE(), '$info_browser', '$info_so', '$_SERVER[REMOTE_ADDR]')");
			$_SESSION['usuario'] = $login['id'];
			$_SESSION['grupo']   = $login['grupo'];
			$retorno["login"] = 1;
		}
	} else {
		session_destroy();
		$retorno["login"] = 0;
	}
	
	echo json_encode($retorno);

?>