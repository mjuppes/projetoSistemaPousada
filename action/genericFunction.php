<?php
include "class.upload.php";

	/**
	* @Descrição: método que recebe
	* parâmetro de data e retorna a data
	* formatada para inserir no banco
	* @author Marcio (mjuppes@gmail.com)
	*/

function getDiaSemana($data)
{
		$diaa=substr($data,0,2)."-";
		$mes=substr($data,3,2)."-";
		$ano=substr($data,6,4);
		$diasemana = date("w", mktime(0,0,0,$mes,$diaa,$ano) );

		switch($diasemana)
		{
			case 0: $dia_semana = "Domingo";
				break;
			case 1: $dia_semana = "Segunda-Feira";
				break;
			case 2: $dia_semana = ("Terça-Feira");
				break;
			case 3: $dia_semana = "Quarta-Feira";
				break;
			case 4: $dia_semana = "Quinta-Feira";
				break;
			case 5: $dia_semana = "Sexta-Feira";
				break;
			case 6: $dia_semana = ("Sábado");
				break;
		}
		return utf8_encode($dia_semana);
}

function busca_cep($cep)
{
	$resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');  
	if(!$resultado)
	{
		$resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";  
	}  
	parse_str($resultado, $retorno);   
	return $retorno;  
}

function decimal_money($valor='')
{
	return number_format($valor,2,",",".");
}

function selectCombo($label='',$arrSelect,$tipo=true,$idPost=false,$idCombo=false,$dadoCombo=false,$encode=false)
{
	$strSelect = "";
	$strSelect .= "<option value=''>".$label."</option>";

	if(empty($arrSelect))
	{
		$strSelect .= "<option value=''>-----------</option>";
		return $strSelect;
	}

	if(!$tipo)
	{
		foreach($arrSelect as $value => $key)
		{
				if(isset($idPost))
				{
					if($idPost == $key)
						$strSelect .= "<option SELECTED value='$key' >".($value)."</option>";
					else
						$strSelect .= "<option value='$key' >".($value)."</option>";
				}
				else
					$strSelect .= "<option value='$key' >".($value)."</option>";
		}
	}
	else
	{
		foreach($arrSelect as $dados)
		{
				if(($idPost))
				{
					if($idPost == $dados[$idCombo])
						$strSelect .= "<option SELECTED value='$dados[$idCombo]' >".($dados[$dadoCombo])."</option>";
					else
						$strSelect .= "<option value='$dados[$idCombo]' >".($dados[$dadoCombo])."</option>";
				}
				else
					$strSelect .= "<option value='$dados[$idCombo]' >".($dados[$dadoCombo])."</option>";
		}
	}
	if($encode)
		return utf8_encode($strSelect);
	else
		return ($strSelect);
}

function dump($arr)
{
	echo "<pre>";
		print_r($arr);
	echo "</pre>";
}


function formatDate($data='',$tipo=false,$p=false)
{
	if(empty($data))
		return NULL;

	if($tipo == false)
	{
		$dta = explode("/", $data);
		$dia = $dta[0];
		$mes = $dta[1];
		$ano = $dta[2];

		$dataFormatada = $ano."/".$mes."/".$dia;
	}
	else
	{
		$dta = explode("-", $data);
		$ano = $dta[2];
		$mes = $dta[1];
		$dia = $dta[0];

		$dataFormatada = $dia."/".$mes."/".$ano;
	}
	
	if($p)
		return "'".$dataFormatada."'";
	else
		return $dataFormatada;
}

function formataDouble($valor){
	
	if ($valor == NULL){
		return 0;
	} else {
		$procura    = array('.',',','R$ ');
		$substituir = array('','.',''); 
		return str_replace($procura,$substituir,$valor);
	}		
}

/**
* @Descrição: método que recebe
* parâmetro de valor decimal e retorna o valor
* formatado para inserir no banco
* @author Marcio (mjuppes@gmail.com)
*/

function decimal($valor='')
{
	$valorDecimal = str_replace('.','', $valor);
	$valorDecimal = str_replace(',','.', $valorDecimal);
	return $valorDecimal;
}


function reduz_imagem($img, $max_x, $max_y, $nome_foto) {
	
	/************************
	@Exemplo: 
	@$foto = "foto.jpg";
	@reduz_imagem($foto, 300, 200, "nome_final.jpg")
	******************/
	//pega o tamanho da imagem ($original_x, $original_y)
	list($width, $height) = getimagesize($img);
	
	$original_x = $width;
	$original_y = $height;
	
	// se a largura for maior que altura
	if($original_x > $original_y) {
	   $porcentagem = (100 * $max_x) / $original_x;	  
	}
	else {
	   $porcentagem = (100 * $max_y) / $original_y;  
	}
	
	$tamanho_x = $original_x * ($porcentagem / 100);
	$tamanho_y = $original_y * ($porcentagem / 100);
	
	$image_p = imagecreatetruecolor($tamanho_x, $tamanho_y);
	$image   = imagecreatefromjpeg($img);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $tamanho_x, $tamanho_y, $width, $height);
	
	
	return imagejpeg($image_p, $nome_foto, 100);

}

function carregaFoto($file,$nome_arquivo,$image_x,$dir){
/*
	utilizado para fazer o upload de fotos
	{file}          nome do input file do formulário
	{nome_arquivo}  novo nome do arquivo carregado, deve ter no máximo 25 caracteres contando a extensão
	{image_x}       redimencionar novo tamanho da imagem
	{dir}           diretorio onde a foto ficará armazenada
*/	
	
	$handle = new Upload($_FILES["$file"]);
	
	if ($handle->uploaded){ #carrega a foto
		$handle->image_resize       = true;
		$handle->image_ratio_y      = true;
		$handle->image_x            = $image_x;
		$handle->file_new_name_body = $nome_arquivo;
		$handle->image_convert      = 'jpg';
		$handle->Process($dir);
		
		if ($handle->processed){ #redimencionamento OK
			$arquivo = $handle->file_dst_name;
		} else {
			return 3; #erro 3
		}
		
		$handle->image_resize = true;
		$handle->image_ratio_y = true;
		$handle->image_x = 160;
		$handle->image_y = 120;
		$handle->image_contrast = 10;
		$handle->jpeg_quality = 70;
		$handle->file_new_name_body = $nome_arquivo;
		$handle->image_convert = 'jpg';
		$handle->Process("$dir/thumbs");
		$handle-> Clean();		

	} else {
		return 2;     #erro 2
	}
	return 1;         #carregamento da foto ok
}

function verificarExtensao($ext)
{

	$arrExtensao = array("txt","exe","aspx","html","xlsx","docx","asp","cvs",
						 "arj","asf","asp","avi","bmp","bak","bat","bin",
						 "cab","cdi","cfg","com","dat","dll","dxf",
						 "exe","eps","fhx","fla","gif","html","hlp","ini",
						 "ico","js","log","lnk","max","mdb","mid","mp3",
						 "mpg","mov","nrg","ogg","ole","php","pic","png",
						 "ppt","qxd","rm","rtf","reg","scr","swf","tar",
						 "ttf","tif","tmp","vob","wab","wav","wri");

	if(strlen($ext) != 3)
	{
		return false;
	}
	else
	{
		if(in_array($ext, $arrExtensao))
		{
			return false;
		}
		return true;
	}
}

function converByteFormatMb($tamanhoOriginal)
{
	$tamanho = $tamanhoOriginal/1024;
	$tamanho = $tamanho/1024;
	$tamanho = number_format($tamanho, 2, '.', '');
	return $tamanho;
}

function formatValor($valor)
{
	$valor = str_replace(",",".",$valor);

	$arrValor = explode(".", $valor);

	$key2 = (count($arrValor)-1);
	$preco = "";

	if(count($arrValor) > 1)
	{
		foreach($arrValor as $key => $value)
		{
			if($key != $key2)
			{
				$preco .= $value;
			}
			else
			{
				$preco.=".".$value;
			}
		}
	}
	else
	{
		$preco = $valor;
	}
	return $preco;
}

function formatDateToCalc($data)
{
	$d = array();
	$d = explode("/",$data);

	$data = $d[2]."-".$d[1]."-".$d[0];

	return $data;
}

function arrItervaloDias($dataInicial='',$dataFinal='',$totdefault=false)
{

	$dataInicial = formatDateToCalc($dataInicial);
	$dataFinal = formatDateToCalc($dataFinal);


	$arrDataIntervalo = array();

	
	for ($i = strtotime($dataInicial); $i <= strtotime($dataFinal); $i=$i+86400) 
	{
		if($i!= strtotime($dataFinal))
		{
			$dataValue = formatDate(date("d-m-Y",$i),true);
			$dataValue = trim($dataValue);

			array_push($arrDataIntervalo,$dataValue);
		}
		else
		{
			if(!$totdefault)
			{
				$dataValue = formatDate(date("d-m-Y",$i = ($i-1)),true);
				$dataValue = trim($dataValue);
			}
			else
			{
				$dataValue = formatDate(date("d-m-Y",$i = ($i)),true);
				$dataValue = trim($dataValue);
			}

			array_push($arrDataIntervalo,$dataValue);
		}
	}

	return $arrDataIntervalo;
}

function montarTdIntervalo($data='', $arrTodosIntervalos=false)
{

	if(in_array($data, $arrTodosIntervalos))
		$strTd.="<td bgcolor='#F08080' align='center'>".$data."</td>";
	else
		$strTd.="<td  align='center'>".$data."</td>";
	return $strTd;
}


function setDataCalendario($arrIdReservaQuarto,$arrIdQuarto=false,$arrNomeQuarto=false,$arrDataInicial=false,$arrDataFinal=false,$mes='',$ano='',$semana='',$arrAllQuartos=false,$arrTipoReserva=false)
{
	
	$mes = trim($mes);
	$ano = trim($ano);
	
	$arrMes = array('01'=>'Janeiro','02'=>'Fevereiro','03'=>'Março',
					'04'=>'Abril','05'=>'Maio','06'=>'Junho','07'=>'Julho','08'=>'Agosto', 
					'09'=>'Setembro','10'=>'Outubro','11'=>'Novembro','12'=>'Dezembro');

	$aux = "";

	foreach($arrIdReservaQuarto as $key => $value)
	{
			$arrDataIntervalo[$value][$key] = arrItervaloDias($arrDataInicial[$key][$value],$arrDataFinal[$key][$value],true);
	}

	$ultimoDia = date('t', mktime(0, 0, 0, $mes, $mes, $ano));

	$arrDiasSemana = array();

	$strTable  = "";
	
	$strTable .= "<table id='calendario' class='table  table-bordered table-condensed table-tablesorter' width='100%' border =1  bordercolor='#DDDDDD'>";
    $strTable .= "<thead>";
        $strTable .= "<tr>";
		$strTable .= "<th style='text-align: center;'></th>";
            $strTable .= "<th style='text-align: center;'>Quarto</th>";


	$strTable .= "<th colspan='50'  style='padding-right:0%;text-align: center;'>".utf8_encode("Mês")." de ".$arrMes[$mes]." Ano de ".$ano."</th>";
	for($i=0;$i<$ultimoDia;$i++)
	{
		$dia = $i+1;

		if(strlen($dia) == 1)
			$dia = "0".$dia;

		$data = $dia."/".$mes."/".$ano;

		array_push($arrDiasSemana,$data);
	}

    $strTable .= "</tr>";
    $strTable .= "</thead>";
    $strTable .= "<tbody>";

	$arrAux = array();

	//Primeira parte com os quartos que tem reserva
	foreach($arrIdQuarto as $key => $value)
	{
			$arrInfoQuarto = array();
			$arrInfoQuarto = explode("|",$value);

			$id_quarto  = $arrInfoQuarto[0];
			$id_reserva = $arrInfoQuarto[1];

			if(!in_array($id_quarto, $arrAux))
			{
				$strTable .= "<tr>";
				
				$strTable .= "<td>
			<a href='#' style='cursor:pointer'  role='button'  onclick='tooltip.ajax(this, \"teste.php?idquarto=$id_quarto\", false,{position:0});'  onmouseover='tooltip.ajax(this, \"teste.php?idquarto=$id_quarto\", false,{position:0});' title='Visualizar'  data-toggle='modal'><img src='http://177.70.26.45/beaverpousada/icones/visualizar.png' width='20px' height='20px'  onclick=\"return false;\" title='Visualizar'></a>
			</td>
			<td><span style='cursor:pointer'>".$arrNomeQuarto[$id_quarto]."</span>
			</td>";

				$arrRetorno =  array();
				$arrRetorno =  arrItervaloDiasCalendario($arrDataIntervalo[$id_quarto],$arrTipoReserva,$mes,$ano);

				foreach($arrRetorno as $dia_semana => $tipo_reserva)
				{
					if($tipo_reserva == "R")
					{
						//Reservado
						$strTable.="<td bgcolor='#FCF6A1'>
								<span style='cursor:pointer' onclick=\"openModalReserva('$dia_semana',$id_quarto)\" data-toggle='modal'>
						".substr($dia_semana, 0, 2)."
						</span>
						</td>";	
					} 
					if($tipo_reserva == "C")
					{
						//Confirmado
						$strTable.="<td bgcolor='#FF4500'>
						<span style='cursor:pointer' onclick=\"openModalReserva('$dia_semana',$id_quarto)\" data-toggle='modal'>
						".substr($dia_semana, 0, 2)."
						</span>
						</td>";
					}
					if(empty($tipo_reserva))
					{
						//Confirmado
						$strTable .= "<td bgcolor='#05F28F' >
						<span style='cursor:pointer' onclick=\"openModalReserva('$dia_semana',$id_quarto)\" data-toggle='modal'>
						".substr($dia_semana, 0, 2)."
							</span>						
						</td>";
					}
				}
				$strTable .= "</tr>";
			}
			array_push($arrAux,$id_quarto);
	}

	//Todos os quartos com excessão dos que não tem reserva
	foreach ($arrAllQuartos as $key => $value)
	{
		$strTable .= "<tr>";
			if(!in_array($key,$arrIdQuarto))
			{
				$arrManutencao = array();
				$arrManutencao = explode("|",$value);

				if(count($arrManutencao) > 0)
				{
					$nomequarto_p  = $arrManutencao[0]; //Nome do quarto
					$dataInicial_p = $arrManutencao[2]; //Data inicial do quarto
					$dataFinal_p   = $arrManutencao[3]; //Data final do quarto

					$arrInterv = arrItervaloDias($dataInicial_p,$dataFinal_p,true);

					/*
						@Removido links por enquanto ainda não os utilizamos para criar reservas a partir da grade
						01/07/2016
					*/
						$strTable .= "<td>
			<a href='#' style='cursor:pointer'  role='button'  onclick='tooltip.ajax(this, \"teste.php?idquarto=$key\", false,{position:0});'  onmouseover='tooltip.ajax(this, \"teste.php?idquarto=$key\", false,{position:0});' title='Visualizar'  data-toggle='modal'><img src='http://177.70.26.45/beaverpousada/icones/visualizar.png' width='20px' height='20px'  onclick=\"return false;\" title='Visualizar'></a>
			</td>
			<td><span style='cursor:pointer'>".$nomequarto_p."</span>
			</td>";
					
					for($i=0; $i<count($arrDiasSemana); $i++)
					{
						if(in_array($arrDiasSemana[$i], $arrInterv))
						{
							$strTable .= '<td bgcolor="#0C0CDA">'.substr($arrDiasSemana[$i], 0, 2)."</td>";
						}
						else
						{
							$strTable .='<td bgcolor="#05F28F">';
							
							$strTable .="<span style='cursor:pointer' onclick=\"openModalReserva('$arrDiasSemana[$i]')\" data-toggle='modal'>";
							$strTable .=substr($arrDiasSemana[$i], 0, 2);
							$strTable .="
							</span>
							</td>";
						}
					}
				}
				else
				{
					$strTable .= "<td><a class='quartoDisponivel' href=\"#\" onmouseover='tooltip.ajax(this, \"teste.php?idquarto=$key\", false,{position:0});' onclick=\"return false;\">".$value."</a></td>";
					for($i=0; $i<count($arrDiasSemana); $i++)
					{
						//$strTable .= '<td bgcolor="#04D47D">'.substr($arrDiasSemana[$i], 0, 2)."</td>";
						$strTable .= '<td bgcolor="#05F28F">'.substr($arrDiasSemana[$i], 0, 2)."</td>";
					}
				}
			}
			$strTable .= "</tr>";
	}

	$strTable .= "</tbody>";
	$strTable .= "</table>";
	echo $strTable;
}

function arrItervaloDiasCalendario($p_arrDias=array(),$p_tipoReserva=array(),$mes='',$ano='')
{
		$mes = trim($mes);
		$ano = trim($ano);

		$ultimoDia = date('t', mktime(0, 0, 0, $mes, $mes, $ano));
		$arrDiasMes = array();

		for($i=0;$i<$ultimoDia;$i++)
		{
			$dia = $i+1;

			if(strlen($dia) == 1)
				$dia = "0".$dia;

			$data = $dia."/".$mes."/".$ano;

			array_push($arrDiasMes,$data);
		}

		$arrDados = array();
		$arrDatas = array();

		foreach($p_arrDias as $key => $arr_value)
		{
				foreach($arr_value as $key_idreserva => $value_datas)
				{
						$value_datas = trim($value_datas);
						$arrDados[$value_datas] = $p_tipoReserva[$key];
						$arrDatas[] = trim($value_datas);
				}
		}

		$arrRetorno = array();

		for($i=0; $i<count($arrDiasMes); $i++)
		{
			if(in_array($arrDiasMes[$i],$arrDatas))
			{
				$tipoReserva = $arrDados[$arrDiasMes[$i]];

				if($tipoReserva == "R") //Reservado
					$arrRetorno[$arrDiasMes[$i]] = $arrDados[$arrDiasMes[$i]];

				if($tipoReserva == "C") //Confirmado
					$arrRetorno[$arrDiasMes[$i]] = $arrDados[$arrDiasMes[$i]];
			}
			else
				$arrRetorno[$arrDiasMes[$i]] = "";

		}

		return $arrRetorno;
}



function smtpmailer($para, $de, $de_nome, $assunto, $corpo)
{ 
	global $error;
	$mail = new PHPMailer();
	$mail->IsSMTP();		// Ativar SMTP
	$mail->SMTPDebug = 1;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
	$mail->SMTPAuth = true;		// Autenticação ativada
	$mail->SMTPSecure = 'ssl';	// SSL REQUERIDO pelo GMail
	$mail->Host = 'smtp.gmail.com';	// SMTP utilizado

	$mail->Port = 465;  		// A porta 587 deverá estar aberta em seu servidor
	$mail->Username = GUSER;
	$mail->Password = GPWD;
	$mail->SetFrom($de, $de_nome);
	$mail->Subject = $assunto;
	//$mail->Body = $corpo;
	$mail->MsgHTML($corpo);
	
	
	$mail->AddAddress($para);
	if(!$mail->Send()) 
	{
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	}
	else 
	{
		$error = 'Mensagem enviada!';
		return true;
	}
}




function setDataCalendarioNormal($mes='',$ano='',$arrAllQuartos=false)
{

	$mes = trim($mes);
	$ano = trim($ano);

	$arrMes = array('01'=>'Janeiro','02'=>'Fevereiro','03'=>'Março',
					'04'=>'Abril','05'=>'Maio','06'=>'Junho','07'=>'Julho','08'=>'Agosto', 
					'09'=>'Setembro','10'=>'Outubro','11'=>'Novembro','12'=>'Dezembro');

	$ultimoDia = date('t', mktime(0, 0, 0, $mes, $mes, $ano));

	$arrDiasSemana = array();

	$strTable  = "";
	
	$strTable .= "<table id='calendario' class='table  table-bordered table-condensed table-tablesorter' width='100%' border =1  bordercolor='#DDDDDD'>";
    $strTable .= "<thead>";
        $strTable .= "<tr>";
		$strTable .= "<th style='text-align: center;'></th>";
            $strTable .= "<th style='text-align: center;'>Quarto</th>";


	$strTable .= "<th colspan='50'  style='padding-right:0%;text-align: center;'>".utf8_encode("Mês")." de ".$arrMes[$mes]." Ano de ".$ano."</th>";
	for($i=0;$i<$ultimoDia;$i++)
	{
		$dia = $i+1;

		if(strlen($dia) == 1)
			$dia = "0".$dia;

		$data = $dia."/".$mes."/".$ano;

		array_push($arrDiasSemana,$data);
	}

    $strTable .= "</tr>";
    $strTable .= "</thead>";
    $strTable .= "<tbody>";

	$arrAux = array();


	//Todos os quartos 
	foreach ($arrAllQuartos as $key => $value)
	{
			$strTable .= "<tr>";
			$strTable .= "
			<td>
				<a href='#' style='cursor:pointer'  role='button'  onclick='tooltip.ajax(this, \"teste.php?idquarto=$key\", false,{position:0});'  onmouseover='tooltip.ajax(this, \"teste.php?idquarto=$key\", false,{position:0});' title='Visualizar'  data-toggle='modal'><img src='http://177.70.26.45/beaverpousada/icones/visualizar.png' width='20px' height='20px'  onclick=\"return false;\" title='Visualizar'></a>
			</td>
			<td><span style='cursor:pointer'>".$value."</span></td>";

			for($i=0; $i<count($arrDiasSemana); $i++)
			{
				//$strTable .= "<td bgcolor='#04D47D'><span role='button'  style='cursor:pointer' onclick=\"openModalReserva('$arrDiasSemana[$i]',$key)\" data-toggle='modal'>".substr($arrDiasSemana[$i], 0, 2)."</span></td>";
				$strTable .= "<td bgcolor='#05F28F'><span role='button'  style='cursor:pointer' onclick=\"openModalReserva('$arrDiasSemana[$i]',$key)\" data-toggle='modal'>".substr($arrDiasSemana[$i], 0, 2)."</span></td>";
			}
			$strTable .= "</tr>";
	}

	$strTable .= "</tbody>";
	$strTable .= "</table>";
	echo $strTable;
}
?>