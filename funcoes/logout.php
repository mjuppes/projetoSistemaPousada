<?php
	
	session_start();
	session_destroy();
	header("Location: ../login.php");
	
	#armazenar informa��es do logout
	
?>