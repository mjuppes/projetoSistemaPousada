<?php
session_start();
//$url = split ("/", $REQUEST_URI);
//if(!isset($_SESSION['idgrupo']) || $_SESSION['URL'] != $url[1])
	//Header("Location: http://www.beaversystem.com.br/beaverPousada/login.php");

if(!isset($_SESSION['idgrupo']))
	//Header("Location: http://www.beaversystem.com.br/beaverPousada/login.php");
	Header("Location: http://177.70.26.45/beaverpousada/login.php");
	
?>