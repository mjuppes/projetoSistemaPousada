<?php

	
	//TODO Tem que fazer a conexão com o BD Aqui.
	//$sth = $dbh->prepare("SELECT * FROM RESERVA");
	$evaluation = array();
	$index = 0;

	//for ($i = 0; $res = $sth->fetch(PDO::FETCH_ASSOC); $i++){
	for($i =1; $i < 10; $i++){
		
		//$evaluation[$index] = "teste: " . $i;
		$evaluation["Item"][$index] = "Item A: " . $i;
		//$evaluationType[$res['idEvaluationType']] = 'none';
		$index++;
		}		

	echo json_encode($evaluation);

?>

