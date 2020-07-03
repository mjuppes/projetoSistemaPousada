<?php session_start(); ?>
<?php include('../CONFIG/config.php');?>
<?php include('../'.DIR_INCLUDES);?>
<?php
$_SESSION['idusuario'] = $_SESSION['usuario'];
if(isset($_POST["numRows"]) && isset($_POST["numPage"]))
{
	$_SESSION['numRows'] = $_POST["numRows"];
	$_SESSION['numPage'] = $_POST["numPage"];
}
switch($_POST['controller'])
{
	case 'getDadosQuarto':
		$arrMes = array("1"=>"Janeiro","2"=>"Fevereiro","3"=>"Marco","4"=>"Abril"
						,"5"=>"Maio","6"=>"Junho","7"=>"Julho","8"=>"Agosto",
						"9"=>"Setembro","10"=>"Outubro","11"=>"Novembro","12"=>"Dezembro");

		if(!empty($_POST['formSelectAno']))
		{
			$arr = array("filtro"=>true);

			$where = " where 	t.ano = ".$_POST['formSelectAno'];

			$controllerRESERVA = new controllerRESERVA('selectGraficoQuarto',$arr,$where);
			$arr = array();
		}
		else
		{
			$arr = array("filtro"=>true);
			$where = " where 	t.ano = ".date('Y');
			$controllerRESERVA = new controllerRESERVA('selectGraficoQuarto',$arr,$where);
			$arr = array();
		}
		
		if(empty($controllerRESERVA->arrResposta))
		{
			echo "0";
			return;
		}

		$arrQtdMes = array();
		$arrNomeQ = array();
		$idquarto = "";
		$idquartoAux = "";


		foreach($controllerRESERVA->arrResposta as $dados)
		{
				$idquarto = $dados["idquarto"];
				$arrNomeQ[$dados["idquarto"]] = $dados["nomequarto"];

				if($idquartoAux != $idquarto && !empty($idquartoAux))
				{
					$arr[$idquartoAux] = $arrQtdMes;
					$arrQtdMes = array();
				}

				if($dados["mesIni"]	== $dados["mesFin"])
					$arrQtdMes[$dados["mesIni"]] = $dados["qtd"];

				if($dados["mesIni"]	!= $dados["mesFin"])
				{
					if(in_array($arrQtdMes[$dados["mesIni"]],$arrQtdMes))
						$arrQtdMes[$dados["mesIni"]] = (int)$arrQtdMes[$dados["mesIni"]]+$dados["qtd"];

					if(in_array($arrQtdMes[$dados["mesFin"]],$arrQtdMes))
						$arrQtdMes[$dados["mesFin"]] = (int)$arrQtdMes[$dados["mesFin"]]+$dados["qtd"];
					else
						$arrQtdMes[$dados["mesFin"]] = $dados["qtd"];
				}
				$idquartoAux = $idquarto;
				$idquarto = "";
		}

		if(count($arr[$idquartoAux]) == 0)
		{
			$arr[$idquartoAux] = $arrQtdMes;
			$arrQtdMes = array();
		}

		$arrMesCh = array();
		$arrValCh = array("1"=>"0","2"=>"0",
						  "3"=>"0","4"=>"0",
						  "5"=>"0","6"=>"0",
						  "7"=>"0","8"=>"0",
						  "9"=>"0","10"=>"0",
						  "11"=>"0","12"=>"0");
		$strJson = "";

		foreach($arr as $key => $arrV)
		{
			$nomeQuarto = $arrNomeQ[$key];
			foreach($arrV as $key => $value)
			{
						$arrValCh[$key] = $value;
			}

			$strValores = implode(",",$arrValCh);

			$arrValCh = array("1"=>"0","2"=>"0",
							  "3"=>"0","4"=>"0",
							  "5"=>"0","6"=>"0",
						      "7"=>"0","8"=>"0",
						     "9"=>"0","10"=>"0",
						     "11"=>"0","12"=>"0");

			if(empty($strJson))
				$strJson .= "{name:'".$nomeQuarto."',data:[".$strValores."]}";
			else
				$strJson .=",{name:'".$nomeQuarto."',data:[".$strValores."]}";
		}

		$strMes = implode(",",$arrMes);
		$arrMesCh = array();


		$strJson = "$strMes|".$strJson;
		echo $strJson;
	break;
	case 'getDadosTipoHospAgencia':

		$where = "";
		
		if(isset($_POST['formSelectMes']) && !empty($_POST['formSelectMes']))
			$where .= " and month(h.datahoje) = $_POST[formSelectMes]";

		if($where)
			$controllerHOSPEDE = new controllerHOSPEDE('selectQtdTipoHospAgencia',false,$where);
		else
			$controllerHOSPEDE = new controllerHOSPEDE('selectQtdTipoHospAgencia');

		if(empty($controllerHOSPEDE->arrResposta))
		{
			echo "0";
			return false;
		}

		$strChartPie = "";
		foreach($controllerHOSPEDE->arrResposta as $dados)
		{
			if(empty($strChartPie))
				$strChartPie.= "['".$dados['nomeagencia']."',".$dados['qtd']."]";
			else
				$strChartPie.= ",['".$dados['nomeagencia']."',".$dados['qtd']."]";
		}
		echo $strChartPie;
	break;
	case 'getDadosNumeroHospede':
		$where = "";
		if(isset($_POST['formSelectAno']))
			$where .= " YEAR(datahoje) = $_POST[formSelectAno]";

		if(isset($_POST['formSelectMes']))
		{	
			if(!empty($where))
				$where .= " and month(datahoje) = $_POST[formSelectMes]";
			else
				$where .= " month(datahoje) = $_POST[formSelectMes]";
		}
		if(isset($_POST['formSelectAgencia']))
		{
			if(!empty($where))
				$where .= " and idagencia = $_POST[formSelectAgencia]";
			else
				$where .= " idagencia = $_POST[formSelectAgencia]";
		}

		if(!empty($where))
			$controllerHOSPEDE = new controllerHOSPEDE('graficoNumeroHospede',false,$where);
		else
			$controllerHOSPEDE = new controllerHOSPEDE('graficoNumeroHospede');

		if(empty($controllerHOSPEDE->arrResposta))
		{
			echo "0";
			return false;
		}

		$strChart = "";
		foreach($controllerHOSPEDE->arrResposta as $dados)
		{
			$strChart.= "[{'name': 'Hóspedes sem agência','data':".$dados['qtd1']."},{'name': 'Hóspedes com agência','data':".$dados['qtd2']."}]";
		}
		echo $strChart;
	break;
	case 'selectAno':
		$arrAno = array("2010","2011","2012","2013","2014","2015","2016","2017","2018","2019","2020");

		$strAno = "";
		$strAno .= "<option value=''>Selecione o ano</option>";

		foreach($arrAno as $key => $value)
		{
				$strAno .= "<option value='".($value)."'>".$value."</option>";
		}
		echo utf8_encode($strAno);
	break;
	case 'selectMes':
		$arrMes = array('Janeiro'=>1,'Fevereiro'=>2,'Março'=>3,
						'Abril'=>4,'Maio'=>5,'Junho'=>6,'Julho'=>7,'Agosto'=>8,
						'Setembro'=>9,'Outubro'=>10,'Novembro'=>11,'Dezembro'=>12);
		
		$strMes = "";
		$strMes .= "<option value=''>Selecione o mês</option>";

		foreach($arrMes as $key => $value)
		{
			$strMes .= "<option value='".($value)."'>".$key."</option>";
		}
		echo ($strMes);
	break;
	case 'selectAgencia':
		$controllerAGENCIA = new controllerAGENCIA('select');
		$strAgencia = "";
		$strAgencia .= "<option value=''>Selecione uma agência</option>";

		foreach($controllerAGENCIA->arrResposta as $dados)
		{
			$strAgencia .= "<option value='".($dados['idagencia'])."'>".$dados['nomeagencia']."</option>";
		}
		echo ($strAgencia);
	break;	
	case 'selectAgenciasQtd':
		$where = "";
		
		if(isset($_POST['formSelectMes']) && !empty($_POST['formSelectMes']))
			$where .= " and month(h.datahoje) = $_POST[formSelectMes]";

		if($where)
			$controllerHOSPEDE = new controllerHOSPEDE('selectQtdTipoHospAgencia',false,$where);
		else
			$controllerHOSPEDE = new controllerHOSPEDE('selectQtdTipoHospAgencia');

		if(empty($controllerHOSPEDE->arrResposta))
		{
			echo "0";
			return false;
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerHOSPEDE->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectNumeroHospede':
		$where = "";
		if(isset($_POST['formSelectAno']))
			$where .= " YEAR(datahoje) = $_POST[formSelectAno]";

		if(isset($_POST['formSelectMes']))
		{	
			if(!empty($where))
				$where .= " and month(datahoje) = $_POST[formSelectMes]";
			else
				$where .= " month(datahoje) = $_POST[formSelectMes]";
		}
		if(isset($_POST['formSelectAgencia']))
		{
			if(!empty($where))
				$where .= " and idagencia = $_POST[formSelectAgencia]";
			else
				$where .= " idagencia = $_POST[formSelectAgencia]";
		}

		if(!empty($where))
			$controllerHOSPEDE = new controllerHOSPEDE('graficoNumeroHospede',false,$where);
		else
			$controllerHOSPEDE = new controllerHOSPEDE('graficoNumeroHospede');

		if(empty($controllerHOSPEDE->arrResposta))
		{
			echo "0";
			return false;
		}
		
		$strJSON = json_encode('{"rows":'.json_encode($controllerHOSPEDE->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectGraficosCombo':
		$arrTipoGrafico = array("Faturamento Anual"=>'A',"Faturamento Discriminado"=>'D');
		echo selectCombo("-- Selecione o Gráfico --",$arrTipoGrafico,false,$_POST['id']);
	break;
	case 'graficoFatAnual':
		$where = " and YEAR(r.datainicial) = '".$_POST['formSelectAno']."'";

		$arrMes = array('1','2','3','4','5','6','7','8','9','10','11','12');

		$controllerRESERVA = new controllerRESERVA('selectGraficoFatAnual',false,$where);

		$arrD_Mes = array();
		foreach($controllerRESERVA->arrResposta as $dados)
		{		
				$arrD_Mes[$dados['mes']] = $dados['valor'];
		}

		foreach($arrMes as $key => $value)
		{
				if(!isset($arrD_Mes[$value]))
					$arrD_Mes[$value] = '0';
		}

		ksort($arrD_Mes);

		$arr_Values = array();
		foreach($arrD_Mes as $key => $value)
		{
				array_push($arr_Values,$value);
		}

		$arrM_Meses = array('Janeiro','Fevereiro','Março',
						'Abril','Maio','Junho','Julho','Agosto',
						'Setembro','Outubro','Novembro','Dezembro');

		$retorno = array();
		
		//$arr_Values = array(10,20,30,40,50,60,70,80,90,100,110,120);

		$retorno["obj_categorias"]  = $arrM_Meses;
		$retorno["series"]			= "[{'name': 'Faturamento','data':[".implode(",",$arr_Values)."]}]";
		echo json_encode($retorno);
		
		return;
		
		// dump($arrD_Mes);
	break;
	//case ''
	default:
}
?>