<?
$email = 'mjuppes@email.com'; // email para onde a mensagem deve ir
$resultado = mail($email, 'Testando nossa configuração', 'Olá, nossa configuração funcionou.');
	
if($resultado)
{
	echo 'Seu email foi enviado com sucesso.';
}
else
{
	echo 'Não foi possível enviar seu email.';
}
?>
