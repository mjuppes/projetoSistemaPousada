<?php session_start(); 
include('../CONFIG/config.php');
include('../'.DIR_DAO);
include('../'.DIR_MPDF.'mpdf.php');
include('../'.DIR_ACTIONS.'genericFunction.php');
include('../'.DIR_CLASSES.'controllerHOSPEDE.php');
include('../'.DIR_CLASSES.'controllerVENDA.php');
include('../'.DIR_CLASSES.'controllerRESERVA.php');
include('../'.DIR_CLASSES.'controllerCENTRO_CUSTO.php');
include('../'.DIR_CLASSES.'controllerPRODUTOS.php');



class relatorioPDF
{
	var $title		  = "";
	var $css		  = "";
	var $arrLabel	  = array();
	var $arrRecordSet = array();
	var $arrFieldHide = array();
	var $arrFieldSum  = array();
	var $colspan	  = "";
	var $html		  = "";


	public function htmlRel()
	{		
		$this->html = $this->css;
		$this->html.='
		<table>
   <thead>
      <tr>
         <td style="background-color:#ddd;text-align: center;padding-bottom:7px" colspan="'.$this->colspan.'">
            <strong>
            <font>'.$this->title.'</font>
            </strong>
         </td>
      </tr>
      <tr>
         <td>
         </td>
      </tr>
   </thead>
   <tbody>
   </tbody>
   <thead>
      <tr style="background-color:#ddd;">';
	
		foreach($this->arrLabel as $label => $width)
		{
			$this->html.='
				<th width="'.$width.'" style="padding-bottom:7px;">
					<strong>
						<font>'.$label.'</font>
					</strong>
				 </th>';
		}
		 $this->html.='
      </tr>
   </thead>
   <tbody>';
   
		$arrKey = array();
		$arrSum = array();
		foreach($this->arrRecordSet as $key => $arrD)
		{
			
				if(empty($arrKey))
				{
					array_push($arrKey,$key);
					$this->html.='<tr style="background-color:#f6f6f6">';
				}
				else
				{
					if(!in_array($key, $arrKey))
						$this->html.='<tr style="background-color:#f6f6f6">';

				}

				foreach($arrD as $field => $value)
				{
						if(!in_array($field, $this->arrFieldHide))
						{
							if(in_array($field,$this->arrFieldSum))
							{
								$arrSum[$field][] = $value;
							}
							

							$this->html.='
									<td style="padding-bottom:10px">
										<font>'.$value.' </font>
									</td>';
						}
				}
				$this->html.='</tr>';
		}

      $this->html .='
		   </tbody>
		</table>';
	
	
		$arrT = array();
		foreach($arrSum as $key => $value)
		{
				$soma = 0;
				for($i=0; $i<count($value); $i++)
				{
						$soma += $value[$i];
				}
				$arrT[] = decimal_money($soma);

		}
		
		$this->html .='<br><table width="100%">';
			$this->html.="<tbody>";

					$this->html.="<tr style='background-color: #DCDCDC'>";
					$this->html.="<td align='center' width='83%' align='left'><font>Total:</font></td>";
					
					foreach($arrT as $key => $value)
					{
						$this->html.="<td align='center'><font>".$value."</font></td>";
					}
					$this->html.="</tr>";

			$this->html.="</tbody>";
		$this->html.="</table>";
	/*
		$this->html .='<br><table>';

			$this->html .='<thead>';
				$this->html .='<tr>';
					$this->html .= "<th style='text-align: center;' colspan='2'><font>Valor total</font></th>";
				$this->html .='</tr>';
				$this->html .='<tr>';
					$this->html.="<th width='210%' align='center'></th>";
					$this->html.="<th width='25%' align='center'></th>";
					$this->html.="</tr>";
			$this->html.="</thead>";
			$this->html.="<tbody>";

					$this->html.="<tr style='background-color: #DCDCDC'>";
					$this->html.="<td align='center'><font>Tetse</font></td>";
					$this->html.="<td align='center'><font>100,00</font></td>";
					$this->html.="</tr>";

			$this->html.="</tbody>";
		$this->html.="</table>";
*/
		$this->html = utf8_encode($this->html);

		return $this->html;
	}
}

switch($_GET['rel'])
{
	case 'relCentroCusto':
		$where = "";

		if(isset($_GET['formSelectCategoria']))
			$where .= " and ct.id_cat_centro = ".$_GET['formSelectCategoria'];

		if(isset($_GET['formSelectSubCategoria']))
			$where .= " and sc.id_sub_cat_centro = ".$_GET['formSelectSubCategoria'];
		
		if(isset($_GET['formDtInicial']) && isset($_GET['formDtFinal']))
			$where .= " and c.data BETWEEN '".$_GET['formDtInicial']."' and '".$_GET['formDtFinal']."'";

		if(isset($_GET['formDtInicial']) && !isset($_GET['formDtFinal']))
			$where .= " and c.data = '".$_GET['formDtInicial']."'";

		if(isset($_GET['formStatus']))
			$where .= " and status = '$_GET[formStatus]'";
		else
			$where .= " and c.status is null";

		if(!empty($where))
			$controllerCENTRO_CUSTO = new controllerCENTRO_CUSTO('select',false,$where);
		else
			$controllerCENTRO_CUSTO = new controllerCENTRO_CUSTO('select');
		
		$rel 			= new relatorioPDF();
		$rel->title 	= "Centro de Custos";
		$rel->css		='<style>
							font
							{
								font-size: 8px;
								text-transform : uppercase;
							}
						  </style>';

		$rel->colspan 		= "5";
		$rel->arrLabel		= array("Categoria"=>"25%",
									"Sub-Categoria"=>"25%",
									"Valor"=>"15%",
									"Data de Pagamento"=>"10%",
									"Data de Cadastro"=>"10%");

		$rel->arrFieldHide	= array("id_centro_custo");
		$rel->arrRecordSet 	= $controllerCENTRO_CUSTO->arrResposta;
		$tabela = $rel->htmlRel();
	break;
	case 'relProdutos':
		$where = "";

		if(isset($_GET['formProdutoStr']) && !empty($_GET['formProdutoStr']))
			$where .= " and  p.nomeproduto  collate Latin1_General_CI_AS like'%".$_GET['formProdutoStr']."%'";

		if(isset($_GET['formSelectCategoria']) && !empty($_GET['formSelectCategoria']))
			$where .= " and  p.idcategoria = ".$_GET['formSelectCategoria'];

		if(isset($_GET['formSelectFornecedor']) && !empty($_GET['formSelectFornecedor']))
			$where .= " and  f.id_fornecedor = ".$_GET['formSelectFornecedor'];

		if(isset($_GET['formSelectOrdem']) && !empty($_GET['formSelectOrdem']))
			$where .= " order by ".$_GET['formSelectOrdem'];


		if(!empty($where))
			$controllerPRODUTOS = new controllerPRODUTOS('select',false,$where);
		else
			$controllerPRODUTOS = new controllerPRODUTOS('select',false,$where);

		$rel 			= new relatorioPDF();
		$rel->title 	= "Produtos Cadastrados";
		$rel->css		='<style>
							font
							{
								font-size: 8px;
								text-transform : uppercase;
							}
							table,thead
							{
								border:1px solid black;
							}
						  </style>';
								
		$rel->colspan 	= "6";
		$rel->arrLabel	= array("Produto"=>"15%",
								"Fornecedor"=>"20%",
								"Categoria"=>"15%",
								"Quantidade"=>"10%",
								"Valor"=>"10%",
								"Total"=>"10%",
								"Cadastrado em"=>"15%");
		
		$rel->arrFieldHide	= array("idproduto","estoque");
		$rel->arrFieldSum	= array("total");
		$rel->arrRecordSet 	= $controllerPRODUTOS->arrResposta;
		$tabela = $rel->htmlRel();
	break;
	
	case 'Hospede':
		$where = "";

		if(isset($_GET['formSelectEstado']) && !empty($_GET['formSelectEstado']))
		{
			if(empty($where))
				$where .= " e.idestado=".$_GET['formSelectEstado'];
			else
				$where .= " and e.idestado=".$_GET['formSelectEstado'];
		}

		if(isset($_GET['formSelectCidade']) && !empty($_GET['formSelectCidade']))
		{
			if(empty($where))
				$where .= " c.idcidade=".$_GET['formSelectCidade'];
			else
				$where .= " and c.idcidade=".$_GET['formSelectCidade'];
		}

		if(isset($_GET['formSelectEmpresa']) && !empty($_GET['formSelectEmpresa']))
		{
			if(empty($where))
				$where .= " emp.idempresa =".$_GET['formSelectEmpresa'];
			else
				$where .= " and emp.idempresa =".$_GET['formSelectEmpresa'];
		}

		if(isset($_GET['formSelectSexo']) && !empty($_GET['formSelectSexo']))
		{
			if(empty($where))
				$where .= " h.sexo='".$_GET['formSelectSexo']."'";
			else
				$where .= " and h.sexo= '".$_GET['formSelectSexo']."'";
		}

		if(isset($_GET['formNome']) && !empty($_GET['formNome']))
		{
			if(empty($where))
				$where .= " h.nome  like'%".$_GET['formNome']."%'";
			else
				$where .= " and  h.nome  like'%".$_GET['formNome']."%'";
		}

		if(isset($_GET['formDtInicial']) && !empty($_GET['formDtInicial']) && isset($_GET['formDtFinal']) && !empty($_GET['formDtFinal']))
		{
			if(empty($where))
				$where .= " h.datahoje BETWEEN '".formatDate($_GET['formDtInicial'])."' and '".formatDate($_GET['formDtFinal'])."'";
			else
				$where .= " and  h.datahoje BETWEEN '".formatDate($_GET['formDtInicial'])."' and '".formatDate($_GET['formDtFinal'])."'";
		}

		if(!empty($where))
			$controllerHOSPEDE = new controllerHOSPEDE('selectHospedeGeral',false,$where);
		else
			$controllerHOSPEDE = new controllerHOSPEDE('selectHospedeGeral');


		for($i=0; $i<count($controllerHOSPEDE->arrResposta); $i++)
		{
			$controllerHOSPEDE->arrResposta[$i]['nome'] = utf8_encode($controllerHOSPEDE->arrResposta[$i]['nome']);
			$controllerHOSPEDE->arrResposta[$i]['nomeestado'] = utf8_encode($controllerHOSPEDE->arrResposta[$i]['nomeestado']);
			$controllerHOSPEDE->arrResposta[$i]['nomecidade'] = utf8_encode($controllerHOSPEDE->arrResposta[$i]['nomecidade']);
		}

		$tabela = "";
		$tabela.="<style>
					table
					{
						border-collapse:collapse;
					}
					table, td, th
					{
						border:1px solid black;
					}
					.fundo
					{
						background-color:#DCDCDC
					}

					img
					{
						opacity:0.4;
						filter:alpha(opacity=40); /* For IE8 and earlier */
					}
				   </style>";

		//$tabela .="<img src='http://www.beaversystem.com.br/beaverPousada/logo1.png'>";
		$tabela .="<table id='curso' width='100%'>";
			$tabela .="<thead >";
				$tabela.="<tr class='fundo'>";
					$tabela.= utf8_encode("<th style='text-align: center;' colspan='6'>Relatório de hóspedes</th>");
				$tabela.="</tr>";
				$tabela.="<tr>";
					$tabela.="<th width='30%' align='center'>Nome do hospede</th>";
					$tabela.="<th width='10%' align='center'>Sexo</th>";
					$tabela.="<th width='14%' align='center'>Empresa</th>";
					$tabela.="<th width='14%' align='center'>Estado</th>";
					$tabela.="<th width='16%' align='center'>Cidade</th>";
					$tabela.="<th width='12%' align='center'>Data de cadastro</th>";
					$tabela.="</tr>";
			$tabela.="</thead>";
			$tabela.="<tbody>";

			$i = 0;
			foreach($controllerHOSPEDE->arrResposta as $dados)
			{
			
				if($i %2)
				{
					$tabela.="<tr style='background-color: #DCDCDC'>";
					$tabela.="<td align='center'>$dados[nome]</td>";
					$tabela.="<td align='center'>$dados[sexo]</td>";
					$tabela.="<td align='center'>$dados[nomeempresa] </td>";
					$tabela.="<td align='center'>$dados[nomeestado] </td>";
					$tabela.="<td align='center'>$dados[nomecidade] </td>";
					$tabela.="<td align='center'>$dados[datahoje] </td>";
					$tabela.="</tr>";
				}
				else
				{
					$tabela.="<tr>";
					$tabela.="<td align='center'>$dados[nome]</td>";
					$tabela.="<td align='center'>$dados[sexo]</td>";
					$tabela.="<td align='center'>$dados[nomeempresa] </td>";
					$tabela.="<td align='center'>$dados[nomeestado] </td>";
					$tabela.="<td align='center'>$dados[nomecidade] </td>";
					$tabela.="<td align='center'>$dados[datahoje] </td>";
					$tabela.="</tr>";
				}
				$i++;
			}
			$tabela.="</tbody>";
		$tabela.="</table>";
	break;
	case 'Venda':

		$where = "";

		if(isset($_GET['formSelectHospede']))
			$where .= " h.idhospede in($_GET[formSelectHospede])";
	
		if(!empty($_GET["formDtInicial"]) &&  !empty($_GET["formDtFinal"]))
		{
			if($where)
				$where .= " and ";

			$where .= " v.datavenda between '".formatDate($_GET[formDtInicial])."' and '".formatDate($_GET[formDtFinal])."'";
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
			$where = " and  $where ";
			$controllerVENDA = new controllerVENDA('selectVendas',false,$where);
		}
		else
			$controllerVENDA = new controllerVENDA('selectVendas');

		for($i=0; $i<count($controllerVENDA->arrResposta); $i++)
		{
			$controllerVENDA->arrResposta[$i]['nomehospede'] 	= utf8_encode($controllerVENDA->arrResposta[$i]['nomehospede']);
			$controllerVENDA->arrResposta[$i]['nomecategoria'] 	= utf8_encode($controllerVENDA->arrResposta[$i]['nomecategoria']);
			$controllerVENDA->arrResposta[$i]['nomeproduto'] 	= utf8_encode($controllerVENDA->arrResposta[$i]['nomeproduto']);
		}

		$tabela = "";
		$tabela.="<style>
			font
			{
				font-size: 8px;
				text-transform : uppercase;
			}
			table,thead
			{
				border:1px solid black;
				font-size: 13px;
				text-transform : uppercase;
			}
		   </style>";

		$tabela .="<table >";

			$tabela .="<thead >";
				$tabela.="<tr>";
					$tabela.= utf8_encode("<th style='text-align: center;' colspan='5'>Relatório de vendas</th>");
				$tabela.="</tr>";
				$tabela.="<tr>";
					$tabela.=utf8_encode("<th width='16%' align='center'>Nome do Hóspede</th>");
					$tabela.="<th width='16%' align='center'>Categoria</th>";
					$tabela.="<th width='16%' align='center'>Nome do produto</th>";
					$tabela.="<th width='16%' align='center'>Data da venda</th>";
					$tabela.="<th width='16%' align='center'>Valor</th>";
					$tabela.="</tr>";
			$tabela.="</thead>";
			$tabela.="<tbody>";

			$i = 0;
			foreach($controllerVENDA->arrResposta as $dados)
			{
				if($i %2)
				{
					$tabela.="<tr style='background-color: #DCDCDC'>";
					$tabela.="<td align='center'><font>$dados[nomehospede]</font></td>";
					$tabela.="<td align='center'><font>$dados[nomecategoria]</font></td>";
					$tabela.="<td align='center'><font>$dados[nomeproduto]</font></td>";
					$tabela.="<td align='center'><font>$dados[datavenda]</font></td>";
					$tabela.="<td align='center'><font>$dados[valor]</font></td>";
					$tabela.="</tr>";
				}
				else
				{
					$tabela.="<tr>";
						$tabela.="<td align='center'><font>$dados[nomehospede]</font></td>";
					$tabela.="<td align='center'><font>$dados[nomecategoria]</font></td>";
					$tabela.="<td align='center'><font>$dados[nomeproduto]</font></td>";
					$tabela.="<td align='center'><font>$dados[datavenda]</font></td>";
					$tabela.="<td align='center'><font>$dados[valor]</font></td>";
					$tabela.="</tr>";
				}
				$i++;
			}
			$tabela.="</tbody>";
		$tabela.="</table>";

		if($where)
			$controllerVENDA = new controllerVENDA('selectVendasTotal',false,$where);
		else
			$controllerVENDA = new controllerVENDA('selectVendasTotal');

		$tabela .="<br><br>
		
		
		<table width:99>";

			$tabela .="<thead >";
				$tabela.="<tr>";

				$tabela.="</tr>";
				$tabela.="<tr>";
					$tabela.="<th width='220%' align='center'></th>";
					$tabela.="<th width='25%' align='center'></th>";
					$tabela.="</tr>";
			$tabela.="</thead>";
			$tabela.="<tbody>";


			foreach($controllerVENDA->arrResposta as $dados)
			{
					$tabela.="<tr style='background-color: #DCDCDC'>";
					$tabela.="<td align='center'>$dados[descricao]</td>";
					$tabela.="<td align='center'>$dados[valorTotal]</td>";
					$tabela.="</tr>";
		}
			$tabela.="</tbody>";
		$tabela.="</table>";
		
		
	break;
	case 'Historico':
		$controllerRESERVA = new controllerRESERVA('selectHistorico',$arr);

		for($i=0; $i<count($controllerRESERVA->arrResposta); $i++)
		{
			$controllerRESERVA->arrResposta[$i]['nome'] = utf8_encode($controllerRESERVA->arrResposta[$i]['nome']);
			$controllerRESERVA->arrResposta[$i]['nomeempresa'] = utf8_encode($controllerRESERVA->arrResposta[$i]['nomeempresa']);
		}

		$tabela = "";
		$tabela.="<style>
					table
					{
						border-collapse:collapse;
					}
					table, td, th
					{
						border:1px solid black;
					}
					
					.fundo
					{
						background-color:#DCDCDC
					}
				   </style>";

		$tabela .="<table id='curso'>";

			$tabela .="<thead >";
				$tabela.="<tr class='fundo'>";
					$tabela.= utf8_encode("<th style='text-align: center;' colspan='6'>Histórico de reservas</th>");
				$tabela.="</tr>";
				$tabela.="<tr>";
					$tabela.="<th width='16%' align='center'>Nome do quarto</th>";
					$tabela.=utf8_encode("<th width='16%' align='center'>Hóspede</th>");
					$tabela.="<th width='16%' align='center'>Data Inicial</th>";
					$tabela.="<th width='16%' align='center'>Data Final</th>";
					$tabela.=utf8_encode("<th width='16%' align='center'>Opção de quarto</th>");
					$tabela.="<th width='16%' align='center'>Empresa</th>";
					$tabela.="</tr>";
			$tabela.="</thead>";
			$tabela.="<tbody>";

			$i = 0;
			foreach($controllerRESERVA->arrResposta as $dados)
			{
				if($i %2)
				{
					$tabela.="<tr style='background-color: #DCDCDC'>";
					$tabela.="<td align='center'>$dados[nomequarto]</td>";
					$tabela.="<td align='center'>$dados[nome]</td>";
					$tabela.="<td align='center'>$dados[datainicial] </td>";
					$tabela.="<td align='center'>$dados[datafinal] </td>";
					$tabela.="<td align='center'>$dados[opcao] </td>";
					$tabela.="<td align='center'>$dados[nomeempresa] </td>";
					$tabela.="</tr>";
				}
				else
				{
					$tabela.="<tr>";
					$tabela.="<td align='center'>$dados[nomequarto]</td>";
					$tabela.="<td align='center'>$dados[nome]</td>";
					$tabela.="<td align='center'>$dados[datainicial] </td>";
					$tabela.="<td align='center'>$dados[datafinal] </td>";
					$tabela.="<td align='center'>$dados[opcao] </td>";
					$tabela.="<td align='center'>$dados[nomeempresa] </td>";
					$tabela.="</tr>";
				}
				$i++;
			}
			$tabela.="</tbody>";
		$tabela.="</table>";
	break;
	case 'HistoricoHp':
		$arr = array("idhospede"=>$_GET['idhospede']);
		$controllerHOSPEDE = new controllerHOSPEDE('selectHistoricoHospede',$arr);

		if(!empty($controllerHOSPEDE->arrResposta))
		{
			$tabela = "";
			$tabela.="<style>
						table
						{
							border-collapse:collapse;
						}
						table, td, th
						{
							border:1px solid black;
						}
						
						.fundo
						{
							background-color:#DCDCDC
						}
					   </style>";

			$tabela .="<table width='100%'>";
				
				$tabela .="<thead >";
					$tabela.="<tr class='fundo'>";
						$tabela.= ("<th style='text-align: center;' colspan='8'>Histórico de reservas</th>");
					$tabela.="</tr>";
					$tabela.="<tr style='background-color: #DCDCDC'>";
						$tabela.="<th style='font-size:80%' width='20%' align='center'>Nome</th>";
						$tabela.="<th style='font-size:80%' width='5%' align='center'>Sexo</th>";
						$tabela.="<th style='font-size:80%' width='15%' align='center'>Nome da empresa</th>";
						$tabela.="<th style='font-size:80%' width='10%' align='center'>Estado</th>";
						$tabela.="<th style='font-size:80%' width='20%' align='center'>Cidade</th>";
						$tabela.="<th style='font-size:80%' width='20%' align='center'>Bairro</th>";
						$tabela.=("<th style='font-size:80%' width='15%' align='center'>Endereço</th>");
						$tabela.="<th style='font-size:80%' width='5%' align='center'>Data de nascimento</th>";
						$tabela.="</tr>";
				$tabela.="</thead>";
				$tabela.="<tbody>";

				$i = 0;
				foreach($controllerHOSPEDE->arrResposta as $dados)
				{
				
					if($i %2)
					{
						$tabela.="<tr style='background-color: #DCDCDC'>";
						$tabela.="<td align='center' style='font-size:80%'>".($dados['nome'])."</td>";
						$tabela.="<td align='center' style='font-size:80%'>$dados[sexo]</td>";
						$tabela.="<td align='center' style='font-size:80%'>$dados[nomeempresa] </td>";
						$tabela.="<td align='center' style='font-size:80%'>".($dados['nomeestado'])."</td>";
						$tabela.="<td align='center' style='font-size:80%'>".($dados['nomecidade'])."</td>";
						$tabela.="<td align='center' style='font-size:80%'>$dados[bairro] </td>";
						$tabela.="<td align='center' style='font-size:80%'>$dados[endereco] </td>";
						$tabela.="<td align='center' style='font-size:80%'>$dados[datanascimento] </td>";
						$tabela.="</tr>";
					}
					else
					{
						$tabela.="<tr>";
						$tabela.="<td align='center' style='font-size:80%'>".($dados['nome'])."</td>";
						$tabela.="<td align='center' style='font-size:80%'>$dados[sexo]</td>";
						$tabela.="<td align='center' style='font-size:80%'>$dados[nomeempresa] </td>";
						$tabela.="<td align='center' style='font-size:80%'>".($dados['nomeestado'])."</td>";
						$tabela.="<td align='center' style='font-size:80%'>".($dados['nomecidade'])."</td>";
						$tabela.="<td align='center' style='font-size:80%'>$dados[bairro] </td>";
						$tabela.="<td align='center' style='font-size:80%'>$dados[endereco] </td>";
						$tabela.="<td align='center' style='font-size:80%'>$dados[datanascimento] </td>";
						$tabela.="</tr>";
					}
					$i++;
				}
				$tabela.="</tbody>";
			$tabela.="</table><br>";
		}

		$controllerRESERVA = new controllerRESERVA('selectHistoricoReserva',$arr);
		if(!empty($controllerRESERVA->arrResposta))
		{
			$tabela .="<table width='100%'>";
				$tabela .="<thead >";
					$tabela.="<tr class='fundo'>";
						$tabela.= ("<th style='text-align: center;' colspan='8'>Histórico de reservas</th>");
					$tabela.="</tr>";
					$tabela.="<tr style='background-color: #DCDCDC'>";
						$tabela.="<th style='font-size:80%' width='30%' align='center'>Quarto</th>";
						$tabela.="<th style='font-size:80%' width='15%' align='center'>Data inicial</th>";
						$tabela.="<th style='font-size:80%' width='10%' align='center'>Data Final</th>";
						$tabela.="<th style='font-size:80%' width='10%' align='center'>".("Opção")."</th>";
						$tabela.="<th style='font-size:80%' width='20%' align='center'>Tipo de pagamento</th>";
						$tabela.="<th style='font-size:80%' width='20%' align='center'>Valor</th>";
						$tabela.="<th style='font-size:80%' width='20%' align='center'>Total</th>";
						$tabela.="<th style='font-size:80%' width='20%' align='center'>Restante</th>";
					$tabela.="</tr>";
				$tabela.="</thead>";
				$tabela.="<tbody>";

				$i = 0;
				foreach($controllerRESERVA->arrResposta as $dados)
				{
					if($i %2)
					{
						$tabela.="<tr style='background-color: #DCDCDC'>";
						$tabela.="<td style='font-size:80%' align='center'>".($dados['nomequarto'])."</td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[datainicial]</td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[datafinal] </td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[opcao] </td>";
						$tabela.="<td style='font-size:80%' align='center'>".($dados['tipopagamento'])."</td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[valor] </td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[valor2] </td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[resto] </td>";
						$tabela.="</tr>";
					}
					else
					{
						$tabela.="<tr>";
						$tabela.="<tr>";
						$tabela.="<td style='font-size:80%' align='center'>".($dados['nomequarto'])."</td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[datainicial]</td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[datafinal] </td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[opcao] </td>";
						$tabela.="<td style='font-size:80%' align='center'>".($dados['tipopagamento'])." </td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[valor] </td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[valor2] </td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[resto] </td>";
						$tabela.="</tr>";
					}
					$i++;
				}
				$tabela.="</tbody>";
			$tabela.="</table><br>";
		}

		$controllerVENDA = new controllerVENDA('selectHistoricoVenda',$arr);
		if(!empty($controllerVENDA->arrResposta))
		{
			$tabela .="<table width='100%'>";
				$tabela .="<thead >";
					$tabela.="<tr class='fundo'>";
						$tabela.= ("<th style='text-align: center;' colspan='4'>Histórico de Vendas</th>");
					$tabela.="</tr>";
					$tabela.="<tr  style='background-color: #DCDCDC'>";
						$tabela.="<th style='font-size:80%' width='25%' align='center'>Categoria</th>";
						$tabela.="<th style='font-size:80%' width='25%' align='center'>Produto</th>";
						$tabela.="<th style='font-size:80%' width='25%' align='center'>Valor</th>";
						$tabela.="<th style='font-size:80%' width='25%' align='center'>Data da venda</th>";
					$tabela.="</tr>";
				$tabela.="</thead>";
				$tabela.="<tbody>";

				$i = 0;
				foreach($controllerVENDA->arrResposta as $dados)
				{
					if($i %2)
					{
						$tabela.="<tr style='background-color: #DCDCDC'>";
						$tabela.="<td style='font-size:80%' align='center'>".($dados['nomecategoria'])."</td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[nomeproduto]</td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[valor] </td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[datavenda] </td>";
						$tabela.="</tr>";
					}
					else
					{
						$tabela.="<tr>";
						$tabela.="<tr >";
						$tabela.="<td style='font-size:80%' align='center'>".($dados['nomecategoria'])."</td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[nomeproduto]</td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[valor] </td>";
						$tabela.="<td style='font-size:80%' align='center'>$dados[datavenda] </td>";
						$tabela.="</tr>";
					}
					$i++;
				}
				$tabela.="</tbody>";
			$tabela.="</table>";
		}
		
		$tabela = utf8_encode($tabela);
	break;

	
	case 'GeralHospede':
		echo "teste";
		return;

		if(isset($_GET["filtro"]) && $_GET["filtro"] == true)
		{
			$arr = array("filtro"=>true);

			$where = "";
			if(!empty($_GET["formSelectHospede"]))
			{
				$where .= " h.idhospede =  $_GET[formSelectHospede]";
			}
			if(!empty($_GET["formDtInicial"]) &&  !empty($_GET["formDtFinal"]))
			{
				if($where)
					$where .= " and ";

				$where .= " v.datavenda between '".formatDate($_GET[formDtInicial])."' and '".formatDate($_GET[formDtFinal])."'";
			}
			if(!empty($_GET["formDtInicial"]) &&  empty($_GET["formDtFinal"]))
			{
				if($where)
					$where .= " and ";

				$where .= " v.datavenda >= '".formatDate($_GET[formDtInicial])."'";
			}
			if(empty($_GET["formDtInicial"]) &&  !empty($_GET["formDtFinal"]))
			{
				if($where)
					$where .= " and ";

				$where .= " v.datavenda >= '".formatDate($_GET[formDtFinal])."'";
			}

			$where = " where $where ";
			$controllerVENDA = new controllerVENDA('selectVendas',$arr,$where);
		}
		else
		{
			$controllerVENDA = new controllerVENDA('selectVendas');
		}

		for($i=0; $i<count($controllerVENDA->arrResposta); $i++)
		{
			$controllerVENDA->arrResposta[$i]['nomehospede'] = utf8_encode($controllerVENDA->arrResposta[$i]['nomehospede']);
			$controllerVENDA->arrResposta[$i]['nomecategoria'] = utf8_encode($controllerVENDA->arrResposta[$i]['nomecategoria']);
			$controllerVENDA->arrResposta[$i]['nomeproduto'] = utf8_encode($controllerVENDA->arrResposta[$i]['nomeproduto']);
		}

		$tabela = "";
		$tabela.="<style>
			table,thead
			{
				border:1px solid black;
			}
			img
			{
				opacity:0.0;
				filter:alpha(opacity=40); /* For IE8 and earlier */
				margin-left: 90%;
			}
		   </style>";

			
		$tabela .="<table >";

			$tabela .="<thead >";
				$tabela.="<tr>";
					$tabela.= utf8_encode("<th style='text-align: center;' colspan='5'>Relatório de vendas</th>");
				$tabela.="</tr>";
				$tabela.="<tr>";
					$tabela.=utf8_encode("<th width='16%' align='center'>Nome do Hóspede</th>");
					$tabela.="<th width='16%' align='center'>Categoria</th>";
					$tabela.="<th width='16%' align='center'>Nome do produto</th>";
					$tabela.="<th width='16%' align='center'>Data da venda</th>";
					$tabela.="<th width='16%' align='center'>Valor</th>";
					$tabela.="</tr>";
			$tabela.="</thead>";
			$tabela.="<tbody>";

			$i = 0;
			foreach($controllerVENDA->arrResposta as $dados)
			{
				if($i %2)
				{
					$tabela.="<tr style='background-color: #DCDCDC'>";
					$tabela.="<td align='center'>$dados[nomehospede]</td>";
					$tabela.="<td align='center'>$dados[nomecategoria]</td>";
					$tabela.="<td align='center'>$dados[nomeproduto] </td>";
					$tabela.="<td align='center'>$dados[datavenda] </td>";
					$tabela.="<td align='center'>$dados[valor] </td>";
					$tabela.="</tr>";
				}
				else
				{
					$tabela.="<tr>";
					$tabela.="<td align='center'>$dados[nomehospede]</td>";
					$tabela.="<td align='center'>$dados[nomecategoria]</td>";
					$tabela.="<td align='center'>$dados[nomeproduto] </td>";
					$tabela.="<td align='center'>$dados[datavenda] </td>";
					$tabela.="<td align='center'>$dados[valor] </td>";
					$tabela.="</tr>";
				}
				$i++;
			}
			$tabela.="</tbody>";
		$tabela.="</table>";

		if($where)
			$controllerVENDA = new controllerVENDA('selectVendasTotal',false,$where);
		else
			$controllerVENDA = new controllerVENDA('selectVendasTotal');

		$tabela .="<br><br><table width:99>";

			$tabela .="<thead >";
				$tabela.="<tr>";
					$tabela.= utf8_encode("<th style='text-align: center;' colspan='2'>Valor total</th>");
				$tabela.="</tr>";
				$tabela.="<tr>";
					$tabela.="<th width='220%' align='center'></th>";
					$tabela.="<th width='25%' align='center'></th>";
					$tabela.="</tr>";
			$tabela.="</thead>";
			$tabela.="<tbody>";


			foreach($controllerVENDA->arrResposta as $dados)
			{
					$tabela.="<tr style='background-color: #DCDCDC'>";
					$tabela.="<td align='center'>$dados[descricao]</td>";
					$tabela.="<td align='center'>$dados[valorTotal]</td>";
					$tabela.="</tr>";
		}
			$tabela.="</tbody>";
		$tabela.="</table>";
	break;
	case 'formularioHospede':
			$tabela = '';
		$tabela.='<style>	
							* {
				margin: 0;
				padding: 0;
			}
			 
			fieldset {
				border: 0;
			}
			 
			body, input, select, textarea, button {
				font-family: sans-serif;
				font-size: 1em;
			}
			 
			.grupo:after {
				content: ".";
				display: block;
				height: 0;
				clear: both;
				visibility: hidden;
			}
			 
			.campo {
				margin-bottom: 1em;
			}
			 
			.campo label {
				margin-bottom: 0.2em;
				color: #666;
				display: block;
			}
			 
			fieldset.grupo .campo {
				float:  left;
				margin-right: 1em;
			}
			 
			.campo input[type="text"],
			.campo input[type="email"],
			.campo input[type="url"],
			.campo input[type="tel"],
			.campo select,
			.campo textarea {
				padding: 0.2em;
				border: 1px solid #CCC;
				box-shadow: 2px 2px 2px rgba(0,0,0,0.2);
				display: block;
			}
			 
			.campo select option {
				padding-right: 1em;
			}
			 
			.campo input:focus, .campo select:focus, .campo textarea:focus {
				background: #FFC;
			}
			 
			.campo label.checkbox {
				color: #000;
				display: inline-block;
				margin-right: 1em;
			}
			 
			.botao {
				font-size: 1.5em;
				background: #F90;
				border: 0;
				margin-bottom: 1em;
				color: #FFF;
				padding: 0.2em 0.6em;
				box-shadow: 2px 2px 2px rgba(0,0,0,0.2);
				text-shadow: 1px 1px 1px rgba(0,0,0,0.5);
			}
			 
			.botao:hover {
				background: #FB0;
				box-shadow: inset 2px 2px 2px rgba(0,0,0,0.2);
				text-shadow: none;
			}
			 
			.botao, select, label.checkbox {
				cursor: pointer;
			}
			</style>
				<form action="#" method="post">
					<fieldset>
						<div class="campo">
							<label>
								<input type="radio" name="sexo" value="masculino"> Pessoa Física
							</label>
							<label>
								<input type="radio" name="sexo" value="feminino"> Pessoa Jurídica 
							</label>
						</div>
						<fieldset class="grupo">
							<div class="campo">
								<label for="nome">Nome:</label>
								<input type="text" id="nome" name="nome" style="width: 10em" />
							</div>
						</fieldset>
					
					<div class="campo">
					<label for="email"> Motivo da viajem:</label>
					</div>
						<div class="campo">
							<textarea rows="2" style="width: 50em"></textarea>
						</div>
						<div class="campo">
							<label for="telefone"> Agencia:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="telefone"> Endereço:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="telefone"> Bairro:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="telefone"> País:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="telefone"> Estado:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="telefone"> Cidade:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="telefone"> Sexo:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="telefone"> Data de nascimento:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="telefone"> Cpf:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="telefone"> RNE:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="telefone"> E-mail:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="telefone"> Passaporte:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="telefone"> Telefone:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="telefone"> Data de cadastro:</label>
							<input type="text"  style="width: 10em" value="'.date("d/m/Y").'"  />
						</div>
					</fieldset>
				</form>';
				
				 $tabela = utf8_encode($tabela);
	break;
	case 'formularioReserva':
			$tabela = '';
		$tabela.='<style>	
							* {
				margin: 0;
				padding: 0;
			}
			 
			fieldset {
				border: 0;
			}
			 
			body, input, select, textarea, button {
				font-family: sans-serif;
				font-size: 1em;
			}
			 
			.grupo:after {
				content: ".";
				display: block;
				height: 0;
				clear: both;
				visibility: hidden;
			}
			 
			.campo {
				margin-bottom: 1em;
			}
			 
			.campo label {
				margin-bottom: 0.2em;
				color: #666;
				display: block;
			}
			 
			fieldset.grupo .campo {
				float:  left;
				margin-right: 1em;
			}
			 
			.campo input[type="text"],
			.campo input[type="email"],
			.campo input[type="url"],
			.campo input[type="tel"],
			.campo select,
			.campo textarea {
				padding: 0.2em;
				border: 1px solid #CCC;
				box-shadow: 2px 2px 2px rgba(0,0,0,0.2);
				display: block;
			}
			 
			.campo select option {
				padding-right: 1em;
			}
			 
			.campo input:focus, .campo select:focus, .campo textarea:focus {
				background: #FFC;
			}
			.campo label.checkbox {
				color: #000;
				display: inline-block;
				margin-right: 1em;
			}
			.botao {
				font-size: 1.5em;
				background: #F90;
				border: 0;
				margin-bottom: 1em;
				color: #FFF;
				padding: 0.2em 0.6em;
				box-shadow: 2px 2px 2px rgba(0,0,0,0.2);
				text-shadow: 1px 1px 1px rgba(0,0,0,0.5);
			}
			.botao:hover {
				background: #FB0;
				box-shadow: inset 2px 2px 2px rgba(0,0,0,0.2);
				text-shadow: none;
			}
			.botao, select, label.checkbox {
				cursor: pointer;
			}
			</style>
				<form action="#" method="post">
					<fieldset>
						<fieldset class="grupo">
							<div class="campo">
								<label for="nome">Hóspede</label>
								<input type="text" id="nome" name="nome" style="width: 10em" />
							</div>
						</fieldset>
						<div class="campo">
							<label for="telefone"> Quarto:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="telefone"> Valor aplicado:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="telefone"> Período de reserva:</label>
							<input type="text"  style="width: 3em"  />
							há
							<input type="text"  style="width: 3em"  />
						</div>
						<div class="campo">
							<label for="telefone"> Opção de quarto:</label>
							<input type="text"  style="width: 10em"  />
						</div>
						<div class="campo">
							<label for="email"> Observações:</label>
						</div>
						<div class="campo">
							<textarea rows="4" style="width: 50em"></textarea>
						</div>
					</fieldset>
				</form>';
				$tabela = utf8_encode($tabela);
	break;
	default:
}
$mpdf=new mPDF();
$mpdf->WriteHTML($tabela);
$mpdf->Output();
exit;
?>