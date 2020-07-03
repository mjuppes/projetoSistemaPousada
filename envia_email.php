<?php session_start(); ?>
<?php include('CONFIG/config.php'); ?>
<?php include(DIR_EMAIL.'class.phpmailer.php'); ?>
<?php include(DIR_ACTIONS.'genericFunction.php'); ?>
<?php


$msg  ="<strong>Contato pelo site</strong><br>";
$msg .="<strong>Contato:</strong> $_POST[name]<br>";
$msg .="<strong>Email:</strong> $_POST[email]<br>";
$msg .="<strong>Mensagem:</strong> $_POST[message]<br>";


$email = 'marcio.juppes@beaversystems.com.br';
smtpmailer($email, 'atendimento@beaversystems.com.br', 'Empresa Beaversystems', 'Contato pelo site',$msg);

echo "<script>
 alert('Mensagem enviada com sucesso!');
window.location = 'http://beaversystems.com.br/';
</script>";
?>