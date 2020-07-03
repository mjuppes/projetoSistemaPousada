<?php session_start(); ?>
<?php include('../CONFIG/config.php');?>
<?php include('../'.DIR_DAO);?>
<?php //include('../'.DIR_CLASSES.'controllerBANCOS.php');?>
<?php include('../'.DIR_CLASSES.'controllerBANDEIRA.php');?>


<?php
$fp = fopen("includes2.php","a+");

// if(is_writable($fp))
	// echo "erro1";
// else
	// echo "erro2";
// return;
$strClass.= "\n<?php include('../'.DIR_CLASSES.'controllerLANCAMENTO_AUDITORIA555.php');?>";
$escreve = fwrite($fp, $strClass);
fclose($fp);
return;
foreach($rows as $row)
{
	echo $row.'<br>';
}
return;

foreach($rows as $row)
{
	$row = explode(";",$row);
	
	$row[0] = str_replace('"',"",$row[0]);
	$row[1] = str_replace('"',"",$row[1]);
	$row[1] = utf8_decode($row[1]);
    //echo $row[0]." - ".$row[1]."<br>";
	
	 $arr = array("bandeira"=>$row[1]);

	 $controllerBANDEIRA = new controllerBANDEIRA('insert',$arr);

}
return;

?>