<?php

	
	#Recebe a solicitação ajax da página tabelas/boletim_ocorrencia.php	

	include "../conexao.php";
	include "../func.sql.php";
	include "../func.geral.php";
	
	$data_mes  = $_POST['formFiltroBO_mes'];
	$data_ano  = $_POST['formFiltroBO_ano'];

	$filtroMes = "";
	$filtroAno = "";
	
	$condicao = array();
	
	if ($data_mes <> ""){
		array_push($condicao, "$data_mes = MONTH(B.data)");
	}
	
	if ($data_ano <> ""){
		array_push($condicao, "$data_ano = YEAR(B.data)");
	}

	$condicao = implode(" AND ", $condicao);
	
	if ($condicao <> ""){
		$condicao = "WHERE ".$condicao;
	}
	
	$SQL_monta_tabela = @query("
		SELECT B.id, B.descricao, CONVERT(VARCHAR(10),B.data,103) AS data, B.arquivo, B.usuario, U.usuario AS responsavel
		FROM boletins B
			LEFT JOIN usuarios U ON U.id = B.usuario
		$condicao
		ORDER BY B.data DESC
	");
	
	if (!$SQL_monta_tabela){
		
		echo "<tr><td colspan='3' align='center'>Ocorreu um erro ao carregar a tabela. Contate o Administrador.</td></tr>";
		
	} else if(num_rows($SQL_monta_tabela) == 0){
	
		echo "<tr><td colspan='3' align='center'>Nenhum registro encontrado.</td></tr>";
		
	} else {
	
		while ($monta_tabela = @fetch_array($SQL_monta_tabela)){
			
		echo 
			utf8_encode(
			"
			<tr rel='$monta_tabela[id]'>
				<td align='center'>$monta_tabela[data]</td>
				<td class='tdDescricao'>$monta_tabela[descricao]</td>
				<td align='center'><a href='../boletim_ocorrencia/$monta_tabela[arquivo]' target='_blank' class='btnBaixar'/></td>
			</tr>
			");
			
		}
	
	}
	
	
?>
