<?php session_start(); ?>
<?php include('CONFIG/config.php');?>
<?php include(DIR_DAO);?>
<?php include(DIR_ACTIONS.'genericFunction.php');?>
<?php include(DIR_CLASSES.'controllerUSUARIO.php');?>
<?php include(DIR_CLASSES.'controllerRESERVA.php');?>
<?php include(DIR_CLASSES.'controllerHOSPCONF.php');?>
<?php include(DIR_CLASSES.'controllerQUARTO.php');?>
<?php
switch($_POST['controller'])
{
	case'montarCalendario':
		$Bd = new Bd(CONEXAO);
		$dadosQuarto = array();

		$strSQL = "	select idhospede,idhospede,datainicial,datafinal from RESERVA where month(datainicial) = 05
			and month(datafinal) = 05	and YEAR(datainicial) = 2014 and YEAR(datafinal) = 2014 and idreserva in (173,174,175) ";

		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		$arrDataInicial = array();
		$arrDataFinal = array();

		foreach($dadosRecordSet as $dados)
		{
			array_push($arrDataInicial,$dados['datainicial']);
			array_push($arrDataFinal,$dados['datafinal']);
		}
		echo setDataCalendario($arrDataInicial,$arrDataFinal);
	break;
	default:
}
?>
