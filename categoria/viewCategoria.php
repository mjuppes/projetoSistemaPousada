<?php session_start(); ?>
<?php include('../CONFIG/config.php');?>
<?php include('../'.DIR_DAO);?>
<?php include('../'.DIR_ACTIONS.'genericFunction.php');?>
<?php include('../'.DIR_CLASSES.'controllerCATEGORIA.php');?>
<?php include('../'.DIR_CLASSES.'controllerFORNECEDOR.php');?>
<?php include('../'.DIR_CLASSES.'controllerSERVICOS.php');?>

<?php
$_SESSION['idusuario'] = $_SESSION['usuario'];

switch($_POST['controller'])
{
	case 'cadastroCategoria':
		$arr = array("idservico"=>$_POST["formSelectServicos"],
					"idfornecedor"=>$_POST["formSelectFornecedor"],
					"nome"=>utf8_decode($_POST["formCategoria"]));

		$controllerCATEGORIA = new controllerCATEGORIA('insert',$arr);
		echo $controllerCATEGORIA->resposta;
	break;
	case 'selectCategorias':
		$controllerCATEGORIA = new controllerCATEGORIA('selectCategoria');
	
		if(empty($controllerCATEGORIA->arrResposta))
		{
			echo "<tr><td colspan='4' align='center'>".utf8_encode('Nenhuma licença encontrada.')."</td></tr>";
			return false;
		}

		$strCategorias = "";
		foreach($controllerCATEGORIA->arrResposta as $dados)
		{
			$strCategorias .= "<tr>";
			$strCategorias .= "<td align=center>".($dados['nomeservico'])."</td>";
			$strCategorias .= "<td align=center>".$dados['nomefornecedor']."</td>";
			$strCategorias .= "<td align=center>".($dados['nomecategoria'])."</td>";
			$strCategorias .= "<td align=center class='colAcoes'>";	
			$strCategorias .= "<a href='cadastro_categoria.php?idcategoria=".$dados['idcategoria']."&editar=true' class='btnEditar btnAcoes colAcoes' alt='Editar'></a>";
			$strCategorias .= "<span class='btnExcluir btnAcoes colAcoes' onclick='excluiCategoria(".$dados['idcategoria'].")' value='' title='Excluir'></span>";
			$strCategorias .= "</td>";
			$strCategorias .= "</tr>";
		}
		echo utf8_encode($strCategorias);
	break;
	case 'selectDadosCategoria':
		$arr = array("idcategoria"=>$_POST["idcategoria"]);
		$controllerCATEGORIA = new controllerCATEGORIA('selectDadosJsonCategoria',$arr);
		echo $controllerCATEGORIA->resposta;
	break;
	case 'updateCategoria':
		$arr = array("idservico"=>$_POST["formSelectServicos"],
					"idfornecedor"=>$_POST["formSelectFornecedor"],
					"nome"=>utf8_decode($_POST["formCategoria"]),
					"idcategoria"=>$_POST["formIdCategoria"]);

		$controllerCATEGORIA = new controllerCATEGORIA('update',$arr);
		echo $controllerCATEGORIA->resposta;
	break;
	case 'delete':
		$arr = array("idcategoria"=>$_POST["idcategoria"]);
		$controllerCATEGORIA = new controllerCATEGORIA('delete',$arr);
		echo $controllerCATEGORIA->resposta;
	break;
	case 'selectFornecedor':
		$controllerFORNECEDOR = new controllerFORNECEDOR('selectFornecedor');

		$strFornecedor = "";
		$strFornecedor .= "<option value=''>".utf8_encode("Selecione um fornecedor")."</option>";

		if(empty($controllerFORNECEDOR->arrResposta))
		{
			return false;
		}

		foreach($controllerFORNECEDOR->arrResposta as $dados)
		{
				if(isset($_POST['id']))
				{
					if($_POST['id'] == $dados['idfornecedor'])
					{
						$strFornecedor .= "<option SELECTED value='".($dados['idfornecedor'])."' >".$dados['nome']."</option>";
					}
					else
					{
						$strFornecedor .= "<option value='".($dados['idfornecedor'])."' >".$dados['nome']."</option>";
					}
				}
				else
				{
					$strFornecedor .= "<option value='".($dados['idfornecedor'])."' >".$dados['nome']."</option>";
				}
		}
		echo $strFornecedor;
	break;
	case 'selectServicos':
		$controllerSERVICOS = new controllerSERVICOS('selectServicos');

		$strServico = "";
		$strServico .= "<option value=''>".("Selecione um serviço")."</option>";

		if(empty($controllerSERVICOS->arrResposta))
		{
			return false;
		}

		foreach($controllerSERVICOS->arrResposta as $dados)
		{
				if(isset($_POST['id']))
				{
					if($_POST['id'] == $dados['idservico'])
					{
						$strServico .= "<option SELECTED value='".($dados['idservico'])."' >".$dados['nome']."</option>";
					}
					else
					{
						$strServico .= "<option value='".($dados['idservico'])."' >".$dados['nome']."</option>";
					}
				}
				else
				{
					$strServico .= "<option value='".($dados['idservico'])."' >".$dados['nome']."</option>";
				}
		}
		echo utf8_encode($strServico);
	break;
	default:
}
?>