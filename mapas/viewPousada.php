<?php session_start(); ?>
<?php include('../CONFIG/config.php');?>
<?php include('../'.DIR_DAO);?>
<?php include('../'.DIR_ACTIONS.'genericFunction.php');?>
<?php include('../'.DIR_CLASSES.'controllerQUARTO.php');?>
<?php include('../'.DIR_CLASSES.'controllerEMPRESA.php');?>
<?php include('../'.DIR_CLASSES.'controllerHOSPEDE.php');?>
<?php include('../'.DIR_CLASSES.'controllerRESERVA.php');?>
<?php include('../'.DIR_CLASSES.'controllerCATEGORIA.php');?>
<?php include('../'.DIR_CLASSES.'controllerPRODUTOS.php');?>

<?php
$_SESSION['idusuario'] = $_SESSION['usuario'];

if(isset($_POST["numRows"]) && isset($_POST["numPage"]))
{
	$_SESSION['numRows'] = $_POST["numRows"];
	$_SESSION['numPage'] = $_POST["numPage"];
}

switch($_POST['controller'])
{
	case 'cadastroQuarto':
		$arr = array("nomequarto"=>$_POST["formNomeQuarto"],
					"disponibilidade"=>$_POST["formSelectDisponibilidade"],
					"localizacao"=>$_POST["formLocalizacao"],
					"qtdvaga"=>$_POST["formQtdVaga"]);

		$controllerQUARTO = new controllerQUARTO('insert',$arr);
		echo $controllerQUARTO->resposta;
	break;
	case 'selectCategoria':
		$controllerCATEGORIA = new controllerCATEGORIA('selectCategoria');
		$strCategoria = "";
		$strCategoria .= "<option value=''>".utf8_encode("Selecione uma categoria")."</option>";

		if(empty($controllerCATEGORIA->arrResposta))
			return false;

		foreach($controllerCATEGORIA->arrResposta as $dados)
		{
			if(isset($_POST['id']))
			{
				if($_POST['id'] == $dados['idcategoria'])
					$strCategoria .= "<option SELECTED value='".($dados['idcategoria'])."' >".$dados['nomecategoria']."</option>";
				else
					$strCategoria .= "<option value='".($dados['idcategoria'])."' >".$dados['nomecategoria']."</option>";
			}
			else
				$strCategoria .= "<option value='".($dados['idcategoria'])."' >".$dados['nomecategoria']."</option>";
		}
		echo utf8_encode($strCategoria);
	break;
	case 'selectQuartos':
		$controllerQUARTO = new controllerQUARTO('selectQuartos',$arr);
		$strJSON = json_encode('{"rows":'.json_encode($controllerQUARTO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectReservaHospede':
		$controllerRESERVA = new controllerRESERVA('selectReservaHospede',$arr);
		$strJSON = json_encode('{"rows":'.json_encode($controllerRESERVA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectReserva':
		$controllerRESERVA = new controllerRESERVA('selectReserva',$arr);
		$strJSON = json_encode('{"rows":'.json_encode($controllerRESERVA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectQuartoCombo':
		$controllerQUARTO = new controllerQUARTO('selectQuartos');
		$strQuarto = "";
		$strQuarto .= "<option value=''>".utf8_encode("Selecione um quarto")."</option>";

		if(empty($controllerQUARTO->arrResposta))
			return false;

		foreach($controllerQUARTO->arrResposta as $dados)
		{
			if(isset($_POST['id']))
			{
				if($_POST['id'] == $dados['idquarto'])
					$strQuarto .= "<option SELECTED value='".($dados['idquarto'])."' >".$dados['nomequarto']."</option>";
				else
					$strQuarto .= "<option value='".($dados['idquarto'])."' >".$dados['nomequarto']."</option>";
			}
			else
				$strQuarto .= "<option value='".($dados['idquarto'])."' >".$dados['nomequarto']."</option>";
		}
		echo utf8_encode($strQuarto);
	break;
	case 'selectDadosQuarto':
		$arr = array("idquarto"=>$_POST["idquarto"]);
		$controllerQUARTO = new controllerQUARTO('selectDadosJsonQuarto',$arr);
		echo $controllerQUARTO->resposta;
	break;
	case 'selectDadosReserva':
		$arr = array("idreserva"=>$_POST["idreserva"]);
		$controllerRESERVA = new controllerRESERVA('selectDadosJsonReserva',$arr);
		echo $controllerRESERVA->resposta;
	break;
	case 'selectHospedeGeral':
		$controllerHOSPEDE = new controllerHOSPEDE('selectHospedeGeral');
		$strHospede = "";
		$strHospede .= "<option value=''>".utf8_encode("Selecione um hospede")."</option>";

		if(empty($controllerHOSPEDE->arrResposta))
			return false;

		foreach($controllerHOSPEDE->arrResposta as $dados)
		{
			if(isset($_POST['id']))
			{
				if($_POST['id'] == $dados['idhospede'])
					$strHospede .= "<option SELECTED value='".($dados['idhospede'])."' >".$dados['nome']."</option>";
				else
					$strHospede .= "<option value='".($dados['idhospede'])."' >".$dados['nome']."</option>";
			}
			else
				$strHospede .= "<option value='".($dados['idhospede'])."' >".$dados['nome']."</option>";
		}
		echo utf8_encode($strHospede);
	
	break;
	case 'selectDisponibilidade':
		$arrDisponibilidade = array("1"=>"Disponível","0"=>"Indisponível");
		$strDisponibilidade = "";
		$strDisponibilidade .= "<option value='' >Selecione uma opção</option>";

		foreach($arrDisponibilidade as $key => $value)
		{
				if($_POST['id'] == $key)
					$strDisponibilidade .= "<option value='".($key)."'>".$value."</option>";
				else
					$strDisponibilidade .= "<option  value='".($key)."'>".$value."</option>";
		}
		echo utf8_encode($strDisponibilidade);
	break;
	case 'cadastroHospede':
		$arr = array("nome"=>$_POST["formNome"],
					"sexo"=>$_POST["formSelectSexo"],
					"datareserva"=>formatDate($_POST["formDtaReserva"]),
					"cpf"=>$_POST["formCpf"],
					"rg"=>$_POST["formRg"],
					"idestado"=>$_POST["formSelectEstado"],
					"idcidade"=>$_POST["formSelectCidade"],
					"email"=>$_POST["formEmail"],
					"datahoje"=>formatDate($_POST["formDta"]));

		if(isset($_POST["formSelectEmpresa"]) && !empty($_POST["formSelectEmpresa"]))
			$arr["idempresa"] = $_POST["formSelectEmpresa"];

		$controllerHOSPEDE = new controllerHOSPEDE('insert',$arr);
		if($controllerHOSPEDE->resposta == 1)
		{
			$controllerHOSPEDE = new controllerHOSPEDE('lastIdhospede');
			echo $controllerHOSPEDE->resposta;
		}
		else
			echo "Error3";
	break;
	case 'cadastroEmpresa':
		$arr = array("nomeempresa"=>$_POST['formEmpresa'],"cnpj"=>$_POST['formCnpj']);
		$controllerEMPRESA = new controllerEMPRESA('insert',$arr);
		if($controllerEMPRESA->resposta == 1)
		{
			$controllerEMPRESA = new controllerEMPRESA('lastIdempresa');
			echo $controllerEMPRESA->resposta;
		}
		else
			echo "Error3";
	break;
	case 'selectEmpresa':
		$controllerEMPRESA = new controllerEMPRESA('selectEmpresa');
		$strEmpresa = "";
		$strEmpresa .= "<option value=''>".utf8_encode("Selecione uma empresa")."</option>";

		if(empty($controllerEMPRESA->arrResposta))
			return false;

		foreach($controllerEMPRESA->arrResposta as $dados)
		{
			if(isset($_POST['id']))
			{
				if($_POST['id'] == $dados['idempresa'])
					$strEmpresa .= "<option SELECTED value='".($dados['idempresa'])."' >".$dados['nomeempresa']."</option>";
				else
					$strEmpresa .= "<option value='".($dados['idempresa'])."' >".$dados['nomeempresa']."</option>";
			}
			else
				$strEmpresa .= "<option value='".($dados['idempresa'])."' >".$dados['nomeempresa']."</option>";
		}
		echo utf8_encode($strEmpresa);
	break;
	case 'cadastroReserva':
		if(isset($_POST['formSelectHospede']))
		{
			$arr = array("idhospede" => $_POST['formSelectHospede'],
						"idquarto"=>$_POST['formSelectQuarto'],
						"datainicial"=>formatDate($_POST['formDtInicial']),
						"datafinal"=>formatDate($_POST['formDtFinal']),
						"opcao"=>$_POST['formSelectOpcaoQuarto']);
		}
		else
		{
			$arr = array("idquarto"=>$_POST['formSelectQuarto'],
						"datainicial"=>formatDate($_POST['formDtInicial']),
						"datafinal"=>formatDate($_POST['formDtFinal']),
						"idhospede"=>trim($_POST['idlasthosp']),
						"opcao"=>$_POST['formSelectOpcaoQuarto']);
		}

		$controllerRESERVA = new controllerRESERVA('verificaPeriodo',$arr);

		if($controllerRESERVA->resposta == "0")
		{
			$controllerQUARTO = new controllerQUARTO('verificaVaga',$arr);
			if(!$controllerQUARTO->resposta)
			{
				echo "4";
				return;
			}

			$controllerRESERVA = new controllerRESERVA('insert',$arr);
			echo $controllerRESERVA->resposta;
		}
		else
		{
			echo "8";
		}
	break;
	case 'selectHospede':
		$controllerHOSPEDE = new controllerHOSPEDE('selectHospede');
		$strHospede = "";
		$strHospede .= "<option value=''>".utf8_encode("Selecione um hospede")."</option>";

		if(empty($controllerHOSPEDE->arrResposta))
			return false;

		foreach($controllerHOSPEDE->arrResposta as $dados)
		{
			if(isset($_POST['id']))
			{
				if($_POST['id'] == $dados['idhospede'])
					$strHospede .= "<option SELECTED value='".($dados['idhospede'])."' >".$dados['nome']."</option>";
				else
					$strHospede .= "<option value='".($dados['idhospede'])."' >".$dados['nome']."</option>";
			}
			else
				$strHospede .= "<option value='".($dados['idhospede'])."' >".$dados['nome']."</option>";
		}
		echo utf8_encode($strHospede);
	break;
	case 'selectProduto':
		$controllerPRODUTOS = new controllerPRODUTOS('selectProduto');
		$strProduto = "";
		$strProduto .= "<option value=''>".utf8_encode("Selecione um hospede")."</option>";

		if(empty($controllerPRODUTOS->arrResposta))
			return false;

		foreach($controllerPRODUTOS->arrResposta as $dados)
		{
			if(isset($_POST['id']))
			{
				if($_POST['id'] == $dados['idproduto'])
					$strProduto .= "<option SELECTED value='".($dados['idproduto'])."' >".$dados['nomeproduto']."</option>";
				else
					$strProduto .= "<option value='".($dados['idproduto'])."' >".$dados['nomeproduto']."</option>";
			}
			else
				$strProduto .= "<option value='".($dados['idproduto'])."' >".$dados['nomeproduto']."</option>";
		}
		echo utf8_encode($strProduto);
	break;
	case 'updateReserva':
		$arr = array("idquarto"=>$_POST["formSelectQuarto"],
					"datainicial"=>formatDate($_POST["formDtInicial"]),
					"datafinal"=>formatDate($_POST["formDtFinal"]),
					"idreserva"=>$_POST["formIdReserva"],
					"opcao"=>$_POST["formSelectOpcaoQuarto"]);

		$controllerRESERVA = new controllerRESERVA('update',$arr);
		echo $controllerRESERVA->resposta;
	break;
	case 'deleteReserva':
		$arr = array("idreserva"=>$_POST["idreserva"]);
		$controllerRESERVA = new controllerRESERVA('delete',$arr);
		echo $controllerRESERVA->resposta;
	break;
	case 'selectOpcaoQuarto':
		$strOpcaoQuarto = "";
		$strOpcaoQuarto .= "<option value=''>".("Selecione uma opção de quarto")."</option>";

		$arrOpcaoQuarto = array("C"=>"Casal","S"=>"Solteiro");

		foreach($arrOpcaoQuarto as $key => $value)
		{
			if(isset($_POST['id']))
			{
				if($_POST['id'] == $key)
					$strOpcaoQuarto .= "<option SELECTED value='".($key)."' >".$value."</option>";
				else
					$strOpcaoQuarto .= "<option value='".($key)."' >".$value."</option>";
			}
			else
				$strOpcaoQuarto .= "<option value='".($key)."' >".$value."</option>";
		}
		echo utf8_encode($strOpcaoQuarto);
	break;
	case 'selectHistorico':
		$controllerRESERVA = new controllerRESERVA('selectHistorico',$arr);
		$strJSON = json_encode('{"rows":'.json_encode($controllerRESERVA->arrResposta)."}");
		echo($strJSON);
	break;

	/*
	case 'updatePrato':
		$arr = array("nomeprato"=>$_POST["formTipoPrato"],
			"preco"=>formatValor($_POST["formPreco"]),
			"dataatualizacao"=>formatDate($_POST["formDtAtualizacao"]),
			"descricao"=>$_POST["formDescricao"],
			"idprato"=>$_POST["formIdPrato"]);
			$controllerPRATOS = new controllerPRATOS('update',$arr);
		echo $controllerPRATOS->resposta;
	break;
	case 'selectAtendente':
		$controllerATENDENTE = new controllerATENDENTE('selectAtendente');
		$strAtendente = "";
		$strAtendente .= "<option value=''>".utf8_encode("Selecione uma atendente")."</option>";

		if(empty($controllerATENDENTE->arrResposta))
			return false;

		foreach($controllerATENDENTE->arrResposta as $dados)
		{
			if(isset($_POST['id']))
			{
				if($_POST['id'] == $dados['idatendente'])
					$strAtendente .= "<option SELECTED value='".($dados['idatendente'])."' >".$dados['nomeatendente']."</option>";
				else
					$strAtendente .= "<option value='".($dados['idatendente'])."' >".$dados['nomeatendente']."</option>";
			}
			else
				$strAtendente .= "<option value='".($dados['idatendente'])."' >".$dados['nomeatendente']."</option>";
		}
		echo utf8_encode($strAtendente);
	break;
	case 'selectPrato':
		$controllerPRATOS = new controllerPRATOS('selectPratos');
		$strPratos = "";
		$strPratos .= "<option value=''>".utf8_encode("Selecione um prato")."</option>";

		if(empty($controllerPRATOS->arrResposta))
			return false;

		foreach($controllerPRATOS->arrResposta as $dados)
		{
			if(isset($_POST['id']))
			{
				if($_POST['id'] == $dados['idprato'])
					$strPratos .= "<option SELECTED value='".($dados['idprato'])."' >".$dados['nomeprato']."</option>";
				else
					$strPratos .= "<option value='".($dados['idprato'])."' >".$dados['nomeprato']."</option>";
			}
			else
				$strPratos .= "<option value='".($dados['idprato'])."' >".$dados['nomeprato']."</option>";
		}
		echo utf8_encode($strPratos);
	break;
	case 'selectTipoBebida':
		$controllerTIPOBEBIDA = new controllerTIPOBEBIDA('selectTipoBebida');
		$strTipobebida = "";
		$strTipobebida .= "<option value=''>".utf8_encode("Selecione um tipo de bebida")."</option>";

		if(empty($controllerTIPOBEBIDA->arrResposta))
			return false;

		foreach($controllerTIPOBEBIDA->arrResposta as $dados)
		{
			if(isset($_POST['id']))
			{
				if($_POST['id'] == $dados['idtipobebida'])
					$strTipobebida .= "<option SELECTED value='".($dados['idtipobebida'])."' >".$dados['tipobebida']."</option>";
				else
					$strTipobebida .= "<option value='".($dados['idtipobebida'])."' >".$dados['tipobebida']."</option>";
			}
			else
				$strTipobebida .= "<option value='".($dados['idtipobebida'])."' >".$dados['tipobebida']."</option>";
		}
		echo utf8_encode($strTipobebida);
	break;
	case 'selectBebida':
		$arr = array("idtipobebida"=>$_POST["id2"]);
		$controllerBEBIDA = new controllerBEBIDA('selectBebida',$arr);
		$strTipobebida = "";
		$strTipobebida .= "<option value=''>".utf8_encode("Selecione uma bebida")."</option>";

		if(empty($controllerBEBIDA->arrResposta))
		{
			$strTipobebida .= "<option value=''>----------------------------------------------------</option>";
			echo $strTipobebida;
			return false;
		}

		foreach($controllerBEBIDA->arrResposta as $dados)
		{
			if(isset($_POST['id']))
			{
				if($_POST['id'] == $dados['idbebida'])
					$strTipobebida .= "<option SELECTED value='".($dados['idbebida'])."' >".$dados['nomebebida']."</option>";
				else
					$strTipobebida .= "<option value='".($dados['idbebida'])."' >".$dados['nomebebida']."</option>";
			}
			else
				$strTipobebida .= "<option value='".($dados['idbebida'])."' >".$dados['nomebebida']."</option>";
		}
		echo utf8_encode($strTipobebida);
	break;
	case 'selectMesa':
		$controllerMESA = new controllerMESA('selectMesa');
		$strMesa = "";
		$strMesa .= "<option value=''>".utf8_encode("Selecione uma mesa")."</option>";

		if(empty($controllerMESA->arrResposta))
			return false;

		foreach($controllerMESA->arrResposta as $dados)
		{
			if(isset($_POST['id']))
			{
				if($_POST['id'] == $dados['idmesa'])
					$strMesa .= "<option SELECTED value='".($dados['idmesa'])."' >".$dados['nome'a']."</option>";
				else
					$strMesa .= "<option value='".($dados['idmesa'])."' >".$dados['nomemesa']."</option>";
			}
			else
				$strMesa .= "<option value='".($dados['idmesa'])."' >".$dados['nomemesa']."</option>";
		}
		echo utf8_encode($strMesa);
	break;
	case 'cadastroAtendimento':
		if(empty($_POST["formSelectPrato"]) &&  empty($_POST["formSelectBebida"]))
		{
			echo "error";
			return false;
		}

		$arr = array("idatendente"=>$_POST["formSelectAtendente"],
					"dataatendimento"=>formatDate($_POST["formDtAtendimento"]),
					"idmesa"=>$_POST["formSelectMesa"],
					"observacao"=>$_POST["formObservacao"]);

		if(isset($_POST["formSelectPrato"]) && !empty($_POST["formSelectPrato"]))
			$arr["idprato"] = $_POST["formSelectPrato"];

		if(isset($_POST["formSelectTipoBebida"]) && isset($_POST["formSelectBebida"]) && !empty($_POST["formSelectTipoBebida"]) && !empty($_POST["formSelectBebida"]))
		{
			$arr["idtipobebida"] = $_POST["formSelectTipoBebida"];
			$arr["idbebida"] = $_POST["formSelectBebida"];
		}
		$controllerATENDIMENTO = new controllerATENDIMENTO('insert',$arr);
		echo $controllerATENDIMENTO->resposta;
	break;
	case 'selectDadosAtendimento':
		$arr = array("idatendimento"=>$_POST["idatendimento"]);
		$controllerATENDIMENTO = new controllerATENDIMENTO('selectDadosJsonAtendimento',$arr);
		echo $controllerATENDIMENTO->resposta;
	break;
	case 'selectAtendimentos':
		if(isset($_POST["formSelectAtendente"]) || isset($_POST["formSelectPrato"]) || isset($_POST["formSelectMesa"]) || isset($_POST["formSelectBebida"]) || isset($_POST["formDtInicial"]) || isset($_POST["formDtFinal"]))
		{

			$where = "";
			if(!empty($_POST["formSelectAtendente"]))
				$where .= " at.idatendente = ".$_POST["formSelectAtendente"];
			if(!empty($_POST["formSelectPrato"]))
			{
				if(empty($where))
					$where .= " p.idprato = ".$_POST["formSelectPrato"];
				else
					$where .= " and p.idprato = ".$_POST["formSelectPrato"];
			}
			if(!empty($_POST["formSelectMesa"]))
			{
				if(empty($where))
					$where .= " m.idmesa = ".$_POST["formSelectMesa"];
				else
					$where .= " and m.idmesa = ".$_POST["formSelectMesa"];
			}

			if(!empty($_POST["formSelectBebida"]))
			{
				if($_POST["formSelectBebida"] == "true")
					$strwhere = "a.idtipobebida is not null";
				else
					$strwhere = "a.idtipobebida is null";

				if(empty($where))
					$where .= " $strwhere";
				else
					$where .= " and $strwhere";
			}

			if(isset($_POST["formDtInicial"]))
			{
				$dtIni = explode("/",$_POST['formDtInicial']);
				$dataInicial = $dtIni[1]."/".$dtIni[0]."/".$dtIni[2];
			}

			if(isset($_POST['formDtFinal']))
			{
				$dtFin = explode("/",$_POST['formDtFinal']);
				$dataFinal = $dtFin[1]."/".$dtFin[0]."/".$dtFin[2];
			}

			if(!empty($_POST["formDtInicial"]) &&  !empty($_POST["formDtFinal"]))
			{
				if(empty($where))
					$where .= " a.dataatendimento between '$dataInicial' and '$dataFinal'";
				else
					$where .= " and  a.dataatendimento between '$dataInicial' and '$dataFinal'";
			}

			if(!empty($_POST["formDtInicial"]) &&  empty($_POST["formDtFinal"]))
			{
				if(empty($where))
					$where .= " a.dataatendimento >= '$dataInicial'";
				else
					$where .= " and  a.dataatendimento >= '$dataInicial'";
			}

			if(empty($_POST["formDtInicial"]) &&  !empty($_POST["formDtFinal"]))
			{
				if(empty($where))
					$where .= " a.dataatendimento >= '$dataFinal'";
				else
					$where .= " and a.dataatendimento >= '$dataFinal'";
			}

			$where = " where ".$where;

			$arr = array("filtro"=>true);
			$controllerATENDIMENTO = new controllerATENDIMENTO('selectAtendimentos',$arr,$where);
		}
		else
			$controllerATENDIMENTO = new controllerATENDIMENTO('selectAtendimentos');

		$strJSON = json_encode('{"rows":'.json_encode($controllerATENDIMENTO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'updateAtendimento':
		$arr = array("idatendimento"=>$_POST["formIdAtendimento"],
					"idatendente"=>$_POST["formSelectAtendente"],
					"idprato"=>$_POST["formSelectPrato"],
					"dataatendimento"=>formatDate($_POST["formDtAtendimento"]),
					"idmesa"=>$_POST["formSelectMesa"],
					"observacao"=>$_POST["formObservacao"]);

		if(isset($_POST["formSelectTipoBebida"]) && isset($_POST["formSelectBebida"]))
		{
			if(empty($_POST["formSelectTipoBebida"]))
				$arr["idtipobebida"] = '';
			else
				$arr["idtipobebida"] = $_POST["formSelectTipoBebida"];

			if(empty($_POST["formSelectBebida"]))
				$arr["idbebida"] = '';
			else
				$arr["idbebida"] = $_POST["formSelectBebida"];
		}
		$controllerATENDIMENTO = new controllerATENDIMENTO('update',$arr);
		echo $controllerATENDIMENTO->resposta;
	break;
	case 'selectAtendDiarios':
		if(isset($_POST["filtro"]) && $_POST["filtro"] == true)
		{
			$arr = array("filtro"=>true);

			if(!empty($_POST["formDtInicial"]) &&  !empty($_POST["formDtFinal"]))
				$where = " where t.dataatendimento between '$_POST[formDtInicial]' and '$_POST[formDtFinal]'";
			if(!empty($_POST["formDtInicial"]) &&  empty($_POST["formDtFinal"]))
				$where = " where t.dataatendimento >= '$_POST[formDtInicial]'";
			if(empty($_POST["formDtInicial"]) &&  !empty($_POST["formDtFinal"]))
				$where = " where t.dataatendimento >= '$_POST[formDtFinal]'";

			$controllerATENDIMENTO = new controllerATENDIMENTO('selectAtendDiarios',$arr,$where);
		}
		else
		{
			$controllerATENDIMENTO = new controllerATENDIMENTO('selectAtendDiarios');
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerATENDIMENTO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'cadastroTipoBebida':
		$arr = array("tipobebida"=>$_POST["formTipoBebida"]);
		$controllerTIPOBEBIDA = new controllerTIPOBEBIDA('insert',$arr);
		echo $controllerTIPOBEBIDA->resposta;
	break;
	case 'selectCatBebidas':
		$controllerTIPOBEBIDA = new controllerTIPOBEBIDA('selectTipoBebida');
		$strJSON = json_encode('{"rows":'.json_encode($controllerTIPOBEBIDA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectDadosTipoBebida':
		$arr = array("idtipobebida"=>$_POST["idtipobebida"]);
		$controllerTIPOBEBIDA = new controllerTIPOBEBIDA('selectDadosTipoBebida',$arr);
		echo $controllerTIPOBEBIDA->resposta;
	break;
	case 'updateTipoBebida':
		$arr = array("idtipobebida"=>$_POST["formIdTipoBebida"],
					"tipobebida"=>$_POST["formTipoBebida"]);

		$controllerTIPOBEBIDA = new controllerTIPOBEBIDA('update',$arr);
		echo $controllerTIPOBEBIDA->resposta;
	break;
	case 'selectAtendPratos':
		if(isset($_POST["filtro"]) && $_POST["filtro"] == true)
		{
			$arr = array("filtro"=>true);

			$where = " where a.dataatendimento = '".formatDate($_POST['formDtAtendimento'])."'";
			$controllerATENDIMENTO = new controllerATENDIMENTO('selectAtendPratos',$arr,$where);
		}
		else
			$controllerATENDIMENTO = new controllerATENDIMENTO('selectAtendPratos');

		$strJSON = json_encode('{"rows":'.json_encode($controllerATENDIMENTO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectSomaAtendimentos':
		if(isset($_POST["filtro"]) && $_POST["filtro"] == true)
		{
			$arr = array("filtro"=>true);

			$where = " where dataatendimento = '".formatDate($_POST['formDtAtendimento'])."'";
			$controllerATENDIMENTO = new controllerATENDIMENTO('selectSomaAtendimentos',$arr,$where);
		}
		else
			$controllerATENDIMENTO = new controllerATENDIMENTO('selectSomaAtendimentos');

		$strJSON = json_encode('{"rows":'.json_encode($controllerATENDIMENTO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'cadastroBebida':
		$arr = array("idtipobebida"=>$_POST["formSelectTipoBebida"],
					"nomebebida"=>$_POST["formNomeBebida"],
					"valor"=>formatValor($_POST["formPreco"]));

		$controllerBEBIDA = new controllerBEBIDA('insert',$arr);
		echo $controllerBEBIDA->resposta;
	break;
	case 'selectBebidas':
		$controllerBEBIDA = new controllerBEBIDA('selectBebida');
		$strJSON = json_encode('{"rows":'.json_encode($controllerBEBIDA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectDadosBebida':
		$arr = array("idbebida"=>$_POST["idbebida"]);
		$controllerBEBIDA = new controllerBEBIDA('selectDadosJsonBebida',$arr);
		echo $controllerBEBIDA->resposta;
	break;
	case 'updateBebida':
		$arr = array("idtipobebida"=>$_POST["formSelectTipoBebida"],
				"nomebebida"=>$_POST["formNomeBebida"],
				"valor"=>formatValor($_POST["formPreco"]),
				"idbebida"=>$_POST["formIdBebida"]);

		$controllerBEBIDA = new controllerBEBIDA('update',$arr);
		echo $controllerBEBIDA->resposta;
	break;
	case 'selectAtendenteTable':
		$controllerATENDENTE = new controllerATENDENTE('selectAtendente');
		$strJSON = json_encode('{"rows":'.json_encode($controllerATENDENTE->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectDadosAtendente':
		$arr = array("idatendente"=>$_POST["idatendente"]);
		$controllerATENDENTE = new controllerATENDENTE('selectDadosJsonAtendente',$arr);
		echo $controllerATENDENTE->resposta;
	break;
	case 'updateAtendente':
		$arr = array("idatendente"=>$_POST["formIdAtendente"],
				"nomeatendente"=>$_POST["formNomeAtendente"]);

		$controllerATENDENTE = new controllerATENDENTE('update',$arr);
		echo $controllerATENDENTE->resposta;
	break;
	case 'selectMesaTable':
		$controllerMESA = new controllerMESA('selectMesa');
		$strJSON = json_encode('{"rows":'.json_encode($controllerMESA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'cadastroMesa':
		$arr = array("nomemesa"=>$_POST["formNomeMesa"],
					"posicao"=>$_POST["formPosicao"]);

		$controllerMESA = new controllerMESA('insert',$arr);
		echo $controllerMESA->resposta;
	break;
	case 'updateMesa':
		$arr = array("idmesa"=>$_POST["formIdMesa"],
					"nomemesa"=>$_POST["formNomeMesa"],
					"posicao"=>$_POST["formPosicao"]);

		$controllerMESA = new controllerMESA('update',$arr);
		echo $controllerMESA->resposta;
	break;
	case 'selectDadosMesa':
		$arr = array("idmesa"=>$_POST["idmesa"]);
		$controllerMESA = new controllerMESA('selectDadosJsonMesa',$arr);
		echo $controllerMESA->resposta;
	break;
	case 'cadastroAtendente':
		$arr = array("nomeatendente"=>$_POST["formNomeAtendente"]);
		$controllerATENDENTE = new controllerATENDENTE('insert',$arr);
		echo $controllerATENDENTE->resposta;
	break;
	
	case 'deleteMesa':
		$arr = array("idmesa"=>$_POST["idmesa"],"habilitado"=>'N');
		$controllerMESA = new controllerMESA('delete',$arr);
		echo $controllerMESA->resposta;
	break;
	case 'selectVariacao':
		$arr = array("filtro"=>true);

		$where = " where idprato = $_POST[idprato]";
		$controllerATENDIMENTO = new controllerATENDIMENTO('selectVariacao',$arr,$where);

		$strJSON = json_encode('{"rows":'.json_encode($controllerATENDIMENTO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'deleteAtendente':
		$arr = array("idatendente"=>$_POST["idatendente"],"habilitado"=>'N');
		$controllerATENDENTE = new controllerATENDENTE('delete',$arr);
		echo $controllerATENDENTE->resposta;
	break;
	case 'selectBebidaTrue':
		$arrMes = array("false"=>"Sem bebida","true"=>"Com bebida");
		$strMes = "";
		$strMes .= "<option value=''>Selecione uma opção</option>";

		foreach($arrMes as $key => $value)
		{
			$strMes .= "<option value='".($key)."'>".$value."</option>";
		}
		echo utf8_encode($strMes);
	break;*/
	default:
}
?>