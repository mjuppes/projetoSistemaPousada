<?php 
session_cache_expire(1);
$cache_expire = session_cache_expire();
?>
<?php session_start(); ?>
<?php include('../CONFIG/config.php');?>
<?php include('../'.DIR_INCLUDES);?>
<?php
$retorno = array();

if(isset($_POST["numRows"]) && isset($_POST["numPage"]))
{
	$_SESSION['numRows'] = $_POST["numRows"];
	$_SESSION['numPage'] = $_POST["numPage"];
}

switch($_POST['controller'])
{
	case 'selectValorQuarto':
		$where = "where pc.idquarto = ".$_POST["id"];
		$controllerPRECOQUARTO = new controllerPRECOQUARTO('select',false,$where);
		echo selectCombo("-- Selecione --",$controllerPRECOQUARTO->arrResposta,true,$_POST['id2'],"idpreco","valor");
	break;
	case 'cadastroPreco':
		$arr = array("idquarto"=>$_POST["formSelectQuarto"],
					"valor"=>formatValor($_POST["formValor"]));

		$controllerPRECOQUARTO = new controllerPRECOQUARTO('verificaValor',$arr);
		if(!empty($controllerPRECOQUARTO->arrResposta))
		{
			echo '4';
			return false;
		}
		else
		{
			$controllerPRECOQUARTO = new controllerPRECOQUARTO('insert',$arr);
			echo $controllerPRECOQUARTO->resposta;
		}
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
			$where .= " and r.idquarto=".$_POST['formSelectQuarto'];

		if(isset($_POST['formNome']) && !empty($_POST['formNome']))
			$where .= " and  h.nome  like'%".$_POST['formNome']."%'";

		if(isset($_POST['formDtInicial']) && !empty($_POST['formDtInicial']) && isset($_POST['formDtFinal']) && !empty($_POST['formDtFinal']))
			$where .= " and  r.datafinal BETWEEN '".formatDate($_POST['formDtInicial'])."' and '".formatDate($_POST['formDtFinal'])."'";

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
	case 'updateReserva':
		$arr 				= array();

		$arr['idquarto'] 	= $_POST['formSelectQuarto'];
		$arr['datainicial'] = formatDate($_POST['formDtInicial']);
		$arr['datafinal'] 	= formatDate($_POST['formDtFinal']);
		$arr['idpreco']		= trim($_POST['formSelectValor']);
		$arr['opcao']		= $_POST['formSelectOpcaoQuarto'];
		$arr['tipopagamento'] = $_POST['tipo_pagamento'];
		$arr['observacao']	= utf8_decode($_POST['formObservacao']);

		if(!isset($_POST["formIdReserva"]))
		{
			$controllerRESERVA = new controllerRESERVA('insert_last_id',$arr);
			$id_reserva = $controllerRESERVA->arrResposta[0]['last_id'];

			$arr_insert 	= array();

			$arrIdsHospede 	= explode(",",$_POST['arrIdsHospede']);
			foreach($arrIdsHospede as $key => $id_hospede)
			{
					$arr_insert[$key]['id_reserva'] 	= $id_reserva;
					$arr_insert[$key]['id_hospede']		= $id_hospede;
			}

			$controllerRESERVA_HOSPEDE = new controllerRESERVA_HOSPEDE('insert_massive',$arr_insert);
			echo   $controllerRESERVA_HOSPEDE->resposta;
		}
		else
		{
			/*
				@Caso atualização de Reserva não implementado atualização de hóspede nesse momento,
				pois tenho que validar o escopo 24/05/2018 14:52 
				Author: Marcio Juppes
			*/

			$arr["idreserva"] =$_POST["formIdReserva"];
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
				echo $_SESSION['sql'];
				return;
				echo $controllerRESERVA->resposta;
			}
			else
				echo "Erro";
		}
	break;
	case 'selectHospede':
		if(!isset($_POST['id2']))
			$controllerHOSPEDE = new controllerHOSPEDE('selectHospede');
		else
		{
			$where = " and nome like '%$_POST[id2]%'";
			$controllerHOSPEDE = new controllerHOSPEDE('selectHospede',false,$where);
		}

		echo selectCombo("-- Selecione --",$controllerHOSPEDE->arrResposta,true,$_POST['id'],"idhospede","nome");
	break;
	case 'selectSexo':
		$arrSexo = array("Masculino"=>"M","Feminino"=>"F");
		echo selectCombo("-- Selecione --",$arrSexo,false,$_POST['id']);
	break;
	case 'selectProdutos':

		if(isset($_POST['id']))
		{
			$where =" and c.idcategoria = $_POST[id]";
			$controllerPRODUTOS = new controllerPRODUTOS('select',false,$where);
		}
		else
			$controllerPRODUTOS = new controllerPRODUTOS('select');

		echo selectCombo("-- Selecione --",$controllerPRODUTOS->arrResposta,true,$_POST['id2'],"idproduto","nomeproduto",true);
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

		$arrOpcaoQuarto = array("C"=>"Casal","S"=>"Solteiro","O"=>"Outros");

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
		$idproduto 			= $_POST["formSelectProduto"];

		$where 				= " and idproduto =".$idproduto;
		$controllerPRODUTOS = new controllerPRODUTOS('select',false,$where);
		$estoque			= $controllerPRODUTOS->arrResposta[0]['estoque'];

		$arrIdsHospede  	= explode(",",$_POST['arrIdsHospede']);
		$valor_prod			= $controllerPRODUTOS->arrResposta[0]['valor'];

		if($estoque == 'S')
		{
			$quantidade_venda 	= count($arrIdsHospede);

			$total_venda 		= ($_POST["formQuantidade"] * $quantidade_venda);

			$quantidade_estoque	= $controllerPRODUTOS->arrResposta[0]['quantidade'];

			if(empty($quantidade_estoque))
				$quantidade_estoque = 0;

			

			$novo_saldo 		= ($quantidade_estoque - $total_venda);
			
			if($novo_saldo < 0)
			{
				$retorno["resposta"]  = "0";
				$retorno["msg"]  	  = "Quantidade maior do que a do estoque, valor atual: ".$quantidade;
				echo json_encode($retorno);
				return;
			}
			else
			{
				$arr = array();

				$arr["id_produto"] 			= $idproduto;
				$arr["data_movimentacao"]	= DATE_NOW;
				$arr["tipo_mov"]			= 'S';
				$arr["quantidade"]			= $total_venda;
				$arr["tipo_tab"]			= 'V';
				$arr["valor_atual"]			= formatValor($valor_prod);
				$arr["observacao"]			= 'Movimentação feita por venda!';

				$controllerMOV_ESTOQUE = new controllerMOV_ESTOQUE('insert',$arr);
				if($controllerMOV_ESTOQUE->resposta == "1")
				{
					
					$arr = array();

					$arr["idproduto"]	= $idproduto;
					$arr["quantidade"]	= $novo_saldo;
					

					$controllerPRODUTOS = new controllerPRODUTOS('update',$arr);
					if($controllerPRODUTOS->resposta == "1")
					{
						$valor_total = ($_POST["formQuantidade"] * formatValor($valor_prod));

						$arr_insert 	= array();

						foreach($arrIdsHospede as $key => $idhospede)
						{
								$arr_insert[$key]['idhospede'] 	 	 = $idhospede;
								$arr_insert[$key]['idcategoria'] 	 = $_POST["formSelectCategoria"];
								$arr_insert[$key]['idproduto'] 		 = $_POST["formSelectProduto"];
								$arr_insert[$key]['idtipo']			 = $_POST["opcao"];
								
								if($_POST["opcao"] == 2 && isset($_POST['formSelectEmpresa']))
									$arr_insert[$key]['id_empresa'] = $_POST['formSelectEmpresa'];

								$arr_insert[$key]['quantidade']		 = $_POST["formQuantidade"];
								$arr_insert[$key]['valor_total']	 = $valor_total;
								$arr_insert[$key]['datavenda']    	 = formatDate($_POST["formDta"]);
								//$arr_insert[$key]['data_cadastro']   = DATE_NOW;
						}

						$controllerVENDA = new controllerVENDA('insert_massive',$arr_insert);
						if($controllerVENDA->resposta == '1')
						{
							$retorno["resposta"]  = "1";
							$retorno["msg"]  	  = "Cadastro de venda efetuada!";
							echo json_encode($retorno);
							return;
						}
					}
				}
			}

		}
		else
		{
			$arr_insert 	= array();

			$valor_total = ($_POST["formQuantidade"] * formatValor($valor_prod));

			foreach($arrIdsHospede as $key => $idhospede)
			{
					$arr_insert[$key]['idhospede'] 	 	 = $idhospede;
					$arr_insert[$key]['idcategoria'] 	 = $_POST["formSelectCategoria"];
					$arr_insert[$key]['idproduto'] 		 = $_POST["formSelectProduto"];
					$arr_insert[$key]['idtipo']			 = $_POST["opcao"];
					
					if($_POST["opcao"] == 2 && isset($_POST['formSelectEmpresa']))
						$arr_insert[$key]['id_empresa'] = $_POST['formSelectEmpresa'];

					
					$arr_insert[$key]['valor_total']	 = $valor_total;
					$arr_insert[$key]['quantidade']		 = $_POST["formQuantidade"];
					$arr_insert[$key]['datavenda']    	 = formatDate($_POST["formDta"]);
					//$arr_insert[$key]['data_cadastro']   = DATE_NOW;

					$controllerVENDA = new controllerVENDA('insert_massive',$arr_insert);
					if($controllerVENDA->resposta == '1')
					{
						$retorno["resposta"]  = "1";
						$retorno["msg"]  	  = "Cadastro de venda efetuada!";
						echo json_encode($retorno);
						return;
					}
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

		$where = "";

		if(isset($_POST['arrIdsHospede']))
		{
			$arrIdsHospede  = explode(",",$_POST['arrIdsHospede']);
			$ids_hospede 	= implode(",",$arrIdsHospede);

			$where .= " h.idhospede in($ids_hospede)";
		}

		if(!empty($_POST["formDtInicial"]) &&  !empty($_POST["formDtFinal"]))
		{
			if($where)
				$where .= " and ";

			$where .= " v.datavenda between '".formatDate($_POST[formDtInicial])."' and '".formatDate($_POST[formDtFinal])."'";
		}
		else
		{
			$mes 		= date("m");
			$ano 		= date("Y");
			$ultimo_dia = date("t", mktime(0,0,0,$mes,'01',$ano)); 
			
			$data_primeiro_dia = "01/".$mes."/".$ano;
			$data_ultimo_dia = $ultimo_dia."/".$mes."/".$ano;
			$where .= " v.datavenda between '".formatDate($data_primeiro_dia)."' and '".formatDate($data_ultimo_dia)."'";
		}

		if(!empty($where))
		{
			$where = " and $where ";
			$controllerVENDA = new controllerVENDA('selectVendas',false,$where);
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
	case 'selectVendasTotal':
		$where = "";

		if(isset($_POST['arrIdsHospede']))
		{
			$arrIdsHospede  = explode(",",$_POST['arrIdsHospede']);
			$ids_hospede 	= implode(",",$arrIdsHospede);

			$where .= " h.idhospede in($ids_hospede)";
		}

		if(!empty($_POST["formDtInicial"]) &&  !empty($_POST["formDtFinal"]))
		{
			if($where)
				$where .= " and ";

			$where .= " v.datavenda between '".formatDate($_POST[formDtInicial])."' and '".formatDate($_POST[formDtFinal])."'";
		}
		else
		{
			$mes 		= date("m");
			$ano 		= date("Y");
			$ultimo_dia = date("t", mktime(0,0,0,$mes,'01',$ano)); 
			
			$data_primeiro_dia = "01/".$mes."/".$ano;
			$data_ultimo_dia = $ultimo_dia."/".$mes."/".$ano;
			$where .= " v.datavenda between '".formatDate($data_primeiro_dia)."' and '".formatDate($data_ultimo_dia)."'";
		}

		if(!empty($where))
		{
			$where = " and $where ";
			$controllerVENDA = new controllerVENDA('selectVendasTotal',false,$where);
		}
		else
			$controllerVENDA = new controllerVENDA('selectVendasTotal');

		if(empty($controllerVENDA->arrResposta))
		{
			echo "0";
			return false;
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
		if(isset($_POST['id']) && $_POST['id'] != 'undefined' && !isset($_POST['id2']))
		{
			$where = "where idpais = ".$_POST['id'];
			$controllerESTADO = new controllerESTADO('selectEstado',false,$where);
		}
		else
			$controllerESTADO = new controllerESTADO('selectEstado');

		if(isset($_POST['id2']))
			echo selectCombo("-- Selecione --",$controllerESTADO->arrResposta,true,$_POST['id2'],"idestado","nomeestado",true);
		else
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

		echo selectCombo("-- Selecione --",$controllerCIDADE->arrResposta,true,$_POST['id2'],"idcidade","nomecidade",true);
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
		$arr = array("id_fornecedor"=>$_POST["formSelectFornecedor"],
					"nomeproduto"=>utf8_decode($_POST["formProduto"]),
					"codigo"=>$_POST["formCodigo"],
					"valor"=>formatValor($_POST["formValor"]),
					"data_compra"=>($_POST["formDtaCompra"]),
					"data_validade"=>($_POST["formDtaValidade"]),
					"data_cadastro"=>DATE_NOW,
					"idcategoria"=>$_POST["formSelectCategoria"],
					"insumo"=>$_POST["formSelectInsumo"],
					"estoque"=>$_POST["formSelectPE"]);

		if($_POST["formSelectPE"] == "N")
		{
			$controllerPRODUTOS = new controllerPRODUTOS('insert',$arr);
			if($controllerPRODUTOS->resposta == "1")
			{
				$retorno["resposta"]  = "1";
				$retorno["msg"]  	  = "Produto cadastrado com sucesso!";
			}
			else
				$retorno["resposta"]  = "Ocorreu erro no banco ao exluir registro!";

			echo json_encode($retorno);
		}
		else
		{
			$arr["quantidade"]  = $_POST["formQuantidade"];
			$arr["id_unidade"]  = $_POST["formSelectSigla"];
			$arr["estoque_min"] = $_POST["formEstMinino"];
			$arr["estoque_max"] = $_POST["formEstMaximo"];
			$arr["custo_medio"] = formatValor($_POST["formCustoMedio"]);

			$controllerPRODUTOS = new controllerPRODUTOS('insert_last_id',$arr);
			$idproduto = $controllerPRODUTOS->arrResposta[0]['last_id'];

			$arr = array("id_produto"=>$idproduto,
						"data_movimentacao"=>DATE_NOW,
						"tipo_mov"=>'E',
						"tipo_tab"=>'P',
						"valor_atual"=>formatValor($_POST["formValor"]),
						"quantidade"=>$_POST["formQuantidade"]);

			$controllerMOV_ESTOQUE = new controllerMOV_ESTOQUE('insert',$arr);
			if($controllerMOV_ESTOQUE->resposta == "1")
			{
				$retorno["resposta"]  = "1";
				$retorno["msg"]  	  = "Produto cadastrado com sucesso!";
			}
			else
				$retorno["resposta"]  = "Ocorreu erro no banco ao exluir registro!";

			echo json_encode($retorno);
		}
	break;
	case 'selectProdutosTable':
		$where = "";

		if(isset($_POST['formProdutoStr']) && !empty($_POST['formProdutoStr']))
			$where .= " and  p.nomeproduto  collate Latin1_General_CI_AS like'%".$_POST['formProdutoStr']."%'";

		if(isset($_POST['formSelectCategoria']) && !empty($_POST['formSelectCategoria']))
			$where .= " and  p.idcategoria = ".$_POST['formSelectCategoria'];

		if(isset($_POST['formSelectFornecedor']) && !empty($_POST['formSelectFornecedor']))
			$where .= " and  f.id_fornecedor = ".$_POST['formSelectFornecedor'];

		if(isset($_POST['formSelectOrdem']) && !empty($_POST['formSelectOrdem']))
			$where .= " order by ".$_POST['formSelectOrdem'];


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
		$idproduto 	= $_POST["formIdProduto"];
		$valor 		= formatValor($_POST["formValorProd"]);

		$arr = array("id_produto"=>$idproduto,
					"valor_atual"=>$valor,
					"data_movimentacao"=>DATE_NOW,
					"tipo_mov"=>'A');

		$controllerMOV_ESTOQUE = new controllerMOV_ESTOQUE('insert',$arr);
		if($controllerMOV_ESTOQUE->resposta == "1")
		{
			$arr = array("idproduto"=>$idproduto,
						"valor"=>$valor);
				
			$controllerPRODUTOS = new controllerPRODUTOS('update',$arr);
			if($controllerPRODUTOS->resposta == "1")
			{
				$retorno["resposta"] = "1";
				$retorno["msg"]		 = "Registro atualizado com sucesso";
			}
			else
				$retorno["resposta"]  = "Ocorreu erro no banco ao atualizar valor!";	
		}
		else
			$retorno["resposta"]  = "Ocorreu erro no banco ao incluir registro!";	

		echo json_encode($retorno);
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
			$arrTipoPagamento = array("Cart�o"=>1,"Dinheiro"=>2);
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

		$arrIdsProduto = explode(",",$_POST['arrIdsProduto']);
		
		$ids_produto = implode(",",$arrIdsProduto);
		$arr = array("ativo"=>"N","idproduto"=>$ids_produto);

		$controllerPRODUTOS = new controllerPRODUTOS('update',$arr);
		if($controllerPRODUTOS->resposta == "1")
			echo $controllerPRODUTOS->resposta;
		else
			echo "erro!";
	break;
	case 'cadastroPagamento':
		$arr = array("idreserva"		=>$_POST["formIdReserva"],
					 "transferencia"	=>$_POST['formSelectTransferencia'],
					 "tipo_pagamento"	=>$_POST["formSelecDpAntecipado"]);

		if(isset($_POST["formData"]) && !empty($_POST["formData"]))
		{
			$data					= 	formatDate($_POST["formData"]);
			$arr["datapagamento"]	=	$data;
		}
		
		if(isset($_POST["formValorPagamento"]) && !empty($_POST["formValorPagamento"]))
			$arr["valor"] = formatValor($_POST['formValorPagamento']);

		if($_POST['formSelecDpAntecipado'] == 2) //Cartão
		{
			$arr["id_cartao"] = $_POST["formSelectCartao"];

			if($_POST['opcao'] == 'C')
				$arr["parcelas"] = $_POST['formSelectParcelas'];
		}

		if($_POST['formSelecDpAntecipado'] != 3 && $_POST['formSelecDpAntecipado'] != 4) //Dinheiro / Cartão
		{
			$controllerPAGAMENTO = new controllerPAGAMENTO('insert',$arr);
			echo $controllerPAGAMENTO->resposta;	
		}
		else
		{
			$controllerPAGAMENTO = new controllerPAGAMENTO('insert_last_id',$arr);
			$id_pagamento 		 = $controllerPAGAMENTO->arrResposta[0]['last_id'];

			if($_POST['formSelecDpAntecipado'] == 3) //Cheque
			{
				$id_banco 		= $_POST['formSelectBanco'];
			
				$arrDataCheque = array();
				foreach($_POST['formDataCheque'] as $key => $value)
				{
						if(!empty($value))
							array_push($arrDataCheque,$value);
				}

				$arrNumeroCheque = array();
				foreach($_POST['formNumeroCheque'] as $key => $value)
				{
						if(!empty($value))
							array_push($arrNumeroCheque,$value);
				}

				$arrValorCheque = array();
				foreach($_POST['formValorCheque'] as $key => $value)
				{
						if(!empty($value))
							array_push($arrValorCheque,formatValor($value));
				}

				$arr_insert 	= array();

				foreach($arrDataCheque as $key => $data_cheque)
				{
						$numero_cheque = $arrNumeroCheque[$key];
						$valor_cheque  = $arrValorCheque[$key];

						$arr_insert[$key]['data_vencimento'] = $data_cheque;
						$arr_insert[$key]['numero'] 		 = $numero_cheque;
						$arr_insert[$key]['valor']			 = $valor_cheque;
						$arr_insert[$key]['id_banco']		 = $id_banco;
						$arr_insert[$key]['id_pagamento']    = $id_pagamento;
				}

				$controllerCHEQUE = new controllerCHEQUE('insert_massive',$arr_insert);
				echo $controllerCHEQUE->resposta;
			}
			
			if($_POST['formSelecDpAntecipado'] == 4) // Depósito
			{
				$id_banco 		= $_POST['formSelectDepBanco'];

				$arrDep = array("id_banco"=>$id_banco,
								"agencia"=>$_POST['formAgencia'],
								"conta"=>$_POST['formConta'],
								"tipo_conta"=>$_POST['formSelectTipoConta'],
								"id_pagamento"=>$id_pagamento);

				$controllerDEPOSITO_CONTA = new controllerDEPOSITO_CONTA('insert',$arrDep);
				echo $controllerDEPOSITO_CONTA->resposta;
			}
		}
	break;
	case 'selectTransferencia':
		$arrDisponibilidade = array("Antecipado"=>"1","Caixa"=>"2","Faturamento"=>"3","Faturamento Parcelado"=>"4");
		echo selectCombo("-- Selecione --",$arrDisponibilidade,false,$_POST['id'],false,false,false);
	break;
	case 'selectDpAntecipado':
		$arrDisponibilidade = array("Dinheiro"=>"1",
									"Cartão"=>"2",
									"Cheque"=>"3",
									"Depósito"=>"4");

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
	case 'deletePagamento':
		$arr = array("idpagamento"=>$_POST["idpagamento"],"ativo"=>'t');
		$controllerPAGAMENTO = new controllerPAGAMENTO('update',$arr);

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

		if(empty($dadosQuarto))
		{
			$strTable .="<div class='alert' aling='center'>";
			$strTable .="<div align='center'>";
			$strTable .="<strong>Aviso!</strong> não existem registros de calendario!";
			$strTable .="</div></div>";
			echo ($strTable);
			return;
		}
		
		
		foreach($dadosQuarto as $dados)
		{
					//Utilizado para dbug
				// if($dados['status'] == 'S')
					// $arrAllQuartos[$dados['idquarto']] = $dados['nomequarto']."|".$dados['status']."|".$dados['datainicial']."|".$dados['datafinal'];
				// else
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
		$idproduto  = $_POST['formSelectProduto'];
		$quantidade = $_POST['formQtd'];
		$valor_prod	= formatValor($_POST["formValor"]);

		$where = " and p.idproduto = $idproduto";
		$controllerPRODUTOS = new controllerPRODUTOS('select',false,$where);
		$quantidade_prod 	= $controllerPRODUTOS->arrResposta[0]['quantidade'];

		$quantidade_atual = ($quantidade_prod + $quantidade);

		if(($quantidade_atual <= 0))
		{
			$retorno["resposta"]  = "Informe o valor correto para cadastro!";
			echo json_encode($retorno);
			return;
		}

		$arr = array("id_produto"=>$idproduto,
						"data_movimentacao"=>DATE_NOW,
						"tipo_mov"=>'E',
						"quantidade"=>$quantidade,
						"tipo_tab"=>'E',
						"valor_atual"=>$valor_prod,
						"observacao"=>$_POST['formObservacao']);

		$controllerMOV_ESTOQUE = new controllerMOV_ESTOQUE('insert',$arr);
		if($controllerMOV_ESTOQUE->resposta == "1")
		{
			$arr = array("idproduto"=>$idproduto,
						"quantidade"=>$quantidade_atual,
						"valor"=>$valor_prod);

			$controllerPRODUTOS = new controllerPRODUTOS('update',$arr);
			if($controllerPRODUTOS->resposta == "1")
			{
				$retorno["resposta"] = "1";
				$retorno["msg"]		 = "Registro cadastro com sucesso";
			}
			else
				$retorno["resposta"]  = "Ocorreu erro no banco ao atualizar quantidade!";	
		}
		else
			$retorno["resposta"]  = "Ocorreu erro no banco ao atualizar MOV_ESTOQUE quantidade!";

		echo json_encode($retorno);
	break;
	case 'selectProdutosEstoque':
	
		if(isset($_POST['id']))
		{
			$where =" and p.idproduto = $_POST[id]";
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
		if(isset($_POST['formSelectProduto']) && !empty($_POST['formSelectProduto']))
		{
			$where = "id_produto=".$_POST['formSelectProduto'];
			$controllerMOV_ESTOQUE = new controllerMOV_ESTOQUE('select',false,$where);
		}
		else
			$controllerMOV_ESTOQUE = new controllerMOV_ESTOQUE('select');

		if(empty($controllerMOV_ESTOQUE->arrResposta))
		{
			echo "0";
			return false;
		}

		for($i=0; $i<count($controllerMOV_ESTOQUE->arrResposta); $i++)
		{
			$controllerMOV_ESTOQUE->arrResposta[$i]['nomeproduto'] = utf8_encode($controllerMOV_ESTOQUE->arrResposta[$i]['nomeproduto']);
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerMOV_ESTOQUE->arrResposta)."}");
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
			$where .= " t.idhospede =".$_POST['formSelectHospede'];

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
				$where .= "  t.datainicial_2  between '".($_POST['formDtInicial'])."'  and '".($_POST['formDtFinal'])."'";
			else
				$where .= " and t.datainicial_2  between '".($_POST['formDtInicial'])."'  and '".($_POST['formDtFinal'])."'";
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
			$where .= " h.idhospede =".$_POST['formSelectHospede'];

		if(isset($_POST['formSelectQuarto']) && !empty($_POST['formSelectQuarto']))
		{
			if(empty($where))
				$where .= " q.idquarto =".$_POST['formSelectQuarto'];
			else
				$where .= " and q.idquarto =".$_POST['formSelectQuarto'];
		}

		if(isset($_POST['formDtInicial'])  &&  isset($_POST['formDtFinal']))
		{
			if(empty($where))
				$where .= "  r.datainicial  between '".($_POST['formDtInicial'])."'  and '".($_POST['formDtFinal'])."'";
			else
				$where .= " and r.datainicial  between '".($_POST['formDtInicial'])."'  and '".($_POST['formDtFinal'])."'";
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
				$where .= " p.tipo_pagamento = ".$_POST['formFormaPagamento'];
			else
				$where .= " and p.tipo_pagamento = ".$_POST['formFormaPagamento'];
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
				$where .= " p.tipo_pagamento = ".$_POST['formFormaPagamento'];
			else
				$where .= " and p.tipo_pagamento = ".$_POST['formFormaPagamento'];
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
		$arrFormaPagamento = array("Cart�o D�bito - Visa"=>"1",
									"Cart�o D�bito - Master"=>"2",
									"Cart�o Cr�dito - Visa"=>"4",
									"Cart�o Cr�dito - Master"=>"5",
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
            $arrRet['tipo_pagamento'] =$dados['tipo_pagamento'];
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
	
	case 'montaPainelAcoesModuloSubMenu':
		$where = ' where  iditens ='.$_POST['iditens'];
		$controllerSUB_MENU = new controllerSUB_MENU('select',false,$where);
		//$titulo = 'Configurações de '.utf8_encode($controllerSUB_MENU->arrResposta[0]['TITLE']);
		$titulo = utf8_encode($controllerSUB_MENU->arrResposta[0]['TITLE']);

		$i=0;
		$html .= '<div class="btn-group" style="width:100%">';
		foreach($controllerSUB_MENU->arrResposta as $dados)
		{
				$margin = "";

				$onclick = 'window.location=\''.$dados['LINK'].'\'"';

				$icones = '/beaverpousada/icones/'.$dados['ICONE'];

				if($i==0)
				{
					$html .= '<div style="width:100%">';
					$margin = "margin-left:2%;";
				}
				else
					$margin = "margin-left:5%;";

				if($i==4)
					$margin .= "margin-right:2%;";

				$html .='<div class=".btn-group pull-left"  style="'.$margin.'width:15%;margin-bottom:10px;margin-top:10px;">';
				$html .='<button onclick="'.$onclick.'" type="button" style="text-align:center;width:100%" class="btn btn-default btn-menu">';
					$html .="<img height='50px' width='40px' src='$icones'><br>";
					
				$html .= utf8_encode($dados['LABELMENU']).'</button> ';
				$html .='</div>';

				if($i == 4)
				{
					$html .='</div>';
					$html .='';
					$i=0;
				}
				else
					$i++;
		}
		$html .= '</div>';

		$ret = array('html'=>$html,'titulo'=>($titulo));
		echo json_encode($ret);
	break;

	
	case 'montaPainelAcoesModulo':
		//$where = ' where u.idgrupo = '.$_SESSION['idgrupo'].' and mn.idmodulo ='.$_POST['idmodulo'];
		$where = ' where  m.idmodulo ='.$_POST['idmodulo'];
		$controllerUSUARIO = new controllerUSUARIO('selectMontaPainelAcoesModulo',false,$where);
		$titulo = $controllerUSUARIO->arrResposta[0]['TITLE'];

		$i=0;
		$html .= '<div class="btn-group" style="width:100%">';
		foreach($controllerUSUARIO->arrResposta as $dados)
		{
				$margin = "";

				if(!empty($dados['SUB_MENU']))
				{
					$iditens  = $dados['IDITENS'];
					$onclick  = 'window.location=\'http://177.70.26.45/beaverpousada/pousada/painel_configuracoes.php?submenu=true&iditens='.$iditens.'\'"';
				}
				else
					$onclick = 'window.location=\''.$dados['LINK'].'\'"';

				$icones = '/beaverpousada/icones/'.$dados['ICONE'];

				if($i==0)
				{
					$html .= '<div style="width:100%">';
					$margin = "margin-left:2%;";
				}
				else
					$margin = "margin-left:5%;";

				if($i==4)
					$margin .= "margin-right:2%;";

				$html .='<div class=".btn-group pull-left"  style="'.$margin.'width:15%;margin-bottom:10px;margin-top:10px;">';
				$html .='<button onclick="'.$onclick.'" type="button" style="text-align:center;width:100%" class="btn btn-default btn-menu">';
					$html .="<img height='50px' width='40px' src='$icones'><br>";
					
				$html .= utf8_encode($dados['LABELMENU']).'</button> ';
				$html .='</div>';

				if($i == 4)
				{
					$html .='</div>';
					$html .='';
					$i=0;
				}
				else
					$i++;
		}
		$html .= '</div>';

		$ret = array('html'=>$html,'titulo'=>utf8_encode($titulo));
		echo json_encode($ret);
	break;
	case 'montarPainelConfig':
		$controllerUSUARIO = new controllerUSUARIO('selectMontaPainelAcoes',false,$where);
		//$html = '<div width="60%">';

		$titulo = 'Módulos';

		$i=0;
		$html .= '<div class="btn-group" style="width:100%">';
		foreach($controllerUSUARIO->arrResposta as $dados)
		{
				$margin = "";
				$idmodulo = $dados['IDMODULO'];
				$onclick  = 'window.location=\'http://177.70.26.45/beaverpousada/pousada/painel_configuracoes.php?acao='.$idmodulo.'\'"';

				$icones = '/beaverpousada/icones/'.$dados['ICONE'];

				if($i==0)
				{
					$html .= '<div style="width:100%">';
					$margin = "margin-left:2%;";
				}
				else
					$margin = "margin-left:5%;";

				if($i==4)
					$margin .= "margin-right:2%;";

				$html .='<div class=".btn-group pull-left"  style="'.$margin.'width:15%;margin-bottom:10px;margin-top:10px;">';////////////////
				$html .='<button onclick="'.$onclick.'" type="button" style="text-align:center;width:100%" class="btn btn-default btn-menu">';
					$html .="<img height='50px' width='40px' src='$icones'><br>";
					
				$html .= utf8_encode($dados['LABELMENU']).'</button> ';
				$html .='</div>';

				if($i == 4)
				{
					$html .='</div>';
					$html .='';
					$i=0;
				}
				else
					$i++;
		}
		$html .= '</div>';

		$ret = array('html'=>$html,'titulo'=>($titulo));
		echo json_encode($ret);
	break;
	case 'cadastroFornecedor':
		$arr = array("nome"=>$_POST['formFornecedor'],
					"id_tipo_fornecedor"=>$_POST['formSelectTipoForn'],
					"id_banco"=>$_POST['formSelectDepBanco'],
					"agencia"=>$_POST['formAgencia'],
					"conta"=>$_POST['formConta'],
					"tipo_conta"=>$_POST['formSelectTipoConta'],
					"cpfcnpj"=> $_POST['formCpfCnpj'],
					"endereco"=>$_POST['formEndereco'],
					"telefone"=>$_POST['formTelefone']);

		if(isset($_POST['formObeservacao']) && !empty($_POST['formObeservacao']))
			$arr['observacao'] = $_POST['formObeservacao'];

		$controllerFORNECEDOR = new controllerFORNECEDOR('insert',$arr);
		echo $controllerFORNECEDOR->resposta;
	break;
	case 'selectTableFornecedor':
		$where= "";

		if(isset($_POST['formFornecedorStr']))
			$where .= " and f.nome like '%".$_POST['formFornecedorStr']."%'";

		if(isset($_POST['formSelectTipoForn']))
			$where .= " and tf.id_tipo_fornecedor = ".$_POST['formSelectTipoForn'];

		if(!empty($where))
			$controllerFORNECEDOR = new controllerFORNECEDOR('select',false,$where);
		else
			$controllerFORNECEDOR = new controllerFORNECEDOR('select');

		if(empty($controllerFORNECEDOR->arrResposta))
		{
			echo "0";
			return false;
		}

		for($i=0; $i<count($controllerFORNECEDOR->arrResposta); $i++)
		{
			$controllerFORNECEDOR->arrResposta[$i]['nome'] = utf8_encode($controllerFORNECEDOR->arrResposta[$i]['nome']);
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerFORNECEDOR->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectDadosFornecedor':
		$arr = array("id_fornecedor"=>$_POST["id_fornecedor"]);
		$controllerFORNECEDOR = new controllerFORNECEDOR('selectDadosJson',$arr);
		echo $controllerFORNECEDOR->resposta;
	break;
	case 'updateFornecedor':
		$arr = array("id_fornecedor"=>$_POST["formIdFornecedor"],
					"nome"=>$_POST["formFornecedor"],
					"id_tipo_fornecedor"=>$_POST['formSelectTipoForn'],
					"id_banco"=>$_POST['formSelectDepBanco'],
					"agencia"=>$_POST['formAgencia'],
					"conta"=>$_POST['formConta'],
					"tipo_conta"=>$_POST['formSelectTipoConta'],
					"cpfcnpj"=>$_POST["formCpfCnpj"],
					"endereco"=>$_POST["formEndereco"],
					"telefone"=>$_POST["formTelefone"],
					"observacao"=>$_POST["formObeservacao"]);

		$controllerFORNECEDOR = new controllerFORNECEDOR('update',$arr);
		echo $controllerFORNECEDOR->resposta;
	break;
	case 'deleteFornecedor':
		$arr = array("id_fornecedor"=>$_POST["id_fornecedor"],
					"ativo"=>'f');

		$controllerFORNECEDOR = new controllerFORNECEDOR('update',$arr);
		if($controllerFORNECEDOR->resposta == "1")
			$retorno["resposta"]  = "1";
		else
			$retorno["resposta"]  = "Ocorreu erro no banco ao exluir registro!";

		echo json_encode($retorno);
	break;
	case 'cadastroUnidade':
		$arr = array("unidade"=>$_POST['formUnidade'],
					"quantidade"=> $_POST['formQuantidade'],
					"descricao"=>$_POST['formDescricao']);

		$controllerUNIDADE = new controllerUNIDADE('insert',$arr);
		echo $controllerUNIDADE->resposta;
	break;
	case 'selectTableUnidade':
		$controllerUNIDADE = new controllerUNIDADE('select');
		if(empty($controllerUNIDADE->arrResposta))
		{
			echo "0";
			return false;
		}

		for($i=0; $i<count($controllerUNIDADE->arrResposta); $i++)
		{
			$controllerUNIDADE->arrResposta[$i]['unidade'] 	 = utf8_encode($controllerUNIDADE->arrResposta[$i]['unidade']);
			$controllerUNIDADE->arrResposta[$i]['descricao'] = utf8_encode($controllerUNIDADE->arrResposta[$i]['descricao']);
		}

		$strJSON = json_encode('{"rows":'.json_encode($controllerUNIDADE->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectDadosUnidade':
		$arr = array("id_unidade"=>$_POST["id_unidade"]);
		$controllerUNIDADE = new controllerUNIDADE('selectDadosJson',$arr);
		echo $controllerUNIDADE->resposta;
	break;
	case 'updateUnidade':
		$arr = array("id_unidade"=>$_POST["formIdUnidade"],
					"unidade"=>$_POST["formUnidade"],
					"quantidade"=>$_POST["formQuantidade"],
					"descricao"=>$_POST["formDescricao"]);

		$controllerUNIDADE = new controllerUNIDADE('update',$arr);
		echo $controllerUNIDADE->resposta;
	break;
	case 'deleteUnidade':
		$arr = array("id_unidade"=>$_POST["id_unidade"],
					"ativo"=>'f');

		$controllerUNIDADE = new controllerUNIDADE('update',$arr);
		if($controllerUNIDADE->resposta == "1")
			$retorno["resposta"]  = "1";
		else
			$retorno["resposta"]  = "Ocorreu erro no banco ao exluir registro!";

		echo json_encode($retorno);
	break;
	case 'selectFornecedor':
		$controllerFORNECEDOR = new controllerFORNECEDOR('select');
		echo selectCombo("-- Selecione --",$controllerFORNECEDOR->arrResposta,true,$_POST['id'],"id_fornecedor","nome");
	break;
	case 'selectSiglaCombo':
		$controllerUNIDADE = new controllerUNIDADE('select');
		echo selectCombo("-- Selecione --",$controllerUNIDADE->arrResposta,true,$_POST['id'],"id_unidade","unidade",true);
	break;
	case 'selectProdutoInsumo':
		$arr = array("Sim"=>"S","Não"=>"N");
		echo selectCombo("-- Selecione --",$arr,false,$_POST['id'],false,false,false);
	break;
	case 'selectProdutoOrdem':
		$arr = array("Ordem alfabética"=>" p.nomeproduto asc ","Ultimo cadastro "=>" p.idproduto desc ");
		echo selectCombo("-- Selecione --",$arr,false,$_POST['id'],false,false,false);
	break;
	case 'selectComboTipoFornecedor':
		$controllerTIPO_FORNECEDOR = new controllerTIPO_FORNECEDOR('select');
		echo selectCombo("-- Selecione --",$controllerTIPO_FORNECEDOR->arrResposta,true,$_POST['id'],"id_tipo_fornecedor","tipo_fornecedor");
	break;
	case 'cadastroTipoFornecedor':
		$arr = array("tipo_fornecedor"=>$_POST['formTipoFornecedor'],
					"descricao"=>$_POST['formDescricao']);

		$controllerTIPO_FORNECEDOR = new controllerTIPO_FORNECEDOR('insert',$arr);
		echo $controllerTIPO_FORNECEDOR->resposta;
	break;
	case 'selectTableTipoFornecedor':
		$controllerTIPO_FORNECEDOR = new controllerTIPO_FORNECEDOR('select');
		if(empty($controllerTIPO_FORNECEDOR->arrResposta))
		{
			echo "0";
			return false;
		}

		for($i=0; $i<count($controllerTIPO_FORNECEDOR->arrResposta); $i++)
		{
			$controllerTIPO_FORNECEDOR->arrResposta[$i]['tipo_fornecedor'] 	 = utf8_encode($controllerTIPO_FORNECEDOR->arrResposta[$i]['tipo_fornecedor']);
			$controllerTIPO_FORNECEDOR->arrResposta[$i]['descricao'] = utf8_encode($controllerTIPO_FORNECEDOR->arrResposta[$i]['descricao']);
		}

		$strJSON = json_encode('{"rows":'.json_encode($controllerTIPO_FORNECEDOR->arrResposta)."}");
		echo($strJSON);
	break;
	case 'deleteTipoFornecedor':
		$arr = array("id_tipo_fornecedor"=>$_POST["id_tipo_fornecedor"],
					"ativo"=>'f');

		$controllerTIPO_FORNECEDOR = new controllerTIPO_FORNECEDOR('update',$arr);
		if($controllerTIPO_FORNECEDOR->resposta == "1")
			$retorno["resposta"]  = "1";
		else
			$retorno["resposta"]  = "Ocorreu erro no banco ao exluir registro!";

		echo json_encode($retorno);
	break;
	case 'selectProdutosInsumo':
		$where= "";

		if(isset($_POST['formStr']))
		{
			$where .= " and (nomeproduto like '%".$_POST['formStr']."%') or ";
			$where .= "  (codigo like '%".$_POST['formStr']."%') ";
		}

		if(!empty($where))
			$controllerPRODUTOS = new controllerPRODUTOS('selectProdutosInsumo',false,$where);
		else
			$controllerPRODUTOS = new controllerPRODUTOS('selectProdutosInsumo');

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
	case 'cadastroLancamentoInsumo':
		$idproduto  = $_POST['formSelectProduto'];
		$quantidade = $_POST['formQuantidade'];

		$where = " and p.idproduto = $idproduto";
		$controllerPRODUTOS = new controllerPRODUTOS('select',false,$where);
		$quantidade_prod 	= $controllerPRODUTOS->arrResposta[0]['quantidade'];
		$valor_prod 		= $controllerPRODUTOS->arrResposta[0]['valor'];
		$valor_prod			= formatValor($valor_prod);

		
		if($_POST['formSelectHistorico'] == 1) //Consumo interno
		{
			if(($quantidade > $quantidade_prod) || ($quantidade <= 0))
			{
				$retorno["resposta"]  = "Quantidade maior estoque atual de $quantidade_prod!";
				echo json_encode($retorno);
				return;
			}
		}
		
		$arr = array("idproduto"=>$idproduto,
					"historico"=>$_POST['formSelectHistorico'],
					"data_cadastro"=>DATE_NOW,
					"quantidade"=>$quantidade);
					
		if(isset($_POST['formDescricao']) && !empty($_POST['formDescricao']))
			$arr['descricao'] = $_POST['formDescricao'];

		$controllerLANCAMENTO_INSUMO = new controllerLANCAMENTO_INSUMO('insert_last_id',$arr);
		$id_lanca_insumo = $controllerLANCAMENTO_INSUMO->arrResposta[0]['last_id'];

		if($_POST['formSelectHistorico'] == 1) //Consumo interno
		{	
			$tipo_mov = 'S';
			$quantidade_atual = ($quantidade_prod - $quantidade);
		}

		if($_POST['formSelectHistorico'] == 2) //Cancelamento de consumo interno
		{	
			$tipo_mov = 'D';
			$quantidade_atual = ($quantidade_prod + $quantidade);
		}

		$arr = array("id_produto"=>$_POST['formSelectProduto'],
					"data_movimentacao"=>DATE_NOW,
					"tipo_mov"=>$tipo_mov,
					"quantidade"=>$quantidade,
					"valor_atual"=>$valor_prod,
					"tipo_tab"=>'I',
					"id_lanca_insumo"=>$id_lanca_insumo);

		$controllerMOV_ESTOQUE = new controllerMOV_ESTOQUE('insert',$arr);
		if($controllerMOV_ESTOQUE->resposta == "1")
		{
			$arr = array("idproduto"=>$idproduto,
				"quantidade"=>$quantidade_atual);

			$controllerPRODUTOS = new controllerPRODUTOS('update',$arr);
			if($controllerPRODUTOS->resposta == "1")
			{
				$retorno["resposta"] = "1";
				$retorno["msg"]		 = "Registro cadastro com sucesso";
			}
			else
				$retorno["resposta"]  = "Ocorreu erro no banco ao atualizar quantidade!";	
		}
		else
			$retorno["resposta"]  = "Ocorreu erro no banco ao incluir registro!";	
	

		echo json_encode($retorno);
	break;
	case 'selectTableLancamentoInsumo':
		$where = "";

		if(isset($_POST['formInsumoStr']))
			$where .= " and p.nomeproduto like '%".$_POST['formInsumoStr']."%'";

		if(isset($_POST['formSelectHistorico']))
			$where .= " and l.historico = '".$_POST['formSelectHistorico']."'";
		
		if(!empty($where))
			$controllerLANCAMENTO_INSUMO = new controllerLANCAMENTO_INSUMO('select',false,$where);	
		else
			$controllerLANCAMENTO_INSUMO = new controllerLANCAMENTO_INSUMO('select');

				
		for($i=0; $i<count($controllerLANCAMENTO_INSUMO->arrResposta); $i++)
		{
			$controllerLANCAMENTO_INSUMO->arrResposta[$i]['nomeproduto'] = utf8_encode($controllerLANCAMENTO_INSUMO->arrResposta[$i]['nomeproduto']);
		}

		$strJSON = json_encode('{"rows":'.json_encode($controllerLANCAMENTO_INSUMO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectTableLancamentoAuditoria':
		$where = "";

		if(isset($_POST['formInsumoStr']))
			$where .= " and p.nomeproduto like '%".$_POST['formInsumoStr']."%'";

		if(isset($_POST['formSelectHistorico']))
			$where .= " and l.historico = '".$_POST['formSelectHistorico']."'";
		
		if(!empty($where))
			$controllerLANCAMENTO_AUDITORIA = new controllerLANCAMENTO_AUDITORIA('select',false,$where);	
		else
			$controllerLANCAMENTO_AUDITORIA = new controllerLANCAMENTO_AUDITORIA('select');
		
		for($i=0; $i<count($controllerLANCAMENTO_AUDITORIA->arrResposta); $i++)
		{
			$controllerLANCAMENTO_AUDITORIA->arrResposta[$i]['nomeproduto'] = utf8_encode($controllerLANCAMENTO_AUDITORIA->arrResposta[$i]['nomeproduto']);
		}

		$strJSON = json_encode('{"rows":'.json_encode($controllerLANCAMENTO_AUDITORIA->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectProdutosAuditoria':
		$where= "";

		if(isset($_POST['formStr']))
		{
			$where .= " and (nomeproduto like '%".$_POST['formStr']."%') or ";
			$where .= "  (codigo like '%".$_POST['formStr']."%') ";
		}

		if(!empty($where))
			$controllerPRODUTOS = new controllerPRODUTOS('selectProdutosAuditoria',false,$where);
		else
			$controllerPRODUTOS = new controllerPRODUTOS('selectProdutosAuditoria');

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
	case 'selectProdEstoqueTable':
		$where= "";

		if(isset($_POST['formStr']))
		{
			$where .= " and (nomeproduto like '%".$_POST['formStr']."%') or ";
			$where .= "  (codigo like '%".$_POST['formStr']."%') ";
		}

		if(!empty($where))
			$controllerPRODUTOS = new controllerPRODUTOS('selectProdutoEstoque',false,$where);
		else
			$controllerPRODUTOS = new controllerPRODUTOS('selectProdutoEstoque');

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
	case 'cadastroControleAuditoria':
		$idproduto  = $_POST['formSelectProduto'];
		$quantidade = $_POST['formQuantidade'];

		$where = " and p.idproduto = $idproduto";
		$controllerPRODUTOS = new controllerPRODUTOS('select',false,$where);
		$quantidade_prod 	= $controllerPRODUTOS->arrResposta[0]['quantidade'];
		$valor_prod 		= $controllerPRODUTOS->arrResposta[0]['valor'];
		$valor_prod			= formatValor($valor_prod);

		
		if($_POST['formSelectHistorico'] == 1) //Saida pela auditoria
		{
			if(($quantidade > $quantidade_prod) || ($quantidade <= 0))
			{
				$retorno["resposta"]  = "Quantidade maior estoque atual de $quantidade_prod!";
				echo json_encode($retorno);
				return;
			}
		}
		
		$arr = array("idproduto"=>$idproduto,
					"historico"=>$_POST['formSelectHistorico'],
					"data_cadastro"=>DATE_NOW,
					"quantidade"=>$quantidade);
					
		if(isset($_POST['formDescricao']) && !empty($_POST['formDescricao']))
			$arr['descricao'] = $_POST['formDescricao'];

		$controllerLANCAMENTO_AUDITORIA = new controllerLANCAMENTO_AUDITORIA('insert_last_id',$arr);
		$id_lanca_auditoria = $controllerLANCAMENTO_AUDITORIA->arrResposta[0]['last_id'];

		if($_POST['formSelectHistorico'] == 1) //Saída pela auditoria
		{	
			$tipo_mov = 'S';
			$quantidade_atual = ($quantidade_prod - $quantidade);
		}

		if($_POST['formSelectHistorico'] == 2) //Entrada pela auditoria
		{	
			$tipo_mov = 'E';
			$quantidade_atual = ($quantidade_prod + $quantidade);
		}

		$arr = array("id_produto"=>$_POST['formSelectProduto'],
					"data_movimentacao"=>DATE_NOW,
					"tipo_mov"=>$tipo_mov,
					"quantidade"=>$quantidade,
					"valor_atual"=>$valor_prod,
					"tipo_tab"=>'A',
					"id_lanca_auditoria"=>$id_lanca_auditoria,
					"observacao"=>$_POST['formDescricao']);

		$controllerMOV_ESTOQUE = new controllerMOV_ESTOQUE('insert',$arr);
		if($controllerMOV_ESTOQUE->resposta == "1")
		{
			$arr = array("idproduto"=>$idproduto,
				"quantidade"=>$quantidade_atual);

			$controllerPRODUTOS = new controllerPRODUTOS('update',$arr);
			if($controllerPRODUTOS->resposta == "1")
			{
				$retorno["resposta"] = "1";
				$retorno["msg"]		 = "Registro cadastro com sucesso";
			}
			else
				$retorno["resposta"]  = "Ocorreu erro no banco ao atualizar quantidade!";	
		}
		else
			$retorno["resposta"]  = "Ocorreu erro no banco ao incluir registro!";	
	

		echo json_encode($retorno);
	break;
	case 'selectEstoqueAtualTable':
		if(isset($_POST['formSelectProduto']) && !empty($_POST['formSelectProduto']))
		{
			$where = "id_produto=".$_POST['formSelectProduto'];
			$controllerPRODUTOS = new controllerPRODUTOS('selectEstoqueAtual',false,$where);
		}
		else
			$controllerPRODUTOS = new controllerPRODUTOS('selectEstoqueAtual');

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
	case 'selectBandeira':
		$controllerBANDEIRA = new controllerBANDEIRA('select');
		echo selectCombo("-- Selecione --",$controllerBANDEIRA->arrResposta,true,$_POST['id'],"id_bandeira","bandeira",true);
	break;
	case 'cadastroCartao':
		$where = " c.id_bandeira = ".$_POST['formSelectBandeira']." and c.tipo = '".$_POST['opcao']."'";
		
		$controllerCARTAO = new controllerCARTAO('select',false,$where);
		if(!empty($controllerCARTAO->arrResposta))
		{
			$retorno["resposta"]  = "Cartão já cadastrado!";
			echo json_encode($retorno);
			return false;
		}

		$arr = array("id_bandeira"=>$_POST['formSelectBandeira'],
					"tipo"=>$_POST['opcao'],
					"dia_recebimento"=>$_POST['formDiaRecebimento'],
					"percentual"=>$_POST['formPercentual']);

		if(isset($_POST['formParcelas']))
			$arr["parcelas"] = $_POST['formParcelas'];

		if(isset($_POST['formBaixaAutomatica']))
			$arr["baixa_automatica"] = $_POST['formBaixaAutomatica'];

		$controllerCARTAO = new controllerCARTAO('insert',$arr);
		if($controllerCARTAO->resposta == "1")
		{
			$retorno["resposta"] = "1";
			$retorno["msg"]		 = "Registro cadastro com sucesso";
		}
		else
			$retorno["resposta"]  = "Ocorreu erro no banco ao incluir registro!";	

		echo json_encode($retorno);
	break;
	case 'selectCartoesTable':
		$controllerCARTAO = new controllerCARTAO('select');

		if(empty($controllerCARTAO->arrResposta))
		{
			echo "0";
			return false;
		}

		// for($i=0; $i<count($controllerCARTAO->arrResposta); $i++)
		// {
			// $controllerCARTAO->arrResposta[$i]['bandeira'] = utf8_encode($controllerCARTAO->arrResposta[$i]['bandeira']);
			// $controllerCARTAO->arrResposta[$i]['tipo'] = utf8_encode($controllerCARTAO->arrResposta[$i]['tipo']);
			// $controllerCARTAO->arrResposta[$i]['baixa_automatica'] = utf8_encode($controllerCARTAO->arrResposta[$i]['baixa_automatica']);
		// }
		$strJSON = json_encode('{"rows":'.json_encode($controllerCARTAO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectCartoesCombo':
		if(!isset($_POST['id']))
			$where = "  tipo = 'D'";
		else
			$where = "  tipo = '$_POST[id]'";

		$controllerCARTAO = new controllerCARTAO('select',false,$where);
		echo selectCombo("-- Selecione --",$controllerCARTAO->arrResposta,true,$_POST['id'],"id_cartao","bandeira",true);
	break;
	case 'selectParcelasCombo':
		$where = "  id_cartao = $_POST[id2]";
		$controllerCARTAO = new controllerCARTAO('select',false,$where);

		$num_parcelas = $controllerCARTAO->arrResposta[0]['parcelas'];
		$arr = array();
		for($i=1; $i<($num_parcelas+1);$i++)
		{
			$arr[$i] = $i;
		}

		echo selectCombo("-- Selecione --",$arr,false,$_POST['id'],false,false,false);
	break;
	case 'selectBancoCombo':
		$controllerBANCOS = new controllerBANCOS('select');
		echo selectCombo("-- Banco --",$controllerBANCOS->arrResposta,true,$_POST['id'],"id_banco","banco",true);
	break;
	case 'selectTipoPagamento':
		$where =' p.idreserva = '.$_POST['idreserva'];
		$controllerPAGAMENTO = new controllerPAGAMENTO('selectTipoPagamento',false,$where);
		for($i=0; $i<count($controllerPAGAMENTO->arrResposta); $i++)
		{
			$controllerPAGAMENTO->arrResposta[$i]['tipo_pagamento'] = utf8_encode($controllerPAGAMENTO->arrResposta[$i]['tipo_pagamento']);
		}
		
		if(empty($controllerPAGAMENTO->arrResposta))
		{
			echo "0";
			return false;
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerPAGAMENTO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectCatCentro':
		$controllerCAT_CENTRO = new controllerCAT_CENTRO('select');
		echo selectCombo("-- Selecione --",$controllerCAT_CENTRO->arrResposta,true,$_POST['id'],"id_cat_centro","categoria_centro",true);
	break;
	case 'cadastroCentroCusto':
		$arr = array("id_sub_cat_centro"=>$_POST["formSelectSubCategoria"],
					 "valor"=>formatValor($_POST["formValorPagamento"]),
					 "descricao"=>$_POST["formDescricao"],
					 "data"=>$_POST["formData"],
					 "data_cadastro"=>DATE_NOW,
					 "tipo_pagamento"=>$_POST["formSelecFormPagamento"]);

		if(isset($_POST["formSelectFornecedor"]))
			$arr['id_fornecedor'] = $_POST["formSelectFornecedor"];

		if($_POST["formSelecFormPagamento"] == 2)
		{
			$arr['id_cartao'] = $_POST["formSelectCartao"];

			if(isset($_POST["formSelectParcelas"]))
				$arr['parcelas'] = $_POST["formSelectParcelas"];
		}

		if($_POST['formSelecFormPagamento'] != 4) 
		{
			$controllerCENTRO_CUSTO = new controllerCENTRO_CUSTO('insert',$arr);
			if($controllerCENTRO_CUSTO->resposta == "1")
			{
				$retorno["resposta"]  = "1";
				$retorno["msg"]		  = "Registro cadastro com sucesso";
			}
			else
				$retorno["resposta"]  = "Ocorreu erro no banco ao incluir registro!";	
		}

		if($_POST['formSelecFormPagamento'] == 4) // Depósito
		{
			$controllerCENTRO_CUSTO = new controllerCENTRO_CUSTO('insert_last_id',$arr);
			$id_centro_custo 		= $controllerCENTRO_CUSTO->arrResposta[0]['last_id'];

			$id_banco = $_POST['formSelectDepBanco'];

			$arrDep   = array(	"id_banco"=>$id_banco,
								"agencia"=>$_POST['formAgencia'],
								"conta"=>$_POST['formConta'],
								"tipo_conta"=>$_POST['formSelectTipoConta'],
								"id_centro_custo"=>$id_centro_custo);

			$controllerDEPOSITO_CONTA = new controllerDEPOSITO_CONTA('insert',$arrDep);

			if($controllerDEPOSITO_CONTA->resposta == "1")
			{
				$retorno["resposta"] = "1";
				$retorno["msg"]		 = "Registro cadastro com sucesso";
			}
			else
				$retorno["resposta"]  = "Ocorreu erro no banco ao incluir registro!";
		}

		echo json_encode($retorno);
	break;
	case 'selectCentroCustoTable':
		$where = "";

		if(isset($_POST['formSelectCategoria']))
			$where .= " and ct.id_cat_centro = ".$_POST['formSelectCategoria'];

		if(isset($_POST['formSelectSubCategoria']))
			$where .= " and sc.id_sub_cat_centro = ".$_POST['formSelectSubCategoria'];
		
		if(isset($_POST['formDtInicial']) && isset($_POST['formDtFinal']))
			$where .= " and c.data BETWEEN '".$_POST['formDtInicial']."' and '".$_POST['formDtFinal']."'";

		if(isset($_POST['formDtInicial']) && !isset($_POST['formDtFinal']))
			$where .= " and c.data = '".$_POST['formDtInicial']."'";

		if(isset($_POST['formStatus']))
			$where .= " and status = '$_POST[formStatus]'";
		else
			$where .= " and c.status is null";

		if(!empty($where))
			$controllerCENTRO_CUSTO = new controllerCENTRO_CUSTO('select',false,$where);
		else
			$controllerCENTRO_CUSTO = new controllerCENTRO_CUSTO('select');

		if(empty($controllerCENTRO_CUSTO->arrResposta))
		{
			echo "0";
			return false;
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerCENTRO_CUSTO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'cadastroCatCentroCusto':
		$arr = array("categoria_centro"=>$_POST["formCategoria"]);

		$controllerCAT_CENTRO = new controllerCAT_CENTRO('insert_last_id',$arr);
		$id_cat_centro = $controllerCAT_CENTRO->arrResposta[0]['last_id'];

		if($id_cat_centro)
		{
			$retorno["id_cat_centro"] 	= $id_cat_centro;
			$retorno["msg"]		 		= "Categoria cadastrada com sucesso";
		}
		else
		{
			$retorno["resposta"]  = "0";
			$retorno["msg"]		 = "Ocorreu erro no banco ao incluir registro!";
		}
		echo json_encode($retorno);
	break;
	case 'selectCatCentro':
		$controllerCAT_CENTRO = new controllerCAT_CENTRO('select');
		echo selectCombo("-- Selecione --",$controllerCAT_CENTRO->arrResposta,true,$_POST['id'],"id_cat_centro","categoria_centro",true);
	break;
	case 'cadastroSubCatCentroCusto':
		$arr = array("id_cat_centro"=>$_POST['formSelectCatCentro'],
					 "sub_cat_centro"=>$_POST['formSubCategoria']);

		if(isset($_POST['formObservacao']))
			$arr["descricao"] = $_POST['formObservacao'];

		$controllerSUB_CAT_CENTRO = new controllerSUB_CAT_CENTRO('insert',$arr);

		if($controllerSUB_CAT_CENTRO->resposta == "1")
		{
			$retorno["resposta"] 	= "1";
			$retorno["msg"]		 	= "Sub-categoria cadastrada com sucesso";
		}
		else
		{
			$retorno["resposta"]  = "0";
			$retorno["msg"]		 = "Ocorreu erro no banco ao incluir registro!";
		}
		echo json_encode($retorno);
	break;
	case 'selectSubCentro':
		$where = " id_cat_centro=".$_POST['id'];
		$controllerSUB_CAT_CENTRO = new controllerSUB_CAT_CENTRO('select',false,$where);
		if(empty($controllerSUB_CAT_CENTRO->arrResposta))
		{
			echo "0";
			return false;
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerSUB_CAT_CENTRO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'excluiSubCatCentroCusto':
		$arr = array("id_sub_cat_centro"=>$_POST["id_sub_cat_centro"],
					"ativo"=>'f');

		$controllerSUB_CAT_CENTRO = new controllerSUB_CAT_CENTRO('update',$arr);
		if($controllerSUB_CAT_CENTRO->resposta == "1")
		{
			$retorno["resposta"] 	= "1";
			$retorno["msg"]		 	= "Sub-categoria excluida com sucesso";
		}
		else
		{
			$retorno["resposta"]  = "0";
			$retorno["msg"]		 = "Ocorreu erro no banco ao incluir registro!";
		}
		echo json_encode($retorno);
	break;
	case 'selectTableCatCentro':
		$controllerCAT_CENTRO = new controllerCAT_CENTRO('select');
		if(empty($controllerCAT_CENTRO->arrResposta))
		{
			echo "0";
			return false;
		}
		$strJSON = json_encode('{"rows":'.json_encode($controllerCAT_CENTRO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectSubCentroCombo':
		$where = " id_cat_centro=".$_POST['id'];
		$controllerSUB_CAT_CENTRO = new controllerSUB_CAT_CENTRO('select',false,$where);
		echo selectCombo("-- Selecione --",$controllerSUB_CAT_CENTRO->arrResposta,true,$_POST['id'],"id_sub_cat_centro","sub_cat_centro",false);
	break;
	case 'confirmarPagamentoCP':
		$arrIdsCentroCusto  = explode(",",$_POST['arrIdsCentroCusto']);
		$ids_centro_custo 	= implode(",",$arrIdsCentroCusto);

		$arr = array("status"=>"P","id_centro_custo"=>$ids_centro_custo);

		$controllerCENTRO_CUSTO = new controllerCENTRO_CUSTO('update',$arr);
		if($controllerCENTRO_CUSTO->resposta == "1")
		{
			$retorno["resposta"] 	= "1";
			$retorno["msg"]		 	= "Baixa efetuada com sucesso";
		}
		else
		{
			$retorno["resposta"]  = "0";
			$retorno["msg"]		 = "Ocorreu erro no banco ao incluir registro!";
		}
		echo json_encode($retorno);
	break;
	case 'selectFormaPagamento':
		$arrDisponibilidade = array("Dinheiro"=>"1",
									"Cartão"=>"2",
									"Depósito"=>"4");

		echo selectCombo("-- Selecione --",$arrDisponibilidade,false,$_POST['id'],false,false,false);
	break;
	case 'selectDadosCentroCusto':
		$arr = array("id_centro_custo"=>$_POST["id_centro_custo"]);
		$controllerCENTRO_CUSTO = new controllerCENTRO_CUSTO('selectDadosJson',$arr);
		echo $controllerCENTRO_CUSTO->resposta;
	break;
	case 'selectHospedeTable':
		$where = "";

		if(isset($_POST['formSelectQuarto']))
		{
			if(isset($_POST['formNomeHospede']))
				$where .= " and nome like '%".$_POST['formNomeHospede']."%'";

			$where .= " and r.idquarto = $_POST[formSelectQuarto]";
		}
		else
		{
			if(isset($_POST['formNomeHospede']))
				$where .= " nome like '%".$_POST['formNomeHospede']."%'";
		}

		if(isset($_POST['arrIdsHospede']))
		{
			$arrIdsHospede  = explode(",",$_POST['arrIdsHospede']);
			$ids_hospede 	= implode(",",$arrIdsHospede);

			if(isset($_POST['formSelectQuarto']))
				$where .= " and h.idhospede not in($ids_hospede)";
			else
			{
				if(empty($where))
					$where .= " idhospede not in($ids_hospede)";
				else
					$where .= " and idhospede not in($ids_hospede)";
			}
		}


		if(!empty($where))
		{
			if(!isset($_POST['formSelectQuarto']))
				$controllerHOSPEDE = new controllerHOSPEDE('selectHospedeTable',false,$where);
			else
			{
				$controllerHOSPCONF = new controllerHOSPCONF('select',false,$where);
				$strJSON = json_encode('{"rows":'.json_encode($controllerHOSPCONF->arrResposta)."}");
				echo($strJSON);
				return false;
			}
		}
		else
			$controllerHOSPEDE = new controllerHOSPEDE('selectHospedeTable');

		$strJSON = json_encode('{"rows":'.json_encode($controllerHOSPEDE->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectHospedeMultipleCombo':
		$arrIdsHospede  = explode(",",$_POST['arrIdsHospede']);
		$ids_hospede 	= implode(",",$arrIdsHospede);
		$where = " idhospede in ($ids_hospede)";
	/*	
		
		$ids_hospede 	= implode(",",$arrIdsHospede);
		if(!isset($_POST['idreserva']))
		{
			$where = " idhospede in ($ids_hospede) ";
		}
		else
		{
			if(count($arrIdsHospede) != 1)
				$where = " idhospede in ($ids_hospede) ";
			else
			{
				$where .= " idhospede in ($ids_hospede) ";
				$where .= " union all select idhospede,nome from HOSPEDE where idhospede in (select id_hospede from RESERVA_HOSPEDE where id_reserva in ($_POST[idreserva]) and ativo is null) ";
			}
		}
		
	*/
		$controllerHOSPEDE = new controllerHOSPEDE('selectHospedeTable',false,$where);
		$strJSON = json_encode($controllerHOSPEDE->arrResposta);
		echo($strJSON);
	break;
	case 'cadastroContatos':
		$arr 					= array();
		$arr['nome']			= $_POST['formNome'];
		$arr['id_estado'] 		= $_POST['formSelectEstado'];
		$arr['id_cidade'] 		= $_POST['formSelectCidade'];
		$arr['telefone'] 		= $_POST['formTelefone'];
		
		if(!empty($_POST['formCep']))
			$arr['cep'] 			= $_POST['formCep'];

		if(!empty($_POST['formEndereco']))
			$arr['endereco'] 		= $_POST['formEndereco'];

		if(!empty($_POST['formBairro']))
			$arr['bairro'] 			= $_POST['formBairro'];

		if(!empty($_POST['formSelectEstrelas']))
			$arr['estrelas'] 		= $_POST['formSelectEstrelas'];

		if(isset($_POST['formSelectFonte']))
			$arr['fonte'] 			= $_POST['formSelectFonte'];
		else
			$arr['fonte_nome'] 		= $_POST['formFonteNome'];

		if(!empty($_POST['formCep']))
			$arr['observacao'] 		= $_POST['formObservacao'];

		$arr['data_cadastro'] 	= DATE_NOW;

		$where =  " telefone = '".trim($_POST['formTelefone'])."'";
		$controllerCONTATOS = new controllerCONTATOS('select',false,$where);
		if(!empty($controllerCONTATOS->arrResposta))
		{
			$nome_contato 		 = $controllerCONTATOS->arrResposta[0]['nome'];
			$cidade 			 = $controllerCONTATOS->arrResposta[0]['nomecidade'];
			$estado		 		 = $controllerCONTATOS->arrResposta[0]['nomeestado'];
			$telefone 			 = $controllerCONTATOS->arrResposta[0]['telefone'];

			$msg  = "Contato já existe: ".$nome_contato;
			$msg .= "\n Telefone: ".$telefone;
			$msg .= "\n Estado:	  ".$estado;
			$msg .= "\n Cidade:   ".$cidade;

			$retorno["msg"]		 	= $msg;
			$retorno["resposta"] 	= "1";
		}
		else
		{
			$controllerCONTATOS = new controllerCONTATOS('insert',$arr);
			if($controllerCONTATOS->resposta == "1")
			{
				$retorno["resposta"] 	= "1";
				$retorno["msg"]		 	= "Contato Cadastrado";
			}
			else
			{
				$retorno["resposta"]  = "0";
				$retorno["msg"]		 = "Ocorreu erro no banco ao incluir registro!";
			}
		}
		echo json_encode($retorno);
		return;
	break;
	case 'cadastroPesquisaContato':
	case 'updatePesquisaContato':
		$arr 						= array();

		if(!isset($_POST['formIdPesquisaContato']))
			$arr['id_contato'] 			= $_POST['formSelectContato'];

		$arr['nome'] 				= $_POST['formNome'];
		$arr['cargo'] 				= $_POST['formCargo'];
		$arr['estrelas'] 			= $_POST['formSelectEstrelas'];
		$arr['num_quartos'] 		= $_POST['formNQuartos'];
		$arr['num_colaboradores'] 	= $_POST['formNColaboradores'];
		$arr['taxa_ocupacao'] 		= $_POST['formSelectOcupacao'];
		$arr['observacao_taxa'] 	= $_POST['formObservacaoTaxa'];

		$arr['sistema'] 			= $_POST['formSelectSoftware'];

		if($_POST['formSelectSoftware'] == 'S')
		{
			$arr['nome_sistema'] 		= $_POST['formNSoftware'];
			$arr['tipo_sistema'] 		= $_POST['formSelectTipoSoftware'];

			if(isset($_POST['formSelectTempoUso']))
				$arr['tempo_uso'] 			= $_POST['formSelectTempoUso'];
			else
				$arr['tempo_uso'] 			= $_POST['formTempo'];

			$arr['custo'] 					= $_POST['formCusto'];

			$arr['satisfeito'] 				= $_POST['formSelectSatisfeito'];
			$arr['observacao_satisfeito'] 	= $_POST['formObsSatisfeito'];
			$arr['observacao_falta'] 		= $_POST['formObsFalta'];
			$arr['suporte'] 				= $_POST['formSelectSuporte'];
			$arr['observacao_suporte'] 		= $_POST['formObsSuporte'];
			$arr['possui_erros'] 			= $_POST['formSelectPossuiErros'];
			$arr['observacao_erros'] 		= $_POST['formObsErros'];
			$arr['numero_usuarios'] 		= $_POST['formPUtil'];
			$arr['observacao_controle']		= $_POST['formObsControle'];
			$arr['motor_vendas'] 			= $_POST['formSelectMotor'];
			$arr['nfe']						= $_POST['formSelectNFE'];
			$arr['observacao_motor_nfe'] 	= $_POST['formObsNFE'];
		}
		else
		{
			$arr['observacao_c_atual'] 	= $_POST['formObsControleAtual'];
			$arr['observacao_sistema'] 	= $_POST['formObsSoftware'];
		}

		if(isset($_POST['formSelectPrioridade']))
			$arr['prioridade'] 		= $_POST['formSelectPrioridade'];

		$arr['observacao_gerais'] 		= $_POST['formObsGerais'];
		$arr['situacao_pesquisa'] 		= $_POST['formSelectSituacao'];
		$arr['id_usuario'] 				= $_SESSION['idusuario'];

		if(!isset($_POST['formIdPesquisaContato']))
		{
			$arr['data_cadastro'] 		= DATE_NOW;
			$controllerPESQUISA_CONTATO = new controllerPESQUISA_CONTATO('insert',$arr);
			echo $_SESSION['sql'];
			return;
		}
		else
		{
			$arr['id_pesquisa'] 		= $_POST['formIdPesquisaContato'];
			$controllerPESQUISA_CONTATO = new controllerPESQUISA_CONTATO('update',$arr);
		}

		if($controllerPESQUISA_CONTATO->resposta == "1")
		{
			$retorno["resposta"] 	= "1";
			$retorno["msg"]		 	= "Pesquisa Finalizada";
		}
		else
		{
			$retorno["resposta"]  = "0";
			$retorno["msg"]		 = "Ocorreu erro no banco ao incluir registro!";
		}
		echo json_encode($retorno);
		return;
	break;
	case 'selectContatosCombo':
		if(!isset($_POST['id2']))
		{
			$where = $_POST['id'];
			$where = "  id_contato not in ( select id_contato from PESQUISA_CONTATO) and $where ";
		}
		else
			$_POST['id'] = $_POST['id2'];

		$controllerCONTATOS = new controllerCONTATOS('select',false,$where);
		echo selectCombo("-- Selecione --",$controllerCONTATOS->arrResposta,true,$_POST['id'],"id_contato","nome",true,true);
	break;
	case 'selectDadosContato':
		$arr = array("id_contato"=>$_POST["id_contato"]);
		$controllerCONTATOS = new controllerCONTATOS('selectDadosJson',$arr);
		echo $controllerCONTATOS->resposta;
	break;
	case 'selectPesquisaContatoTable':
		$where = '';

		if(isset($_POST["formSelectEstado"]))
			$where  .= " c.id_estado = ".$_POST["formSelectEstado"];

		if(isset($_POST["formSelectCidade"]))
		{
			if(empty($where))
				$where  .= " c.id_cidade = ".$_POST["formSelectCidade"];
			else
				$where  .= " and c.id_cidade = ".$_POST["formSelectCidade"];
		}

		if(isset($_POST["formSelectSoftware"]))
		{
			if(empty($where))
				$where  .= " pc.sistema = '".$_POST["formSelectSoftware"]."'";
			else
				$where  .= " and pc.sistema = '".$_POST["formSelectSoftware"]."'";
		}

		if(isset($_POST["formSelectSituacao"]))
		{
			if(empty($where))
				$where  .= " pc.situacao_pesquisa = '".$_POST["formSelectSituacao"]."'";
			else
				$where  .= " and pc.situacao_pesquisa = '".$_POST["formSelectSituacao"]."'";
		}
		
		if(isset($_POST["formSelectPrioridade"]))
		{
			if(empty($where))
				$where  .= " pc.prioridade = '".$_POST["formSelectPrioridade"]."'";
			else
				$where  .= " and pc.prioridade = '".$_POST["formSelectPrioridade"]."'";
		}
	
		if(isset($_POST["formDtaIni"]) && isset($_POST["formDtaFinal"]))
		{
			if(empty($where))
				$where .= "  cast(pc.data_cadastro as date)  BETWEEN '".($_POST['formDtaIni'])."' and '".($_POST['formDtaFinal'])."'";
			else
				$where  .= " and  cast(pc.data_cadastro as date)  BETWEEN '".($_POST['formDtaIni'])."' and '".($_POST['formDtaFinal'])."'";
		}

		if(!empty($where))
			$controllerPESQUISA_CONTATO = new controllerPESQUISA_CONTATO('select',false,$where);
		else
			$controllerPESQUISA_CONTATO = new controllerPESQUISA_CONTATO('select');

		if(empty($controllerPESQUISA_CONTATO->arrResposta))
		{
			echo "0";
			return false;
		}

		for($i=0; $i<count($controllerPESQUISA_CONTATO->arrResposta); $i++)
		{
			$controllerPESQUISA_CONTATO->arrResposta[$i]['contato'] = utf8_encode($controllerPESQUISA_CONTATO->arrResposta[$i]['contato']);
		}
		
		$strJSON = json_encode('{"rows":'.json_encode($controllerPESQUISA_CONTATO->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectDadosPesquisaContato':
		$arr = array("id_pesquisa"=>$_POST["id_pesquisa"]);
		$controllerPESQUISA_CONTATO = new controllerPESQUISA_CONTATO('selectDadosJson',$arr);
		echo $controllerPESQUISA_CONTATO->resposta;
	break;
	case 'carregaJsonHospedes':
		if(!isset($_POST['idreserva']))
			$controllerHOSPEDE = new controllerHOSPEDE('selectHospede');
		else
		{
			$where = " and idhospede not in (select id_hospede from RESERVA_HOSPEDE where id_reserva = $_POST[idreserva] and ativo is null)";
			$controllerHOSPEDE = new controllerHOSPEDE('selectHospede',false,$where);
		}

		$arr 	= array();
		$arrRet = array();
		foreach($controllerHOSPEDE->arrResposta as $dados)
		{
				$arr = array(label => utf8_encode($dados['nome']),value=>"$dados[idhospede]");
				array_push($arrRet,$arr);
		}
		echo stripslashes(json_encode($arrRet));
	break;
	case 'selectReservaHospede':
		$where  = " where rh.id_reserva = $_POST[id]";
		$controllerRESERVA_HOSPEDE = new controllerRESERVA_HOSPEDE('select',false,$where);
		if(empty($controllerRESERVA_HOSPEDE->arrResposta))
		{
			echo "0";
			return false;
		}
		
		for($i=0; $i<count($controllerRESERVA_HOSPEDE->arrResposta); $i++)
		{
			$controllerRESERVA_HOSPEDE->arrResposta[$i]['nome'] = utf8_encode($controllerRESERVA_HOSPEDE->arrResposta[$i]['nome']);
		}
	
		$strJSON = json_encode('{"rows":'.json_encode($controllerRESERVA_HOSPEDE->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectDadosReservaHospede':
		$where  = " where rh.id_reserva = $_POST[idreserva]";
		$controllerRESERVA_HOSPEDE = new controllerRESERVA_HOSPEDE('select',false,$where);
		if(empty($controllerRESERVA_HOSPEDE->arrResposta))
		{
			echo "0";
			return false;
		}

		$ids_hospede = "";
		foreach($controllerRESERVA_HOSPEDE->arrResposta as $dados)
		{
				empty($ids_hospede) ? $ids_hospede .= $dados['id_hospede'] : $ids_hospede .= ",".$dados['id_hospede'];
		}
		
		echo $ids_hospede;
	break;
	case 'updateComboOption':
		$arr = array();

		$arr["ativo"] 	   = 'N';
		$arr["id_reserva"] = $_POST['id_reserva'];
		$arr["id_hospede"] = $_POST['arrIdsHospede'];

		$controllerRESERVA_HOSPEDE = new controllerRESERVA_HOSPEDE('update',$arr);
		echo $controllerRESERVA_HOSPEDE->resposta;
	break;
	default:
}
?>