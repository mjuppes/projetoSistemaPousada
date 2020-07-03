<?php session_start(); ?>
<?php include('../CONFIG/config.php');?>
<?php include('../'.DIR_DAO);?>
<?php #include('../'.DIR_ACTIONS.'genericFunction.php');?>
<?php include('../'.DIR_CLASSES.'controllerCLIENTE.php');?>
<?php include('../'.DIR_CLASSES.'controllerPRODUTOS.php');?>
<?php include('../'.DIR_CLASSES.'controllerPROPOSTASERV.php');?>

<?php
$_SESSION['idusuario'] = $_SESSION['usuario'];
$_SESSION['numRows'] = "";
$_SESSION['numPage'] = "";

switch($_POST['controller'])
{
	case 'cadastroCliente':
		$arr = array("nome"=>$_POST["formNomeCliente"]
					,"email"=>$_POST["formEmail"]
					,"cnpj"=>$_POST["formCNPJ"]
					,"telefone"=>$_POST["formTelefone"]
					,"contato"=>$_POST["formContato"]);

		$controllerCLIENTE = new controllerCLIENTE('insert',$arr);
		echo $controllerCLIENTE->resposta;
	break;
	case 'selectClientes':
		$_SESSION['numRows'] = $_POST["numRows"];
		$_SESSION['numPage'] = $_POST["numPage"];

		if(isset($_POST["filtro"]) && $_POST["filtro"] == true)
		{
			$arr = array();
			$arr['filtro'] = true;
			$where = " where nome like '%$_POST[formNomeCliente]%'";

			$controllerCLIENTE = new controllerCLIENTE('selectClientes', $arr,$where);

		}
		else
		{
			if($_POST['id'])
			{
				$arr = array("idcliente"=>$_POST['id']);
				$controllerCLIENTE = new controllerCLIENTE('selectClientes', $arr);
			}
			else
			{
				$controllerCLIENTE = new controllerCLIENTE('selectClientes');
			}
		}

		if(empty($controllerCLIENTE->arrResposta))
		{
			echo "<tr><td colspan='7' align='center'>".('Nenhum cliente encontrado.')."</td></tr>";
			return false;
		}

		$strJSON = json_encode('{"rows":'.json_encode($controllerCLIENTE->arrResposta)."}");
		echo($strJSON);
	break;
	case 'selectDadosCliente':
		$arr = array("idcliente"=>$_POST["idcliente"]);
		$controllerCLIENTE = new controllerCLIENTE('selectDadosJsonCliente',$arr);
		echo $controllerCLIENTE->resposta;
	break;
	case 'updateCliente':
		$arr = array("nome"=>$_POST["formNomeCliente"]
					,"email"=>$_POST["formEmail"]
					,"cnpj"=>$_POST["formCNPJ"]
					,"telefone"=>$_POST["formTelefone"]
					,"contato"=>$_POST["formContato"]
					,"idcliente"=>$_POST["formIdCliente"]);

		$controllerCLIENTE = new controllerCLIENTE('update',$arr);
		echo $controllerCLIENTE->resposta;
	break;
	case 'delete':
		$arr = array("idcliente"=>$_POST["idcliente"]);
		$controllerCLIENTE = new controllerCLIENTE('delete',$arr);
		echo $controllerCLIENTE->resposta;
	break;
	case 'selectComboCliente':
		$controllerCLIENTE = new controllerCLIENTE('selectClientes');

		$strClientes = "";
		$strClientes .= "<option value=''>".utf8_encode("Selecione um cliente")."</option>";
		foreach($controllerCLIENTE->arrResposta as $dados)
		{
				if(isset($_POST['id']))
				{
					if($_POST['id'] == $dados['idcliente'])
					{
						$strClientes .= "<option SELECTED value='".($dados['idcliente'])."' >".utf8_encode($dados['nome'])."</option>";
					}
					else
					{
						$strClientes .= "<option value='".($dados['idcliente'])."' >".utf8_encode($dados['nome'])."</option>";
					}
				}
				else
				{
					$strClientes .= "<option value='".($dados['idcliente'])."' >".utf8_encode($dados['nome'])."</option>";
				}
		}
		echo $strClientes;
	break;
	case 'selectPropostaCliente':
		if(isset($_POST["filtro"]) && $_POST["filtro"] == true)
		{
			$arr = array();
			$arr['filtro'] = true;
			$where = " pr.efetuada = 'S'  and c.idcliente = ".$_POST["idcliente"];
			$controllerPRODUTOS = new controllerPRODUTOS('selectPropostaProduto', $arr,$where);
		}
		else
		{
			$arr = array("idcliente"=>$_POST["id"]);
			$controllerPRODUTOS = new controllerPRODUTOS('selectPropostaProduto',$arr);
		}


		if(empty($controllerPRODUTOS->arrResposta))
		{
			echo "<tr><td colspan='8' align='center'>".('Nenhum proposta encontrada.')."</td></tr>";
			return false;
		}

		$strTableProdProposta = "";
		foreach($controllerPRODUTOS->arrResposta as $dados)
		{
				$strTableProdProposta .= "<tr>";
				$strTableProdProposta .= "<td align=center>".($dados['nome'])."</td>";
				$strTableProdProposta .= "<td align=center>".($dados['projeto'])."</td>";
				$strTableProdProposta .= "<td align=center>".($dados['modelo'])."</td>";
				$strTableProdProposta .= "<td align=center>".($dados['data'])."</td>";
				$strTableProdProposta .= "<td align=center>".($dados['codproduto'])."</td>";
				$strTableProdProposta .= "<td align=center>".($dados['preco'])."</td>";
				$strTableProdProposta .= "<td align=center>".($dados['efetuada'])."</td>";
				$strTableProdProposta .= "<td align=center class='colAcoes'>";
				$strTableProdProposta .= "<a href='../produtos/visualizar_proposta.php?idproduto=".$dados['idproduto']."&idproposta=".$dados['idproposta']."&idcliente=".$dados['idcliente']."' title='Visualizar' class='btnAcoes btnVisualizar'/>";
				$strTableProdProposta .= "</td>";
				$strTableProdProposta .= "</tr>";
		}
		echo utf8_encode($strTableProdProposta);
	break;
	case 'selectPropClienteServico':
		$arr = array("idcliente"=>$_POST["id"]);

		if(isset($_POST["filtro"]) && $_POST["filtro"] == true)
		{
			$arr = array();
			$arr['filtro'] = true;
			$where = " where  p.efetuada = 'S'  and c.idcliente = ".$_POST["idcliente"];
			$controllerPROPOSTASERV = new controllerPROPOSTASERV('selectPropClienteServico', $arr,$where);
		}
		else
		{
			$controllerPROPOSTASERV = new controllerPROPOSTASERV('selectPropClienteServico',$arr);
		}

		if(empty($controllerPROPOSTASERV->arrResposta))
		{
			echo "<tr><td align='center' colspan='8'>".('Nenhuma proposta encontrada')."</td></tr>";
			return false;
		}

		$strTablePropServ = "";
		foreach($controllerPROPOSTASERV->arrResposta as $dados)
		{
				$strTablePropServ .= "<tr>";
				$strTablePropServ .= "<td align=center>".($dados['nomecliente'])."</td>";
				$strTablePropServ .= "<td align=center>".($dados['nomeservico'])."</td>";
				$strTablePropServ .= "<td align=center>".($dados['numprop'])."</td>";
				$strTablePropServ .= "<td align=center>".($dados['dataproposta'])."</td>";
				$strTablePropServ .= "<td align=center>".($dados['preco'])."</td>";
				$strTablePropServ .= "<td align=center>".($dados['efetuada'])."</td>";
				$strTablePropServ .= "<td align=center class='colAcoes'>";
				$strTablePropServ .= "<a href='../servicos/visualizar_proposta.php?idpropostaserv=".$dados['idpropostaserv']."&idordemservtec=".$dados['idordemservtec']."&visualizar=true' title='Visualizar' class='btnAcoes btnVisualizar'/>";
				$strTablePropServ .= "</td>";
				$strTablePropServ .= "</td>";
				$strTablePropServ .= "</tr>";
		}
		echo utf8_encode($strTablePropServ);	
	default:
}
?>