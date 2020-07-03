<?php session_start(); ?>
<?php include('../CONFIG/config.php');?>
<?php include(DIR_INCLUDES);?>
<?php

function diasemana($data)
{
	// Traz o dia da semana para qualquer data informada
	$dia =  substr($data,0,2);
	$mes =  substr($data,3,2);
	$ano =  substr($data,6,9);
	$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano));
	
	return $diasemana;
	/*
	switch($diasemana){
		case"0":
			$diasemana = "Domingo";	  
		break; 
		case"1":
			$diasemana = "Segunda-Feira"; 
		break;  
		case"2":
			$diasemana = "Terça-Feira";	
		break;  	
		case"3": 
			$diasemana = "Quarta-Feira";	
		break; 
		case"4":
			$diasemana = "Quinta-Feira";
		break;
		case"5":
			$diasemana = "Sexta-Feira";
		break;
		case"6":
			$diasemana = "Sábado";
		break;
	}
	
	return $diasemana;
	*/
}

$retorno = array();
switch($_POST['controller'])
{
	case 'showCalendarioSemanal':
	
	$mes = '05';   
	$ano = date("Y");
	$ultimo_dia = date("t", mktime(0,0,0,$mes,'01',$ano));
	
	
	$width = "14.29%";
	
$html = '	
	<table id="tableCalendario" style="overflow: auto;" class="table  table-bordered " width="500">
   <thead>
      <tr class="trlabel">
         <th width="'.$width.'" align="center">
			<span  class="pull-right" >Segunda</span>
		 </th>
         <th width="'.$width.'" align="center">
			<span  class="pull-right" >Terça</span>
		 </th>
         <th width="'.$width.'" align="center">
			<span  class="pull-right" >Quarta</span>
		 </th>
         <th width="'.$width.'" align="center">
			<span  class="pull-right" >Quinta</span>
		 </th>
		 <th width="'.$width.'" align="center">
			<span  class="pull-right" >Sexta</span>
		 </th>
		 <th width="'.$width.'" align="center">
			<span  class="pull-right" >Sábado</span>
		 </th>
		 <th width="'.$width.'" align="center">
			<span  class="pull-right" >Domingo</span>
		 </th>
      </tr>
   </thead>
   <tbody>';

   for($i=1; $i<($ultimo_dia+1); $i++)
   {
		if($i < 10)
			$dia ="0".$i;
		else
			$dia =$i;

		$data = ($dia.'/'.$mes.'/'.$ano);

		if(diasemana($data) == 1)
			$html.= ' <tr  id="tr0">';
		
		$span = '<span  class="pull-right" data-cal-date="2013-02-25" data-cal-view="day" data-toggle="tooltip" title="" data-original-title="">'.$dia.'</span>';	
		$html.= ' <td onclick="mostraModal();"  style="cursor:pointer" bgcolor="05F28F" align="center">'.$span.'</td>';
		if(diasemana($data) == 0)
			$html.= '</tr>';
		
   }
 $html.='
   </tbody>
</table>';
	



echo $html;
return;
	//$retorno["html"]  = $html;
	//$retorno["html"]  = $ultimo_dia;
	$retorno["html"]  = diasemana('31/05/2017');
	
	echo json_encode($retorno);
	break;
}


?>