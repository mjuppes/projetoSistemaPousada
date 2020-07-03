<?php
// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
require("phpmailer/class.phpmailer.php");

//Inicia a classe PHPMailer
$mail = new PHPMailer();

//Define os dados do servidor e tipo de conexão
$mail->IsSMTP(); // Define que a mensagem será SMTP
$mail->Mailer = "smtp";
$mail->Host = "ssl://smtp.gmail.com";
$mail->Port = 465;
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "mjuppes@gmail.com"; // SMTP username - Seu e-mail
$mail->Password = "mjuppes88"; // SMTP password

//Define o remetente
$mail->From = "mjuppes@gmail.com"; // Seu e-mail
$mail->FromName = "marcio"; // Seu nome
$mail->SMTPDebug  = 1;

//Define os destinatário(s)
$mail->AddAddress('mjuppes@gmail.com.com', 'Fulano da Silva');
$mail->AddAddress('thomas.aes.31@hotmail.com','thomas');
//$mail->AddAddress('cristiano.teixeira@embratec.com.br','felix');
//$mail->AddAddress('alvaro.ecivil@hotmail.com','Alvaro');

//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); //Cópia Oculta

//Define os dados técnicos da Mensagem
$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
//$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

//Define a mensagem (Texto e Assunto)
$mail->Subject  = "Mensagem Teste Beaver"; // Assunto da mensagem
$mail->Body = "Este é o corpo da mensagem de teste, em <b>HTML</b>! <br/> <img src=\"http://blog.thiagobelem.net/wp-includes/images/smilies/icon_smile.gif\" alt=\":)\" class=\"wp-smiley\"> ";
$mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano! \r\n <img src=\"http://blog.thiagobelem.net/wp-includes/images/smilies/icon_smile.gif\" alt=\":)\" class=\"wp-smiley\"> ";

//Define os anexos (opcional)
//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo
$mail->AddAttachment("C:/inetpub/wwwroot/beaverPousada/logo1.png", "logo1.png");  // Insere um anexo

//Envia o e-mail
$enviado = $mail->Send();

//Limpa os destinatários e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();

//Exibe uma mensagem de resultado
if($enviado)
{
	echo "E-mail enviado com sucesso!";
}
else
{
	echo "Não foi possível enviar o e-mail.<br /><br />";
	echo "<b>Informações do erro:</b> <br />" . $mail->ErrorInfo;
}
?>