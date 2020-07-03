<?php

#retorna informações do usuario
	
$user_agente = $_SERVER["HTTP_USER_AGENT"];

$Browser_Nome = strtok($user_agente, "/");
$Browser_Versao = strtok(" ");

if(ereg("MSIE",$user_agente)) {

$Browser_Nome = "Internet Explorer";
$Browser_Versao = strtok("MSIE");
$Browser_Versao= strtok(" ");
$Browser_Versao = strtok(";");
}

if(ereg("Opera", $user_agente)) {

$Browser_Nome = "Opera";
$Browser_Versao = strtok("Opera");
$Browser_Versao = strtok("/");
$Browser_Versao = strtok(";");
}

$Sistema = "desconhecido";
if(ereg("Windows",$user_agente) || ereg("WinNT",$user_agente) || ereg("Win95",$user_agente)) {
$sistema = "Windows";
}

if(ereg("Mac", $user_agente)) {
$sistema = "Macintosh";
}
if(ereg("X11", $user_agente)) { 
$sistema = "Unix"; 
} 

#evita erros no retorno do tamanho da string
$info_browser =  Trim(substr("$Browser_Nome $Browser_Versao",0,49));
$info_so      =  Trim(substr("$sistema",0,49));

?>