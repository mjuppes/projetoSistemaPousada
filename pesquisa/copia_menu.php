<?php session_start(); ?>
<?php include('../CONFIG/config.php');?>
<?php include('../'.DIR_DAO);?>
<?php include('../'.DIR_ACTIONS.'genericFunction.php');?>
<?php include('../'.DIR_CLASSES.'controllerCANCELAMENTO.php');?>
<?php include('../'.DIR_CLASSES.'controllerPRECOQUARTO.php');?>
<?php include('../'.DIR_CLASSES.'controllerMOVESTOQUE.php');?>
<?php include('../'.DIR_CLASSES.'controllerCATEGORIA.php');?>
<?php include('../'.DIR_CLASSES.'controllerPAGAMENTO.php');?>
<?php include('../'.DIR_CLASSES.'controllerPRODUTOS.php');?>
<?php include('../'.DIR_CLASSES.'controllerHOSPCONF.php');?>
<?php include('../'.DIR_CLASSES.'controllerDESCONTO.php');?>
<?php include('../'.DIR_CLASSES.'controllerAGENCIA.php');?>
<?php include('../'.DIR_CLASSES.'controllerESTOQUE.php');?>
<?php include('../'.DIR_CLASSES.'controllerEMPRESA.php');?>
<?php include('../'.DIR_CLASSES.'controllerHOSPEDE.php');?>
<?php include('../'.DIR_CLASSES.'controllerRESERVA.php');?>
<?php include('../'.DIR_CLASSES.'controllerQUARTO.php');?>
<?php include('../'.DIR_CLASSES.'controllerESTADO.php');?>
<?php include('../'.DIR_CLASSES.'controllerCIDADE.php');?>
<?php include('../'.DIR_CLASSES.'controllerCARTAO.php');?>
<?php include('../'.DIR_CLASSES.'controllerVENDA.php');?>
<?php include('../'.DIR_CLASSES.'controllerPAIS.php');?>
<?php include('../'.DIR_CLASSES.'controllerUSUARIO.php');?>

<?php

if(isset($_POST["numRows"]) && isset($_POST["numPage"]))
{
	$_SESSION['numRows'] = $_POST["numRows"];
	$_SESSION['numPage'] = $_POST["numPage"];
}

switch($_POST['controller'])
{
	case 'selectValorQuarto':
		$where = "where idquarto = ".$_POST["id"];

		$arr= array("filtro"=>true);
		$controllerPRECOQUARTO = new controllerPRECOQUARTO('select',$arr,$where);

		$str = "";
		$str .= "<option value=''>".utf8_encode("-- Selecione --")."</option>";

		if(empty($controllerPRECOQUARTO->arrResposta))
		{
			$str .= "<option value=''>-------------------</option>";
			echo $str;
			return false;
		}

		foreach($controllerPRECOQUARTO->arrResposta as $dados)
		{
			if(isset($_POST['id2']))
			{
				if($_POST['id2'] == $dados['idpreco'])
					$str .= "<option SELECTED value='".($dados['idpreco'])."' >".$dados['valor']."</option>";
				else
					$str .= "<option value='".($dados['idpreco'])."' >".$dados['valor']."</option>";
			}
			else 
				$str .= "<option value='".($dados['idpreco'])."' >".$dados['valor']."</option>";
		}
		echo utf8_encode($str);
	break;
	case 'cadastroPreco':
		$arr = array("idquarto"=>$_POST["formSelectQuarto"],
					"valor"=>formatValor($_POST["formValor"]));

		$controllerPRECOQUARTO = new controllerPRECOQUARTO('verificaValor',$arr);
		if($controllerPRECOQUARTO->arrResposta)
		{
			echo '4';
			return false;
		}

		$controllerPRECOQUARTO = new controllerPRECOQUARTO('insert',$arr);
		echo $controllerPRECOQUARTO->resposta;
	break;
	case 'cadastroQuarto':
		$arrItens = array();
		$arrItens = explode(",",$_POST['arrItens']);

		$strIten = "";
		foreach($arrItens as $key => $value)
		{
			if(empty($strIten))
				$strIten .= $value;
			else
				$strIten .= "|".$value;
		}

		$arr = array("nomequarto"=>$_POST["formNomeQuarto"],
					"localizacao"=>utf8_decode($_POST["formLocalizacao"]),
					"qtdvaga"=>$_POST["formQtdVaga"],
					"itens"=>$strIten);

		$controllerQUARTO = new controllerQUARTO('insert',$arr);
		echo $controllerQUARTO->resposta;
	break;
	case 'selectCategoria':
		$controllerCATEGORIA = new controllerCATEGORIA('select');
		$strCategoria = "";
		$strCategoria .= "<option value=''>".("-- Selecione --")."</option>";

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
		echo ($strCategoria);
	break;
	case 'selectEmpresa':
		$controllerEMPRESA = new controllerEMPRESA('selectEmpresa');
		$strCategoria = "";
		$strCategoria .= "<option value=''>".utf8_encode("-- Selecione --")."</option>";

		if(empty($controllerEMPRESA->arrResposta))
			return false;

		foreach($controllerEMPRESA->arrResposta as $dados)
		{
			if(isset($_POST['id']))
			{
				if($_POST['id'] == $dados['idempresa'])
					$strCategoria .= "<option SELECTED value='".($dados['idempresa'])."' >".$dados['nomeempresa']."</option>";
				else
					$strCategoria .= "<option value='".($dados['idempresa'])."' >".$dados['nomeempresa']."</option>";
			}
			else 
				$strCategoria .= "<option value='".($dados['idempresa'])."' >".$dados['nomeempresa']."</option>";
		}
		echo utf8_encode($strCategoria);
	break;
	case 'selectQuartos':
		$controllerQUARTO = new controllerQUARTO('selectQuartos');
		for($i=0; $i<count($controllerQUARTO->arrResposta); $i++)
		{
			$controllerQUARTO->arrResposta[$i]['localizacao'] = utf8_encode($controllerQUARTO->arrResposta[$i]['localizacao']);
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerQUARTO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectQuartosCombo':
		$where = ' where status is null ';
		$controllerQUARTO = new controllerQUARTO('selectQuartos');
		echo selectCombo("-- Selecione --",$controllerQUARTO->arrResposta,true,$_POST['id'],"idquarto","nomequarto");
	break;
	case 'selectHospedeGeral':
		$where = "";

		if(isset($_POST['formSelectEstado']) && !empty($_POST['formSelectEstado']))
		{
			if(empty($where))
				$where .= " e.idestado=".$_POST['formSelectEstado'];
			else
				$where .= " and e.idestado=".$_POST['formSelectEstado'];
		}

		if(isset($_POST['formSelectCidade']) && !empty($_POST['formSelectCidade']))
		{
			if(empty($where))
				$where .= " c.idcidade=".$_POST['formSelectCidade'];
			else
				$where .= " and c.idcidade=".$_POST['formSelectCidade'];
		}

		if(isset($_POST['formSelectEmpresa']) && !empty($_POST['formSelectEmpresa']))
		{
			if(empty($where))
				$where .= " emp.idempresa =".$_POST['formSelectEmpresa'];
			else
				$where .= " and emp.idempresa =".$_POST['formSelectEmpresa'];
		}

		if(isset($_POST['formSelectSexo']) && !empty($_POST['formSelectSexo']))
		{
			if(empty($where))
				$where .= " h.sexo='".$_POST['formSelectSexo']."'";
			else
				$where .= " and h.sexo= '".$_POST['formSelectSexo']."'";
		}

		if(isset($_POST['formNome']) && !empty($_POST['formNome']))
		{
			if(empty($where))
				$where .= " h.nome  like'%".$_POST['formNome']."%'";
			else
				$where .= " and  h.nome  like'%".$_POST['formNome']."%'";
		}

		if(isset($_POST['formDtInicial']) && !empty($_POST['formDtInicial']) && isset($_POST['formDtFinal']) && !empty($_POST['formDtFinal']))
		{
			if(empty($where))
				$where .= " h.datahoje BETWEEN '".formatDate($_POST['formDtInicial'])."' and '".formatDate($_POST['formDtFinal'])."'";
			else
				$where .= " and  h.datahoje BETWEEN '".formatDate($_POST['formDtInicial'])."' and '".formatDate($_POST['formDtFinal'])."'";
		}

		if(!empty($where))
			$controllerHOSPEDE = new controllerHOSPEDE('selectHospedeGeral',false,$where);
		else
			$controllerHOSPEDE = new controllerHOSPEDE('selectHospedeGeral');



		if(empty($controllerHOSPEDE->arrResposta))
		{
			echo "0";
			return false;
		}

		for($i=0; $i<count($controllerHOSPEDE->arrResposta); $i++)
		{
			$controllerHOSPEDE->arrResposta[$i]['nome'] = utf8_encode($controllerHOSPEDE->arrResposta[$i]['nome']);
			$controllerHOSPEDE->arrResposta[$i]['nomeestado'] = utf8_encode($controllerHOSPEDE->arrResposta[$i]['nomeestado']);
			$controllerHOSPEDE->arrResposta[$i]['nomecidade'] = utf8_encode($controllerHOSPEDE->arrResposta[$i]['nomecidade']);
		}

		$strJSON = json_encode('{"rows":'.json_encode($controllerHOSPEDE->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectHospedeGeralCombo':
		$controllerHOSPEDE = new controllerHOSPEDE('selectHospedeGeral');
		echo selectCombo("-- Selecione --",$controllerHOSPEDE->arrResposta,true,$_POST['id'],"idhospede","nome");
	break;
	case 'selectDadosHospede':
		$arr = array("idhospede"=>$_POST["idhospede"]);
		$controllerHOSPEDE = new controllerHOSPEDE('selectDadosJson',$arr);
		echo $controllerHOSPEDE->resposta;
	break;
	case 'selectReserva':
		$where = "";

		if(isset($_POST['formSelectQuarto']) && !empty($_POST['formSelectQuarto']))
		{
			if(empty($where))
				$where .= " r.idquarto=".$_POST['formSelectQuarto'];
			else
				$where .= " and r.idquarto=".$_POST['formSelectQuarto'];
		}

		if(isset($_POST['formNome']) && !empty($_POST['formNome']))
		{
			if(empty($where))
				$where .= " h.nome  like'%".$_POST['formNome']."%'";
			else
				$where .= " and  h.nome  like'%".$_POST['formNome']."%'";
		}

		if(isset($_POST['formDtInicial']) && !empty($_POST['formDtInicial']) && isset($_POST['formDtFinal']) && !empty($_POST['formDtFinal']))
		{
			if(empty($where))
				$where .= " r.datainicial BETWEEN '".formatDate($_POST['formDtInicial'])."' and   '".formatDate($_POST['formDtFinal'])."'";
			else
				$where .= " and  r.datafinal BETWEEN '".formatDate($_POST['formDtInicial'])."' and '".formatDate($_POST['formDtFinal'])."'";
		}

		if(!empty($where))
			$controllerRESERVA = new controllerRESERVA('selectReserva',false,$where);
		else
		{
			if(isset($_POST['id']))
			{
				$arr = array("idquarto"=>$_POST['id']);
				$controllerRESERVA = new controllerRESERVA('selectReserva',$arr);
			}
			else
				$controllerRESERVA = new controllerRESERVA('selectReserva');
		}

		if(empty($controllerRESERVA->arrResposta))
		{
			echo "0";
			return false;
		}
		else
		{
			for($i=0; $i<count($controllerRESERVA->arrResposta); $i++)
			{
				$controllerRESERVA->arrResposta[$i]['nomehospede'] = utf8_encode($controllerRESERVA->arrResposta[$i]['nomehospede']);
			}
			$strJSON = json_encode('{"rows":'.json_encode($controllerRESERVA->arrResposta)."}");
			echo($strJSON);
		}
	break;
	case 'selectQuartoCombo':
		$where = ' where status is null ';
		$controllerQUARTO = new controllerQUARTO('selectQuartos',false,$where);
		echo selectCombo("-- Selecione --",$controllerQUARTO->arrResposta,true,$_POST['id'],"idquarto","nomequarto");
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
	case 'selectHospedeGeralCombo':
		$controllerHOSPEDE = new controllerHOSPEDE('selectHospedeGeral');
		echo selectCombo("-- Selecione --",$controllerQUARTO->arrResposta,true,$_POST['id'],"idhospede","nome");
		return;
	break;
	case 'selectDisponibilidade':
		$arrDisponibilidade = array("1"=>"Disponível","0"=>"Indisponível");
		echo selectCombo("-- Selecione -- ",$arrDisponibilidade,false,$_POST['id']);
	break;
	case 'selectMotivoCombo':
		$arrMotivo = array("Turismo"=>"1","Trabalho"=>"2","Congresso"=>"3","Outro"=>"4");
		echo selectCombo("-- Selecione --",$arrMotivo,false,$_POST['id'],false,false,false);
	break;	
	case 'cadastroHospede':
		$dataHoje = date("d/m/Y");
		$arr = array("opcao"=>$_POST["opcao"],
					"nome"=>utf8_decode($_POST["formNome"]),
					"sexo"=>$_POST["formSelectSexo"],
					"cpf"=>$_POST["formCpf"],
					"rg"=>$_POST["formRg"],
					"idestado"=>$_POST["formSelectEstado"],
					"idcidade"=>$_POST["formSelectCidade"],
					"email"=>$_POST["formEmail"],
					"passaporte"=>$_POST["formPassaporte"],
					"telefone"=>$_POST["formTelefone"],
					"telefone2"=>$_POST["formTelefone2"],
					"telefone3"=>$_POST["formTelefone3"],
					"endereco"=>$_POST["formEndereco"],
					"rne"=>$_POST["formRNE"],
					"datahoje"=>formatDate($dataHoje),
					"idpais"=>$_POST["formSelectPais"],
					"cep"=>$_POST["formCep"],
					"bairro"=>$_POST["formBairro"],
					"datachegada"=>formatDate(date("d/m/Y")),
					"idmotivo"=>$_POST["formSelectMotivo"],
					"datanascimento"=>formatDate($_POST["formDtaNascimento"]));

		if(isset($_POST["formSelectEmpresa"]) && !empty($_POST["formSelectEmpresa"]))
			$arr["idempresa"] = $_POST["formSelectEmpresa"];

		if(isset($_POST["formSelectAgencia"]) && !empty($_POST["formSelectAgencia"]))
			$arr["idagencia"] = $_POST["formSelectAgencia"];

		if(!isset($_POST['formIdLastHosp']) || empty($_POST['formIdLastHosp']))
		{
			$controllerHOSPEDE = new controllerHOSPEDE('insert',$arr);
			if($controllerHOSPEDE->resposta == 1)
				echo "1";
			else
				echo "Error3";
		}
		else
		{
			$controllerHOSPEDE = new controllerHOSPEDE('insert_last_id',$arr);
			echo $controllerHOSPEDE->arrResposta[0]['last_id'];
		}
		return;
	break;
	case 'cadastroEmpresa':
		$arr = array("nomeempresa"=>$_POST['formEmpresa']
					,"cnpj"=>$_POST['formCnpj']
					,"telefone"=>$_POST['formTelefone']
					,"endereco"=>$_POST['formEndereco']
					,"inscricaoest"=>$_POST['formIE']);

		if(isset($_POST['formFax']) && !empty($_POST['formFax']))
			$arr["fax"] = $_POST['formFax'];

		$controllerEMPRESA = new controllerEMPRESA('insert',$arr);

		if(isset($_POST['form']) && !empty($_POST['form']) && $_POST['form'])
		{
			if($controllerEMPRESA->resposta == 1)
				echo $controllerEMPRESA->resposta;
			else
				echo "Error3";
		}
		else
		{
			if($controllerEMPRESA->resposta == 1)
			{
				$controllerEMPRESA = new controllerEMPRESA('lastIdempresa');
				echo $controllerEMPRESA->resposta;
			}
			else
				echo "Error3";
		}
	break;
	case 'updateEmpresa':
		$arr = array("nomeempresa"=>$_POST['formEmpresa']
					,"cnpj"=>$_POST['formCnpj']
					,"telefone"=>$_POST['formTelefone']
					,"endereco"=>$_POST['formEndereco']
					,"inscricaoest"=>$_POST['formIE']);

		if(isset($_POST['formFax']) && !empty($_POST['formFax']))
			$arr["fax"] = $_POST['formFax'];

		$arr["idempresa"] = $_POST['formIdEmpresa'];

		$controllerEMPRESA = new controllerEMPRESA('update',$arr);

		if($controllerEMPRESA->resposta == 1)
			echo $controllerEMPRESA->resposta;
		else
			echo "Error3";
	break;
	case 'selectEmpresa':
		$controllerEMPRESA = new controllerEMPRESA('selectEmpresa');
		echo selectCombo("-- Selecione --",$controllerEMPRESA->arrResposta,true,$_POST['id'],"idempresa","nomeempresa");
	break;
	case 'selectEmpresaTable':

		$where = "";

		if(isset($_POST['formNomeEmpresa']) && !empty($_POST['formNomeEmpresa']))
			$where .= "  nomeempresa like '%".$_POST['formNomeEmpresa']."%'";

		if(!empty($where))
			$controllerEMPRESA = new controllerEMPRESA('selectEmpresa',false,$where);
		else
			$controllerEMPRESA = new controllerEMPRESA('selectEmpresa');

		if(empty($controllerEMPRESA->arrResposta))
		{
			echo "0";
			return false;
		}

		for($i=0; $i<count($controllerEMPRESA->arrResposta); $i++)
		{
			$controllerEMPRESA->arrResposta[$i]['nomeempresa'] = utf8_encode($controllerEMPRESA->arrResposta[$i]['nomeempresa']);
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerEMPRESA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'cadastroReserva':
		if(isset($_POST['formSelectHospede']))
		{
			$arr = array("idhospede" => $_POST['formSelectHospede'],
						"idquarto"=>$_POST['formSelectQuarto'],
						"datainicial"=>formatDate($_POST['formDtInicial']),
						"datafinal"=>formatDate($_POST['formDtFinal']),
						"idpreco"=>trim($_POST['formSelectValor']),
						"opcao"=>$_POST['formSelectOpcaoQuarto'],
						"idpagamento"=>$_POST['formSelectTipoPagamento'],
						"tipopagamento"=>$_POST['tipopagamento'],
						"observacao"=>utf8_decode($_POST['formObservacao']));
		}
		else
		{
			$arr = array("idquarto"=>$_POST['formSelectQuarto'],
						 "datainicial"=>formatDate($_POST['formDtInicial']),
						 "datafinal"=>formatDate($_POST['formDtFinal']),
						 "idhospede"=>trim($_POST['idlasthosp']),
						 "idpreco"=>trim($_POST['formSelectValor']),
						 "opcao"=>$_POST['formSelectOpcaoQuarto'],
						 "idpagamento"=>$_POST['formSelectTipoPagamento'],
						 "tipopagamento"=>$_POST['tipopagamento'],
						 "observacao"=>utf8_decode($_POST['formObservacao']));
		}

		$controllerRESERVA = new controllerRESERVA('insert',$arr);
		echo   $controllerRESERVA->resposta;
		return;
		$controllerQUARTO = new controllerQUARTO('verificaVaga',$arr);
		if($controllerQUARTO->resposta)
			$flag = 1;
		else
		{
			echo "4";
			return;
		}

		$controllerRESERVA = new controllerRESERVA('verificaPeriodo',$arr);

		if($controllerRESERVA->resposta != "0" && $flag==1)
		{
			$controllerRESERVA = new controllerRESERVA('insert',$arr);

			if(isset($_POST['formCartao']) && $controllerRESERVA->resposta == 1)
			{
				$controllerRESERVA = new controllerRESERVA('lastIdreserva');
				$idreserva = $controllerRESERVA->resposta;

				$arr = array();
				$arr["numerocartao"] = $_POST['formCartao'];
				$arr["idreserva"] = $idreserva;

				$controllerCARTAO = new controllerCARTAO('insert',$arr);
				echo $controllerCARTAO->resposta;
			}
			else
			{
				echo   $controllerRESERVA->resposta;
			}
			return;
		}

		if($controllerRESERVA->resposta == "0")
		{
			$controllerRESERVA = new controllerRESERVA('insert',$arr);
			
			if(isset($_POST['formCartao']) && $controllerRESERVA->resposta == 1)
			{
			
				$controllerRESERVA = new controllerRESERVA('lastIdreserva');
				$idreserva = $controllerRESERVA->resposta;

				$arr = array();
				$arr["numerocartao"] = $_POST['formCartao'];
				$arr["idreserva"] = $idreserva;

				$controllerCARTAO = new controllerCARTAO('insert',$arr);
				echo $controllerCARTAO->resposta;
			}
			else
				echo $controllerRESERVA->resposta;
			return;
		}
		else
			echo "8";
		break;
	case 'selectHospede':
		$controllerHOSPEDE = new controllerHOSPEDE('selectHospede');
		echo selectCombo("-- Selecione --",$controllerHOSPEDE->arrResposta,true,$_POST['id'],"idhospede","nome");
	break;
	case 'selectSexo':
		$arrSexo = array("Masculino"=>"M","Feminino"=>"F");
		echo selectCombo("-- Selecione --",$arrSexo,false,$_POST['id']);
	break;
	case 'selectProdutos':

		if(isset($_POST['id']))
		{
			$where =" c.idcategoria = $_POST[id]";
			$controllerPRODUTOS = new controllerPRODUTOS('select',false,$where);
		}
		else
			$controllerPRODUTOS = new controllerPRODUTOS('select');

		echo selectCombo("-- Selecione --",$controllerPRODUTOS->arrResposta,true,$_POST['id2'],"idproduto","nomeproduto");
	break;
	case 'updateReserva':
		$arr = array("idquarto"=>$_POST["formSelectQuarto"],
					"datainicial"=>formatDate($_POST["formDtInicial"]),
					"datafinal"=>formatDate($_POST["formDtFinal"]),
					"idreserva"=>$_POST["formIdReserva"],
					"idpreco"=>$_POST["formSelectValor"],
					"opcao"=>$_POST["formSelectOpcaoQuarto"],
					"tipopagamento"=>$_POST['tipopagamento'],
					"observacao"=>utf8_decode($_POST['formObservacao']));
		
		$controllerQUARTO = new controllerQUARTO('verificaVaga',$arr);

		if(!$controllerQUARTO->resposta)
		{
			echo "4";
			return;
		}

		$arrHC = array("idreserva"=>$_POST["formIdReserva"],"datainicial"=>formatDate($_POST["formDtInicial"]));
		$controllerHOSPCONF = new controllerHOSPCONF('update',$arrHC);

		if($controllerHOSPCONF->resposta == 1)
		{
			$controllerRESERVA = new controllerRESERVA('update',$arr);
			echo $controllerRESERVA->resposta;
		}
		else
			echo "Erro";
	break;
	case 'updateQuarto':
		$arrItens = array();
		$arrItens = explode(",",$_POST['arrItens']);

		$strIten = "";
		foreach($arrItens as $key => $value)
		{
			if(empty($strIten))
				$strIten .= $value;
			else
				$strIten .= "|".$value;
		}

		$arr = array("nomequarto"=>$_POST["formNomeQuarto"],
					"localizacao"=>utf8_decode($_POST["formLocalizacao"]),
					"qtdvaga"=>$_POST["formQtdVaga"],
					"itens"=>$strIten,
					"idquarto"=>$_POST["formIdQuarto"]);

		if(isset($_POST['manutencao']) && $_POST['manutencao'] == "S")
		{
			$arr['status'] = $_POST['manutencao'];
			$arr['datainicial'] = $_POST['formDtInicial'];
			$arr['datafinal'] =$_POST['formDtFinal'];
		}
		else
		{
			$arr['status'] 		= "";
			$arr['datainicial'] = "";
			$arr['datafinal'] 	= "";
		}

		$controllerQUARTO = new controllerQUARTO('update',$arr);
		echo $controllerQUARTO->resposta;
	break;
	case 'deleteQuarto':
		$arr = array("idquarto"=>$_POST["idquarto"]);
		$controllerQUARTO = new controllerQUARTO('delete',$arr);
		if($controllerQUARTO->resposta == "1")
			echo $controllerQUARTO->resposta;
		else
			echo "erro!";
	break;
	case 'deleteEmpresa':
		$arr = array("idempresa"=>$_POST["idempresa"]);
		
		$controllerEMPRESA = new controllerEMPRESA('delete',$arr);
		if($controllerEMPRESA->resposta == "1")
			echo $controllerEMPRESA->resposta;
		else
			echo "erro!";
	break;
	case 'deleteReserva':
		$arr = array("idreserva"=>$_POST["idreserva"]);
		$controllerRESERVA = new controllerRESERVA('verificaDesconto',$arr);

		if($controllerRESERVA->resposta == "false") //Verifica se a reserva tem desconto 11/06/2014 10:06
		{
			$controllerPAGAMENTO = new controllerPAGAMENTO('verificaPendencia',$arr);

			if($controllerPAGAMENTO->resposta == "true")
			{
				echo 4;	//Caso de pendência não pagamento total das diárias 12/05/2014 10:09
				return false;
			}
		}

		$controllerRESERVA = new controllerRESERVA('delete',$arr);
		echo $controllerRESERVA->resposta;
	break;
	case 'selectOpcaoQuarto':
		$strOpcaoQuarto = "";
		$strOpcaoQuarto .= "<option value=''>".("-- Selecione --")."</option>";

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
		if(empty($controllerRESERVA->arrResposta))
		{
			echo "0";
			return false;
		}

		for($i=0; $i<count($controllerRESERVA->arrResposta); $i++)
		{
			$controllerRESERVA->arrResposta[$i]['nome'] = utf8_encode($controllerRESERVA->arrResposta[$i]['nome']);
			$controllerRESERVA->arrResposta[$i]['nomeempresa'] = utf8_encode($controllerRESERVA->arrResposta[$i]['nomeempresa']);
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerRESERVA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectCancelamento':
		$where = "";

		if(isset($_POST["formNomeCancelamento"]) && !empty($_POST["formNomeCancelamento"]))
			$where .= " and h.nome like '%".$_POST["formNomeCancelamento"]."%'";

		if(isset($_POST["formSelectQuartoCancelamento"]) && !empty($_POST["formSelectQuartoCancelamento"]))
			$where .= " and q.idquarto = ".$_POST["formSelectQuartoCancelamento"]."";

		if(!empty($where))
			$controllerCANCELAMENTO = new controllerCANCELAMENTO('select',false,$where);
		else
			$controllerCANCELAMENTO = new controllerCANCELAMENTO('select');

		if(empty($controllerCANCELAMENTO->arrResposta))
		{
			echo "0";
			return false;
		}

		for($i=0; $i<count($controllerCANCELAMENTO->arrResposta); $i++)
		{
			$controllerCANCELAMENTO->arrResposta[$i]['nomehospede'] = utf8_encode($controllerCANCELAMENTO->arrResposta[$i]['nomehospede']);
			$controllerCANCELAMENTO->arrResposta[$i]['nomequarto'] = utf8_encode($controllerCANCELAMENTO->arrResposta[$i]['nomequarto']);
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerCANCELAMENTO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'cadastroVenda':
		$arr = array("idcategoria"=>$_POST["formSelectCategoria"],
					"idproduto"=>$_POST["formSelectProduto"],
					"idhospede"=>$_POST["formSelectHospede"],
					"idtipo"=>$_POST["opcao"],
					"quantidade"=>$_POST["formQuantidade"],
					"datavenda"=>formatDate($_POST["formDta"]));

		$controllerESTOQUE = new controllerESTOQUE('verificarEstoque',$arr);

		if($controllerESTOQUE->resposta == "S")
		{
			$controllerESTOQUE = new controllerESTOQUE('verificarEstoqueQtd',$arr);
			if($controllerESTOQUE->resposta <= 0)
			{
				/**
					@Regra se caso não tenha o produto em estoque 
					 informe q está em falta 
				**/
				echo "88";
			}
			else
			{
				if($_POST["formQuantidade"] > $controllerESTOQUE->resposta)
				{
					echo "77";
					return;
				}
				else
				{
					$dataHoje = date("d/m/Y");

					$arrM = array("idproduto"=>$_POST["formSelectProduto"],
								  "data"=>formatDate($dataHoje),
								  "unidade"=>$_POST["formQuantidade"]);
					

					$controllerMOVESTOQUE = new controllerMOVESTOQUE('insert',$arrM);
					if($controllerMOVESTOQUE->resposta == 1)
					{
						$qtd = ($controllerESTOQUE->resposta - $_POST["formQuantidade"]);
						$arrE = array("idproduto"=>$_POST["formSelectProduto"],
									"quantidade"=>$qtd);

						$controllerESTOQUE = new controllerESTOQUE('update',$arrE);
						if($controllerESTOQUE->resposta == 1)
						{
							$controllerVENDA = new controllerVENDA('insert',$arr);

							if($controllerVENDA->resposta == 1)
								echo $controllerVENDA->resposta;
							else
							{
								echo "8";
							}
						}
					}
					else
					{
						echo "99";
					}
				}
			}
		}
		else
		{
			$controllerVENDA = new controllerVENDA('insert',$arr);

			if($controllerVENDA->resposta == 1)
				echo $controllerVENDA->resposta;
			else
			{
				echo "8";
			}
		}
	break;
	case 'selectHistoricoHospede':
		$arr = array("idhospede"=>$_POST['id']);
		$controllerHOSPEDE = new controllerHOSPEDE('selectHistoricoHospede',$arr);

		
		if(empty($controllerHOSPEDE->arrResposta))
		{
			echo "0";
			return false;
		}
		
		for($i=0; $i<count($controllerHOSPEDE->arrResposta); $i++)
		{
			$controllerHOSPEDE->arrResposta[$i]['nome'] = utf8_encode($controllerHOSPEDE->arrResposta[$i]['nome']);
		}
		

		$strJSON = json_encode('{"rows":'.json_encode($controllerHOSPEDE->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectHistoricoReserva':
		$arr = array("idhospede"=>$_POST['id']);
		$controllerRESERVA = new controllerRESERVA('selectHistoricoReserva',$arr);

		if(empty($controllerRESERVA->arrResposta))
		{
			echo "0";
			return false;
		}

		for($i=0; $i<count($controllerRESERVA->arrResposta); $i++)
		{
			$controllerRESERVA->arrResposta[$i]['nomequarto'] = utf8_encode($controllerRESERVA->arrResposta[$i]['nomequarto']);
			$controllerRESERVA->arrResposta[$i]['tipopagamento'] = utf8_encode($controllerRESERVA->arrResposta[$i]['tipopagamento']);
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerRESERVA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectHistoricoVenda':
		$arr = array("idhospede"=>$_POST['id']);
		$controllerVENDA = new controllerVENDA('selectHistoricoVenda',$arr);
		if(empty($controllerVENDA->arrResposta))
		{
			echo "0";
			return false;
		}

		for($i=0; $i<count($controllerVENDA->arrResposta); $i++)
		{
			$controllerVENDA->arrResposta[$i]['nomecategoria'] = utf8_encode($controllerVENDA->arrResposta[$i]['nomecategoria']);
			$controllerVENDA->arrResposta[$i]['nomeproduto'] = utf8_encode($controllerVENDA->arrResposta[$i]['nomeproduto']);
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerVENDA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectVendas':
		if(isset($_POST["filtro"]) && $_POST["filtro"] == true)
		{
			$arr = array("filtro"=>true);

			$where = "";
			if(!empty($_POST["formSelectHospede"]))
			{
				$where .= " h.idhospede =  $_POST[formSelectHospede]";
			}
			if(!empty($_POST["formDtInicial"]) &&  !empty($_POST["formDtFinal"]))
			{
				if($where)
					$where .= " and ";

				$where .= " v.datavenda between '".formatDate($_POST[formDtInicial])."' and '".formatDate($_POST[formDtFinal])."'";
			}
			if(!empty($_POST["formDtInicial"]) &&  empty($_POST["formDtFinal"]))
			{
				if($where)
					$where .= " and ";

				$where .= " v.datavenda >= '".formatDate($_POST[formDtInicial])."'";
			}
			if(empty($_POST["formDtInicial"]) &&  !empty($_POST["formDtFinal"]))
			{
				if($where)
					$where .= " and ";

				$where .= " v.datavenda >= '".formatDate($_POST[formDtFinal])."'";
			}

			$where = " where $where ";
			$controllerVENDA = new controllerVENDA('selectVendas',$arr,$where);
		}
		else
			$controllerVENDA = new controllerVENDA('selectVendas');

		if(empty($controllerVENDA->arrResposta))
		{
			echo "0";
			return false;
		}

		for($i=0; $i<count($controllerVENDA->arrResposta); $i++)
		{
			$controllerVENDA->arrResposta[$i]['nomehospede'] = utf8_encode($controllerVENDA->arrResposta[$i]['nomehospede']);
			$controllerVENDA->arrResposta[$i]['nomeproduto'] = utf8_encode($controllerVENDA->arrResposta[$i]['nomeproduto']);
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerVENDA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectDadosVenda':
		$arr = array("idvenda"=>$_POST["idvenda"]);
		$controllerVENDA = new controllerVENDA('selectDadosVenda',$arr);
		echo $controllerVENDA->resposta;
	break;
	case 'selectDadosEmpresa':
		$arr = array("idempresa"=>$_POST["idempresa"]);
		$controllerEMPRESA = new controllerEMPRESA('selectDadosJson',$arr);
		echo $controllerEMPRESA->resposta;
	break;
	case 'updateVenda':
		$arr = array("idcategoria"=>$_POST["formSelectCategoria"],
					"idproduto"=>$_POST["formSelectProduto"],
					"idhospede"=>$_POST["formSelectHospede"],
					"idtipo"=>$_POST["opcao"],
					"datavenda"=>formatDate($_POST["formDta"]),
					"quantidade"=>$_POST["formQuantidade"],
					"idvenda"=>$_POST["formIdVenda"]);

		$controllerVENDA = new controllerVENDA('update',$arr);
		echo $controllerVENDA->resposta;
	break;
	case 'selectVendasReserva':
		$arr=array("idhospede"=>$_POST['idhospede']);
		$controllerRESERVA = new controllerRESERVA('selectVendasReserva',$arr);
		$strJSON = json_encode('{"rows":'.json_encode($controllerRESERVA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectDadosVenda':
		$arr = array("idvenda"=>$_POST["idvenda"]);
		$controllerVENDA = new controllerVENDA('selectDadosJsonVenda',$arr);
		echo $controllerVENDA->resposta;
	break;
	case 'selectEstado':
		if(isset($_POST['id']) && $_POST['id'] != 'undefined')
		{
			$where = "where idpais = ".$_POST['id'];
			$controllerESTADO = new controllerESTADO('selectEstado',false,$where);
		}
		else
			$controllerESTADO = new controllerESTADO('selectEstado');

		echo selectCombo("-- Selecione --",$controllerESTADO->arrResposta,true,$_POST['id'],"idestado","nomeestado",true);
	break;
	case 'selectCidade':
		if(empty($_POST['id']))
			$controllerCIDADE = new controllerCIDADE('selectCidade');
		else
		{
			$where = "where idestado = $_POST[id]";
			$controllerCIDADE = new controllerCIDADE('selectCidade',false,$where);
		}

		echo selectCombo("-- Selecione --",$controllerCIDADE->arrResposta,true,$_POST['id2'],"idcidade","nomecidade");
	break;
	case 'selectTableEstado':
		$controllerESTADO = new controllerESTADO('selectEstado');
		for($i=0; $i<count($controllerESTADO->arrResposta); $i++)
		{
			$controllerESTADO->arrResposta[$i]['nomeestado'] = utf8_encode($controllerESTADO->arrResposta[$i]['nomeestado']);
		}

		$strJSON = json_encode('{"rows":'.json_encode($controllerESTADO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'cadastroEstado':
		$arr = array("idpais"=>$_POST["formSelectPais"],
						"nomeestado"=>utf8_decode($_POST["formNomeEstado"]));
		$controllerESTADO = new controllerESTADO('insert',$arr);
		echo $controllerESTADO->resposta;
	break;
	case 'selectDadosEstado':
		$arr = array("idestado"=>$_POST["idestado"]);
		$controllerESTADO = new controllerESTADO('selectDadosJsonEstado',$arr);
		echo $controllerESTADO->resposta;
	break;
	case 'updateEstado':
		$arr = array("idestado"=>$_POST["formIdEstado"],"nomeestado"=>$_POST['formNomeEstado']);
		$controllerESTADO = new controllerESTADO('update',$arr);
		echo $controllerESTADO->resposta;
	break;
	case 'cadastroCidade':
		$arr = array("idpais"=>$_POST["formSelectPais"],"idestado"=>$_POST["formSelectEstado"],"nomecidade"=>$_POST["formNomeCidade"]);
		$controllerCIDADE = new controllerCIDADE('insert',$arr);
		echo $controllerCIDADE->resposta;
	break;
	case 'updateCidade':
		$arr = array("idestado"=>$_POST["formSelectEstado"],
					 "nomecidade"=>$_POST['formNomeCidade'],
					 "idcidade"=>$_POST['formIdCidade']);

		$controllerCIDADE = new controllerCIDADE('update',$arr);
		echo $controllerCIDADE->resposta;
	break;
	case 'selectDadosCidade':
		$arr = array("idcidade"=>$_POST["idcidade"]);
		$controllerCIDADE = new controllerCIDADE('selectDadosJsonCidade',$arr);
		echo $controllerCIDADE->resposta;
	break;
	case 'selectTableCidade':
		$controllerCIDADE = new controllerCIDADE('selectCidade');
		for($i=0; $i<count($controllerCIDADE->arrResposta); $i++)
		{
			$controllerCIDADE->arrResposta[$i]['nomecidade'] = utf8_encode($controllerCIDADE->arrResposta[$i]['nomecidade']);
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerCIDADE->arrResposta)."}");
		echo($strJSON);
	break;
	case 'deleteCidade':
		$arr = array("idcidade"=>$_POST["idcidade"]);
		$controllerCIDADE = new controllerCIDADE('delete',$arr);
		echo $controllerCIDADE->resposta;
	break;
	case 'deleteVenda':
		$arr = array("idvenda"=>$_POST["idvenda"]);
		$controllerVENDA = new controllerVENDA('delete',$arr);
		echo $controllerVENDA->resposta;
	break;
	case 'deleteEstado':
		$arr = array("idcidade"=>$_POST["idcidade"]);
		$controllerCIDADE = new controllerCIDADE('delete',$arr);
		echo $controllerCIDADE->resposta;
	break;
	case 'updateHospede':
		$arr = array("opcao"=>$_POST["opcao"],
					"nome"=>utf8_decode($_POST["formNome"]),
					"sexo"=>$_POST["formSelectSexo"],
					"cpf"=>$_POST["formCpf"],
					"rg"=>$_POST["formRg"],
					"idestado"=>$_POST["formSelectEstado"],
					"idcidade"=>$_POST["formSelectCidade"],
					"email"=>$_POST["formEmail"],
					"passaporte"=>$_POST["formPassaporte"],
					"telefone"=>$_POST["formTelefone"],
					"endereco"=>$_POST["formEndereco"],
					"rne"=>$_POST["formRNE"],
					"datahoje"=>formatDate($_POST["formDta"]),
					"idhospede"=>$_POST["formIdHospede"],
					"idagencia"=>$_POST["formSelectAgencia"],
					"bairro"=>$_POST["formBairro"],
					"idmotivo"=>$_POST["formSelectMotivo"],
					"datanascimento"=>formatDate($_POST["formDtaNascimento"]));

		if(isset($_POST["formSelectEmpresa"]) && !empty($_POST["formSelectEmpresa"]))
			$arr["idempresa"] = $_POST["formSelectEmpresa"];


		$controllerHOSPEDE = new controllerHOSPEDE('update',$arr);
		echo $controllerHOSPEDE->resposta;
	break;
	case 'cadastroProduto':
		$arr = array("nomeproduto"=>utf8_decode($_POST["formProduto"]),
					"valor"=>formatValor($_POST["formValor"]),
					"idcategoria"=>$_POST["formSelectCategoria"],
					"estoque"=>$_POST["formSelectPE"]);

		$controllerPRODUTOS = new controllerPRODUTOS('insert',$arr);
		echo $controllerPRODUTOS->resposta;
	break;
	case 'selectProdutosTable':
		$where = "";

		if(isset($_POST['formProdutoStr']) && !empty($_POST['formProdutoStr']))
			$where .= "  p.nomeproduto  like'%".$_POST['formProdutoStr']."%'";

		if(isset($_POST['formSelectCategoria']) && !empty($_POST['formSelectCategoria']))
			$where .= "  p.idcategoria = ".$_POST['formSelectCategoria'];


		if(!empty($where))
			$controllerPRODUTOS = new controllerPRODUTOS('select',false,$where);
		else
			$controllerPRODUTOS = new controllerPRODUTOS('select',false,$where);

		if(empty($controllerPRODUTOS->arrResposta))
		{
			echo "0";
			return false;
		}

		for($i=0; $i<count($controllerPRODUTOS->arrResposta); $i++)
		{
			$controllerPRODUTOS->arrResposta[$i]['nomeproduto'] = utf8_encode($controllerPRODUTOS->arrResposta[$i]['nomeproduto']);
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerPRODUTOS->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectDadosProduto':
		$arr = array("idproduto"=>$_POST["idproduto"]);
		$controllerPRODUTOS = new controllerPRODUTOS('selectDadosJson',$arr);
		echo $controllerPRODUTOS->resposta;
	break;
	case 'updateProduto':
		$arr = array("nomeproduto"=>utf8_decode($_POST["formProduto"]),
					"valor"=>formatValor($_POST["formValor"]),
					"idcategoria"=>$_POST["formSelectCategoria"],
					"idproduto"=>$_POST["formIdProduto"],
					"estoque"=>$_POST["formSelectPE"]);

		$controllerPRODUTOS = new controllerPRODUTOS('update',$arr);
		echo $controllerPRODUTOS->resposta;
	break;
	case 'cadastroCategoria':
		$arr = array("nomecategoria"=>$_POST["formCategoria"]);
		$controllerCATEGORIA = new controllerCATEGORIA('insert',$arr);
		echo $controllerCATEGORIA->resposta;
	break;
	case 'selectTableCategoria':
		$controllerCATEGORIA = new controllerCATEGORIA('select');
		$strJSON = json_encode('{"rows":'.json_encode($controllerCATEGORIA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'cadastroAgencia':
		$arr = array("nomeagencia"=>$_POST["formAgencia"],
					"contato"=>utf8_decode($_POST["formContato"]),
					"obs"=>$_POST["formObeservacao"]);

		$controllerAGENCIA = new controllerAGENCIA('insert',$arr);
		echo $controllerAGENCIA->resposta;
	break;
	case 'selectAgencia':
		$controllerAGENCIA = new controllerAGENCIA('select');
		$strJSON = json_encode('{"rows":'.json_encode($controllerAGENCIA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectDadosAgencia':
		$arr = array("idagencia"=>$_POST["idagencia"]);
		$controllerAGENCIA = new controllerAGENCIA('selectDadosJson',$arr);
		echo $controllerAGENCIA->resposta;
	break;
	case 'updateAgencia':
		$arr = array("nomeagencia"=>$_POST["formAgencia"],
					"contato"=>utf8_decode($_POST["formContato"]),
					"obs"=>$_POST["formObeservacao"],
					"idagencia"=>$_POST["formIdAgencia"]);

		$controllerAGENCIA = new controllerAGENCIA('update',$arr);

		if($controllerAGENCIA->resposta == 1)
			echo $controllerAGENCIA->resposta;
		else
			echo "Error3";
	break;
	case 'deleteAgencia':
		$arr = array("idagencia"=>$_POST["idagencia"]);
		$controllerAGENCIA = new controllerAGENCIA('delete',$arr);

		if($controllerAGENCIA->resposta == "1")
			echo $controllerAGENCIA->resposta;
		else
			echo "erro!";
	break;
	case 'selectAgenciaCombo':
		$controllerAGENCIA = new controllerAGENCIA('select');
		echo selectCombo("-- Selecione --",$controllerAGENCIA->arrResposta,true,$_POST['id'],"idagencia","nomeagencia",false);
	break;

	case 'selectTipoPagemento':
			$arrTipoPagamento = array("Cart䯢=>1,"Dinheiro"=>2);
			echo selectCombo("-- Selecione --",$arrTipoPagamento,false,$_POST['id']);
	break;
	case 'selectTablePais':
		$controllerPAIS = new controllerPAIS('select');
		$strJSON = json_encode('{"rows":'.json_encode($controllerPAIS->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectDadosPais':
		$arr = array("idpais"=>$_POST["idpais"]);
		$controllerPAIS = new controllerPAIS('selectDadosJson',$arr);
		echo $controllerPAIS->resposta;
	break;
	case 'cadastroPais':
		$arr = array("nomepais"=>utf8_decode($_POST["formNomePais"]));
		$controllerPAIS = new controllerPAIS('insert',$arr);
		echo $controllerPAIS->resposta;
	break;
	case 'updatePais':
		$arr = array("idpais"=>$_POST["formIdPais"],"nomepais"=>$_POST['formNomePais']);
		$controllerPAIS = new controllerPAIS('update',$arr);
		echo $controllerPAIS->resposta;
	break;
	case 'selectPais':
		$controllerPAIS = new controllerPAIS('select');
		echo selectCombo("-- Selecione --",$controllerPAIS->arrResposta,true,$_POST['id'],"idpais","nomepais");
	break;
	case 'deleteHospede':
		$arr = array("ativo"=>"N","idhospede"=>$_POST["idhospede"]);
		$controllerHOSPEDE = new controllerHOSPEDE('update',$arr);
		echo $controllerHOSPEDE->resposta;
	break;
	case 'deleteProduto':
		$arr = array("idproduto"=>$_POST["idproduto"]);
		$controllerPRODUTOS = new controllerPRODUTOS('delete',$arr);
		echo $_SESSION['sql'];
		return;

		if($controllerPRODUTOS->resposta == "1")
			echo $controllerPRODUTOS->resposta;
		else
			echo "erro!";
	break;
	case 'cadastroPagamento':
		$arr = array("valor"=>formatValor($_POST['formValorPagamento']),
					"idreserva"=>$_POST["formIdReserva"],
					"transferencia"=>$_POST['formSelectTransferencia'],
					"dpatensipado"=>$_POST["formSelecDpAntecipado"],
					"datapagamento"=>formatDate($_POST["formData"]));

		$controllerPAGAMENTO = new controllerPAGAMENTO('insert',$arr);
		echo $controllerPAGAMENTO->resposta;
	break;
	case 'selectTransferencia':
		$arrDisponibilidade = array("Antecipado"=>"1","Caixa"=>"2","Faturamento"=>"3","Faturamento Parcelado"=>"4");
		echo selectCombo("-- Selecione --",$arrDisponibilidade,false,$_POST['id'],false,false,false);
	break;
	case 'selectDpAntecipado':
		$arrDisponibilidade = array("Cartão débito - Visa"=>"1",
									"Cartão débito - Master"=>"2",
									"Cartão de crédito - Visa"=>"4",
									"Cartão de crédito - Master"=>"5",
									"Dinheiro"=>"6",
									"Depósito"=>"7");

		echo selectCombo("-- Selecione --",$arrDisponibilidade,false,$_POST['id'],false,false,false);
	break;
	case 'selectPagamentos':
		$where = "idreserva = ".$_POST['id'];

		$controllerPAGAMENTO = new controllerPAGAMENTO('select',false,$where);
		
		if(empty($controllerPAGAMENTO->arrResposta))
		{
			echo "0";
			return false;
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerPAGAMENTO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectDadosPagamento':
		$arr = array("idpagamento"=>$_POST["idpagamento"]);
		$controllerPAGAMENTO = new controllerPAGAMENTO('selectDadosJson',$arr);
		echo $controllerPAGAMENTO->resposta;
	break;
	case 'updatePagamento':
		$arr = array("idpagamento"=>$_POST["formIdPagamento"],
					"valor"=>formatValor($_POST['formValor']),
					"transferencia"=>$_POST['formSelectTransferencia'],
					"dpatensipado"=>$_POST["formSelecDpAntecipado"],
					"datapagamento"=>formatDate($_POST["formData"]));

		$controllerPAGAMENTO = new controllerPAGAMENTO('update',$arr);
		echo $controllerPAGAMENTO->resposta;
	break;
	case 'deletePagamento':
		$arr = array("idpagamento"=>$_POST["idpagamento"]);
		$controllerPAGAMENTO = new controllerPAGAMENTO('delete',$arr);

		if($controllerPAGAMENTO->resposta == "1")
			echo $controllerPAGAMENTO->resposta;
		else
			echo "erro!";
	break;
	case 'selectTotalPagamentos':
		$where = "idreserva = ".$_POST['id'];

		$controllerPAGAMENTO = new controllerPAGAMENTO('selectTotal',false,$where);
		if(empty($controllerPAGAMENTO->arrResposta))
		{
			echo "0";
			return false;
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerPAGAMENTO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectMotivo':
		$arrMotivoCancelamento = array("Não comparecimento"=>"1","Outro"=>"2");
		echo selectCombo("-- Selecione --",$arrMotivoCancelamento,false,$_POST['id'],false,false,false);
	break;
	case 'cadastroCancelamento':
		$arr = array("motivo"=>$_POST['formSelectMotivo'],
					 "observacao"=>$_POST['formObservacao'],
					"idreserva"=>$_POST["idreserva"]);

		$controllerCANCELAMENTO = new controllerCANCELAMENTO('insert',$arr);
		echo $controllerCANCELAMENTO->resposta;
	break;
	case 'selectAno':
		$arrAno = array("2010","2011","2012","2013","2014","2015","2016","2017","2018","2019","2020");

		$strAno = "";
		$strAno .= "<option value=''>-- Selecione --</option>";

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
		$strMes .= "<option value=''>-- Selecione --</option>";

		foreach($arrMes as $key => $value)
		{
			$strMes .= "<option value='".($value)."'>".$key."</option>";
		}
		echo ($strMes);
	break;
	case 'selectSemana':
		$arrSemana = array('Semana 1'=>1,'Semana 2'=>2,'Semana 3'=>3,
						'Semana 4 '=>4,'Semana 5'=>05);
		
		$strSemana = "";
		$strSemana .= "<option value=''>-- Selecione --</option>";

		foreach($arrSemana as $key => $value)
		{
			$strSemana .= "<option value='".($value)."'>".$key."</option>";
		}
		echo utf8_encode($strSemana);
	break;
	case'montarCalendario':
		if(!isset($_POST['formSelectMes']) && !isset($_POST['formSelectAno']))
		{
			$ano = date("Y");
			$mes = date("m");
			$dia = date("d");

			$_POST['formSelectAno'] = $ano;
			$_POST['formSelectMes'] = $mes;
		}

		//baixo
		if(strlen($_POST['formSelectMes']) == 1)
			$_POST['formSelectMes'] = "0".$_POST['formSelectMes'];

		$Bd = new Bd(CONEXAO);
		$dadosQuarto = array();

	

			
		$strSQL = "	select r.idreserva,r.idquarto,nomequarto, CONVERT(VARCHAR(10),r.datainicial,103) as datainicial ,
					CONVERT(VARCHAR(10),r.datafinal,103) as datafinal, 
					(case 
						when
							(select confirmado from HOSPCONF where idreserva = r.idreserva) is null  then 'R'
						when 
							(select confirmado from HOSPCONF where idreserva = r.idreserva) =  'S' then 'C'
						end 
					)as status
					from RESERVA r
						join QUARTO q on q.idquarto = r.idquarto 
					where
						r.idreserva not in (select idreserva from CANCELAMENTO)
						and month(r.datainicial) = ".$_POST['formSelectMes']."
						and YEAR(r.datainicial) = ".$_POST['formSelectAno'];
						
						if(isset($_POST['formSelectQuarto']) && !empty($_POST['formSelectQuarto']))
							$strSQL .= " and q.idquarto=".$_POST['formSelectQuarto'];
		
		
		$strSQL .= "					union all
						
	select h.idreserva,h.idquarto,nomequarto, CONVERT(VARCHAR(10),h.datainicial,103) as datainicial ,
					CONVERT(VARCHAR(10),h.datafinal,103) as datafinal, 
					(case 
						when
							(select confirmado from HOSPCONF where idreserva = h.idreserva) is null  then 'R'
						when 
							(select confirmado from HOSPCONF where idreserva = h.idreserva) =  'S' then 'C'
						end 
					)as status

					from HISTORICO h
						join QUARTO q on q.idquarto = h.idquarto 
					where
						h.idreserva not in (select idreserva from CANCELAMENTO)
						and month(h.datainicial) = ".$_POST['formSelectMes']."
						and YEAR(h.datainicial) = ".$_POST['formSelectAno'];

		if(isset($_POST['formSelectQuarto']) && !empty($_POST['formSelectQuarto']))
			$strSQL .= " and q.idquarto=".$_POST['formSelectQuarto'];
		
		/*
			@ Avaliar necessidade de opção de sair
			29/12/2015 09:32

			$strSQL .= " union all
						select h.idreserva, h.idquarto,nomequarto,CONVERT(VARCHAR(10),datainicial,103) as datainicial ,
							CONVERT(VARCHAR(10),datafinal,103) as datafinal , 'S' as status from HISTORICO h 
							join QUARTO q on q.idquarto = h.idquarto where h.idreserva
							not in (select idreserva from CANCELAMENTO) 
						and month(datainicial) =  ".$_POST['formSelectMes']." 
						and YEAR(datainicial) = ".$_POST['formSelectAno'];
		*/
			
			
		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		$sqlQUARTO = "
			select q.idquarto,q.nomequarto,q.status,
			CONVERT(VARCHAR(10),q.datainicial,103) as datainicial,
			CONVERT(VARCHAR(10),q.datafinal,103) as datafinal
			 from QUARTO q";

		if(isset($_POST['formSelectQuarto']) && !empty($_POST['formSelectQuarto']))
			$sqlQUARTO .= " where q.idquarto=".$_POST['formSelectQuarto'];

		$dadosQuarto = $Bd->execQuery($sqlQUARTO,true);

		$arrAllQuartos = array();

		foreach($dadosQuarto as $dados)
		{
				if($dados['status'] == 'S')
					$arrAllQuartos[$dados['idquarto']] = $dados['nomequarto']."|".$dados['status']."|".$dados['datainicial']."|".$dados['datafinal'];
				else
					$arrAllQuartos[$dados['idquarto']] = $dados['nomequarto'];
		}

		if(empty($dadosRecordSet))
		{
			echo setDataCalendarioNormal($_POST['formSelectMes'],$_POST['formSelectAno'],$arrAllQuartos);

			/*
				@01/07/2016 retirada a parte da mensagem 14:38

				$str ="<div class='alert' aling='center'   style='width:99%;'>";
				$str .="<div align='center'>";
				$str .="<strong>Aviso!</strong> não existem reservas para este mês!";
				$str .="</div></div>";
				echo $str;
			*/
		}
		else
		{
			$arrIdReservaQuarto = array();
			$arrIdQuarto 		= array();
			$arrNomeQuarto 		= array();
			$arrDataInicial 	= array();
			$arrDataFinal 		= array();
			$arrTipoReserva 	= array();

			foreach($dadosRecordSet as $dados)
			{
					array_push($arrIdQuarto,$dados['idquarto']."|".$dados['idreserva']);

					$arrIdReservaQuarto[$dados['idreserva']] = $dados['idquarto'];
					$arrNomeQuarto[$dados['idquarto']] = $dados['nomequarto'];
					$arrDataInicial[$dados['idreserva']][$dados['idquarto']] = $dados['datainicial'];
					$arrDataFinal[$dados['idreserva']][$dados['idquarto']] = $dados['datafinal'];
					//$arrTipoReserva[$dados['idquarto']] = $dados['status'];
					$arrTipoReserva[$dados['idreserva']] = $dados['status'];
			}

			echo setDataCalendario($arrIdReservaQuarto,$arrIdQuarto,$arrNomeQuarto,$arrDataInicial,$arrDataFinal,$_POST['formSelectMes'],$_POST['formSelectAno'],$_POST['formSelectSemana'],$arrAllQuartos,$arrTipoReserva);
		}
	break;
	case 'descontoReserva':
		$arr = array("idreserva"=>$_POST['idreserva'],"valordesconto"=>formatValor($_POST['valor']));
		$controllerDESCONTO = new controllerDESCONTO('insert',$arr);	
		echo $controllerDESCONTO->resposta;
	break;
	case 'verificaDesconto':
		$arr = array("idreserva"=>$_POST["idreserva"]);
		$controllerRESERVA = new controllerRESERVA('verificaDesconto',$arr);
		echo $controllerRESERVA->resposta;
	break;
	case 'cadastroEstoque':
		$arr = array("idproduto"=>$_POST["formSelectProduto"],
					"quantidade"=>$_POST["formQtd"]);

		$controllerESTOQUE = new controllerESTOQUE('insert',$arr);
		echo $controllerESTOQUE->resposta;
	break;
	case 'selectProdutosEstoque':
		if(isset($_POST['id']))
		{
			$where =" p.idproduto = $_POST[id]";
			$controllerPRODUTOS = new controllerPRODUTOS('select',false,$where);
		}
		else
			$controllerPRODUTOS = new controllerPRODUTOS('selectProdutoEstoque');

		$strCombo = "";
		$strCombo .= "<option value=''>".("-- Selecione --")."</option>";

		if(empty($controllerPRODUTOS->arrResposta))
		{
			$strCombo .= "<option>----------------------------------------</option>";
			echo $strCombo;
			return false;
		}
		foreach($controllerPRODUTOS->arrResposta as $dados)
		{
			if(isset($_POST['id']))
			{
				if($_POST['id'] == $dados['idproduto'])
					$strCombo .= "<option SELECTED value='".($dados['idproduto'])."' >".$dados['nomeproduto']."</option>";
				else
					$strCombo .= "<option value='".($dados['idproduto'])."' >".$dados['nomeproduto']."</option>";
			}
			else 
				$strCombo .= "<option value='".($dados['idproduto'])."' >".$dados['nomeproduto']."</option>";
		}
		echo utf8_encode($strCombo);
	break;
	case 'selectEstoqueTable':
		$controllerESTOQUE = new controllerESTOQUE('select');
		if(empty($controllerESTOQUE->arrResposta))
		{
			echo "0";
			return false;
		}

		for($i=0; $i<count($controllerESTOQUE->arrResposta); $i++)
		{
			$controllerESTOQUE->arrResposta[$i]['nomeproduto'] = utf8_encode($controllerESTOQUE->arrResposta[$i]['nomeproduto']);
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerESTOQUE->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectDadosEstoque':
		$arr = array("idestoque"=>$_POST["idestoque"]);
		$controllerESTOQUE = new controllerESTOQUE('selectDadosJson',$arr);
		echo $controllerESTOQUE->resposta;
	break;
	case 'updateEstoque':
		$arr = array("idestoque"=>$_POST["formIdEstoque"],"quantidade"=>$_POST["formQtd"]);
		$controllerESTOQUE = new controllerESTOQUE('update',$arr);
		echo $controllerESTOQUE->resposta;
	break;
	case 'selectProdutoEstoque':
		$arr = array("Sim"=>"S","Não"=>"N");
		echo selectCombo("-- Selecione --",$arr,false,$_POST['id'],false,false,false);
	break;
	case 'selectDadosCategoria':
		$arr = array("idcategoria"=>$_POST['idcategoria']);
		$controllerCATEGORIA = new controllerCATEGORIA('selectDadosJson',$arr);
		echo $controllerCATEGORIA->resposta;
	break;
	case 'updateCategoria':
		$arr = array("idcategoria"=>$_POST["formIdCategoria"],
					"nomecategoria"=>$_POST["formCategoria"]);

		$controllerCATEGORIA = new controllerCATEGORIA('update',$arr);
		echo $controllerCATEGORIA->resposta;
	break;
	case 'deleteCategoria':
		$arr = array("idcategoria"=>$_POST["idcategoria"]);
		$controllerCATEGORIA = new controllerCATEGORIA('delete',$arr);
		echo $controllerCATEGORIA->resposta;
	break;
	case 'selectTableRelatorioGeral':

		$where = "";
		if(isset($_POST['formSelectHospede']) && !empty($_POST['formSelectHospede']))
		{
			$where .= " t.idhospede =".$_POST['formSelectHospede'];
		}

		if(isset($_POST['formSelectQuarto']) && !empty($_POST['formSelectQuarto']))
		{
			if(empty($where))
				$where .= " t.idquarto =".$_POST['formSelectQuarto'];
			else
				$where .= " and t.idquarto =".$_POST['formSelectQuarto'];
		}

		if(isset($_POST['formDtInicial'])  &&  isset($_POST['formDtFinal']))
		{
			if(empty($where))
			{
				$where = " 
				t.idreserva in(
					select idreserva from RESERVA where 
					(datainicial  between '".formatDate($_POST['formDtInicial'])."'  and '".formatDate($_POST['formDtFinal'])."') and (
					datafinal  between '".formatDate($_POST['formDtInicial'])."' and  '".formatDate($_POST['formDtFinal'])."')
						union all
					select idreserva from HISTORICO where 
					(datainicial  between '".formatDate($_POST['formDtInicial'])."'  and '".formatDate($_POST['formDtFinal'])."') and (
					datafinal  between '".formatDate($_POST['formDtInicial'])."' and  '".formatDate($_POST['formDtFinal'])."')
							)";
			}
			else
			{
				$where = " 
				and 
				 t.idreserva in(
					select idreserva from RESERVA where 
					(datainicial  between '".formatDate($_POST['formDtInicial'])."'  and '".formatDate($_POST['formDtFinal'])."') and (
					datafinal  between '".formatDate($_POST['formDtInicial'])."' and  '".formatDate($_POST['formDtFinal'])."')
						union all
					select idreserva from HISTORICO where 
					(datainicial  between '".formatDate($_POST['formDtInicial'])."'  and '".formatDate($_POST['formDtFinal'])."') and (
					datafinal  between '".formatDate($_POST['formDtInicial'])."' and  '".formatDate($_POST['formDtFinal'])."')
							)";
			}
			
		}

		if(!empty($where))
			$controllerRESERVA = new controllerRESERVA('selectRelatorioGeral', false,$where);
		else
			$controllerRESERVA = new controllerRESERVA('selectRelatorioGeral');

		for($i=0; $i<count($controllerRESERVA->arrResposta); $i++)
		{
			$controllerRESERVA->arrResposta[$i]['nome'] = utf8_encode($controllerRESERVA->arrResposta[$i]['nome']);
			$controllerRESERVA->arrResposta[$i]['nomequarto'] = utf8_encode($controllerRESERVA->arrResposta[$i]['nomequarto']);
		}

		$strJSON = json_encode('{"rows":'.json_encode($controllerRESERVA->arrResposta)."}");
		echo($strJSON);
	break;
	
	case 'selectTableRelatorioGeralTotal':
		$where = "";
		if(isset($_POST['formSelectHospede']) && !empty($_POST['formSelectHospede']))
		{
			$where .= " t.idhospede =".$_POST['formSelectHospede'];
		}

		if(isset($_POST['formSelectQuarto']) && !empty($_POST['formSelectQuarto']))
		{
			if(empty($where))
				$where .= " t.idquarto =".$_POST['formSelectQuarto'];
			else
				$where .= " and t.idquarto =".$_POST['formSelectQuarto'];
		}


		if(isset($_POST['formDtInicial'])  &&  isset($_POST['formDtFinal']))
		{
			if(empty($where))
			{
				$where = " 
				t.idreserva in(
					select idreserva from RESERVA where 
					(datainicial  between '".formatDate($_POST['formDtInicial'])."'  and '".formatDate($_POST['formDtFinal'])."') and (
					datafinal  between '".formatDate($_POST['formDtInicial'])."' and  '".formatDate($_POST['formDtFinal'])."')
						union all
					select idreserva from HISTORICO where 
					(datainicial  between '".formatDate($_POST['formDtInicial'])."'  and '".formatDate($_POST['formDtFinal'])."') and (
					datafinal  between '".formatDate($_POST['formDtInicial'])."' and  '".formatDate($_POST['formDtFinal'])."')
							)";
			}
			else
			{
				$where = " 
				and 
				 t.idreserva in(
					select idreserva from RESERVA where 
					(datainicial  between '".formatDate($_POST['formDtInicial'])."'  and '".formatDate($_POST['formDtFinal'])."') and (
					datafinal  between '".formatDate($_POST['formDtInicial'])."' and  '".formatDate($_POST['formDtFinal'])."')
						union all
					select idreserva from HISTORICO where 
					(datainicial  between '".formatDate($_POST['formDtInicial'])."'  and '".formatDate($_POST['formDtFinal'])."') and (
					datafinal  between '".formatDate($_POST['formDtInicial'])."' and  '".formatDate($_POST['formDtFinal'])."')
							)";
			}
		}

		if(!empty($where))
			$controllerRESERVA = new controllerRESERVA('selectRelatorioGeralTotal', false,$where);
		else
			$controllerRESERVA = new controllerRESERVA('selectRelatorioGeralTotal');
			
		$strJSON = json_encode('{"rows":'.json_encode($controllerRESERVA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'verificaCapacidade':
		$arr = array("idquarto"=>$_POST['formSelectQuarto'],
					"datainicial"=>formatDate($_POST['formDtInicial']),
					"datafinal"=>formatDate($_POST['formDtFinal']));

		$controllerQUARTO = new controllerQUARTO('verificaVagaRetNum',$arr);

		$retMsg = array();
		$retMsg["qtdvaga"] = $controllerQUARTO->resposta;
		echo json_encode($retMsg);
	break;
	case 'selectPrecoQuartoTable':
		$arr = array("idquarto"=>$_POST['id']);
		$controllerPRECOQUARTO = new controllerPRECOQUARTO('select',$arr);
		
		if(empty($controllerPRECOQUARTO->arrResposta))
		{
			echo "0";
			return false;
		}

		for($i=0; $i<count($controllerPRECOQUARTO->arrResposta); $i++)
		{
			$controllerPRECOQUARTO->arrResposta[$i]['nomequarto'] = utf8_encode($controllerPRECOQUARTO->arrResposta[$i]['nomequarto']);
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerPRECOQUARTO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectTableRelatorioDiscriminado':

		$where = "";
		if(isset($_POST['formSelectHospede']) && !empty($_POST['formSelectHospede']))
		{
			$where .= " h.idhospede =".$_POST['formSelectHospede'];
		}

		if(isset($_POST['formSelectQuarto']) && !empty($_POST['formSelectQuarto']))
		{
			if(empty($where))
				$where .= " r.idquarto =".$_POST['formSelectQuarto'];
			else
				$where .= " and r.idquarto =".$_POST['formSelectQuarto'];
		}

		if(isset($_POST['formTipoPagamento']) && !empty($_POST['formTipoPagamento']))
		{
			if(empty($where))
				$where .= " p.transferencia =". $_POST['formTipoPagamento'];
			else
				$where .= " and p.transferencia =". $_POST['formTipoPagamento'];
		}

		if(isset( $_POST['formFormaPagamento']) && !empty( $_POST['formFormaPagamento']))
		{
			if(empty($where))
				$where .= " p.dpatensipado = ".$_POST['formFormaPagamento'];
			else
				$where .= " and p.dpatensipado = ".$_POST['formFormaPagamento'];
		}

		if(isset($_POST['formDtInicial'])  &&  isset($_POST['formDtFinal']))
		{
			if(empty($where))
				$where .= " p.datapagamento between '".formatDate($_POST['formDtInicial'])."'  and '".formatDate($_POST['formDtFinal'])."'";
			else
				$where .= "  and  p.datapagamento between '".formatDate($_POST['formDtInicial'])."'  and '".formatDate($_POST['formDtFinal'])."'";
		}


		$controllerPAGAMENTO = new controllerPAGAMENTO('selectTableRelatorioDiscriminado',false,$where);

		if(empty($controllerPAGAMENTO->arrResposta))
		{
			echo "0";
			return false;
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerPAGAMENTO->arrResposta)."}");
		echo($strJSON);
	break;
	
	case 'selectTableRelatorioDiscriminadoTotal':

		$where = "";
		if(isset($_POST['formSelectHospede']) && !empty($_POST['formSelectHospede']))
		{
			$where .= " h.idhospede =".$_POST['formSelectHospede'];
		}

		if(isset($_POST['formSelectQuarto']) && !empty($_POST['formSelectQuarto']))
		{
			if(empty($where))
				$where .= " r.idquarto =".$_POST['formSelectQuarto'];
			else
				$where .= " and r.idquarto =".$_POST['formSelectQuarto'];
		}

		if(isset($_POST['formTipoPagamento']) && !empty($_POST['formTipoPagamento']))
		{
			if(empty($where))
				$where .= " p.transferencia =". $_POST['formTipoPagamento'];
			else
				$where .= " and p.transferencia =". $_POST['formTipoPagamento'];
		}

		if(isset( $_POST['formFormaPagamento']) && !empty( $_POST['formFormaPagamento']))
		{
			if(empty($where))
				$where .= " p.dpatensipado = ".$_POST['formFormaPagamento'];
			else
				$where .= " and p.dpatensipado = ".$_POST['formFormaPagamento'];
		}

		if(isset($_POST['formDtInicial'])  &&  isset($_POST['formDtFinal']))
		{
			if(empty($where))
				$where .= " p.datapagamento between '".formatDate($_POST['formDtInicial'])."'  and '".formatDate($_POST['formDtFinal'])."'";
			else
				$where .= "  and  p.datapagamento between '".formatDate($_POST['formDtInicial'])."'  and '".formatDate($_POST['formDtFinal'])."'";
		}


		$controllerPAGAMENTO = new controllerPAGAMENTO('selectTableRelatorioDiscriminadoTotal',false,$where);

		if(empty($controllerPAGAMENTO->arrResposta))
		{
			echo "0";
			return false;
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerPAGAMENTO->arrResposta)."}");
		echo($strJSON);
	break;
	
	case 'selectTipoPagementoCombo':
		$arrTipoPagamento = array("Antecipado"=>"1",
								"Caixa"=>"2",
								"Faturamento"=>"3",
								"Faturamento Parcelado"=>"4");

		echo selectCombo("-- Selecione -- ",$arrTipoPagamento,false,$_POST['id']);
	break;
	case 'selectFormaPagamentoCombo':
		$arrFormaPagamento = array("Cart䯠D꣩to - Visa"=>"1",
									"Cart䯠D꣩to - Master"=>"2",
									"Cart䯠Crꥩto - Visa"=>"4",
									"Cart䯠Crꥩto - Master"=>"5",
									"Dinheiro"=>"6");

		echo selectCombo("-- Selecione -- ",$arrFormaPagamento,false,$_POST['id']);
	break;
	case 'selectDescontos':
		$where = " idreserva = ".$_POST['id'];
		$controllerDESCONTO = new controllerDESCONTO('select',false,$where);
		if(empty($controllerDESCONTO->arrResposta))
		{
			echo "0";
			return false;
		}

		$strJSON = json_encode('{"rows":'.json_encode($controllerDESCONTO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'deleteDesconto':
		$arr = array("iddesconto"=>$_POST["iddesconto"]);
		
		$controllerDESCONTO = new controllerDESCONTO('delete',$arr);
		if($controllerDESCONTO->resposta == "1")
			echo $controllerDESCONTO->resposta;
		else
			echo "erro!";
	break;
	case 'verificarCep':
		$resultado_busca = busca_cep("'".$_POST['formCep']."'");

		$ret = array();
		$ret["complemento"]  =  trim(utf8_encode($resultado_busca['tipo_logradouro']."  ".$resultado_busca['logradouro']));
		$ret["uf"] = trim($resultado_busca['uf']);
		$ret["bairro"] = trim(utf8_encode($resultado_busca['bairro']));
		echo json_encode($ret);
	break;
	
	
	
	
	case 'selectTabelPagamentos':
	
		$arrRet = array();
		$where = "idreserva = ".$_POST['idreserva'];

		$controllerPAGAMENTO = new controllerPAGAMENTO('select',false,$where);
		
		foreach($controllerPAGAMENTO->arrResposta as $dados)
		{
			$arrRet['idpagamento'] = $dados['idpagamento'];
            $arrRet['transferencia'] =$dados['transferencia'];
            $arrRet['dpatensipado'] =$dados['dpatensipado'];
            $arrRet['datapagamento'] =$dados['datapagamento'];
            $arrRet['valor'] =$dados['valor'];
            $arrRet['idreserva'] =$dados['idreserva'];
            $arrRet['resp'] = $dados['resp'];
			
		}

		echo json_encode($arrRet);
		return;
		
		if(empty($controllerPAGAMENTO->arrResposta))
		{
			echo "0";
			return false;
		}
		
		$controllerPAGAMENTO = new controllerPAGAMENTO('selectTotal',false,$where);
		if(empty($controllerPAGAMENTO->arrResposta))
		{
			echo "0";
			return false;
		}
		$where = " idreserva = ".$_POST['id'];
		$controllerDESCONTO = new controllerDESCONTO('select',false,$where);
		if(empty($controllerDESCONTO->arrResposta))
		{
			echo "0";
			return false;
		}

		dump($controllerDESCONTO->arrResposta);
		return;
		$strJSON = json_encode('{"rows":'.json_encode($controllerDESCONTO->arrResposta)."}");
		$strJSON .= json_encode('{"rows":'.json_encode($controllerPAGAMENTO->arrResposta)."}");
		$strJSON .= json_encode('{"rows":'.json_encode($controllerPAGAMENTO->arrResposta)."}");
		
		echo $strJSON;
	break;
	case 'montarPainelConfig':
		$where = ' where u.idgrupo = '.$_SESSION['idgrupo'].' and mn.idmenu ='.$_POST['idmenu'];
		$controllerUSUARIO = new controllerUSUARIO('selectMontaPainelAcoes',false,$where);
		$html = '<div class="bs-example" data-example-id="list-group-btns" width="60%">';
		$html .= '<div class="list-group">';
		foreach($controllerUSUARIO->arrResposta as $dados)
		{
				$onclick = 'window.location=\''.$dados['LINK'].'\'"';
				$html .='<p>';
				$html .='<button onclick="'.$onclick.'" type="button" style="text-align:center" class="btn btn-default list-group-item">'.utf8_encode($dados['LABELMENU']).'</button> ';
				$html .='</p>';
		}		
		$html .= '</div>';
		$html .= '</div>';
		echo $html;
	break;
	default:
}
?>