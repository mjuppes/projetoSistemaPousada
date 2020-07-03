<?php session_start(); ?>
<?php include('CONFIG/config.php');?>
<?php include(DIR_DAO);?>
<?php

$Bd = new Bd(CONEXAO);
if($fd = @fopen( "c:/temp/hoteis.txt","r"))
{
	while(!feof($fd))
	{
		$novidades = fgets( $fd, 1024 );
		$pieces = explode(",", $novidades);
		
		$nome_hotel = utf8_decode($pieces[0]);
		$endereco		= utf8_decode($pieces[1]);
		$bairro		= utf8_decode($pieces[2]);
		$telefone	= utf8_decode($pieces[3]);
		$estrelas	= ($pieces[4] == 'N/A') ? 'Não tem' : utf8_decode($pieces[4]);

		$fonte		= trim($pieces[5]);

		if($fonte == 'Trivago')
			$fonte = '1';
		if($fonte == 'Booking')
			$fonte = '2';
		if($fonte == 'Google')
			$fonte = '3';
		if($fonte == 'Hoteis.com')
			$fonte = '4';
		
		$id_estado 	= '23';
		$id_cidade 	= '4173';
		$data = date("d/m/Y hh:mm:ss");
		

		$strSQL  = "insert into contatos (nome,id_estado,id_cidade,telefone,endereco,bairro,estrelas,fonte)";
		$strSQL .= " 				values('$nome_hotel','$id_estado','$id_cidade','$telefone','$endereco','$bairro','$estrelas','$fonte')";
		 $resposta = $Bd->execQuery($strSQL,false);
		 echo $nome_hotel.' - '.$endereco.' - '.$bairro.' - '.$telefone.' - '.$estrelas.' - '.$fonte.'<br>';
		 
	}
fclose($fd);
}
//$Bd->closeConnect();
?>