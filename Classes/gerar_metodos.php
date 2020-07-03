<?php
class geraMetodos
{
	
	var $path = "";
	
	public function geraMetodos($strSQL=false,$path2="")
	{

		$this->path = $path2;
		
		if(!$strSQL)
		{
			echo "Não posso executar a classe!";
			return false;
		}

		$Bd = new Bd('sqlServer');

		$dadosRecordSet = array();
		$dadosRecordSet = $Bd->execQuery($strSQL,true);

		$arrTabelasColunas = array();
		$arrTabelas = array();

		if($dadosRecordSet)
		{
			$tabela = '';
			foreach($dadosRecordSet as $dados)
			{
				if($dados['Tabela'] != $tabela)
				{
					array_push($arrTabelasColunas,$dados['Tabela']);
					if($tabela != '')
						array_push($arrTabelas,$tabela);
					else
						array_push($arrTabelas,$dados['Tabela']);
				}
				$arrTabelasColunas[$dados['Tabela']][] = $dados['Coluna'];
				$tabela = $dados['Tabela'];
			}

			foreach($arrTabelas as $dados => $tabela)
			{
				
				$this->gerarController($arrTabelasColunas,$tabela);
				$this->gerarModel($arrTabelasColunas,$tabela);
				//$this->gerarView($arrTabelasColunas,$tabela);
				//$this->gerarJavascript($arrTabelasColunas,$tabela);
			}
			//echo 'Ok Classes geradas';
		}
		$Bd->closeConnect();
	}

	private function gerarJavascript($arrTabelasColunas,$tabela)
	{
		$substr2 = substr($tabela, 0, 1);
		$substr3 = substr($tabela,1);
		$funcao  = $substr2.strtolower($substr3);

		$id = "";
		$strObj = "";

		foreach($arrTabelasColunas[$tabela] as $dados => $camposTabela)
		{
			if(empty($id))
			{ 
				$id = $camposTabela;
				$strObj .= "					objeto.".$camposTabela."\n";
			}
			else
				$strObj .= "						objeto.".$camposTabela."\n";
		}

		$strFunJs   = "	function visualizar$funcao($id)\n";
		$strFunJs  .= " 	{\n";
		$strFunJs  .= " 		$.ajax({\n";
		$strFunJs  .= "		type: 	'POST',\n";
		$strFunJs  .= "		url: 'view.php',\n";
		$strFunJs  .= "		data : {\n";
		$strFunJs  .= "			controller : '',\n";
		$strFunJs  .= "						$id : $id\n";
		$strFunJs  .= "		},\n";
		$strFunJs  .= "					success: function(data)\n";
		$strFunJs  .= "					{\n";
		$strFunJs  .= "						var objeto = eval('(' +data+ ')');\n";

		for($i=0; $i<count($arrTabelasColunas[$tabela]); $i++)
		{
			$strFunJs  .= "						$('#').html();\n";
		}

		$strFunJs  .= "	 $strObj\n";
		$strFunJs  .= "			}\n";
		$strFunJs  .= "		});\n";
		$strFunJs  .= "	}\n";
		$strFunJs  .= "	\n";


		$strFunJs  .= "	function update$funcao($id)\n";
		$strFunJs  .= " 	{\n";
		$strFunJs  .= " 		$.ajax({\n";
		$strFunJs  .= "		type: 	'POST',\n";
		$strFunJs  .= "		url: 'view.php',\n";
		$strFunJs  .= "		data : {\n";
		$strFunJs  .= "			controller : '',\n";
		$strFunJs  .= "						$id : $id\n";
		$strFunJs  .= "		},\n";
		$strFunJs  .= "					success: function(data)\n";
		$strFunJs  .= "					{\n";
		$strFunJs  .= "						var objeto = eval('(' +data+ ')');\n";

		for($i=0; $i<count($arrTabelasColunas[$tabela]); $i++)
		{
			$strFunJs  .= "						$('#').val();\n";
		}

		$strFunJs  .= "	 $strObj\n";
		$strFunJs  .= "			}\n";
		$strFunJs  .= "		});\n";
		$strFunJs  .= "	}\n";
		
		$strFunJs  .= "	function exclui$funcao($id)\n";
		$strFunJs  .= " 	{\n";
		$strFunJs  .= " 			if(!confirm('eseja realmente excluir?'))\n";
		$strFunJs  .= " 			{\n";
		$strFunJs  .= " 					return false;\n";
		$strFunJs  .= " 			}\n";
		$strFunJs  .= " 		$.ajax({\n";
		$strFunJs  .= "				type: 	'POST',\n";
		$strFunJs  .= "				url: 'view.php',\n";
		$strFunJs  .= "				data : {\n";
		$strFunJs  .= "				controller : '',\n";
		$strFunJs  .= "						$id : $id\n";
		$strFunJs  .= "				},\n";
		$strFunJs  .= "					success: function(data)\n";
		$strFunJs  .= "					{\n";
		$strFunJs  .= "			}\n";
		$strFunJs  .= "		});\n";
		$strFunJs  .= "	}\n";

		$fp = fopen($this->path."tabela.js", "w+");
		$escreve = fwrite($fp, $strFunJs);
		fclose($fp);
	}

	private function gerarView($arrTabelasColunas,$tabela)
	{
		$substr2 = substr($tabela, 0, 1);
		$substr2 = strtoupper($substr2);
		$substr3 = substr($tabela,1);
		$arquivo = $substr2.$substr3;
		$tabela  = $arquivo;

		$controller =  "controller".$arquivo;
		$arrTemplet = "";

		foreach($arrTabelasColunas[$tabela] as $dados => $camposTabela)
		{
			if(empty($arrTemplet))
				$arrTemplet = chr(36)."arr = array('$camposTabela'=>".chr(36)."dados['$camposTabela']\n";
			else
				$arrTemplet.= "								,'$camposTabela'=>".chr(36)."dados['$camposTabela']\n";
		}
		$arrTemplet.");";

		$fp = fopen($this->path."view.php", "w+");

		$strClass   = "<?php\n switch(".chr(36)."_POST['controller'])\n";
		$strClass  .= "			{\n";
		$strClass  .= "				case 'selecionar';\n";
		$strClass  .= "					".chr(36)."$controller = new $controller('select')\n";
		$strClass  .= "					if(empty(".chr(36)."$controller->arrResposta))\n";
		$strClass  .= "					{\n";
		$strClass  .= "						echo '0';\n";
		$strClass  .= "						return false;\n";
		$strClass  .= "					}\n";
		$strClass  .= "				break;\n";
		$strClass  .= "				case 'cadastrar';\n";
		$strClass  .= " 				$arrTemplet";
		$strClass  .= "					".chr(36)."$controller = new $controller('insert')\n";
		$strClass  .= "					echo ".chr(36)."$controller->resposta;\n";
		$strClass  .= "				break;\n";
		$strClass  .= "				case 'atualizar';\n";
		$strClass  .= " 				$arrTemplet";
		$strClass  .= "					".chr(36)."$controller = new $controller('update')\n";
		$strClass  .= "					echo ".chr(36)."$controller-->resposta;\n";
		$strClass  .= "				break;\n";
		$strClass  .= "				case 'deletar';\n";
		$strClass  .= "					".chr(36)."$controller = new $controller('delete')\n";
		$strClass  .= "					echo ".chr(36)."$controller-->resposta;\n";
		$strClass  .= "				break;\n";
		$strClass  .= "			}\n";
		$strClass  .= "?>";

		$escreve = fwrite($fp, $strClass);
		fclose($fp);
	}

	private function gerarController($arrTabelasColunas,$tabela)
	{
		$substr2 = substr($tabela, 0, 1);
		$substr2 = strtoupper($substr2);
		$substr3 = substr($tabela,1);
		$arquivo = $substr2.$substr3;
		$tabela = $arquivo;

		$arquivo = "controller".$arquivo.".php";

		if(file_exists($this->path.$arquivo))
		{
			$file = $this->pat.$arquivo;
			$newfile = $this->path.$arquivo.".bak";
			copy($file, $newfile);
		}

		$fpC = fopen("C:/inetpub/wwwroot/beaverPousada/INCLUDES/includes.php","a+");

		$valida = false;
		while(!feof($fpC))
		{
			  $row = fgets($fpC,4096);
			  $valida = strstr($row, $arquivo);
		}

		if($valida == false)
		{
			$strController= "\n<?php include('../'.DIR_CLASSES.'".$arquivo."');?>";
			$escreve = fwrite($fpC, $strController);
		}

		fclose($fpC);
		
		$fp = fopen($this->path.$arquivo, "w+");
		$strClass  =  "<?php require_once('model$tabela.php');?>\n";
		$strClass .=  "<?php\n";
		$strClass .= "class  controller".$tabela."\n";
		$strClass .= "{\n";
		$strClass .= "    var ".chr(36)."command;\n";
		$strClass .= "    var ".chr(36)."resposta;\n";
		$strClass .= "    var ".chr(36)."arrResposta = array();\n";
		$strClass .= "	\n";
		//$strClass .= "	public function controller".$tabela."(".chr(36)."action,".chr(36)."arrDados=false)\n";
		$strClass .= "	public function controller".$tabela."(".chr(36)."action,".chr(36)."arrDados=false,".chr(36)."where=false)\n";
		$strClass .= "	{\n";

		$strClass .= "		".chr(36)."this->command = new $tabela();\n\n";

		$strClass .= "		switch(".chr(36)."action)\n";
		$strClass .= "		{\n";
		$strClass .= "			case 'select':\n";
		$strClass .= "				if(empty(".chr(36)."where))\n";
		$strClass .= "					".chr(36)."this->arrResposta = ".chr(36)."this->command->select();\n";
		$strClass .= "				else\n";
		$strClass .= "					".chr(36)."this->arrResposta = ".chr(36)."this->command->select(".chr(36)."where);\n";
		$strClass .= "			break;\n";
		$strClass .= "			case 'selectDadosJson':\n";
		$strClass .= "				".chr(36)."this->resposta = ".chr(36)."this->command->selectDadosJson(".chr(36)."arrDados['']);\n";
		$strClass .= "			break;\n";
		$strClass .= "			case 'insert':\n";
		$strClass .= "				".chr(36)."this->resposta = ".chr(36)."this->command->insert(".chr(36)."arrDados);\n";
		$strClass .= "			break;\n";
		$strClass .= "			case 'insert_last_id':\n";
		$strClass .= "				".chr(36)."this->resposta = ".chr(36)."this->command->insert_last_id(".chr(36)."arrDados);\n";
		$strClass .= "			break;\n";

		$strClass .= "			case 'update':\n";
		$strClass .= "				".chr(36)."this->resposta = ".chr(36)."this->command->update(".chr(36)."arrDados);\n";
		$strClass .= "			break;\n";
		$strClass .= "			case 'delete':\n";
		$strClass .= "				".chr(36)."this->resposta = ".chr(36)."this->command->delete(".chr(36)."arrDados);\n";
		$strClass .= "			break;\n";
		$strClass .= "		}\n";
		$strClass .= "	}\n";
		$strClass  .= "}\n";
		$strClass  .= "?>";
		$escreve = fwrite($fp, $strClass);
		fclose($fp);
	}

	private function gerarModel($arrTabelasColunas,$tabela)
	{
		$sqlTemplet = "";
		foreach($arrTabelasColunas[$tabela] as $dados => $camposTabela)
		{
			if(empty($sqlTemplet))
			{
				$idTabela = $camposTabela;
				$sqlTemplet .= " select  $camposTabela ";

				$strJson = chr(36)."arrJson = array('$camposTabela'=>".chr(36)."dados['$camposTabela']\n";
			}
			else
			{
				$sqlTemplet .= ",$camposTabela";
				$strJson .= "								,'$camposTabela'=>".chr(36)."dados['$camposTabela']\n";
			}
		}
		$strJson .=");\n";
		$sqlTemplet.= " from $tabela";

		$substr2 = substr($tabela, 0, 1);
		$substr2 = strtoupper($substr2);
		$substr3 = substr($tabela, 1);
		$arquivo = $substr2.$substr3;

		$arquivo = "model".$arquivo.".php";

		if(file_exists($this->path.$arquivo))
		{
			$file = $this->path.$arquivo;
			$newfile = $this->path.$arquivo.".bak";
			copy($file, $newfile);
		}

		$fp = fopen($this->path.$arquivo, "w+");
		$strClass   = "<?php\n";
		$strClass  .= "class  ".$tabela."\n";
		$strClass  .= "{\n";

		$strClass  .= "    var ".chr(36)."table_name = '".$tabela."';\n";

		foreach($arrTabelasColunas[$tabela] as $dados => $camposTabela)
		{
			$strClass  .= "    var ".chr(36).$camposTabela.";\n";
		}

		foreach($arrTabelasColunas[$tabela] as $dados => $camposTabela)
		{
			$substr2 = substr($camposTabela, 0, 1);
			$substr2 = strtoupper($substr2);
			$substr3 = substr($camposTabela, 1);
			$str = $substr2.$substr3;
			$strClass .= "	\n";
			$strClass .= "	function get".$str."()\n";
			$strClass .= "	{\n";
			$strClass .= "		return ".chr(36)."this->".$camposTabela.";\n";
			$strClass .= "	}\n";
			$strClass .= "	function set".$str."(".chr(36).$camposTabela.")\n";
			$strClass .= "	{\n";
			$strClass .= "		".chr(36)."this->".$camposTabela." = ".chr(36).$camposTabela.";\n";
			$strClass .= "	}\n\n";
		}

		$strClass .= "\n	public function select(".chr(36)."where=false)\n";
		$strClass .= "	{\n";
		$strClass .= "		".chr(36)."Bd = new Bd(CONEXAO);\n";
		$strClass .= "		".chr(36)."dadosRecordSet = array();\n";
		$strClass .= "		".chr(36)."strSQL = '$sqlTemplet';\n ";
		$strClass .= "		".chr(36)."dadosRecordSet = ".chr(36)."Bd->execQuery(".chr(36)."strSQL,true);\n";
		$strClass .= "		".chr(36)."Bd->closeConnect();\n";
		$strClass .= "		return ".chr(36)."dadosRecordSet;\n";
		$strClass  .= "	}\n";
		
		$strClass .= "	\n	public function selectDadosJson(".chr(36)."idTabela)\n";
		$strClass .= "	{\n";
		$strClass .= "		".chr(36)."Bd = new Bd(CONEXAO);\n";
		$strClass .= "		".chr(36)."dadosRecordSet = array();\n";
		$strClass .= "		".chr(36)."strSQL = '$sqlTemplet';\n ";
		$strClass .= "		".chr(36)."dadosRecordSet = ".chr(36)."Bd->execQuery(".chr(36)."strSQL,true);\n";
		$strClass .= "\n";
		$strClass .= "		foreach(".chr(36)."dadosRecordSet as ".chr(36)."dados)\n";
		$strClass .= "		{\n";
		$strClass .= "				$strJson";
		$strClass .= "		}\n";
		
		$strClass .= "		".chr(36)."Bd->closeConnect();\n";
		$strClass .= "		return json_encode(".chr(36)."arrJson);";
		$strClass .= "	}\n\n";
		
		$strClass .= "	public function insert(".chr(36)."arrDados)\n";
		$strClass .= "	{\n";
		$strClass .= "		".chr(36)."Bd = new Bd(CONEXAO);\n";
		$strClass .= "		".chr(36)."resposta = ".chr(36)."Bd->executarSql(".chr(36)."arrDados,".chr(36)."this->table_name,'insert');\n";
		$strClass .= "		".chr(36)."Bd->closeConnect();\n";
  		$strClass .= "		return ".chr(36)."resposta;\n";
		$strClass .= "	}\n";

		
		$strClass .= "	public function insert_last_id(".chr(36)."arrDados,".chr(36)."campo=false)\n";
		$strClass .= "	{\n";
		$strClass .= "		".chr(36)."Bd = new Bd(CONEXAO);\n";
		$strClass .= "		".chr(36)."dadosRecordSet = array();\n";
		$strClass .= "		".chr(36)."dadosRecordSet = ".chr(36)."Bd->executarSql(".chr(36)."arrDados,".chr(36)."this->table_name,'insert_last_id');\n";
		$strClass .= "		".chr(36)."Bd->closeConnect();\n";
  		$strClass .= "		return ".chr(36)."dadosRecordSet;\n";
		$strClass .= "	}\n";

		$strClass.= "\n	public function update(".chr(36)."arrDados)\n";
		$strClass.= "	{\n";
		$strClass.= "		". chr(36)."chave = '$idTabela = '.".chr(36)."arrDados['$idTabela'];\n";
		$strClass.= "		".  chr(36)."Bd = new Bd(CONEXAO);\n";
		$strClass.= "		". chr(36)."resposta = ".chr(36)."Bd->executarSql(".chr(36)."arrDados,".chr(36)."this->table_name,'update',".chr(36)."chave,'$idTabela');\n";
		$strClass.= "		". chr(36)."Bd->closeConnect();\n";
		$strClass.= "		return ".chr(36)."resposta;\n";
		$strClass.= "	}\n";
		
		$strClass.= "\n	public function delete(".chr(36)."arrDados)\n";
		$strClass.= "	{\n";
		$strClass.= "		". chr(36)."chave = '$idTabela = '.".chr(36)."arrDados['$idTabela'];\n";
		$strClass.= "		".  chr(36)."Bd = new Bd(CONEXAO);\n";
		$strClass.= "		". chr(36)."resposta = ".chr(36)."Bd->executarSql(".chr(36)."arrDados,".chr(36)."this->table_name,'delete',".chr(36)."chave);\n";
		$strClass.= "		". chr(36)."Bd->closeConnect();\n";
		$strClass.= "		return ".chr(36)."resposta;\n";
		$strClass.= "	}\n";
		$strClass.= "}\n";
		$strClass.= "?>\n";

		$escreve = fwrite($fp, $strClass);
		fclose($fp);
	}
}
?>