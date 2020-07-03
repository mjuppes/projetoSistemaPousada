<?php
echo date("d/m/Y");
function periodo(){
	
	$periodos = array();
	
	$incrementaMesesIni = array(0,1,2,3);
	$incrementaMesesFim = array(1,2,3,4);
	
	$diaAtual = 10;#date("d");
	
	if ($diaAtual > 14){
	
		$mesInicial = strftime('%m',mktime(0, 0, 0, date("m"), 01+31, date("Y")));
		
	} else {
	
		$mesInicial = strftime('%m',mktime(0, 0, 0, date("m"), 01-31, date("Y")));
		
	}
	
	for ($i = 0; $i < 4; $i++){
			
		$periodoIni = strftime('%d/%m/%Y',mktime(0, 0, 0, $mesInicial+$incrementaMesesIni[$i], 15, date("Y")));
			
		$periodoFim = strftime('%d/%m/%Y',mktime(0, 0, 0, $mesInicial+$incrementaMesesFim[$i], 14, date("Y")));
		
		array_push($periodos,$periodoIni."-".$periodoFim);
	}
	
	return $periodos;
	
}

print_r(periodo());

$arrPediodoDefault[0] = "15/01/2012-14/02/2012 - Atual";
$arrPediodoDefault[1] = "15/12/2011-14/01/2012";
$arrPediodoDefault[2] = "15/11/2011-14/12/2011";
$arrPediodoDefault[3] = "15/10/2011-14/11/2011";

?>