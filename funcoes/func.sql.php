<?php
	
	include "conexao.php";
	
	#DEFINE O BANCO DE DADOS, esta constante é utilizada nos SQL
	define("BD_TYPE", "mssql"); 
	
	/* monta a função fetch_array utilizada para listar os dados do SELECT */
	function fetch_array($SQL){
		$fetch_array = BD_TYPE."_fetch_array";
		return $fetch_array($SQL);
	}
	
	/* monta a função que executa a QUERY */
	function query($SQL){
		$query = BD_TYPE."_query";
		return $query($SQL);	
	}
	
	/* monta a função que finaliza uma QUERY */
	function close(){
		$close = BD_TYPE."_close";
		return $close();	
	}
	
	/* função para retornar a quantidade de registros encontrados */
	function num_rows($SQL){
		$num_rows = BD_TYPE."_num_rows";
		return $num_rows($SQL);
	}

	#RETORNA O ULTIMO ID INSERIDO
	function ultimoID($bd){
		#{banco consultado}
		
		$SQL         = "SELECT MAX(id) as id FROM $bd";
		
		$executa_SQL = query($SQL);
		
		$retorno     = fetch_array($executa_SQL);
		
		return $retorno['id'];
		
	}

	#FAZER A INSERÇÃO DOS DADOS NO BD
	function inserir($bd, $into, $values){
	
		#{ nome do banco | campos do banco (array) | valor a ser inserido (array) }
		
		$erro     = 0;
		$mensagem = "";
		$SQL      = "";
		$into   = implode(",",$into);
		$values = implode(",",$values);
		
		#verifica se foi informado o BD
		if (!$bd){
			$erro = 1;
		}
		
		#verifica se os campos foram informados
		if ((!$into) OR (!$values)){
			$erro = 2;
		}
		
		$SQL = "INSERT INTO $bd ($into) VALUES ($values)";
		
		switch($erro){
			case 1: $mensagem = "Informe o Banco de Dados."; break;
			case 2: $mensagem = "Informe o nome dos campos."; break;
			case 3: $mensagem = "A quantidade de campos não confere com a quantidade de colunas."; break;
			default: 
				$executa_SQL = query($SQL);
				if (!$executa_SQL){
					$mensagem = "Ocorreu um erro ao inserir os dados. <b>Verifique a sintaxe SQL:</b> <i>$SQL</i>";
				} else {
					$mensagem = 1;
				}
			break;
		}
		
		#@close();
		
		return $mensagem;
		
	}
		
	#FAZ O UPDATE DOS DADOS
	function update($bd, $campos, $values, $cond){
	
		#{ nome do banco | campo do banco (array) | novo valor (array) | condição para o update }
		
		$erro     = 0;
		$mensagem = "";
		$SQL      = "";
		
		#verifica se foi informado o BD
		if (!$bd){
			$erro = 1;
		}
		
		#verifica se os campos foram informados
		if ((!$campos) OR (!$values)){
			$erro = 2;
		}
		
		#verifica se a quantidade de campos coluna/inseridos são iguais
		if (count($campos) <> count($values)){
			$erro = 3;
		}
		
		switch($erro){
			case 1: $mensagem = "Informe o Banco de Dados."; break;
			case 2: $mensagem = "Informe o nome dos campos."; break;
			case 3: $mensagem = "A quantidade de campos não confere com a quantidade de colunas."; break;
			default: 

				#monta o SET para realizar o update
				$monta_SET = "";
				$SET       = array();
				$i         = 0;
				#monta a condição
				if ($cond <> "") { $cond = "WHERE $cond"; }
				
				foreach ($campos as $campo){
					array_push($SET,"$campo = $values[$i]");
					$i += 1;
				}
				
				$monta_SET = implode(" , ",$SET);
				
				$SQL = "UPDATE $bd SET $monta_SET $cond";
				
				$executa_SQL = @query($SQL);
				
				if (!$executa_SQL){
					$mensagem = "Ocorreu um erro ao atualizar os dados. <b>Verifique a sintaxe SQL:</b> <i>$SQL</i>";
				} else {
					$mensagem = 1;
				}
				
			break;
		}
		
		#@close();
		
		return $mensagem;
		
	}
	
	#EXCLUI UM REGISTRO
	function deletar($bd, $cond){
		
		#{ nome do banco | condição para deletar }
		
		$erro     = 0;
		$mensagem = "";
		$SQL      = "";
		
		#verifica se foi informado o BD
		if (!$bd){
			$erro = 1;
		}
		
		#verifica se foi definida uma condição para exclusão
		if (!$cond){
			$erro = 2;
		}
		
		switch($erro){
			case 1: $mensagem = "Informe o Banco de Dados."; break;
			case 2: $mensagem = "Informe uma condição para realizar a exclusão"; break;
			default: 
				
				$SQL = "DELETE FROM $bd WHERE $cond";
				
				$executa_SQL = @query($SQL);
				
				if (!$executa_SQL){
					$mensagem = "Ocorreu um erro ao fazer a exclusão. <b>Verifique a sintaxe SQL:</b> <i>$SQL</i>";
				} else {
					$mensagem = 1;
				}
				
			break;
		}
		
		#@close();
		
		return $mensagem;
	}
	
	#REALIZA UM SELECT
	function select($bd, $campos, $cond, $tipo, $extra){
		
		#{ banco que deve ser consultado | campos que serão retornado | condição para consulta | tipo de retorno, 1 ou n resultados | define agrupamentos, ordem e outras ações. }
		
		$erro     = 0;
		$mensagem = "";
		$SQL      = "";
		
		#verifica se foi selecionado um banco para consulta
		if (!$bd){
			$erro = 1;
		}
		
		#verifica se os campos de retorno foram definidos
		if (!$campos){
			$erro = 2;
		}
		
		#verifica se foi selecionado um tipo de retorno
		if (!$tipo){
			$erro = 3;
		}
		
		#monta as condições
		if ($cond){
			$cond = "WHERE $cond";
		}

		switch($erro){
			case 1: $mensagem = "Informe o Banco de Dados."; break;
			case 2: $mensagem = "Informe os campos de retorno"; break;
			case 3: $mensagem = "Informe o tipo de retorno"; break;
			default: 
				
				$SQL = "SELECT $campos FROM $bd $cond $extra";
				
				$executa_SQL = query($SQL);
				
				if (!$executa_SQL){
				
					$mensagem = "Ocorreu um erro ao realizar a consulta. <b>Verifique a sintaxe SQL:</b> <i>$SQL</i>";
				
				} else {
					
					$mensagem = $executa_SQL;
					
				}
				
			break;
		}
		
		return $mensagem;
		
		#@close();
				
	}
		
?>
