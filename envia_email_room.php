<?php session_start(); ?>
<?php include('CONFIG/config.php'); ?>
<?php include(DIR_EMAIL.'class.phpmailer.php'); ?>
<?php include(DIR_ACTIONS.'genericFunction.php'); ?>
<?php

// $arr = array("nome"=>'asdas');
// echo json_encode($arr);
// return;
// echo "<pre>";
	// print_r($_POST);
// echo "</pre>";
// return;
$msg  ="<strong>Contato pelo site</strong><br>";
$msg .="<strong>Contato:</strong> $_POST[name]<br>";
$msg .="<strong>Email:</strong> $_POST[email]<br>";
$msg .="<strong>Mensagem:</strong> $_POST[message]<br>";


$email = 'marcio.juppes@beaversystems.com.br';
smtpmailer($email, 'atendimento@beaversystems.com.br', 'Empresa Beaversystems', 'Contato pelo site',$msg);


?>