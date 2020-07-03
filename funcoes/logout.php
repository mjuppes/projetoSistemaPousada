<?php
	
	session_start();
	session_destroy();
	header("Location: ../login.php");
	
	#armazenar informações do logout
	
?>