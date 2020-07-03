<?php session_start(); ?>
<?php include('../CONFIG/config.php');?>
<?php include('../'.DIR_DAO);?>
<?php include('../'.DIR_ACTIONS.'genericFunction.php');?>
<?php include('../'.DIR_CLASSES.'controllerPESQUISA.php');?>
<?php include('../'.DIR_CLASSES.'controllerPARAMETRO.php');?>
<?php include('../'.DIR_CLASSES.'controllerPERGUNTA.php');?>
<?php include('../'.DIR_CLASSES.'controllerRESPOSTA.php');?>

<?php
 switch($_POST['controller'])
 {
		case 'cadastroPesquisa';
			$arr = array('nomepesquisa'=>$_POST["formNomePesquisa"]);
			
			$controllerPESQUISA = new controllerPESQUISA('insert',$arr);
			if($controllerPESQUISA->resposta == 1)
			{
				$controllerPESQUISA = new controllerPESQUISA('lastIdPesquisa');
				$idpesquisa = $controllerPESQUISA->resposta;
				echo $idpesquisa;
			}
			else
				echo "Erro3";
		break;
		case 'selectPesquisa':
			$controllerPESQUISA = new controllerPESQUISA('select');
			if(empty($controllerPESQUISA->arrResposta))
			{
				echo "0";
				return false;
			}
			$strJSON = json_encode('{"rows":'.json_encode($controllerPESQUISA->arrResposta)."}");
			echo($strJSON);
		break;
		case 'selectDadosPesquisa':
			$arr = array("idpesquisa"=>trim($_POST["idpesquisa"]));
			$controllerPESQUISA = new controllerPESQUISA('selectDadosJson',$arr);
			echo $controllerPESQUISA->resposta;
		break;
		case 'updatePesquisa':
			$arr = array("idpesquisa"=>$_POST["formIdPesquisa"],
						"nomepesquisa"=>$_POST["formNomePesquisa"]);

			$controllerPESQUISA = new controllerPESQUISA('update',$arr);
			echo $controllerPESQUISA->resposta;
		break;
		case 'cadastroParametros':
			$arrParametros = array();
			$arrParametros = explode(",",$_POST["arrParametros"]);

			$cont = 0;
			foreach($arrParametros as $key => $value)
			{
				$arr = array("idpesquisa"=>trim($_POST["idpesquisa"]),"parametro"=>$value,"valor"=>$cont);
				$controllerPARAMETRO = new controllerPARAMETRO('insert',$arr);

				if($controllerPARAMETRO->resposta != 1)
					echo "erro";
				
				$cont++;
			}
			echo 1;
		break;
		case 'cadastroPerguntas':
			$arrPerguntas = array();
			$arrPerguntas = explode(",",$_POST["arrPerguntas"]);

			foreach($arrPerguntas as $key => $value)
			{
				$arr = array("idpesquisa"=>trim($_POST["idpesquisa"]),"pergunta"=>$value);
				$controllerPERGUNTA = new controllerPERGUNTA('insert',$arr);

				if($controllerPERGUNTA->resposta != 1)
				{
					echo "erro";
					return;
				}
			}
			echo 1;
		break;
		case 'formularioPesquisa':
			$where = " where p.idpesquisa = $_POST[idpesquisa]";
			$controllerPERGUNTA = new controllerPERGUNTA('select',false,$where);
			$controllerPARAMETRO = new controllerPARAMETRO('select',false,$where);

			if(empty($controllerPARAMETRO->arrResposta))
			{
				$strTable  ="<div class='alert' aling='center'>";
				$strTable .="<div align='center'>";
				$strTable .="<strong>Aviso!</strong> não existem parâmetros cadastrados!";
				$strTable .="</div></div>";
				$strTable .="<button id='push' type='button' onclick=window.location='cadastro_pesquisa.php?idpesquisa=".$_POST['idpesquisa']."&adicionar=true' class='btn' title='Adicionar'><img src='../icones/adicionar.png' width='20px' height='20px'>&nbsp;<strong>Adicionar Parâmetros</strong></button>";
				echo $strTable;
				return false;
			}
			
			
			if(empty($controllerPERGUNTA->arrResposta))
			{
				$strTable  ="<div class='alert' aling='center'>";
				$strTable .="<div align='center'>";
				$strTable .="<strong>Aviso!</strong> não existem perguntas cadastradas!";
				$strTable .="</div></div>";
				$strTable .="<button id='push' type='button' onclick=window.location='cadastro_perguntas.php?idpesquisa=".$_POST['idpesquisa']."' class='btn' title='Adicionar'><img src='../icones/adicionar.png' width='20px' height='20px'>&nbsp;<strong>Adicionar Pergunta</strong></button>";
				echo $strTable;
				return false;
			}

			$width2 =  count($controllerPARAMETRO->arrResposta) * 10;
			
			$width1 = (100-$width2);

			$width1 = $width1."%";
			$strTable  ="<table  class= width=100% style='position:relative'>";
			$strTable .="<tr>";
			$strTable .="<td  >";
			$strTable .="</td>";
			$strTable .="<td>";
			$strTable .="</td>";
			$strTable .="<td width=100% align='right'>";
			$strTable .="<button id='push' onclick=window.location='cadastro_perguntas.php?idpesquisa=".$_POST['idpesquisa']."' type='button' class='btn' title='Adicionar'><img src='../icones/adicionar.png' width='20px' height='20px'>&nbsp;<strong>Adicionar</strong></button>";
			$strTable .="</td>";
			$strTable .="</tr>";
			$strTable .="</table>";

			$nomepesquisa = $controllerPERGUNTA->arrResposta[0]['nomepesquisa'];

			$strTable .=' <table id="curso" class="table table-striped table-bordered table-condensed" >';
			$strTable .='<thead>';
			$strTable .='<tr class="trlabel">';
			$strTable .='<th width="'.$width1.'" align="center" >'.$nomepesquisa.' perguntas</th>';
			$strTable .='<th width="'.$width2.'" colspan="10" align="center"></th>';
			$strTable .='</tr>';
			$strTable .='</thead>';
			$strTable .='<tbody>';

			foreach($controllerPERGUNTA->arrResposta as $dados)
			{
				$strTable .='<tr>';
				$strTable .='<td align=center ondblclick="modificaPergunta(this.id)" id="'.$dados["idpergunta"].'"><strong>'.$dados["pergunta"].'</strong></td>';
			
				$parametro ="";
				foreach($controllerPARAMETRO->arrResposta as $dados2)
				{
						$name = "groupId".$dados["idpergunta"];
						if(empty($parametro))
						{
							$parametro .=  "<td align=center>&nbsp;&nbsp;<input type='radio' name='".$name."' value='".$dados2["valor"]."'>&nbsp;&nbsp;<strong>".$dados2["parametro"]."</strong>&nbsp&nbsp</td>";
						}
						else
						{
							$parametro .=  "<td align=center><input type='radio' name='".$name."' value='".$dados2["valor"]."'>&nbsp;&nbsp;<strong>".$dados2["parametro"]."</strong></td>";
						}
				}
				$strTable .=$parametro;
				$strTable .='	<td align="right">';
				$strTable .= "<span  style='cursor:pointer' onclick=excluirPergunta('$dados[idpergunta]') value='' title='Excluir'><img src='../icones/excluir.png' width='20px' height='20px'></span>";
				$strTable .='</td>';
				$strTable .='</tr>';
			}

			$strTable .='</tbody>';
			$strTable .='</table>';
			$strTable .='<table   width=5% style="position:relative">';
			$strTable .='	<tr>';
			$strTable .='	<td width=80% align="left">';
			$strTable .='		<button type="button" onclick="getRespostas()" class="btn" title="Concluir pesquisa"><img src="../icones/salvar.png" width="30px" height="40px"><strong>Salvar</strong></button>';
			$strTable .='	</td>';
			$strTable .='	<td>';
			$strTable .='	</td>';
			$strTable .='	<td width=10% align="right">';
			$strTable .='<button type="button" class="btn" title="Estística" onclick="directChart()"><img src="../icones/grafico.png" width="30px" height="40px"><strong>Gráfico</strong></button>';
			$strTable .='</td>';
			$strTable .='		</tr>';
			$strTable .='</table>';
			echo $strTable;
		break;
		case 'cadastroRespostas':
			$arrResposta = array();
			$arrResposta = explode(",",$_POST["arrResposta"]);
			$arrIdPerguntas = array();
			$arrIdPerguntas = explode(",",$_POST["arrIdPerguntas"]);

			$str = "";
			foreach($arrResposta as $key => $value)
			{
				$arr = array("idpergunta"=>$arrIdPerguntas[$key],"resposta"=>$value,"idpesquisa"=>trim($_POST['idpesquisa']));
				$controllerRESPOSTA = new controllerRESPOSTA('insert',$arr);

				if($controllerRESPOSTA->resposta != 1)
				{
					echo "erro";
					return;
				}
			}
			echo 1;
		break;
		case 'geraGraficoPesquisa':
			$where = " where r.idpesquisa =". $_POST["idpesquisa"];	
			
			$arr = array("idpesquisa"=>true);
			$controllerRESPOSTA = new controllerRESPOSTA('select',$arr,$where);

			$data = array();

			if($_POST['tipoGrafico'] == "Pie")
			{
				$str = "";
				foreach($controllerRESPOSTA->arrResposta as $dados)
				{
					if(empty($str))
						$str .= "['".$dados['parametro']."',".$dados['num']."]";
					else
						$str .= ",['".$dados['parametro']."',".$dados['num']."]";
				}
				echo trim($str);
			}
			if($_POST['tipoGrafico'] == "Bar")
			{
				$str = "";
				foreach($controllerRESPOSTA->arrResposta as $dados)
				{
					if(empty($str))
						$str .= "[{'name': '".$dados['parametro']."', 'colorByPoint': true,'data':".$dados['num']."}";
					else
						$str .= ",{'name': '".$dados['parametro']."', 'colorByPoint': true,'data':".$dados['num']."}";
				}
				echo $str."]";
			}
		break;
		case 'geraGraficoPergunta':
			$where = " where r.idpergunta = $_POST[idpergunta]";	

			if(empty($_POST['idpergunta']))
			{
				$arr = array("idpesquisa"=>true);
				$where = " where r.idpesquisa = $_POST[idpesquisa]";
				$controllerRESPOSTA = new controllerRESPOSTA('select',$arr,$where);
			}
			else
				$controllerRESPOSTA = new controllerRESPOSTA('select',false,$where);

			$data = array();

			$pergunta = $controllerRESPOSTA->arrResposta[0]['pergunta'];

			if(empty($pergunta))
			{
				$pergunta = "Resultado geral";
			}

			if($_POST['tipoGrafico'] == "Pie")
			{
				foreach($controllerRESPOSTA->arrResposta as $dados)
				{
					$str .= "['".$dados['parametro']."',".$dados['num']."]";
				}
				echo trim($str);
			}

			if($_POST['tipoGrafico'] == "Bar")
			{
				$str = "";
				foreach($controllerRESPOSTA->arrResposta as $dados)
				{
					if(empty($str))
						$str .= "[{'name': '".$dados['parametro']."','data':".$dados['num']."}";
					else
						$str .= ",{'name': '".$dados['parametro']."','data':".$dados['num']."}";
				}
				echo $str."]";
			}
		break;
		case 'selectPergunta':
			$where = "where p.idpesquisa = ".$_POST["id"];
			$controllerPERGUNTA = new controllerPERGUNTA('select',false,$where);

			$str = "";
			$str .= "<option value=''>".utf8_encode("Selecione uma pergunta")."</option>";
			if(empty($controllerPERGUNTA->arrResposta))
			{
				$str .= "<option value=''>-------------------</option>";
				echo $str;
				return false;
			}

			foreach($controllerPERGUNTA->arrResposta as $dados)
			{
				if(isset($_POST['id']))
				{
					if($_POST['id'] == $dados['idpreco'])
						$str .= "<option SELECTED value='".($dados['idpergunta'])."' >".$dados['pergunta']."</option>";
					else
						$str .= "<option value='".($dados['idpergunta'])."' >".$dados['pergunta']."</option>";
				}
				else 
					$str .= "<option value='".($dados['idpergunta'])."' >".$dados['pergunta']."</option>";
			}
			echo ($str);
		break;
		case 'selectDadosPergunta':
			$arr = array("idpergunta"=>trim($_POST["idpergunta"]));
			$controllerPERGUNTA = new controllerPERGUNTA('selectDadosJson',$arr);
			echo $controllerPERGUNTA->resposta;
		break;
		case 'excluirPesquisa':
			$arr = array("idpesquisa"=>trim($_POST["idpesquisa"]));
			$controllerPESQUISA = new controllerPESQUISA('delete',$arr);

			if($controllerPESQUISA->resposta != 1)
			{
				echo "Erro";
				return false;
			}
			else
				echo $controllerPESQUISA->resposta;
		break;
		case 'excluirPergunta':
			$arr = array("idpergunta"=>trim($_POST["idpergunta"]));
			$controllerRESPOSTA = new controllerRESPOSTA('delete',$arr);
			if($controllerRESPOSTA->resposta == 1 || empty($controllerRESPOSTA->resposta))
			{
				$controllerPERGUNTA = new controllerPERGUNTA('delete',$arr);
				if($controllerPERGUNTA->resposta != 1)
				{
					echo "Erro";
					return false;
				}
				else
					echo $controllerPERGUNTA->resposta;
			}
			else
			{
				echo "Erro";
				return false;
			}
		break;
		case 'tableTipoGrafico':
			$strTable =' <table  class="table table-striped table-bordered " width="10%">';
			$strTable .='<tr>';
			$strTable .='<th  style="text-align: center;" >Pizza</th>';
			$strTable .='<th   style="text-align: center;" >Barra</th>';
			$strTable .='</tr>';
			$strTable .='<tr>';
			$strTable .='<td align=center  style="text-align: center;">&nbsp&nbsp<input type="radio" onclick="grafico(this.value)" value="Pie" checked name="tipoGrafico" value=""></td>';
			$strTable .='<td align=center  style="text-align: center;">&nbsp&nbsp<input type="radio" onclick="grafico(this.value)"  value="Bar" name="tipoGrafico" value=""></td>';
			$strTable .='</tr>';
			$strTable .='</tbody>';
			$strTable .='</table>';
			echo $strTable;
		break;
}
?>