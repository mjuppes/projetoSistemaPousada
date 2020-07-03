<?php
	#Recebe a solicitação ajax da página tabelas/boletim_ocorrencia.php	
	include "../conexao.php";
	include "../func.sql.php";
	include "../func.geral.php";

	$programa = utf8_decode($_POST['formFiltroMP_programa']);
	$setor 	  = $_POST['formFiltroMP_setor'];
	$data_mes = $_POST['formFiltroMP_mes'];
	$data_ano = $_POST['formFiltroMP_ano'];
	
	$condicao = array();
	
	if($data_mes){
		#$condicao .= " $data_mes = MONTH(data)";
		array_push($condicao, "$data_mes = MONTH(data)");
	}
	if($data_ano){
		#$condicao .= " AND $data_ano = YEAR(data)";
		array_push($condicao, "$data_ano = YEAR(data)");
	}	
	if($programa)
	{
		#$condicao .= " AND programa = '$programa'";
		array_push($condicao, "programa = '$programa'");
	}
	if($setor)
	{
		#$condicao .= " AND setor = '$setor'";
		array_push($condicao, "setor = '$setor'");
	}
	
	$condicao = implode(" AND ", $condicao);
	
	if (Trim($condicao) <> ""){ $condicao = " WHERE $condicao"; }
	
	
	$SQL_monta_tabela = @query("select mapaspdf.id as id,
										programa,CONVERT(VARCHAR(10),data,103) AS data,setor,arquivo,descricao,usuarios.usuario as usuario,
										data_cadastro from mapaspdf
										join usuarios on mapaspdf.usuario = usuarios.id
										$condicao order by programa, setor, data ASC");
	if(!$SQL_monta_tabela)
	{
		echo "<tr><td colspan='4' align='center'>Ocorreu um erro ao carregar a tabela. Contate o Administrador.$condicao</td></tr>";
	}
	else if(num_rows($SQL_monta_tabela) == 0)
	{
		echo "<tr><td colspan='4' align='center'>Nenhum registro encontrado.</td></tr>";
	}
	else
	{
		while($monta_tabela = @fetch_array($SQL_monta_tabela))
		{
				echo
				utf8_encode("<tr rel='$monta_tabela[id]'>
								<td align='center'>$monta_tabela[data]</td>
								<td align='left'>$monta_tabela[programa]</td>
								<td align='center'>$monta_tabela[setor]</td>
								<td align='center'><a href='../mapas_pdf/$monta_tabela[arquivo]' target='_blank' class='btnAcoesSemIco'>baixar arquivo</a></td>
							</tr>");
		}
	}
?>